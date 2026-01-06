<?php
/**
 * Design Tokens Manager.
 *
 * @package DiviAI\Template
 * @since 1.0.0
 */

namespace DiviAI\Template;

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Design Tokens class for managing brand colors and fonts.
 */
class DesignTokens {

    /**
     * Token definitions.
     *
     * @var array
     */
    private array $definitions = [];

    /**
     * Color presets.
     *
     * @var array
     */
    private array $presets = [];

    /**
     * Constructor.
     */
    public function __construct() {
        $this->init_definitions();
        $this->init_presets();
    }

    /**
     * Initialize token definitions.
     *
     * @return void
     */
    private function init_definitions(): void {
        $this->definitions = [
            'colors' => [
                'primary' => [
                    'label'       => __( 'Primary Color', 'divi-ai-pagebuilder' ),
                    'default'     => '#3366ff',
                    'description' => __( 'Main brand color for buttons, links, accents', 'divi-ai-pagebuilder' ),
                ],
                'secondary' => [
                    'label'       => __( 'Secondary Color', 'divi-ai-pagebuilder' ),
                    'default'     => '#ff6633',
                    'description' => __( 'Supporting brand color', 'divi-ai-pagebuilder' ),
                ],
                'accent' => [
                    'label'       => __( 'Accent Color', 'divi-ai-pagebuilder' ),
                    'default'     => '#00cc88',
                    'description' => __( 'Highlight color for special elements', 'divi-ai-pagebuilder' ),
                ],
                'text_primary' => [
                    'label'       => __( 'Primary Text', 'divi-ai-pagebuilder' ),
                    'default'     => '#333333',
                    'description' => __( 'Main body text color', 'divi-ai-pagebuilder' ),
                ],
                'text_secondary' => [
                    'label'       => __( 'Secondary Text', 'divi-ai-pagebuilder' ),
                    'default'     => '#666666',
                    'description' => __( 'Muted/secondary text', 'divi-ai-pagebuilder' ),
                ],
                'text_light' => [
                    'label'       => __( 'Light Text', 'divi-ai-pagebuilder' ),
                    'default'     => '#ffffff',
                    'description' => __( 'Text on dark backgrounds', 'divi-ai-pagebuilder' ),
                ],
                'bg_primary' => [
                    'label'       => __( 'Primary Background', 'divi-ai-pagebuilder' ),
                    'default'     => '#ffffff',
                    'description' => __( 'Main page background', 'divi-ai-pagebuilder' ),
                ],
                'bg_secondary' => [
                    'label'       => __( 'Secondary Background', 'divi-ai-pagebuilder' ),
                    'default'     => '#f8f9fa',
                    'description' => __( 'Alternate section background', 'divi-ai-pagebuilder' ),
                ],
                'bg_dark' => [
                    'label'       => __( 'Dark Background', 'divi-ai-pagebuilder' ),
                    'default'     => '#1a1a2e',
                    'description' => __( 'Dark section background', 'divi-ai-pagebuilder' ),
                ],
            ],
            'fonts' => [
                'heading' => [
                    'label'       => __( 'Heading Font', 'divi-ai-pagebuilder' ),
                    'default'     => 'Montserrat',
                    'type'        => 'font-family',
                    'description' => __( 'Font for headings (H1-H6)', 'divi-ai-pagebuilder' ),
                ],
                'body' => [
                    'label'       => __( 'Body Font', 'divi-ai-pagebuilder' ),
                    'default'     => 'Open Sans',
                    'type'        => 'font-family',
                    'description' => __( 'Font for body text', 'divi-ai-pagebuilder' ),
                ],
                'accent' => [
                    'label'       => __( 'Accent Font', 'divi-ai-pagebuilder' ),
                    'default'     => 'Playfair Display',
                    'type'        => 'font-family',
                    'description' => __( 'Decorative/accent font', 'divi-ai-pagebuilder' ),
                ],
            ],
        ];
    }

    /**
     * Initialize color presets.
     *
     * @return void
     */
    private function init_presets(): void {
        $this->presets = [
            'professional_blue' => [
                'name'   => __( 'Professional Blue', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#2563eb',
                    'secondary'      => '#7c3aed',
                    'accent'         => '#06b6d4',
                    'text_primary'   => '#1e293b',
                    'text_secondary' => '#64748b',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#ffffff',
                    'bg_secondary'   => '#f8fafc',
                    'bg_dark'        => '#0f172a',
                ],
                'fonts' => [
                    'heading' => 'Inter',
                    'body'    => 'Inter',
                    'accent'  => 'Inter',
                ],
            ],
            'creative_coral' => [
                'name'   => __( 'Creative Coral', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#f43f5e',
                    'secondary'      => '#8b5cf6',
                    'accent'         => '#fbbf24',
                    'text_primary'   => '#18181b',
                    'text_secondary' => '#71717a',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#ffffff',
                    'bg_secondary'   => '#fafafa',
                    'bg_dark'        => '#18181b',
                ],
                'fonts' => [
                    'heading' => 'Poppins',
                    'body'    => 'Open Sans',
                    'accent'  => 'Playfair Display',
                ],
            ],
            'nature_green' => [
                'name'   => __( 'Nature Green', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#059669',
                    'secondary'      => '#0891b2',
                    'accent'         => '#ca8a04',
                    'text_primary'   => '#1c1917',
                    'text_secondary' => '#57534e',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#ffffff',
                    'bg_secondary'   => '#f5f5f4',
                    'bg_dark'        => '#1c1917',
                ],
                'fonts' => [
                    'heading' => 'Merriweather',
                    'body'    => 'Source Sans Pro',
                    'accent'  => 'Lora',
                ],
            ],
            'elegant_dark' => [
                'name'   => __( 'Elegant Dark', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#c9a227',
                    'secondary'      => '#a78bfa',
                    'accent'         => '#f472b6',
                    'text_primary'   => '#fafafa',
                    'text_secondary' => '#a1a1aa',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#09090b',
                    'bg_secondary'   => '#18181b',
                    'bg_dark'        => '#000000',
                ],
                'fonts' => [
                    'heading' => 'Playfair Display',
                    'body'    => 'Lato',
                    'accent'  => 'Cormorant Garamond',
                ],
            ],
            'modern_minimal' => [
                'name'   => __( 'Modern Minimal', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#000000',
                    'secondary'      => '#525252',
                    'accent'         => '#ef4444',
                    'text_primary'   => '#171717',
                    'text_secondary' => '#737373',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#ffffff',
                    'bg_secondary'   => '#fafafa',
                    'bg_dark'        => '#171717',
                ],
                'fonts' => [
                    'heading' => 'Roboto',
                    'body'    => 'Roboto',
                    'accent'  => 'Roboto Slab',
                ],
            ],
            'sunset_warm' => [
                'name'   => __( 'Sunset Warm', 'divi-ai-pagebuilder' ),
                'colors' => [
                    'primary'        => '#ea580c',
                    'secondary'      => '#be185d',
                    'accent'         => '#facc15',
                    'text_primary'   => '#292524',
                    'text_secondary' => '#78716c',
                    'text_light'     => '#ffffff',
                    'bg_primary'     => '#fffbeb',
                    'bg_secondary'   => '#fef3c7',
                    'bg_dark'        => '#292524',
                ],
                'fonts' => [
                    'heading' => 'Raleway',
                    'body'    => 'Nunito',
                    'accent'  => 'Dancing Script',
                ],
            ],
        ];
    }

    /**
     * Register Customizer settings.
     *
     * @param \WP_Customize_Manager $wp_customize Customizer manager.
     * @return void
     */
    public function register_customizer( \WP_Customize_Manager $wp_customize ): void {
        // Add panel.
        $wp_customize->add_panel( 'divi_ai_global_styles', [
            'title'       => __( 'Divi AI Global Styles', 'divi-ai-pagebuilder' ),
            'description' => __( 'Configure brand colors and fonts for AI-generated content.', 'divi-ai-pagebuilder' ),
            'priority'    => 30,
        ] );

        // Add color section.
        $wp_customize->add_section( 'divi_ai_colors', [
            'title' => __( 'Color Palette', 'divi-ai-pagebuilder' ),
            'panel' => 'divi_ai_global_styles',
        ] );

        // Add font section.
        $wp_customize->add_section( 'divi_ai_typography', [
            'title' => __( 'Typography', 'divi-ai-pagebuilder' ),
            'panel' => 'divi_ai_global_styles',
        ] );

        // Add preset section.
        $wp_customize->add_section( 'divi_ai_presets', [
            'title' => __( 'Style Presets', 'divi-ai-pagebuilder' ),
            'panel' => 'divi_ai_global_styles',
        ] );

        // Register color settings.
        foreach ( $this->definitions['colors'] as $key => $config ) {
            $setting_id = "divi_ai_color_{$key}";

            $wp_customize->add_setting( $setting_id, [
                'default'           => $config['default'],
                'sanitize_callback' => 'sanitize_hex_color',
                'transport'         => 'postMessage',
            ] );

            $wp_customize->add_control(
                new \WP_Customize_Color_Control(
                    $wp_customize,
                    $setting_id,
                    [
                        'label'       => $config['label'],
                        'description' => $config['description'],
                        'section'     => 'divi_ai_colors',
                    ]
                )
            );
        }

        // Register font settings.
        foreach ( $this->definitions['fonts'] as $key => $config ) {
            $setting_id = "divi_ai_font_{$key}";

            $wp_customize->add_setting( $setting_id, [
                'default'           => $config['default'],
                'sanitize_callback' => 'sanitize_text_field',
                'transport'         => 'postMessage',
            ] );

            $wp_customize->add_control( $setting_id, [
                'label'       => $config['label'],
                'description' => $config['description'],
                'section'     => 'divi_ai_typography',
                'type'        => 'select',
                'choices'     => $this->get_google_fonts(),
            ] );
        }
    }

    /**
     * Get all current token values.
     *
     * @return array
     */
    public function get_all(): array {
        $tokens = [
            'colors' => [],
            'fonts'  => [],
        ];

        foreach ( $this->definitions['colors'] as $key => $config ) {
            $tokens['colors'][ $key ] = get_theme_mod( "divi_ai_color_{$key}", $config['default'] );
        }

        foreach ( $this->definitions['fonts'] as $key => $config ) {
            $tokens['fonts'][ $key ] = get_theme_mod( "divi_ai_font_{$key}", $config['default'] );
        }

        return $tokens;
    }

    /**
     * Save token values.
     *
     * @param array $tokens Token values.
     * @return void
     */
    public function save( array $tokens ): void {
        if ( isset( $tokens['colors'] ) ) {
            foreach ( $tokens['colors'] as $key => $value ) {
                if ( isset( $this->definitions['colors'][ $key ] ) ) {
                    set_theme_mod( "divi_ai_color_{$key}", sanitize_hex_color( $value ) );
                }
            }
        }

        if ( isset( $tokens['fonts'] ) ) {
            foreach ( $tokens['fonts'] as $key => $value ) {
                if ( isset( $this->definitions['fonts'][ $key ] ) ) {
                    set_theme_mod( "divi_ai_font_{$key}", sanitize_text_field( $value ) );
                }
            }
        }
    }

    /**
     * Apply a preset.
     *
     * @param string $preset_id Preset identifier.
     * @return bool
     */
    public function apply_preset( string $preset_id ): bool {
        if ( ! isset( $this->presets[ $preset_id ] ) ) {
            return false;
        }

        $preset = $this->presets[ $preset_id ];

        $this->save( [
            'colors' => $preset['colors'],
            'fonts'  => $preset['fonts'],
        ] );

        return true;
    }

    /**
     * Get all presets.
     *
     * @return array
     */
    public function get_presets(): array {
        return $this->presets;
    }

    /**
     * Get token definitions.
     *
     * @return array
     */
    public function get_definitions(): array {
        return $this->definitions;
    }

    /**
     * Get Google Fonts list.
     *
     * @return array Font name => Font name.
     */
    private function get_google_fonts(): array {
        return [
            'Inter'              => 'Inter',
            'Roboto'             => 'Roboto',
            'Open Sans'          => 'Open Sans',
            'Lato'               => 'Lato',
            'Montserrat'         => 'Montserrat',
            'Poppins'            => 'Poppins',
            'Raleway'            => 'Raleway',
            'Nunito'             => 'Nunito',
            'Source Sans Pro'    => 'Source Sans Pro',
            'PT Sans'            => 'PT Sans',
            'Merriweather'       => 'Merriweather',
            'Playfair Display'   => 'Playfair Display',
            'Lora'               => 'Lora',
            'Roboto Slab'        => 'Roboto Slab',
            'Ubuntu'             => 'Ubuntu',
            'Work Sans'          => 'Work Sans',
            'Oswald'             => 'Oswald',
            'Fira Sans'          => 'Fira Sans',
            'Quicksand'          => 'Quicksand',
            'DM Sans'            => 'DM Sans',
            'Cabin'              => 'Cabin',
            'Rubik'              => 'Rubik',
            'Cormorant Garamond' => 'Cormorant Garamond',
            'Dancing Script'     => 'Dancing Script',
        ];
    }
}
