<?php
/**
 * Main Plugin class.
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
 * Plugin class - Singleton pattern.
 */
final class Plugin {

    /**
     * Plugin version.
     *
     * @var string
     */
    const VERSION = '1.0.0';

    /**
     * Single instance of the class.
     *
     * @var Plugin|null
     */
    private static ?Plugin $instance = null;

    /**
     * Service container.
     *
     * @var Container
     */
    private Container $container;

    /**
     * Get the single instance of the class.
     *
     * @return Plugin
     */
    public static function instance(): Plugin {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor to prevent instantiation.
     */
    private function __construct() {
        $this->container = new Container();
        $this->init();
    }

    /**
     * Initialize the plugin.
     *
     * @return void
     */
    private function init(): void {
        // Register services.
        $this->register_services();

        // Load hooks.
        $this->load_hooks();

        /**
         * Fires when the plugin is fully initialized.
         *
         * @since 1.0.0
         */
        do_action( 'divi_ai_init' );
    }

    /**
     * Register services in the container.
     *
     * @return void
     */
    private function register_services(): void {
        // Assets manager.
        $this->container->register( 'assets', function () {
            return new Assets();
        } );

        // Settings page.
        $this->container->register( 'settings', function () {
            return new \DiviAI\Admin\SettingsPage();
        } );

        // AI Provider Factory.
        $this->container->register( 'ai_factory', function () {
            return new \DiviAI\AI\ProviderFactory();
        } );

        // REST API.
        $this->container->register( 'rest_api', function () {
            return new \DiviAI\API\RestController();
        } );

        // Template Library.
        $this->container->register( 'templates', function () {
            return new \DiviAI\Template\TemplateLibrary();
        } );

        // Design Tokens.
        $this->container->register( 'design_tokens', function () {
            return new \DiviAI\Template\DesignTokens();
        } );

        // Wizard.
        $this->container->register( 'wizard', function () {
            return new \DiviAI\Wizard\WizardController();
        } );

        /**
         * Fires after default services are registered.
         * Use this to register additional services.
         *
         * @since 1.0.0
         * @param Container $container The service container.
         */
        do_action( 'divi_ai_register_services', $this->container );
    }

    /**
     * Load WordPress hooks.
     *
     * @return void
     */
    private function load_hooks(): void {
        // Admin hooks.
        if ( is_admin() ) {
            add_action( 'admin_menu', [ $this->get( 'settings' ), 'add_menu_pages' ] );
            add_action( 'admin_init', [ $this->get( 'settings' ), 'register_settings' ] );
            add_action( 'admin_enqueue_scripts', [ $this->get( 'assets' ), 'enqueue_admin_assets' ] );
        }

        // REST API hooks.
        add_action( 'rest_api_init', [ $this->get( 'rest_api' ), 'register_routes' ] );

        // Customizer hooks.
        add_action( 'customize_register', [ $this->get( 'design_tokens' ), 'register_customizer' ] );

        // AJAX handlers.
        $this->register_ajax_handlers();
    }

    /**
     * Register AJAX handlers.
     *
     * @return void
     */
    private function register_ajax_handlers(): void {
        $ajax_actions = [
            'divi_ai_test_provider'    => [ $this->get( 'settings' ), 'ajax_test_provider' ],
            'divi_ai_clear_cache'      => [ $this->get( 'settings' ), 'ajax_clear_cache' ],
            'divi_ai_export_settings'  => [ $this->get( 'settings' ), 'ajax_export_settings' ],
            'divi_ai_import_settings'  => [ $this->get( 'settings' ), 'ajax_import_settings' ],
            'divi_ai_generate_content' => [ $this->get( 'rest_api' ), 'ajax_generate_content' ],
            'divi_ai_get_templates'    => [ $this->get( 'templates' ), 'ajax_get_templates' ],
            'divi_ai_wizard_start'     => [ $this->get( 'wizard' ), 'ajax_start' ],
            'divi_ai_wizard_step'      => [ $this->get( 'wizard' ), 'ajax_save_step' ],
        ];

        foreach ( $ajax_actions as $action => $callback ) {
            add_action( "wp_ajax_{$action}", $callback );
        }
    }

    /**
     * Get a service from the container.
     *
     * @param string $service Service identifier.
     * @return mixed
     */
    public function get( string $service ) {
        return $this->container->get( $service );
    }

    /**
     * Check if a service exists.
     *
     * @param string $service Service identifier.
     * @return bool
     */
    public function has( string $service ): bool {
        return $this->container->has( $service );
    }

    /**
     * Get the container instance.
     *
     * @return Container
     */
    public function container(): Container {
        return $this->container;
    }

    /**
     * Get the plugin version.
     *
     * @return string
     */
    public function version(): string {
        return self::VERSION;
    }

    /**
     * Get the plugin directory path.
     *
     * @return string
     */
    public function dir(): string {
        return DIVI_AI_PLUGIN_DIR;
    }

    /**
     * Get the plugin URL.
     *
     * @return string
     */
    public function url(): string {
        return DIVI_AI_PLUGIN_URL;
    }

    /**
     * Prevent cloning.
     */
    private function __clone() {}

    /**
     * Prevent unserializing.
     *
     * @throws \Exception Always.
     */
    public function __wakeup() {
        throw new \Exception( 'Cannot unserialize singleton.' );
    }
}
