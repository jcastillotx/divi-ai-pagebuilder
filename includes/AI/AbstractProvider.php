<?php
/**
 * Abstract AI Provider base class.
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
 * Abstract class for AI providers.
 */
abstract class AbstractProvider implements ProviderInterface {

    /**
     * API key.
     *
     * @var string
     */
    protected string $api_key;

    /**
     * Current model.
     *
     * @var string
     */
    protected string $model;

    /**
     * Supported features.
     *
     * @var array<string>
     */
    protected array $supported_features = [ 'text' ];

    /**
     * Constructor.
     *
     * @param string $api_key API key.
     * @param string $model   Optional. Model to use.
     */
    public function __construct( string $api_key, string $model = '' ) {
        $this->api_key = $api_key;
        $this->model   = $model ?: $this->get_default_model();
    }

    /**
     * Get default model for this provider.
     *
     * @return string
     */
    abstract protected function get_default_model(): string;

    /**
     * {@inheritdoc}
     */
    public function get_model(): string {
        return $this->model;
    }

    /**
     * {@inheritdoc}
     */
    public function set_model( string $model ): void {
        $this->model = $model;
    }

    /**
     * {@inheritdoc}
     */
    public function supports( string $feature ): bool {
        return in_array( $feature, $this->supported_features, true );
    }

    /**
     * {@inheritdoc}
     */
    public function generate_image( string $prompt, array $options = [] ): array {
        return [
            'success' => false,
            'error'   => __( 'Image generation not supported by this provider.', 'divi-ai-pagebuilder' ),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function generate_structured( string $prompt, string $json_schema, array $options = [] ): array {
        // Default implementation using text generation with JSON instruction.
        $structured_prompt = $prompt . "\n\nRespond with valid JSON matching this schema:\n" . $json_schema;

        $result = $this->generate_text( $structured_prompt, $options );

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
     * Extract JSON from text response.
     *
     * @param string $text Response text.
     * @return array|null Parsed JSON or null.
     */
    protected function extract_json( string $text ): ?array {
        // Try direct parsing first.
        $decoded = json_decode( $text, true );
        if ( json_last_error() === JSON_ERROR_NONE ) {
            return $decoded;
        }

        // Try to find JSON in markdown code block.
        if ( preg_match( '/```(?:json)?\s*([\s\S]*?)```/', $text, $matches ) ) {
            $decoded = json_decode( trim( $matches[1] ), true );
            if ( json_last_error() === JSON_ERROR_NONE ) {
                return $decoded;
            }
        }

        // Try to find JSON between curly braces.
        if ( preg_match( '/\{[\s\S]*\}/', $text, $matches ) ) {
            $decoded = json_decode( $matches[0], true );
            if ( json_last_error() === JSON_ERROR_NONE ) {
                return $decoded;
            }
        }

        return null;
    }

    /**
     * Make HTTP request.
     *
     * @param string $url     Request URL.
     * @param array  $body    Request body.
     * @param array  $headers Additional headers.
     * @return array|\WP_Error Response or error.
     */
    protected function make_request( string $url, array $body, array $headers = [] ) {
        $default_headers = [
            'Content-Type' => 'application/json',
        ];

        $response = wp_remote_post(
            $url,
            [
                'headers' => array_merge( $default_headers, $headers ),
                'body'    => wp_json_encode( $body ),
                'timeout' => 120,
            ]
        );

        return $response;
    }

    /**
     * Handle API error response.
     *
     * @param array|\WP_Error $response API response.
     * @return array Error array.
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

        $error_message = $body['error']['message'] ?? $body['error'] ?? __( 'Unknown error', 'divi-ai-pagebuilder' );

        divi_ai_log( "API Error ({$code}): {$error_message}", 'error' );

        return [
            'success' => false,
            'error'   => $error_message,
            'code'    => $code,
        ];
    }

    /**
     * Log API usage.
     *
     * @param int    $tokens_used Tokens used.
     * @param string $type        Generation type.
     * @param string $prompt      Original prompt.
     * @return void
     */
    protected function log_usage( int $tokens_used, string $type, string $prompt ): void {
        global $wpdb;

        $table = $wpdb->prefix . 'divi_ai_history';

        $wpdb->insert(
            $table,
            [
                'user_id'         => get_current_user_id(),
                'prompt'          => $prompt,
                'ai_provider'     => $this->get_name(),
                'tokens_used'     => $tokens_used,
                'generation_type' => $type,
                'created_at'      => current_time( 'mysql' ),
            ],
            [ '%d', '%s', '%s', '%d', '%s', '%s' ]
        );

        // Update usage tracking.
        divi_ai_track_usage( $tokens_used );
    }
}
