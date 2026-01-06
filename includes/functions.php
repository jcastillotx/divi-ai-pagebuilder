<?php
/**
 * Global helper functions for Divi AI Page Builder.
 *
 * @package DiviAI
 * @since 1.0.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get the main plugin instance.
 *
 * @return \DiviAI\Core\Plugin
 */
function divi_ai() {
    return \DiviAI\Core\Plugin::instance();
}

/**
 * Get a service from the plugin container.
 *
 * @param string $service Service identifier.
 * @return mixed
 */
function divi_ai_get( string $service ) {
    return divi_ai()->get( $service );
}

/**
 * Get plugin settings.
 *
 * @param string|null $key     Optional. Specific setting key.
 * @param mixed       $default Optional. Default value if key doesn't exist.
 * @return mixed
 */
function divi_ai_get_setting( ?string $key = null, $default = null ) {
    $settings = get_option( 'divi_ai_settings', [] );

    if ( null === $key ) {
        return $settings;
    }

    return $settings[ $key ] ?? $default;
}

/**
 * Update plugin settings.
 *
 * @param string|array $key   Setting key or array of settings.
 * @param mixed        $value Optional. Value if key is string.
 * @return bool
 */
function divi_ai_update_setting( $key, $value = null ): bool {
    $settings = get_option( 'divi_ai_settings', [] );

    if ( is_array( $key ) ) {
        $settings = array_merge( $settings, $key );
    } else {
        $settings[ $key ] = $value;
    }

    return update_option( 'divi_ai_settings', $settings );
}

/**
 * Log a message if debug mode is enabled.
 *
 * @param string $message  Log message.
 * @param string $level    Log level (debug, info, warning, error).
 * @param array  $context  Additional context data.
 * @return void
 */
function divi_ai_log( string $message, string $level = 'info', array $context = [] ): void {
    if ( ! divi_ai_get_setting( 'debug_mode', false ) ) {
        return;
    }

    $log_levels = [ 'debug' => 0, 'info' => 1, 'warning' => 2, 'error' => 3 ];
    $current_level = divi_ai_get_setting( 'log_level', 'warning' );

    if ( $log_levels[ $level ] < $log_levels[ $current_level ] ) {
        return;
    }

    $log_message = sprintf(
        '[Divi AI] [%s] %s',
        strtoupper( $level ),
        $message
    );

    if ( ! empty( $context ) ) {
        $log_message .= ' | Context: ' . wp_json_encode( $context );
    }

    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( $log_message );
    }
}

/**
 * Encrypt sensitive data.
 *
 * @param string $data Data to encrypt.
 * @return string Encrypted data.
 */
function divi_ai_encrypt( string $data ): string {
    if ( empty( $data ) ) {
        return '';
    }

    $key = wp_salt( 'auth' );
    $iv  = substr( wp_salt( 'secure_auth' ), 0, 16 );

    $encrypted = openssl_encrypt( $data, 'aes-256-cbc', $key, 0, $iv );

    return base64_encode( $encrypted );
}

/**
 * Decrypt sensitive data.
 *
 * @param string $data Encrypted data.
 * @return string Decrypted data.
 */
function divi_ai_decrypt( string $data ): string {
    if ( empty( $data ) ) {
        return '';
    }

    $key = wp_salt( 'auth' );
    $iv  = substr( wp_salt( 'secure_auth' ), 0, 16 );

    $decoded = base64_decode( $data );

    return openssl_decrypt( $decoded, 'aes-256-cbc', $key, 0, $iv );
}

/**
 * Get encrypted API key.
 *
 * @param string $provider Provider name (openai, anthropic).
 * @return string Decrypted API key.
 */
function divi_ai_get_api_key( string $provider ): string {
    $encrypted_key = get_option( "divi_ai_{$provider}_key", '' );

    if ( empty( $encrypted_key ) ) {
        return '';
    }

    return divi_ai_decrypt( $encrypted_key );
}

/**
 * Set encrypted API key.
 *
 * @param string $provider Provider name (openai, anthropic).
 * @param string $key      API key to encrypt and store.
 * @return bool
 */
function divi_ai_set_api_key( string $provider, string $key ): bool {
    $encrypted_key = divi_ai_encrypt( $key );
    return update_option( "divi_ai_{$provider}_key", $encrypted_key );
}

/**
 * Check if AI features are enabled.
 *
 * @return bool
 */
function divi_ai_is_enabled(): bool {
    return (bool) divi_ai_get_setting( 'enable_ai', true );
}

/**
 * Check if a provider is configured.
 *
 * @param string $provider Provider name.
 * @return bool
 */
function divi_ai_provider_configured( string $provider ): bool {
    $key = divi_ai_get_api_key( $provider );
    return ! empty( $key );
}

/**
 * Get available AI providers.
 *
 * @return array
 */
function divi_ai_get_providers(): array {
    return [
        'openai' => [
            'name'   => __( 'OpenAI', 'divi-ai-pagebuilder' ),
            'models' => [
                'gpt-4o'       => 'GPT-4o',
                'gpt-4-turbo'  => 'GPT-4 Turbo',
                'gpt-4'        => 'GPT-4',
                'gpt-3.5-turbo' => 'GPT-3.5 Turbo',
            ],
        ],
        'anthropic' => [
            'name'   => __( 'Anthropic', 'divi-ai-pagebuilder' ),
            'models' => [
                'claude-3-opus-20240229'   => 'Claude 3 Opus',
                'claude-3-sonnet-20240229' => 'Claude 3 Sonnet',
                'claude-3-haiku-20240307'  => 'Claude 3 Haiku',
            ],
        ],
    ];
}

/**
 * Sanitize HTML for Divi content.
 *
 * @param string $html HTML content.
 * @return string Sanitized HTML.
 */
function divi_ai_sanitize_content( string $html ): string {
    $allowed_tags = wp_kses_allowed_html( 'post' );

    // Add additional tags used by Divi.
    $divi_tags = [
        'et_pb_section' => [],
        'et_pb_row'     => [],
        'et_pb_column'  => [],
        'et_pb_text'    => [],
        'et_pb_button'  => [],
        'et_pb_image'   => [],
    ];

    $allowed_tags = array_merge( $allowed_tags, $divi_tags );

    return wp_kses( $html, $allowed_tags );
}

/**
 * Format token count for display.
 *
 * @param int $tokens Token count.
 * @return string Formatted string.
 */
function divi_ai_format_tokens( int $tokens ): string {
    if ( $tokens >= 1000000 ) {
        return number_format( $tokens / 1000000, 1 ) . 'M';
    }
    if ( $tokens >= 1000 ) {
        return number_format( $tokens / 1000, 1 ) . 'K';
    }
    return number_format( $tokens );
}

/**
 * Get user's current usage for the period.
 *
 * @param int|null    $user_id User ID. Defaults to current user.
 * @param string|null $period  Period start date. Defaults to current month.
 * @return array Usage data.
 */
function divi_ai_get_usage( ?int $user_id = null, ?string $period = null ): array {
    global $wpdb;

    $user_id = $user_id ?? get_current_user_id();
    $period  = $period ?? gmdate( 'Y-m-01' );

    $table = $wpdb->prefix . 'divi_ai_usage';

    $usage = $wpdb->get_row(
        $wpdb->prepare(
            "SELECT * FROM {$table} WHERE user_id = %d AND period_start = %s",
            $user_id,
            $period
        ),
        ARRAY_A
    );

    return $usage ?: [
        'user_id'        => $user_id,
        'period_start'   => $period,
        'tokens_used'    => 0,
        'requests_count' => 0,
    ];
}

/**
 * Update user's usage tracking.
 *
 * @param int $tokens_used   Tokens used in this request.
 * @param int|null $user_id  User ID. Defaults to current user.
 * @return bool
 */
function divi_ai_track_usage( int $tokens_used, ?int $user_id = null ): bool {
    global $wpdb;

    $user_id = $user_id ?? get_current_user_id();
    $period  = gmdate( 'Y-m-01' );
    $table   = $wpdb->prefix . 'divi_ai_usage';

    $result = $wpdb->query(
        $wpdb->prepare(
            "INSERT INTO {$table} (user_id, period_start, tokens_used, requests_count)
             VALUES (%d, %s, %d, 1)
             ON DUPLICATE KEY UPDATE
             tokens_used = tokens_used + %d,
             requests_count = requests_count + 1",
            $user_id,
            $period,
            $tokens_used,
            $tokens_used
        )
    );

    return false !== $result;
}

/**
 * Check if user has exceeded rate limits.
 *
 * @param int|null $user_id User ID. Defaults to current user.
 * @return bool|WP_Error True if within limits, WP_Error if exceeded.
 */
function divi_ai_check_rate_limit( ?int $user_id = null ) {
    $user_id     = $user_id ?? get_current_user_id();
    $usage       = divi_ai_get_usage( $user_id );
    $rate_limit  = divi_ai_get_setting( 'rate_limit', 100 );
    $token_budget = divi_ai_get_setting( 'token_budget', 1000000 );

    if ( $rate_limit > 0 && $usage['requests_count'] >= $rate_limit ) {
        return new WP_Error(
            'rate_limit_exceeded',
            __( 'You have exceeded the request limit for this period.', 'divi-ai-pagebuilder' )
        );
    }

    if ( $token_budget > 0 && $usage['tokens_used'] >= $token_budget ) {
        return new WP_Error(
            'token_budget_exceeded',
            __( 'You have exceeded the token budget for this period.', 'divi-ai-pagebuilder' )
        );
    }

    return true;
}
