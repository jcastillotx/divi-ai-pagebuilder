<?php
/**
 * Plugin Name:       Divi AI Page Builder
 * Plugin URI:        https://www.kre8ivtech.com/divi-ai-pagebuilder
 * Description:       AI-powered design and content creation for the Divi page builder. Generate layouts, write content, and optimize designs using natural language.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            Kre8ivTech, LLC
 * Author URI:        https://www.kre8ivtech.com
 * License:           Proprietary
 * License URI:       https://www.kre8ivtech.com/license
 * Text Domain:       divi-ai-pagebuilder
 * Domain Path:       /languages
 *
 * @package DiviAI
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin version.
 *
 * @var string
 */
define( 'DIVI_AI_VERSION', '1.0.0' );

/**
 * Plugin file path.
 *
 * @var string
 */
define( 'DIVI_AI_PLUGIN_FILE', __FILE__ );

/**
 * Plugin directory path.
 *
 * @var string
 */
define( 'DIVI_AI_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Plugin directory URL.
 *
 * @var string
 */
define( 'DIVI_AI_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Plugin basename.
 *
 * @var string
 */
define( 'DIVI_AI_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Minimum required PHP version.
 *
 * @var string
 */
define( 'DIVI_AI_MIN_PHP_VERSION', '8.0' );

/**
 * Minimum required WordPress version.
 *
 * @var string
 */
define( 'DIVI_AI_MIN_WP_VERSION', '6.0' );

/**
 * Minimum required Divi version.
 *
 * @var string
 */
define( 'DIVI_AI_MIN_DIVI_VERSION', '4.14' );

/**
 * Check if the server environment meets the minimum requirements.
 *
 * @return bool True if requirements are met, false otherwise.
 */
function divi_ai_check_requirements() {
    $errors = array();

    // Check PHP version.
    if ( version_compare( PHP_VERSION, DIVI_AI_MIN_PHP_VERSION, '<' ) ) {
        $errors[] = sprintf(
            /* translators: 1: Current PHP version, 2: Required PHP version */
            __( 'Divi AI Page Builder requires PHP %2$s or higher. You are running PHP %1$s.', 'divi-ai-pagebuilder' ),
            PHP_VERSION,
            DIVI_AI_MIN_PHP_VERSION
        );
    }

    // Check WordPress version.
    if ( version_compare( get_bloginfo( 'version' ), DIVI_AI_MIN_WP_VERSION, '<' ) ) {
        $errors[] = sprintf(
            /* translators: 1: Current WordPress version, 2: Required WordPress version */
            __( 'Divi AI Page Builder requires WordPress %2$s or higher. You are running WordPress %1$s.', 'divi-ai-pagebuilder' ),
            get_bloginfo( 'version' ),
            DIVI_AI_MIN_WP_VERSION
        );
    }

    if ( ! empty( $errors ) ) {
        add_action( 'admin_notices', function() use ( $errors ) {
            foreach ( $errors as $error ) {
                echo '<div class="notice notice-error"><p>' . esc_html( $error ) . '</p></div>';
            }
        });
        return false;
    }

    return true;
}

/**
 * Check if Divi theme or Divi Builder plugin is active.
 *
 * @return bool True if Divi is available, false otherwise.
 */
function divi_ai_is_divi_active() {
    // Check for Divi theme.
    $theme = wp_get_theme();
    if ( 'Divi' === $theme->get( 'Name' ) || 'Divi' === $theme->get( 'Template' ) ) {
        return true;
    }

    // Check for Divi Builder plugin.
    if ( class_exists( 'ET_Builder_Plugin' ) ) {
        return true;
    }

    // Check for Extra theme (uses Divi Builder).
    if ( 'Extra' === $theme->get( 'Name' ) || 'Extra' === $theme->get( 'Template' ) ) {
        return true;
    }

    return false;
}

/**
 * Display admin notice if Divi is not active.
 *
 * @return void
 */
function divi_ai_divi_required_notice() {
    echo '<div class="notice notice-error"><p>';
    esc_html_e( 'Divi AI Page Builder requires the Divi theme or Divi Builder plugin to be installed and active.', 'divi-ai-pagebuilder' );
    echo '</p></div>';
}

/**
 * Initialize the plugin.
 *
 * @return void
 */
function divi_ai_init() {
    // Check requirements.
    if ( ! divi_ai_check_requirements() ) {
        return;
    }

    // Check for Divi.
    if ( ! divi_ai_is_divi_active() ) {
        add_action( 'admin_notices', 'divi_ai_divi_required_notice' );
        return;
    }

    // Load text domain for translations.
    load_plugin_textdomain( 'divi-ai-pagebuilder', false, dirname( DIVI_AI_PLUGIN_BASENAME ) . '/languages' );

    // Include core files.
    // require_once DIVI_AI_PLUGIN_DIR . 'includes/class-plugin.php';

    // Initialize the plugin.
    // DiviAI\Plugin::instance();

    /**
     * Fires after the Divi AI Page Builder plugin is fully loaded.
     *
     * @since 1.0.0
     */
    do_action( 'divi_ai_loaded' );
}
add_action( 'plugins_loaded', 'divi_ai_init' );

/**
 * Plugin activation hook.
 *
 * @return void
 */
function divi_ai_activate() {
    // Check requirements before activation.
    if ( ! divi_ai_check_requirements() ) {
        wp_die(
            esc_html__( 'Divi AI Page Builder cannot be activated. Please check the requirements.', 'divi-ai-pagebuilder' ),
            'Plugin Activation Error',
            array( 'back_link' => true )
        );
    }

    // Set default options.
    $default_options = array(
        'version'            => DIVI_AI_VERSION,
        'installed_at'       => current_time( 'mysql' ),
        'openai_api_key'     => '',
        'anthropic_api_key'  => '',
        'default_ai_provider'=> 'openai',
        'rate_limit'         => 100,
        'rate_period'        => 3600,
    );

    // Only set defaults if options don't exist.
    if ( ! get_option( 'divi_ai_settings' ) ) {
        add_option( 'divi_ai_settings', $default_options );
    }

    // Create custom database tables.
    divi_ai_create_tables();

    // Flush rewrite rules.
    flush_rewrite_rules();

    /**
     * Fires after the Divi AI Page Builder plugin is activated.
     *
     * @since 1.0.0
     */
    do_action( 'divi_ai_activated' );
}
register_activation_hook( __FILE__, 'divi_ai_activate' );

/**
 * Plugin deactivation hook.
 *
 * @return void
 */
function divi_ai_deactivate() {
    // Flush rewrite rules.
    flush_rewrite_rules();

    /**
     * Fires after the Divi AI Page Builder plugin is deactivated.
     *
     * @since 1.0.0
     */
    do_action( 'divi_ai_deactivated' );
}
register_deactivation_hook( __FILE__, 'divi_ai_deactivate' );

/**
 * Create custom database tables.
 *
 * @return void
 */
function divi_ai_create_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = array();

    // AI Generation History table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_history (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        prompt TEXT NOT NULL,
        response LONGTEXT,
        ai_provider VARCHAR(50),
        tokens_used INT UNSIGNED,
        generation_type VARCHAR(50),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_created_at (created_at)
    ) $charset_collate;";

    // Usage Tracking table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_usage (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id BIGINT UNSIGNED NOT NULL,
        period_start DATE NOT NULL,
        tokens_used BIGINT UNSIGNED DEFAULT 0,
        requests_count INT UNSIGNED DEFAULT 0,
        UNIQUE KEY unique_user_period (user_id, period_start)
    ) $charset_collate;";

    // Prompt Templates table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_prompt_templates (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100),
        prompt_template TEXT NOT NULL,
        is_system TINYINT(1) DEFAULT 0,
        created_by BIGINT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    ) $charset_collate;";

    // Template Library table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_template_library (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        template_id VARCHAR(100) NOT NULL UNIQUE,
        name VARCHAR(255) NOT NULL,
        category VARCHAR(100) NOT NULL,
        subcategory VARCHAR(100),
        tags JSON,
        industry JSON,
        color_palette JSON,
        fonts_used JSON,
        module_count INT UNSIGNED,
        preview_url VARCHAR(500),
        json_path VARCHAR(500),
        json_content LONGTEXT,
        popularity_score DECIMAL(3,2) DEFAULT 0.00,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category),
        INDEX idx_subcategory (subcategory),
        INDEX idx_popularity (popularity_score),
        FULLTEXT idx_search (name, category, subcategory)
    ) $charset_collate;";

    // User Style Profiles table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_style_profiles (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        profile_name VARCHAR(100) NOT NULL,
        is_active TINYINT(1) DEFAULT 0,
        color_primary VARCHAR(7),
        color_secondary VARCHAR(7),
        color_accent VARCHAR(7),
        color_text_primary VARCHAR(7),
        color_text_secondary VARCHAR(7),
        color_text_light VARCHAR(7),
        color_bg_primary VARCHAR(7),
        color_bg_secondary VARCHAR(7),
        color_bg_dark VARCHAR(7),
        font_heading VARCHAR(100),
        font_body VARCHAR(100),
        font_accent VARCHAR(100),
        custom_tokens JSON,
        created_by BIGINT UNSIGNED,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_active (is_active)
    ) $charset_collate;";

    // Template Transformation Cache table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_transform_cache (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        template_id VARCHAR(100) NOT NULL,
        profile_hash VARCHAR(32) NOT NULL,
        transformed_json LONGTEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        expires_at DATETIME,
        UNIQUE KEY unique_transform (template_id, profile_hash),
        INDEX idx_expires (expires_at)
    ) $charset_collate;";

    // Wizard Sessions table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_wizard_sessions (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        session_id VARCHAR(64) NOT NULL UNIQUE,
        user_id BIGINT UNSIGNED NOT NULL,
        wizard_type ENUM('page', 'section', 'site_setup') NOT NULL,
        current_step VARCHAR(50) NOT NULL,
        step_data JSON,
        accumulated_data JSON,
        status ENUM('active', 'completed', 'abandoned') DEFAULT 'active',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        expires_at DATETIME,
        INDEX idx_user_id (user_id),
        INDEX idx_status (status),
        INDEX idx_expires (expires_at)
    ) $charset_collate;";

    // Media Cache table.
    $sql[] = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}divi_ai_media_cache (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        source VARCHAR(50) NOT NULL,
        source_id VARCHAR(255) NOT NULL,
        query_hash VARCHAR(32),
        media_type ENUM('image', 'video', 'pattern') NOT NULL,
        url VARCHAR(500) NOT NULL,
        thumbnail_url VARCHAR(500),
        metadata JSON,
        attribution TEXT,
        downloaded_path VARCHAR(500),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        expires_at DATETIME,
        UNIQUE KEY unique_source (source, source_id),
        INDEX idx_query (query_hash),
        INDEX idx_type (media_type),
        INDEX idx_expires (expires_at)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    foreach ( $sql as $query ) {
        dbDelta( $query );
    }

    // Store the database version.
    update_option( 'divi_ai_db_version', DIVI_AI_VERSION );
}
