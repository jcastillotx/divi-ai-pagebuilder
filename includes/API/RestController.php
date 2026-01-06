<?php
/**
 * REST API Controller.
 *
 * @package DiviAI\API
 * @since 1.0.0
 */

namespace DiviAI\API;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * REST API Controller class.
 */
class RestController {

    /**
     * API namespace.
     *
     * @var string
     */
    const NAMESPACE = 'divi-ai/v1';

    /**
     * Register REST API routes.
     *
     * @return void
     */
    public function register_routes(): void {
        // Content generation.
        register_rest_route(
            self::NAMESPACE,
            '/generate/content',
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'generate_content' ],
                'permission_callback' => [ $this, 'check_permission' ],
                'args'                => $this->get_content_args(),
            ]
        );

        // Layout generation.
        register_rest_route(
            self::NAMESPACE,
            '/generate/layout',
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'generate_layout' ],
                'permission_callback' => [ $this, 'check_permission' ],
                'args'                => $this->get_layout_args(),
            ]
        );

        // Image generation.
        register_rest_route(
            self::NAMESPACE,
            '/generate/image',
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'generate_image' ],
                'permission_callback' => [ $this, 'check_permission' ],
                'args'                => $this->get_image_args(),
            ]
        );

        // Get usage statistics.
        register_rest_route(
            self::NAMESPACE,
            '/usage',
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_usage' ],
                'permission_callback' => [ $this, 'check_permission' ],
            ]
        );

        // Templates.
        register_rest_route(
            self::NAMESPACE,
            '/templates',
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_templates' ],
                'permission_callback' => [ $this, 'check_permission' ],
                'args'                => $this->get_templates_args(),
            ]
        );

        register_rest_route(
            self::NAMESPACE,
            '/templates/(?P<id>[a-zA-Z0-9_-]+)',
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_template' ],
                'permission_callback' => [ $this, 'check_permission' ],
            ]
        );

        register_rest_route(
            self::NAMESPACE,
            '/templates/(?P<id>[a-zA-Z0-9_-]+)/transform',
            [
                'methods'             => \WP_REST_Server::CREATABLE,
                'callback'            => [ $this, 'transform_template' ],
                'permission_callback' => [ $this, 'check_permission' ],
            ]
        );

        // Design tokens.
        register_rest_route(
            self::NAMESPACE,
            '/tokens',
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_tokens' ],
                    'permission_callback' => [ $this, 'check_permission' ],
                ],
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'save_tokens' ],
                    'permission_callback' => [ $this, 'check_admin_permission' ],
                ],
            ]
        );

        // Token presets.
        register_rest_route(
            self::NAMESPACE,
            '/tokens/presets',
            [
                'methods'             => \WP_REST_Server::READABLE,
                'callback'            => [ $this, 'get_token_presets' ],
                'permission_callback' => [ $this, 'check_permission' ],
            ]
        );
    }

    /**
     * Check if user has permission.
     *
     * @return bool
     */
    public function check_permission(): bool {
        return current_user_can( 'edit_posts' );
    }

    /**
     * Check if user has admin permission.
     *
     * @return bool
     */
    public function check_admin_permission(): bool {
        return current_user_can( 'manage_options' );
    }

    /**
     * Get content generation arguments.
     *
     * @return array
     */
    private function get_content_args(): array {
        return [
            'prompt' => [
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            'type' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'general',
                'enum'     => [ 'general', 'headline', 'paragraph', 'cta', 'seo' ],
            ],
            'tone' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'professional',
            ],
            'max_tokens' => [
                'required' => false,
                'type'     => 'integer',
                'default'  => 1024,
            ],
        ];
    }

    /**
     * Get layout generation arguments.
     *
     * @return array
     */
    private function get_layout_args(): array {
        return [
            'prompt' => [
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            'type' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'section',
                'enum'     => [ 'page', 'section', 'header', 'footer' ],
            ],
            'industry' => [
                'required' => false,
                'type'     => 'string',
                'default'  => '',
            ],
            'style' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'modern',
            ],
        ];
    }

    /**
     * Get image generation arguments.
     *
     * @return array
     */
    private function get_image_args(): array {
        return [
            'prompt' => [
                'required'          => true,
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
            ],
            'size' => [
                'required' => false,
                'type'     => 'string',
                'default'  => '1792x1024',
                'enum'     => [ '1024x1024', '1792x1024', '1024x1792' ],
            ],
            'style' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'natural',
                'enum'     => [ 'natural', 'vivid' ],
            ],
            'quality' => [
                'required' => false,
                'type'     => 'string',
                'default'  => 'hd',
                'enum'     => [ 'standard', 'hd' ],
            ],
        ];
    }

    /**
     * Get templates listing arguments.
     *
     * @return array
     */
    private function get_templates_args(): array {
        return [
            'category' => [
                'required' => false,
                'type'     => 'string',
                'default'  => '',
            ],
            'search' => [
                'required' => false,
                'type'     => 'string',
                'default'  => '',
            ],
            'industry' => [
                'required' => false,
                'type'     => 'string',
                'default'  => '',
            ],
            'page' => [
                'required' => false,
                'type'     => 'integer',
                'default'  => 1,
            ],
            'per_page' => [
                'required' => false,
                'type'     => 'integer',
                'default'  => 24,
            ],
        ];
    }

    /**
     * Generate content endpoint.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response|\WP_Error
     */
    public function generate_content( \WP_REST_Request $request ) {
        $prompt     = $request->get_param( 'prompt' );
        $type       = $request->get_param( 'type' );
        $tone       = $request->get_param( 'tone' );
        $max_tokens = $request->get_param( 'max_tokens' );

        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create_default();

            $system_prompt = $this->build_content_system_prompt( $type, $tone );

            $result = $provider->generate_text( $prompt, [
                'system'     => $system_prompt,
                'max_tokens' => $max_tokens,
            ] );

            if ( ! $result['success'] ) {
                return new \WP_Error( 'generation_failed', $result['error'], [ 'status' => 500 ] );
            }

            return rest_ensure_response( [
                'success'     => true,
                'content'     => $result['content'],
                'tokens_used' => $result['tokens_used'],
            ] );

        } catch ( \Exception $e ) {
            return new \WP_Error( 'generation_error', $e->getMessage(), [ 'status' => 500 ] );
        }
    }

    /**
     * Generate layout endpoint.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response|\WP_Error
     */
    public function generate_layout( \WP_REST_Request $request ) {
        $prompt   = $request->get_param( 'prompt' );
        $type     = $request->get_param( 'type' );
        $industry = $request->get_param( 'industry' );
        $style    = $request->get_param( 'style' );

        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create_default();

            $system_prompt = $this->build_layout_system_prompt( $type, $industry, $style );
            $json_schema   = $this->get_layout_json_schema( $type );

            $result = $provider->generate_structured( $prompt, $json_schema, [
                'system'     => $system_prompt,
                'max_tokens' => 4096,
            ] );

            if ( ! $result['success'] ) {
                return new \WP_Error( 'generation_failed', $result['error'], [ 'status' => 500 ] );
            }

            return rest_ensure_response( [
                'success'     => true,
                'layout'      => $result['data'],
                'tokens_used' => $result['tokens_used'],
            ] );

        } catch ( \Exception $e ) {
            return new \WP_Error( 'generation_error', $e->getMessage(), [ 'status' => 500 ] );
        }
    }

    /**
     * Generate image endpoint.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response|\WP_Error
     */
    public function generate_image( \WP_REST_Request $request ) {
        $prompt  = $request->get_param( 'prompt' );
        $size    = $request->get_param( 'size' );
        $style   = $request->get_param( 'style' );
        $quality = $request->get_param( 'quality' );

        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create( 'openai' );

            if ( ! $provider->supports( 'image' ) ) {
                return new \WP_Error(
                    'not_supported',
                    __( 'Image generation not supported.', 'divi-ai-pagebuilder' ),
                    [ 'status' => 400 ]
                );
            }

            $result = $provider->generate_image( $prompt, [
                'size'    => $size,
                'style'   => $style,
                'quality' => $quality,
            ] );

            if ( ! $result['success'] ) {
                return new \WP_Error( 'generation_failed', $result['error'], [ 'status' => 500 ] );
            }

            return rest_ensure_response( [
                'success'        => true,
                'url'            => $result['url'],
                'revised_prompt' => $result['revised_prompt'] ?? '',
            ] );

        } catch ( \Exception $e ) {
            return new \WP_Error( 'generation_error', $e->getMessage(), [ 'status' => 500 ] );
        }
    }

    /**
     * Get usage statistics.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response
     */
    public function get_usage( \WP_REST_Request $request ) {
        $usage = divi_ai_get_usage();

        $settings = [
            'rate_limit'    => divi_ai_get_setting( 'rate_limit', 100 ),
            'token_budget'  => divi_ai_get_setting( 'token_budget', 1000000 ),
        ];

        return rest_ensure_response( [
            'usage'    => $usage,
            'limits'   => $settings,
            'period'   => gmdate( 'F Y' ),
        ] );
    }

    /**
     * Get templates listing.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response
     */
    public function get_templates( \WP_REST_Request $request ) {
        $templates = divi_ai_get( 'templates' );

        $results = $templates->search( [
            'category' => $request->get_param( 'category' ),
            'search'   => $request->get_param( 'search' ),
            'industry' => $request->get_param( 'industry' ),
        ], $request->get_param( 'page' ), $request->get_param( 'per_page' ) );

        return rest_ensure_response( $results );
    }

    /**
     * Get single template.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response|\WP_Error
     */
    public function get_template( \WP_REST_Request $request ) {
        $templates = divi_ai_get( 'templates' );
        $template  = $templates->get( $request->get_param( 'id' ) );

        if ( ! $template ) {
            return new \WP_Error( 'not_found', __( 'Template not found.', 'divi-ai-pagebuilder' ), [ 'status' => 404 ] );
        }

        return rest_ensure_response( $template );
    }

    /**
     * Transform template with user tokens.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response|\WP_Error
     */
    public function transform_template( \WP_REST_Request $request ) {
        $templates = divi_ai_get( 'templates' );
        $tokens    = $request->get_json_params()['tokens'] ?? [];

        $result = $templates->transform( $request->get_param( 'id' ), $tokens );

        if ( ! $result ) {
            return new \WP_Error( 'transform_failed', __( 'Failed to transform template.', 'divi-ai-pagebuilder' ), [ 'status' => 500 ] );
        }

        return rest_ensure_response( $result );
    }

    /**
     * Get design tokens.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response
     */
    public function get_tokens( \WP_REST_Request $request ) {
        $tokens = divi_ai_get( 'design_tokens' );
        return rest_ensure_response( $tokens->get_all() );
    }

    /**
     * Save design tokens.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response
     */
    public function save_tokens( \WP_REST_Request $request ) {
        $tokens = divi_ai_get( 'design_tokens' );
        $data   = $request->get_json_params();

        $tokens->save( $data );

        return rest_ensure_response( [
            'success' => true,
            'message' => __( 'Tokens saved successfully.', 'divi-ai-pagebuilder' ),
        ] );
    }

    /**
     * Get token presets.
     *
     * @param \WP_REST_Request $request Request object.
     * @return \WP_REST_Response
     */
    public function get_token_presets( \WP_REST_Request $request ) {
        $tokens = divi_ai_get( 'design_tokens' );
        return rest_ensure_response( $tokens->get_presets() );
    }

    /**
     * Build content system prompt.
     *
     * @param string $type Content type.
     * @param string $tone Writing tone.
     * @return string
     */
    private function build_content_system_prompt( string $type, string $tone ): string {
        $base = 'You are a professional copywriter creating content for a website. ';
        $base .= "Write in a {$tone} tone. ";

        $type_instructions = [
            'headline'  => 'Create compelling headlines that grab attention. Max 10 words.',
            'paragraph' => 'Write clear, engaging body copy. 2-3 sentences.',
            'cta'       => 'Create action-oriented call-to-action text. 2-4 words.',
            'seo'       => 'Write SEO-optimized content with relevant keywords.',
            'general'   => 'Create website content that is clear, engaging, and conversion-focused.',
        ];

        return $base . ( $type_instructions[ $type ] ?? $type_instructions['general'] );
    }

    /**
     * Build layout system prompt.
     *
     * @param string $type     Layout type.
     * @param string $industry Industry.
     * @param string $style    Design style.
     * @return string
     */
    private function build_layout_system_prompt( string $type, string $industry, string $style ): string {
        $prompt = 'You are an expert web designer creating Divi Builder layouts. ';
        $prompt .= "Create a {$type} layout";

        if ( $industry ) {
            $prompt .= " for a {$industry} business";
        }

        if ( $style ) {
            $prompt .= " with a {$style} design style";
        }

        $prompt .= '. The layout should be modern, professional, and conversion-optimized.';

        return $prompt;
    }

    /**
     * Get layout JSON schema.
     *
     * @param string $type Layout type.
     * @return string
     */
    private function get_layout_json_schema( string $type ): string {
        $schema = [
            'type'       => 'object',
            'properties' => [
                'sections' => [
                    'type'  => 'array',
                    'items' => [
                        'type'       => 'object',
                        'properties' => [
                            'type'       => [ 'type' => 'string' ],
                            'headline'   => [ 'type' => 'string' ],
                            'subheadline' => [ 'type' => 'string' ],
                            'body'       => [ 'type' => 'string' ],
                            'cta_text'   => [ 'type' => 'string' ],
                            'cta_url'    => [ 'type' => 'string' ],
                            'background' => [ 'type' => 'string' ],
                        ],
                    ],
                ],
            ],
        ];

        return wp_json_encode( $schema );
    }

    /**
     * AJAX handler for content generation (for non-REST calls).
     *
     * @return void
     */
    public function ajax_generate_content(): void {
        check_ajax_referer( 'divi_ai_admin', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $prompt     = sanitize_textarea_field( wp_unslash( $_POST['prompt'] ?? '' ) );
        $type       = sanitize_text_field( wp_unslash( $_POST['type'] ?? 'general' ) );
        $tone       = sanitize_text_field( wp_unslash( $_POST['tone'] ?? 'professional' ) );

        try {
            $factory  = new \DiviAI\AI\ProviderFactory();
            $provider = $factory->create_default();

            $result = $provider->generate_text( $prompt, [
                'system' => $this->build_content_system_prompt( $type, $tone ),
            ] );

            if ( $result['success'] ) {
                wp_send_json_success( $result );
            } else {
                wp_send_json_error( [ 'message' => $result['error'] ], 500 );
            }

        } catch ( \Exception $e ) {
            wp_send_json_error( [ 'message' => $e->getMessage() ], 500 );
        }
    }
}
