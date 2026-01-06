<?php
/**
 * Assets manager for enqueuing scripts and styles.
 *
 * @package DiviAI\Core
 * @since 1.0.0
 */

namespace DiviAI\Core;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Assets class.
 */
class Assets {

    /**
     * Plugin URL.
     *
     * @var string
     */
    private string $plugin_url;

    /**
     * Plugin version.
     *
     * @var string
     */
    private string $version;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->plugin_url = DIVI_AI_PLUGIN_URL;
        $this->version    = DIVI_AI_VERSION;
    }

    /**
     * Enqueue admin assets.
     *
     * @param string $hook Current admin page hook.
     * @return void
     */
    public function enqueue_admin_assets( string $hook ): void {
        // Settings page.
        if ( 'settings_page_divi-ai-settings' === $hook ) {
            $this->enqueue_settings_assets();
        }

        // Wizard page.
        if ( 'toplevel_page_divi-ai-wizard' === $hook ) {
            $this->enqueue_wizard_assets();
        }

        // All admin pages get base styles.
        if ( strpos( $hook, 'divi-ai' ) !== false ) {
            $this->enqueue_base_admin_assets();
        }
    }

    /**
     * Enqueue base admin assets.
     *
     * @return void
     */
    private function enqueue_base_admin_assets(): void {
        wp_enqueue_style(
            'divi-ai-admin-base',
            $this->plugin_url . 'assets/dist/css/admin.css',
            [],
            $this->version
        );
    }

    /**
     * Enqueue settings page assets.
     *
     * @return void
     */
    private function enqueue_settings_assets(): void {
        wp_enqueue_script(
            'divi-ai-admin',
            $this->plugin_url . 'assets/dist/js/admin.js',
            [ 'wp-element', 'wp-components', 'wp-api-fetch', 'wp-i18n' ],
            $this->version,
            true
        );

        wp_enqueue_style(
            'divi-ai-admin',
            $this->plugin_url . 'assets/dist/css/admin.css',
            [ 'wp-components' ],
            $this->version
        );

        wp_localize_script( 'divi-ai-admin', 'diviAIAdmin', $this->get_admin_localize_data() );
    }

    /**
     * Enqueue wizard page assets.
     *
     * @return void
     */
    private function enqueue_wizard_assets(): void {
        wp_enqueue_script(
            'divi-ai-wizard',
            $this->plugin_url . 'assets/dist/js/wizard.js',
            [ 'wp-element', 'wp-components', 'wp-api-fetch', 'wp-i18n' ],
            $this->version,
            true
        );

        wp_enqueue_style(
            'divi-ai-wizard',
            $this->plugin_url . 'assets/dist/css/wizard.css',
            [ 'wp-components' ],
            $this->version
        );

        wp_localize_script( 'divi-ai-wizard', 'diviAIWizard', $this->get_wizard_localize_data() );
    }

    /**
     * Get localized data for admin script.
     *
     * @return array
     */
    private function get_admin_localize_data(): array {
        return [
            'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
            'restUrl'   => rest_url( 'divi-ai/v1/' ),
            'nonce'     => wp_create_nonce( 'divi_ai_admin' ),
            'restNonce' => wp_create_nonce( 'wp_rest' ),
            'settings'  => divi_ai_get_setting(),
            'providers' => divi_ai_get_providers(),
            'strings'   => [
                'saveSuccess'     => __( 'Settings saved successfully.', 'divi-ai-pagebuilder' ),
                'saveError'       => __( 'Error saving settings.', 'divi-ai-pagebuilder' ),
                'testSuccess'     => __( 'Connection successful!', 'divi-ai-pagebuilder' ),
                'testError'       => __( 'Connection failed. Please check your API key.', 'divi-ai-pagebuilder' ),
                'cacheCleared'    => __( 'Cache cleared successfully.', 'divi-ai-pagebuilder' ),
                'confirmReset'    => __( 'Are you sure you want to reset all settings to defaults?', 'divi-ai-pagebuilder' ),
                'confirmClear'    => __( 'Are you sure you want to clear the cache?', 'divi-ai-pagebuilder' ),
            ],
            'usage'     => divi_ai_get_usage(),
        ];
    }

    /**
     * Get localized data for wizard script.
     *
     * @return array
     */
    private function get_wizard_localize_data(): array {
        return [
            'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
            'restUrl'    => rest_url( 'divi-ai/v1/' ),
            'nonce'      => wp_create_nonce( 'divi_ai_wizard' ),
            'restNonce'  => wp_create_nonce( 'wp_rest' ),
            'userTokens' => $this->get_user_design_tokens(),
            'siteInfo'   => [
                'name'    => get_bloginfo( 'name' ),
                'logo'    => $this->get_site_logo_url(),
                'hasMenu' => has_nav_menu( 'primary-menu' ),
            ],
            'strings'    => [
                'generating'    => __( 'Generating...', 'divi-ai-pagebuilder' ),
                'selectType'    => __( 'What would you like to create?', 'divi-ai-pagebuilder' ),
                'fullPage'      => __( 'Full Page', 'divi-ai-pagebuilder' ),
                'section'       => __( 'Section', 'divi-ai-pagebuilder' ),
                'siteSetup'     => __( 'Site Setup', 'divi-ai-pagebuilder' ),
            ],
        ];
    }

    /**
     * Get user's design tokens from Customizer.
     *
     * @return array
     */
    private function get_user_design_tokens(): array {
        return [
            'colors' => [
                'primary'   => get_theme_mod( 'divi_ai_color_primary', '#3366ff' ),
                'secondary' => get_theme_mod( 'divi_ai_color_secondary', '#ff6633' ),
                'accent'    => get_theme_mod( 'divi_ai_color_accent', '#00cc88' ),
                'textPrimary'   => get_theme_mod( 'divi_ai_color_text_primary', '#333333' ),
                'textSecondary' => get_theme_mod( 'divi_ai_color_text_secondary', '#666666' ),
                'textLight'     => get_theme_mod( 'divi_ai_color_text_light', '#ffffff' ),
                'bgPrimary'     => get_theme_mod( 'divi_ai_color_bg_primary', '#ffffff' ),
                'bgSecondary'   => get_theme_mod( 'divi_ai_color_bg_secondary', '#f8f9fa' ),
                'bgDark'        => get_theme_mod( 'divi_ai_color_bg_dark', '#1a1a2e' ),
            ],
            'fonts'  => [
                'heading' => get_theme_mod( 'divi_ai_font_heading', 'Montserrat' ),
                'body'    => get_theme_mod( 'divi_ai_font_body', 'Open Sans' ),
                'accent'  => get_theme_mod( 'divi_ai_font_accent', 'Playfair Display' ),
            ],
        ];
    }

    /**
     * Get site logo URL.
     *
     * @return string
     */
    private function get_site_logo_url(): string {
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if ( $custom_logo_id ) {
            $logo_url = wp_get_attachment_image_url( $custom_logo_id, 'full' );
            if ( $logo_url ) {
                return $logo_url;
            }
        }

        return '';
    }

    /**
     * Enqueue frontend assets (for Divi Builder integration).
     *
     * @return void
     */
    public function enqueue_frontend_assets(): void {
        if ( ! $this->is_divi_builder_active() ) {
            return;
        }

        wp_enqueue_script(
            'divi-ai-builder',
            $this->plugin_url . 'assets/dist/js/builder.js',
            [ 'jquery', 'wp-element' ],
            $this->version,
            true
        );

        wp_enqueue_style(
            'divi-ai-builder',
            $this->plugin_url . 'assets/dist/css/builder.css',
            [],
            $this->version
        );
    }

    /**
     * Check if Divi Builder is active on current page.
     *
     * @return bool
     */
    private function is_divi_builder_active(): bool {
        return function_exists( 'et_core_is_fb_enabled' ) && et_core_is_fb_enabled();
    }
}
