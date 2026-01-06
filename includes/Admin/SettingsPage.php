<?php
/**
 * Admin Settings Page.
 *
 * @package DiviAI\Admin
 * @since 1.0.0
 */

namespace DiviAI\Admin;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Settings Page class.
 */
class SettingsPage {

    /**
     * Settings group name.
     *
     * @var string
     */
    const SETTINGS_GROUP = 'divi_ai_settings_group';

    /**
     * Settings option name.
     *
     * @var string
     */
    const OPTION_NAME = 'divi_ai_settings';

    /**
     * Add admin menu pages.
     *
     * @return void
     */
    public function add_menu_pages(): void {
        // Main wizard page.
        add_menu_page(
            __( 'Divi AI', 'divi-ai-pagebuilder' ),
            __( 'Divi AI', 'divi-ai-pagebuilder' ),
            'edit_pages',
            'divi-ai-wizard',
            [ $this, 'render_wizard_page' ],
            'dashicons-art',
            30
        );

        // Settings as submenu.
        add_options_page(
            __( 'Divi AI Settings', 'divi-ai-pagebuilder' ),
            __( 'Divi AI', 'divi-ai-pagebuilder' ),
            'manage_options',
            'divi-ai-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    /**
     * Register settings.
     *
     * @return void
     */
    public function register_settings(): void {
        register_setting(
            self::SETTINGS_GROUP,
            self::OPTION_NAME,
            [
                'type'              => 'array',
                'sanitize_callback' => [ $this, 'sanitize_settings' ],
                'default'           => $this->get_defaults(),
            ]
        );
    }

    /**
     * Get default settings.
     *
     * @return array
     */
    public function get_defaults(): array {
        return [
            'version'           => DIVI_AI_VERSION,
            'enable_ai'         => true,
            'default_creation'  => 'page',
            'show_welcome'      => true,
            'default_provider'  => 'openai',
            'fallback_provider' => '',
            'openai_model'      => 'gpt-4-turbo',
            'anthropic_model'   => 'claude-3-sonnet-20240229',
            'rate_limit'        => 100,
            'rate_period'       => 'hour',
            'token_budget'      => 1000000,
            'alert_threshold'   => 80,
            'alert_email'       => get_option( 'admin_email' ),
            'cache_duration'    => 24,
            'debug_mode'        => false,
            'log_level'         => 'warning',
            'cleanup_uninstall' => false,
        ];
    }

    /**
     * Sanitize settings.
     *
     * @param array $input Input settings.
     * @return array Sanitized settings.
     */
    public function sanitize_settings( array $input ): array {
        $sanitized = [];
        $defaults  = $this->get_defaults();

        // Boolean fields.
        $booleans = [ 'enable_ai', 'show_welcome', 'debug_mode', 'cleanup_uninstall' ];
        foreach ( $booleans as $field ) {
            $sanitized[ $field ] = ! empty( $input[ $field ] );
        }

        // Select fields with allowed values.
        $selects = [
            'default_creation'  => [ 'page', 'section', 'site_setup' ],
            'default_provider'  => [ 'openai', 'anthropic' ],
            'fallback_provider' => [ '', 'openai', 'anthropic' ],
            'rate_period'       => [ 'hour', 'day', 'month' ],
            'log_level'         => [ 'debug', 'info', 'warning', 'error' ],
        ];

        foreach ( $selects as $field => $allowed ) {
            $value = sanitize_text_field( $input[ $field ] ?? '' );
            $sanitized[ $field ] = in_array( $value, $allowed, true ) ? $value : $defaults[ $field ];
        }

        // Model fields.
        $sanitized['openai_model']    = sanitize_text_field( $input['openai_model'] ?? $defaults['openai_model'] );
        $sanitized['anthropic_model'] = sanitize_text_field( $input['anthropic_model'] ?? $defaults['anthropic_model'] );

        // Numeric fields.
        $sanitized['rate_limit']      = absint( $input['rate_limit'] ?? $defaults['rate_limit'] );
        $sanitized['token_budget']    = absint( $input['token_budget'] ?? $defaults['token_budget'] );
        $sanitized['alert_threshold'] = min( 100, max( 0, absint( $input['alert_threshold'] ?? $defaults['alert_threshold'] ) ) );
        $sanitized['cache_duration']  = absint( $input['cache_duration'] ?? $defaults['cache_duration'] );

        // Email field.
        $sanitized['alert_email'] = sanitize_email( $input['alert_email'] ?? '' );

        // Preserve version.
        $sanitized['version'] = DIVI_AI_VERSION;

        return $sanitized;
    }

    /**
     * Render wizard page (React app mounts here).
     *
     * @return void
     */
    public function render_wizard_page(): void {
        if ( ! current_user_can( 'edit_pages' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'divi-ai-pagebuilder' ) );
        }

        echo '<div id="divi-ai-wizard-root" class="wrap"></div>';
    }

    /**
     * Render settings page (React app mounts here).
     *
     * @return void
     */
    public function render_settings_page(): void {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_html__( 'You do not have permission to access this page.', 'divi-ai-pagebuilder' ) );
        }

        echo '<div id="divi-ai-settings-root" class="wrap"></div>';
    }

    /**
     * AJAX handler for testing provider connection.
     *
     * @return void
     */
    public function ajax_test_provider(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $provider = sanitize_text_field( wp_unslash( $_POST['provider'] ?? '' ) );
        $api_key  = sanitize_text_field( wp_unslash( $_POST['api_key'] ?? '' ) );

        if ( ! in_array( $provider, [ 'openai', 'anthropic' ], true ) ) {
            wp_send_json_error( [ 'message' => __( 'Invalid provider', 'divi-ai-pagebuilder' ) ], 400 );
        }

        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $instance = $factory->create( $provider, $api_key );
            $result   = $instance->test_connection();

            if ( $result['success'] ) {
                wp_send_json_success( [
                    'message' => __( 'Connection successful!', 'divi-ai-pagebuilder' ),
                    'model'   => $result['model'] ?? '',
                ] );
            } else {
                wp_send_json_error( [ 'message' => $result['error'] ?? __( 'Connection failed', 'divi-ai-pagebuilder' ) ], 400 );
            }
        } catch ( \Exception $e ) {
            wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
        }
    }

    /**
     * AJAX handler for saving API key.
     *
     * @return void
     */
    public function ajax_save_api_key(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $provider = sanitize_text_field( wp_unslash( $_POST['provider'] ?? '' ) );
        $api_key  = sanitize_text_field( wp_unslash( $_POST['api_key'] ?? '' ) );

        if ( ! in_array( $provider, [ 'openai', 'anthropic' ], true ) ) {
            wp_send_json_error( [ 'message' => __( 'Invalid provider', 'divi-ai-pagebuilder' ) ], 400 );
        }

        $saved = divi_ai_set_api_key( $provider, $api_key );

        if ( $saved ) {
            wp_send_json_success( [ 'message' => __( 'API key saved successfully.', 'divi-ai-pagebuilder' ) ] );
        } else {
            wp_send_json_error( [ 'message' => __( 'Failed to save API key.', 'divi-ai-pagebuilder' ) ], 500 );
        }
    }

    /**
     * AJAX handler for clearing cache.
     *
     * @return void
     */
    public function ajax_clear_cache(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        global $wpdb;

        $wpdb->query( "TRUNCATE TABLE {$wpdb->prefix}divi_ai_transform_cache" );

        wp_send_json_success( [ 'message' => __( 'Cache cleared successfully.', 'divi-ai-pagebuilder' ) ] );
    }

    /**
     * AJAX handler for exporting settings.
     *
     * @return void
     */
    public function ajax_export_settings(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $settings   = get_option( self::OPTION_NAME, [] );
        $categories = get_option( 'divi_ai_template_categories', [] );

        // Remove sensitive data.
        unset( $settings['openai_api_key'], $settings['anthropic_api_key'] );

        $export = [
            'plugin_version' => DIVI_AI_VERSION,
            'exported_at'    => current_time( 'mysql' ),
            'settings'       => $settings,
            'categories'     => $categories,
        ];

        wp_send_json_success( $export );
    }

    /**
     * AJAX handler for importing settings.
     *
     * @return void
     */
    public function ajax_import_settings(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $import_data = json_decode( wp_unslash( $_POST['import_data'] ?? '' ), true );

        if ( ! $import_data || ! isset( $import_data['settings'] ) ) {
            wp_send_json_error( [ 'message' => __( 'Invalid import data.', 'divi-ai-pagebuilder' ) ], 400 );
        }

        // Sanitize imported settings.
        $sanitized = $this->sanitize_settings( $import_data['settings'] );

        update_option( self::OPTION_NAME, $sanitized );

        if ( isset( $import_data['categories'] ) ) {
            update_option( 'divi_ai_template_categories', $import_data['categories'] );
        }

        wp_send_json_success( [ 'message' => __( 'Settings imported successfully.', 'divi-ai-pagebuilder' ) ] );
    }

    /**
     * Get cache statistics.
     *
     * @return array
     */
    public function get_cache_stats(): array {
        global $wpdb;

        $table = $wpdb->prefix . 'divi_ai_transform_cache';

        $count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
        $size  = $wpdb->get_var(
            "SELECT ROUND(SUM(LENGTH(transformed_json)) / 1024 / 1024, 2) FROM {$table}"
        );

        return [
            'count' => $count,
            'size'  => (float) $size,
        ];
    }
}
