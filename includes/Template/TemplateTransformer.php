<?php
/**
 * Template Transformer - Applies design tokens to templates.
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
 * Template Transformer class.
 */
class TemplateTransformer {

    /**
     * Color mapping from template to tokens.
     *
     * @var array
     */
    private array $color_mapping = [];

    /**
     * User design tokens.
     *
     * @var array
     */
    private array $tokens = [];

    /**
     * Transform a template with user tokens.
     *
     * @param array $template Template JSON structure.
     * @param array $tokens   User design tokens.
     * @return array Transformed template.
     */
    public function transform( array $template, array $tokens ): array {
        $this->tokens = $tokens;

        // Build color mapping from template colors.
        $this->build_color_mapping( $template );

        // Walk and transform the template.
        return $this->walk_and_transform( $template );
    }

    /**
     * Build color mapping by analyzing template colors.
     *
     * @param array $template Template structure.
     * @return void
     */
    private function build_color_mapping( array $template ): void {
        // Extract all colors from template.
        $colors = $this->extract_colors( $template );

        // Analyze and map each color to a semantic role.
        foreach ( $colors as $color ) {
            if ( ! isset( $this->color_mapping[ $color ] ) ) {
                $this->color_mapping[ $color ] = $this->determine_color_role( $color );
            }
        }
    }

    /**
     * Extract all colors from template.
     *
     * @param array $node Template node.
     * @return array Unique colors found.
     */
    private function extract_colors( array $node ): array {
        $colors = [];

        foreach ( $node as $key => $value ) {
            if ( is_array( $value ) ) {
                $colors = array_merge( $colors, $this->extract_colors( $value ) );
            } elseif ( is_string( $value ) && $this->is_color_property( $key ) ) {
                $normalized = $this->normalize_color( $value );
                if ( $normalized ) {
                    $colors[] = $normalized;
                }
            }
        }

        return array_unique( $colors );
    }

    /**
     * Walk and transform template recursively.
     *
     * @param array $node Template node.
     * @return array Transformed node.
     */
    private function walk_and_transform( array $node ): array {
        foreach ( $node as $key => $value ) {
            if ( is_array( $value ) ) {
                $node[ $key ] = $this->walk_and_transform( $value );
            } elseif ( is_string( $value ) ) {
                $node[ $key ] = $this->transform_value( $key, $value );
            }
        }

        return $node;
    }

    /**
     * Transform a single value.
     *
     * @param string $key   Property key.
     * @param string $value Property value.
     * @return string Transformed value.
     */
    private function transform_value( string $key, string $value ): string {
        // Transform colors.
        if ( $this->is_color_property( $key ) ) {
            return $this->transform_color( $value );
        }

        // Transform fonts.
        if ( $this->is_font_property( $key ) ) {
            return $this->transform_font( $value, $key );
        }

        return $value;
    }

    /**
     * Check if property is color-related.
     *
     * @param string $key Property key.
     * @return bool
     */
    private function is_color_property( string $key ): bool {
        $color_properties = [
            'background_color',
            'text_color',
            'text_text_color',
            'button_bg_color',
            'button_text_color',
            'border_color',
            'header_text_color',
            'body_text_color',
            'link_color',
            'icon_color',
            'circle_color',
            'bar_bg_color',
            'use_background_color',
            'button_bg_color_gradient_start',
            'button_bg_color_gradient_end',
            'background_color_gradient_start',
            'background_color_gradient_end',
        ];

        foreach ( $color_properties as $prop ) {
            if ( strpos( $key, $prop ) !== false ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if property is font-related.
     *
     * @param string $key Property key.
     * @return bool
     */
    private function is_font_property( string $key ): bool {
        return strpos( $key, '_font' ) !== false && strpos( $key, '_font_size' ) === false;
    }

    /**
     * Normalize color format.
     *
     * @param string $color Color value.
     * @return string|null Normalized hex color or null.
     */
    private function normalize_color( string $color ): ?string {
        $color = trim( $color );

        // Already hex.
        if ( preg_match( '/^#[0-9A-Fa-f]{6}$/', $color ) ) {
            return strtolower( $color );
        }

        // Short hex.
        if ( preg_match( '/^#([0-9A-Fa-f])([0-9A-Fa-f])([0-9A-Fa-f])$/', $color, $matches ) ) {
            return '#' . strtolower( $matches[1] . $matches[1] . $matches[2] . $matches[2] . $matches[3] . $matches[3] );
        }

        // RGB/RGBA.
        if ( preg_match( '/^rgba?\s*\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)/', $color, $matches ) ) {
            return sprintf( '#%02x%02x%02x', $matches[1], $matches[2], $matches[3] );
        }

        return null;
    }

    /**
     * Determine the semantic role of a color.
     *
     * @param string $hex Hex color.
     * @return string Role identifier.
     */
    private function determine_color_role( string $hex ): string {
        $hsl = $this->hex_to_hsl( $hex );

        // Pure white.
        if ( $hsl['l'] >= 98 ) {
            return 'text_light';
        }

        // Very light (backgrounds).
        if ( $hsl['l'] >= 90 ) {
            return 'bg_primary';
        }

        // Light with low saturation (secondary backgrounds).
        if ( $hsl['l'] >= 80 && $hsl['s'] <= 20 ) {
            return 'bg_secondary';
        }

        // Very dark.
        if ( $hsl['l'] <= 20 ) {
            if ( $hsl['s'] <= 10 ) {
                return 'text_primary';
            }
            return 'bg_dark';
        }

        // Medium gray (secondary text).
        if ( $hsl['s'] <= 10 && $hsl['l'] >= 30 && $hsl['l'] <= 60 ) {
            return 'text_secondary';
        }

        // High saturation, medium luminance (primary/accent colors).
        if ( $hsl['s'] >= 50 && $hsl['l'] >= 30 && $hsl['l'] <= 70 ) {
            return 'primary';
        }

        // Default to secondary.
        return 'secondary';
    }

    /**
     * Transform a color based on its role.
     *
     * @param string $color Original color.
     * @return string Transformed color.
     */
    private function transform_color( string $color ): string {
        $normalized = $this->normalize_color( $color );

        if ( ! $normalized ) {
            return $color;
        }

        $role = $this->color_mapping[ $normalized ] ?? null;

        if ( ! $role ) {
            return $color;
        }

        // Map role to token.
        $token_map = [
            'primary'        => 'colors.primary',
            'secondary'      => 'colors.secondary',
            'accent'         => 'colors.accent',
            'text_primary'   => 'colors.textPrimary',
            'text_secondary' => 'colors.textSecondary',
            'text_light'     => 'colors.textLight',
            'bg_primary'     => 'colors.bgPrimary',
            'bg_secondary'   => 'colors.bgSecondary',
            'bg_dark'        => 'colors.bgDark',
        ];

        $token_path = $token_map[ $role ] ?? null;

        if ( ! $token_path ) {
            return $color;
        }

        $new_color = $this->get_token_value( $token_path );

        return $new_color ?: $color;
    }

    /**
     * Transform a font value.
     *
     * @param string $font_string Divi font string.
     * @param string $property    Property name.
     * @return string Transformed font string.
     */
    private function transform_font( string $font_string, string $property ): string {
        $parts     = explode( '|', $font_string );
        $font_name = $parts[0] ?? '';

        // Determine if heading or body font.
        $is_heading = $this->is_heading_font_property( $property );
        $token_key  = $is_heading ? 'fonts.heading' : 'fonts.body';

        $new_font = $this->get_token_value( $token_key );

        if ( $new_font ) {
            $parts[0] = $new_font;
        }

        return implode( '|', $parts );
    }

    /**
     * Check if font property is for headings.
     *
     * @param string $property Property name.
     * @return bool
     */
    private function is_heading_font_property( string $property ): bool {
        $heading_keywords = [ 'header', 'title', 'heading' ];

        foreach ( $heading_keywords as $keyword ) {
            if ( stripos( $property, $keyword ) !== false ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a token value by path.
     *
     * @param string $path Dot-notation path.
     * @return mixed|null Token value or null.
     */
    private function get_token_value( string $path ) {
        $keys   = explode( '.', $path );
        $value  = $this->tokens;

        foreach ( $keys as $key ) {
            if ( ! isset( $value[ $key ] ) ) {
                return null;
            }
            $value = $value[ $key ];
        }

        return $value;
    }

    /**
     * Convert hex color to HSL.
     *
     * @param string $hex Hex color.
     * @return array HSL values.
     */
    private function hex_to_hsl( string $hex ): array {
        $hex = ltrim( $hex, '#' );

        $r = hexdec( substr( $hex, 0, 2 ) ) / 255;
        $g = hexdec( substr( $hex, 2, 2 ) ) / 255;
        $b = hexdec( substr( $hex, 4, 2 ) ) / 255;

        $max = max( $r, $g, $b );
        $min = min( $r, $g, $b );
        $l   = ( $max + $min ) / 2;

        if ( $max === $min ) {
            $h = $s = 0;
        } else {
            $d = $max - $min;
            $s = $l > 0.5 ? $d / ( 2 - $max - $min ) : $d / ( $max + $min );

            switch ( $max ) {
                case $r:
                    $h = ( ( $g - $b ) / $d + ( $g < $b ? 6 : 0 ) ) / 6;
                    break;
                case $g:
                    $h = ( ( $b - $r ) / $d + 2 ) / 6;
                    break;
                case $b:
                    $h = ( ( $r - $g ) / $d + 4 ) / 6;
                    break;
            }
        }

        return [
            'h' => round( $h * 360 ),
            's' => round( $s * 100 ),
            'l' => round( $l * 100 ),
        ];
    }
}
