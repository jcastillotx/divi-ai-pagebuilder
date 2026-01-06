<?php
/**
 * AI Creation Wizard Controller.
 *
 * @package DiviAI\Wizard
 * @since 1.0.0
 */

namespace DiviAI\Wizard;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Wizard Controller class.
 */
class WizardController {

    /**
     * Database table name.
     *
     * @var string
     */
    private string $table;

    /**
     * Wizard types and their steps.
     *
     * @var array
     */
    private array $wizard_steps = [
        'page' => [
            'page_type',
            'layout_preference',
            'content_overview',
            'media_requirements',
            'preview',
        ],
        'section' => [
            'section_type',
            'background_options',
            'content_description',
            'preview',
        ],
        'site_setup' => [
            'header_select',
            'footer_select',
            'page_404_select',
            'logo_menu_setup',
            'complete',
        ],
    ];

    /**
     * Constructor.
     */
    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'divi_ai_wizard_sessions';
    }

    /**
     * AJAX handler for starting a wizard.
     *
     * @return void
     */
    public function ajax_start(): void {
        check_ajax_referer( 'divi_ai_wizard', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $type = sanitize_text_field( wp_unslash( $_POST['type'] ?? 'page' ) );

        if ( ! isset( $this->wizard_steps[ $type ] ) ) {
            wp_send_json_error( [ 'message' => __( 'Invalid wizard type', 'divi-ai-pagebuilder' ) ], 400 );
        }

        $session = $this->create_session( $type );

        wp_send_json_success( [
            'session_id' => $session['session_id'],
            'type'       => $type,
            'steps'      => $this->wizard_steps[ $type ],
            'current_step' => $this->wizard_steps[ $type ][0],
        ] );
    }

    /**
     * AJAX handler for saving step data.
     *
     * @return void
     */
    public function ajax_save_step(): void {
        check_ajax_referer( 'divi_ai_wizard', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $session_id = sanitize_text_field( wp_unslash( $_POST['session_id'] ?? '' ) );
        $step_data  = json_decode( wp_unslash( $_POST['step_data'] ?? '{}' ), true );

        $session = $this->get_session( $session_id );

        if ( ! $session ) {
            wp_send_json_error( [ 'message' => __( 'Session not found or expired', 'divi-ai-pagebuilder' ) ], 404 );
        }

        // Merge step data with accumulated data.
        $accumulated = json_decode( $session['accumulated_data'] ?? '{}', true );
        $accumulated = array_merge( $accumulated, $step_data );

        // Get next step.
        $steps       = $this->wizard_steps[ $session['wizard_type'] ];
        $current_idx = array_search( $session['current_step'], $steps, true );
        $next_idx    = $current_idx + 1;
        $next_step   = $next_idx < count( $steps ) ? $steps[ $next_idx ] : 'complete';

        $this->update_session( $session_id, [
            'current_step'     => $next_step,
            'accumulated_data' => wp_json_encode( $accumulated ),
            'step_data'        => wp_json_encode( $step_data ),
        ] );

        wp_send_json_success( [
            'next_step'        => $next_step,
            'accumulated_data' => $accumulated,
            'is_complete'      => $next_step === 'complete' || $next_step === 'preview',
        ] );
    }

    /**
     * Create a new wizard session.
     *
     * @param string $type Wizard type.
     * @return array Session data.
     */
    public function create_session( string $type ): array {
        global $wpdb;

        $session_id = wp_generate_uuid4();
        $first_step = $this->wizard_steps[ $type ][0];

        $wpdb->insert(
            $this->table,
            [
                'session_id'       => $session_id,
                'user_id'          => get_current_user_id(),
                'wizard_type'      => $type,
                'current_step'     => $first_step,
                'step_data'        => '{}',
                'accumulated_data' => '{}',
                'status'           => 'active',
                'created_at'       => current_time( 'mysql' ),
                'updated_at'       => current_time( 'mysql' ),
                'expires_at'       => gmdate( 'Y-m-d H:i:s', time() + HOUR_IN_SECONDS ),
            ],
            [ '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' ]
        );

        return [
            'session_id'   => $session_id,
            'wizard_type'  => $type,
            'current_step' => $first_step,
        ];
    }

    /**
     * Get a wizard session.
     *
     * @param string $session_id Session ID.
     * @return array|null Session data or null.
     */
    public function get_session( string $session_id ): ?array {
        global $wpdb;

        $session = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table}
                 WHERE session_id = %s AND status = 'active' AND expires_at > NOW()",
                $session_id
            ),
            ARRAY_A
        );

        return $session ?: null;
    }

    /**
     * Update a wizard session.
     *
     * @param string $session_id Session ID.
     * @param array  $data       Data to update.
     * @return bool
     */
    public function update_session( string $session_id, array $data ): bool {
        global $wpdb;

        $data['updated_at'] = current_time( 'mysql' );

        $result = $wpdb->update(
            $this->table,
            $data,
            [ 'session_id' => $session_id ]
        );

        return false !== $result;
    }

    /**
     * Complete a wizard session.
     *
     * @param string $session_id Session ID.
     * @return bool
     */
    public function complete_session( string $session_id ): bool {
        return $this->update_session( $session_id, [
            'status' => 'completed',
        ] );
    }

    /**
     * Generate content for a wizard session.
     *
     * @param string $session_id Session ID.
     * @return array Generated content.
     */
    public function generate( string $session_id ): array {
        $session = $this->get_session( $session_id );

        if ( ! $session ) {
            return [ 'success' => false, 'error' => __( 'Session not found', 'divi-ai-pagebuilder' ) ];
        }

        $accumulated = json_decode( $session['accumulated_data'] ?? '{}', true );

        switch ( $session['wizard_type'] ) {
            case 'page':
                return $this->generate_page( $accumulated );
            case 'section':
                return $this->generate_section( $accumulated );
            case 'site_setup':
                return $this->apply_site_setup( $accumulated );
            default:
                return [ 'success' => false, 'error' => __( 'Unknown wizard type', 'divi-ai-pagebuilder' ) ];
        }
    }

    /**
     * Generate a full page.
     *
     * @param array $data Wizard data.
     * @return array Generation result.
     */
    private function generate_page( array $data ): array {
        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create_default();

            $prompt = $this->build_page_prompt( $data );

            $result = $provider->generate_structured( $prompt, $this->get_page_schema(), [
                'max_tokens' => 4096,
            ] );

            if ( ! $result['success'] ) {
                return $result;
            }

            // Get templates based on sections.
            $templates = divi_ai_get( 'templates' );
            $tokens    = divi_ai_get( 'design_tokens' )->get_all();

            $sections = [];
            foreach ( $result['data']['sections'] ?? [] as $section ) {
                // Find best matching template.
                $template_results = $templates->search( [ 'category' => 'sections/' . $section['type'] ], 1, 1 );

                if ( ! empty( $template_results['templates'] ) ) {
                    $template = $template_results['templates'][0];
                    $transformed = $templates->transform( $template['template_id'], $tokens );
                    $section['template'] = $transformed;
                }

                $sections[] = $section;
            }

            return [
                'success'  => true,
                'sections' => $sections,
                'metadata' => $result['data'],
            ];

        } catch ( \Exception $e ) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Generate a single section.
     *
     * @param array $data Wizard data.
     * @return array Generation result.
     */
    private function generate_section( array $data ): array {
        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create_default();

            $prompt = $this->build_section_prompt( $data );

            $result = $provider->generate_structured( $prompt, $this->get_section_schema(), [
                'max_tokens' => 2048,
            ] );

            if ( ! $result['success'] ) {
                return $result;
            }

            // Get template.
            $templates = divi_ai_get( 'templates' );
            $tokens    = divi_ai_get( 'design_tokens' )->get_all();

            $section_type = $data['section_type'] ?? 'hero';
            $template_results = $templates->search( [ 'category' => 'sections/' . $section_type ], 1, 1 );

            $template_data = null;
            if ( ! empty( $template_results['templates'] ) ) {
                $template = $template_results['templates'][0];
                $template_data = $templates->transform( $template['template_id'], $tokens );
            }

            return [
                'success'  => true,
                'content'  => $result['data'],
                'template' => $template_data,
            ];

        } catch ( \Exception $e ) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Apply site setup configuration.
     *
     * @param array $data Wizard data.
     * @return array Result.
     */
    private function apply_site_setup( array $data ): array {
        $results = [];

        // Handle header.
        if ( ! empty( $data['header_template'] ) ) {
            $results['header'] = $this->apply_theme_builder_template( 'header', $data['header_template'] );
        }

        // Handle footer.
        if ( ! empty( $data['footer_template'] ) ) {
            $results['footer'] = $this->apply_theme_builder_template( 'footer', $data['footer_template'] );
        }

        // Handle 404 page.
        if ( ! empty( $data['page_404_template'] ) ) {
            $results['page_404'] = $this->apply_theme_builder_template( '404', $data['page_404_template'] );
        }

        // Handle logo.
        if ( ! empty( $data['logo_attachment_id'] ) ) {
            set_theme_mod( 'custom_logo', absint( $data['logo_attachment_id'] ) );
            $results['logo'] = true;
        }

        // Handle menu.
        if ( ! empty( $data['create_menu'] ) ) {
            $results['menu'] = $this->create_primary_menu( $data['menu_pages'] ?? [] );
        }

        return [
            'success' => true,
            'results' => $results,
        ];
    }

    /**
     * Apply a template to Theme Builder.
     *
     * @param string $type     Template type (header, footer, 404).
     * @param string $template Template JSON.
     * @return bool
     */
    private function apply_theme_builder_template( string $type, string $template ): bool {
        // This would integrate with Divi Theme Builder API.
        // For now, we'll store it in options.
        update_option( "divi_ai_{$type}_template", $template );
        return true;
    }

    /**
     * Create primary navigation menu.
     *
     * @param array $pages Page IDs to include.
     * @return int|false Menu ID or false.
     */
    private function create_primary_menu( array $pages ) {
        $menu_name = __( 'Primary Menu', 'divi-ai-pagebuilder' );
        $menu_id   = wp_create_nav_menu( $menu_name );

        if ( is_wp_error( $menu_id ) ) {
            return false;
        }

        $menu_order = 0;
        foreach ( $pages as $page_id ) {
            $page = get_post( $page_id );
            if ( $page && 'publish' === $page->post_status ) {
                wp_update_nav_menu_item( $menu_id, 0, [
                    'menu-item-title'     => $page->post_title,
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object'    => 'page',
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $menu_order++,
                ] );
            }
        }

        // Assign to primary location.
        $locations = get_theme_mod( 'nav_menu_locations', [] );
        $locations['primary-menu'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locations );

        return $menu_id;
    }

    /**
     * Build prompt for page generation.
     *
     * @param array $data Wizard data.
     * @return string Prompt.
     */
    private function build_page_prompt( array $data ): string {
        $prompt  = "Create a {$data['page_type']} page layout.\n\n";
        $prompt .= "Business: {$data['business_name']}\n";
        $prompt .= "Industry: {$data['industry']}\n";
        $prompt .= "Description: {$data['description']}\n";
        $prompt .= "Target Audience: {$data['target_audience']}\n";
        $prompt .= "Tone: {$data['tone']}\n";
        $prompt .= "Layout Style: {$data['layout_preference']}\n\n";
        $prompt .= "Generate a complete page with appropriate sections, headlines, body text, and CTAs.";

        return $prompt;
    }

    /**
     * Build prompt for section generation.
     *
     * @param array $data Wizard data.
     * @return string Prompt.
     */
    private function build_section_prompt( array $data ): string {
        $prompt  = "Create a {$data['section_type']} section.\n\n";
        $prompt .= "Content Description: {$data['content_description']}\n";
        $prompt .= "Background: {$data['background_type']}\n\n";
        $prompt .= "Generate compelling headline, subheadline, body text, and CTA.";

        return $prompt;
    }

    /**
     * Get JSON schema for page generation.
     *
     * @return string JSON schema.
     */
    private function get_page_schema(): string {
        return wp_json_encode( [
            'type'       => 'object',
            'properties' => [
                'sections' => [
                    'type'  => 'array',
                    'items' => [
                        'type'       => 'object',
                        'properties' => [
                            'type'        => [ 'type' => 'string' ],
                            'headline'    => [ 'type' => 'string' ],
                            'subheadline' => [ 'type' => 'string' ],
                            'body'        => [ 'type' => 'string' ],
                            'cta_text'    => [ 'type' => 'string' ],
                            'bullets'     => [ 'type' => 'array', 'items' => [ 'type' => 'string' ] ],
                        ],
                    ],
                ],
            ],
        ] );
    }

    /**
     * Get JSON schema for section generation.
     *
     * @return string JSON schema.
     */
    private function get_section_schema(): string {
        return wp_json_encode( [
            'type'       => 'object',
            'properties' => [
                'headline'    => [ 'type' => 'string' ],
                'subheadline' => [ 'type' => 'string' ],
                'body'        => [ 'type' => 'string' ],
                'cta_text'    => [ 'type' => 'string' ],
                'bullets'     => [ 'type' => 'array', 'items' => [ 'type' => 'string' ] ],
            ],
        ] );
    }
}
