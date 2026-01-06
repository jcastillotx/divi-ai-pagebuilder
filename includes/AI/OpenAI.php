<?php
/**
 * OpenAI Provider Implementation.
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
 * OpenAI provider class.
 */
class OpenAI extends AbstractProvider {

    /**
     * API base URL.
     *
     * @var string
     */
    private const API_BASE = 'https://api.openai.com/v1';

    /**
     * Supported features.
     *
     * @var array<string>
     */
    protected array $supported_features = [ 'text', 'image', 'structured', 'streaming' ];

    /**
     * {@inheritdoc}
     */
    public function get_name(): string {
        return 'openai';
    }

    /**
     * {@inheritdoc}
     */
    protected function get_default_model(): string {
        return 'gpt-4-turbo';
    }

    /**
     * {@inheritdoc}
     */
    public function get_models(): array {
        return [
            'gpt-4o'         => 'GPT-4o (Latest)',
            'gpt-4-turbo'    => 'GPT-4 Turbo',
            'gpt-4'          => 'GPT-4',
            'gpt-3.5-turbo'  => 'GPT-3.5 Turbo',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function test_connection(): array {
        $response = $this->make_request(
            self::API_BASE . '/chat/completions',
            [
                'model'      => $this->model,
                'messages'   => [
                    [ 'role' => 'user', 'content' => 'Say "connected" and nothing else.' ],
                ],
                'max_tokens' => 10,
            ],
            [
                'Authorization' => 'Bearer ' . $this->api_key,
            ]
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
        $max_tokens  = $options['max_tokens'] ?? 2048;
        $system      = $options['system'] ?? $this->get_default_system_prompt();

        $messages = [
            [ 'role' => 'system', 'content' => $system ],
            [ 'role' => 'user', 'content' => $prompt ],
        ];

        $response = $this->make_request(
            self::API_BASE . '/chat/completions',
            [
                'model'       => $model,
                'messages'    => $messages,
                'temperature' => $temperature,
                'max_tokens'  => $max_tokens,
            ],
            [
                'Authorization' => 'Bearer ' . $this->api_key,
            ]
        );

        if ( is_wp_error( $response ) ) {
            return $this->handle_error( $response );
        }

        $code = wp_remote_retrieve_response_code( $response );

        if ( 200 !== $code ) {
            return $this->handle_error( $response );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        $content     = $body['choices'][0]['message']['content'] ?? '';
        $tokens_used = $body['usage']['total_tokens'] ?? 0;

        // Log usage.
        $this->log_usage( $tokens_used, 'text', $prompt );

        return [
            'success'     => true,
            'content'     => $content,
            'tokens_used' => $tokens_used,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generate_structured( string $prompt, string $json_schema, array $options = [] ): array {
        $system = $options['system'] ?? $this->get_default_system_prompt();
        $system .= "\n\nYou must respond with valid JSON matching this schema:\n" . $json_schema;
        $system .= "\n\nRespond ONLY with the JSON object, no additional text.";

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
     * {@inheritdoc}
     */
    public function generate_image( string $prompt, array $options = [] ): array {
        // Check rate limits.
        $rate_check = divi_ai_check_rate_limit();
        if ( is_wp_error( $rate_check ) ) {
            return [
                'success' => false,
                'error'   => $rate_check->get_error_message(),
            ];
        }

        $size    = $options['size'] ?? '1792x1024';
        $quality = $options['quality'] ?? 'hd';
        $style   = $options['style'] ?? 'natural';

        // Enhance prompt for better results.
        $enhanced_prompt = $this->enhance_image_prompt( $prompt );

        $response = $this->make_request(
            self::API_BASE . '/images/generations',
            [
                'model'   => 'dall-e-3',
                'prompt'  => $enhanced_prompt,
                'n'       => 1,
                'size'    => $size,
                'quality' => $quality,
                'style'   => $style,
            ],
            [
                'Authorization' => 'Bearer ' . $this->api_key,
            ]
        );

        if ( is_wp_error( $response ) ) {
            return $this->handle_error( $response );
        }

        $code = wp_remote_retrieve_response_code( $response );

        if ( 200 !== $code ) {
            return $this->handle_error( $response );
        }

        $body = json_decode( wp_remote_retrieve_body( $response ), true );

        $url             = $body['data'][0]['url'] ?? '';
        $revised_prompt  = $body['data'][0]['revised_prompt'] ?? $prompt;

        // Log usage (estimate tokens for image).
        $this->log_usage( 1000, 'image', $prompt );

        return [
            'success'        => true,
            'url'            => $url,
            'revised_prompt' => $revised_prompt,
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
               'Your responses are concise, professional, and actionable.';
    }

    /**
     * Enhance image prompt for better DALL-E results.
     *
     * @param string $prompt Original prompt.
     * @return string Enhanced prompt.
     */
    private function enhance_image_prompt( string $prompt ): string {
        $enhancements = [
            'professional photography',
            'high resolution',
            'commercial quality',
            'clean composition',
            'modern aesthetic',
        ];

        return $prompt . ', ' . implode( ', ', $enhancements );
    }
}
