<?php
/**
 * Anthropic Claude Provider Implementation.
 *
 * @package DiviAI\AI
 * @since 1.0.0
 */

namespace DiviAI\AI;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Anthropic Claude provider class.
 */
class Anthropic extends AbstractProvider {

    /**
     * API base URL.
     *
     * @var string
     */
    private const API_BASE = 'https://api.anthropic.com/v1';

    /**
     * API version.
     *
     * @var string
     */
    private const API_VERSION = '2023-06-01';

    /**
     * Supported features.
     *
     * @var array<string>
     */
    protected array $supported_features = [ 'text', 'structured', 'streaming' ];

    /**
     * {@inheritdoc}
     */
    public function get_name(): string {
        return 'anthropic';
    }

    /**
     * {@inheritdoc}
     */
    protected function get_default_model(): string {
        return 'claude-3-sonnet-20240229';
    }

    /**
     * {@inheritdoc}
     */
    public function get_models(): array {
        return [
            'claude-3-opus-20240229'   => 'Claude 3 Opus (Most capable)',
            'claude-3-sonnet-20240229' => 'Claude 3 Sonnet (Balanced)',
            'claude-3-haiku-20240307'  => 'Claude 3 Haiku (Fast)',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function test_connection(): array {
        $response = $this->make_request(
            self::API_BASE . '/messages',
            [
                'model'      => $this->model,
                'max_tokens' => 10,
                'messages'   => [
                    [ 'role' => 'user', 'content' => 'Say "connected" and nothing else.' ],
                ],
            ],
            $this->get_headers()
        );

        if ( is_wp_error( $response ) ) {
            return $this->handle_error( $response );
        }

        $code = wp_remote_retrieve_response_code( $response );

        if ( 200 !== $code ) {
            return $this->handle_error( $response );
        }

        return [
            'success' => true,
            'model'   => $this->model,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generate_text( string $prompt, array $options = [] ): array {
        // Check rate limits.
        $rate_check = divi_ai_check_rate_limit();
        if ( is_wp_error( $rate_check ) ) {
            return [
                'success' => false,
                'error'   => $rate_check->get_error_message(),
            ];
        }

        $model       = $options['model'] ?? $this->model;
        $temperature = $options['temperature'] ?? 0.7;
        $max_tokens  = $options['max_tokens'] ?? 4096;
        $system      = $options['system'] ?? $this->get_default_system_prompt();

        $body = [
            'model'      => $model,
            'max_tokens' => $max_tokens,
            'messages'   => [
                [ 'role' => 'user', 'content' => $prompt ],
            ],
        ];

        // Add system prompt if provided.
        if ( ! empty( $system ) ) {
            $body['system'] = $system;
        }

        // Only add temperature if not 1.0 (default).
        if ( $temperature !== 1.0 ) {
            $body['temperature'] = $temperature;
        }

        $response = $this->make_request(
            self::API_BASE . '/messages',
            $body,
            $this->get_headers()
        );

        if ( is_wp_error( $response ) ) {
            return $this->handle_error( $response );
        }

        $code = wp_remote_retrieve_response_code( $response );

        if ( 200 !== $code ) {
            return $this->handle_error( $response );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        $content = '';
        foreach ( $body['content'] ?? [] as $block ) {
            if ( 'text' === $block['type'] ) {
                $content .= $block['text'];
            }
        }

        $input_tokens  = $body['usage']['input_tokens'] ?? 0;
        $output_tokens = $body['usage']['output_tokens'] ?? 0;
        $tokens_used   = $input_tokens + $output_tokens;

        // Log usage.
        $this->log_usage( $tokens_used, 'text', $prompt );

        return [
            'success'       => true,
            'content'       => $content,
            'tokens_used'   => $tokens_used,
            'input_tokens'  => $input_tokens,
            'output_tokens' => $output_tokens,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generate_structured( string $prompt, string $json_schema, array $options = [] ): array {
        $system = $options['system'] ?? $this->get_default_system_prompt();
        $system .= "\n\nYou must respond with valid JSON matching this schema:\n" . $json_schema;
        $system .= "\n\nRespond ONLY with the JSON object, no additional text, no markdown code blocks.";

        $options['system'] = $system;

        $result = $this->generate_text( $prompt, $options );

        if ( ! $result['success'] ) {
            return $result;
        }

        $json = $this->extract_json( $result['content'] ?? '' );

        if ( null === $json ) {
            return [
                'success' => false,
                'error'   => __( 'Failed to parse JSON response.', 'divi-ai-pagebuilder' ),
            ];
        }

        return [
            'success'     => true,
            'data'        => $json,
            'tokens_used' => $result['tokens_used'] ?? 0,
        ];
    }

    /**
     * Get API headers.
     *
     * @return array
     */
    private function get_headers(): array {
        return [
            'x-api-key'         => $this->api_key,
            'anthropic-version' => self::API_VERSION,
            'Content-Type'      => 'application/json',
        ];
    }

    /**
     * Get default system prompt.
     *
     * @return string
     */
    private function get_default_system_prompt(): string {
        return 'You are an expert web designer and UX/UI specialist with over 15 years of professional experience. ' .
               'You combine deep knowledge of design principles with practical understanding of what converts visitors into customers. ' .
               'Your responses are concise, professional, and actionable. ' .
               'When generating content for websites, you consider SEO, accessibility, and conversion optimization.';
    }

    /**
     * {@inheritdoc}
     */
    protected function handle_error( $response ): array {
        if ( is_wp_error( $response ) ) {
            return [
                'success' => false,
                'error'   => $response->get_error_message(),
            ];
        }

        $code = wp_remote_retrieve_response_code( $response );
        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        // Anthropic error format.
        $error_message = $body['error']['message'] ?? __( 'Unknown error', 'divi-ai-pagebuilder' );
        $error_type    = $body['error']['type'] ?? 'unknown';

        divi_ai_log( "Anthropic API Error ({$code}, {$error_type}): {$error_message}", 'error' );

        return [
            'success'    => false,
            'error'      => $error_message,
            'error_type' => $error_type,
            'code'       => $code,
        ];
    }
}
