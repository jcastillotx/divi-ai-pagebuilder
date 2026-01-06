<?php
/**
 * Template Library Manager.
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
 * Template Library class.
 */
class TemplateLibrary {

    /**
     * Database table name.
     *
     * @var string
     */
    private string $table;

    /**
     * Constructor.
     */
    public function __construct() {
        global $wpdb;
        $this->table = $wpdb->prefix . 'divi_ai_template_library';
    }

    /**
     * Search templates.
     *
     * @param array $filters Search filters.
     * @param int   $page    Page number.
     * @param int   $per_page Items per page.
     * @return array
     */
    public function search( array $filters = [], int $page = 1, int $per_page = 24 ): array {
        global $wpdb;

        $where  = [ '1=1' ];
        $params = [];

        if ( ! empty( $filters['category'] ) ) {
            $where[]  = 'category = %s';
            $params[] = $filters['category'];
        }

        if ( ! empty( $filters['subcategory'] ) ) {
            $where[]  = 'subcategory = %s';
            $params[] = $filters['subcategory'];
        }

        if ( ! empty( $filters['search'] ) ) {
            $search   = '%' . $wpdb->esc_like( $filters['search'] ) . '%';
            $where[]  = '(name LIKE %s OR category LIKE %s OR subcategory LIKE %s)';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if ( ! empty( $filters['industry'] ) ) {
            $where[]  = 'JSON_CONTAINS(industry, %s)';
            $params[] = wp_json_encode( $filters['industry'] );
        }

        $offset = ( $page - 1 ) * $per_page;

        // Get total count.
        $count_sql = "SELECT COUNT(*) FROM {$this->table} WHERE " . implode( ' AND ', $where );
        if ( ! empty( $params ) ) {
            $count_sql = $wpdb->prepare( $count_sql, $params );
        }
        $total = (int) $wpdb->get_var( $count_sql );

        // Get templates.
        $sql = "SELECT id, template_id, name, category, subcategory, tags, industry,
                       color_palette, fonts_used, module_count, preview_url, popularity_score
                FROM {$this->table} WHERE " . implode( ' AND ', $where ) .
               " ORDER BY popularity_score DESC LIMIT %d OFFSET %d";

        $params[] = $per_page;
        $params[] = $offset;

        $templates = $wpdb->get_results( $wpdb->prepare( $sql, $params ), ARRAY_A );

        // Decode JSON fields.
        foreach ( $templates as &$template ) {
            $template['tags']          = json_decode( $template['tags'] ?? '[]', true );
            $template['industry']      = json_decode( $template['industry'] ?? '[]', true );
            $template['color_palette'] = json_decode( $template['color_palette'] ?? '{}', true );
            $template['fonts_used']    = json_decode( $template['fonts_used'] ?? '{}', true );
        }

        return [
            'templates'   => $templates,
            'total'       => $total,
            'page'        => $page,
            'per_page'    => $per_page,
            'total_pages' => ceil( $total / $per_page ),
        ];
    }

    /**
     * Get a single template.
     *
     * @param string $template_id Template ID.
     * @return array|null
     */
    public function get( string $template_id ): ?array {
        global $wpdb;

        $template = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$this->table} WHERE template_id = %s",
                $template_id
            ),
            ARRAY_A
        );

        if ( ! $template ) {
            return null;
        }

        // Decode JSON fields.
        $template['tags']          = json_decode( $template['tags'] ?? '[]', true );
        $template['industry']      = json_decode( $template['industry'] ?? '[]', true );
        $template['color_palette'] = json_decode( $template['color_palette'] ?? '{}', true );
        $template['fonts_used']    = json_decode( $template['fonts_used'] ?? '{}', true );
        $template['json_content']  = json_decode( $template['json_content'] ?? '{}', true );

        return $template;
    }

    /**
     * Transform template with user design tokens.
     *
     * @param string $template_id Template ID.
     * @param array  $tokens      User design tokens.
     * @return array|null
     */
    public function transform( string $template_id, array $tokens ): ?array {
        $template = $this->get( $template_id );

        if ( ! $template || empty( $template['json_content'] ) ) {
            return null;
        }

        // Check cache first.
        $cached = $this->get_cached_transform( $template_id, $tokens );
        if ( $cached ) {
            return $cached;
        }

        // Transform the template.
        $transformer = new TemplateTransformer();
        $transformed = $transformer->transform( $template['json_content'], $tokens );

        // Cache the result.
        $this->cache_transform( $template_id, $tokens, $transformed );

        return [
            'template_id' => $template_id,
            'json'        => $transformed,
            'original'    => $template,
        ];
    }

    /**
     * Get cached transformation.
     *
     * @param string $template_id Template ID.
     * @param array  $tokens      Design tokens.
     * @return array|null
     */
    private function get_cached_transform( string $template_id, array $tokens ): ?array {
        global $wpdb;

        $profile_hash = md5( wp_json_encode( $tokens ) );
        $cache_table  = $wpdb->prefix . 'divi_ai_transform_cache';

        $cached = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT transformed_json FROM {$cache_table}
                 WHERE template_id = %s AND profile_hash = %s AND expires_at > NOW()",
                $template_id,
                $profile_hash
            )
        );

        if ( $cached ) {
            return json_decode( $cached, true );
        }

        return null;
    }

    /**
     * Cache a transformation.
     *
     * @param string $template_id Template ID.
     * @param array  $tokens      Design tokens.
     * @param array  $transformed Transformed template.
     * @return void
     */
    private function cache_transform( string $template_id, array $tokens, array $transformed ): void {
        global $wpdb;

        $profile_hash = md5( wp_json_encode( $tokens ) );
        $cache_table  = $wpdb->prefix . 'divi_ai_transform_cache';
        $cache_hours  = divi_ai_get_setting( 'cache_duration', 24 );

        $wpdb->replace(
            $cache_table,
            [
                'template_id'      => $template_id,
                'profile_hash'     => $profile_hash,
                'transformed_json' => wp_json_encode( $transformed ),
                'created_at'       => current_time( 'mysql' ),
                'expires_at'       => gmdate( 'Y-m-d H:i:s', time() + ( $cache_hours * HOUR_IN_SECONDS ) ),
            ],
            [ '%s', '%s', '%s', '%s', '%s' ]
        );
    }

    /**
     * Get template categories.
     *
     * @return array
     */
    public function get_categories(): array {
        global $wpdb;

        $categories = $wpdb->get_results(
            "SELECT category, subcategory, COUNT(*) as count
             FROM {$this->table}
             GROUP BY category, subcategory
             ORDER BY category, subcategory",
            ARRAY_A
        );

        // Organize into tree structure.
        $tree = [];
        foreach ( $categories as $row ) {
            $cat    = $row['category'];
            $subcat = $row['subcategory'];

            if ( ! isset( $tree[ $cat ] ) ) {
                $tree[ $cat ] = [
                    'name'          => ucwords( str_replace( [ '-', '_' ], ' ', $cat ) ),
                    'slug'          => $cat,
                    'subcategories' => [],
                    'count'         => 0,
                ];
            }

            $tree[ $cat ]['count'] += (int) $row['count'];

            if ( $subcat ) {
                $tree[ $cat ]['subcategories'][] = [
                    'name'  => ucwords( str_replace( [ '-', '_' ], ' ', $subcat ) ),
                    'slug'  => $subcat,
                    'count' => (int) $row['count'],
                ];
            }
        }

        return array_values( $tree );
    }

    /**
     * Insert or update a template.
     *
     * @param array $data Template data.
     * @return int|false Template ID or false.
     */
    public function upsert( array $data ) {
        global $wpdb;

        $json_fields = [ 'tags', 'industry', 'color_palette', 'fonts_used' ];

        foreach ( $json_fields as $field ) {
            if ( isset( $data[ $field ] ) && is_array( $data[ $field ] ) ) {
                $data[ $field ] = wp_json_encode( $data[ $field ] );
            }
        }

        $exists = $wpdb->get_var(
            $wpdb->prepare(
                "SELECT id FROM {$this->table} WHERE template_id = %s",
                $data['template_id']
            )
        );

        if ( $exists ) {
            $result = $wpdb->update(
                $this->table,
                $data,
                [ 'template_id' => $data['template_id'] ]
            );
            return $result !== false ? (int) $exists : false;
        }

        $result = $wpdb->insert( $this->table, $data );
        return $result ? $wpdb->insert_id : false;
    }

    /**
     * AJAX handler for getting templates.
     *
     * @return void
     */
    public function ajax_get_templates(): void {
        check_ajax_referer( 'divi_ai_wizard', 'nonce' );

        if ( ! current_user_can( 'edit_posts' ) ) {
            wp_send_json_error( [ 'message' => __( 'Unauthorized', 'divi-ai-pagebuilder' ) ], 403 );
        }

        $category = sanitize_text_field( wp_unslash( $_POST['category'] ?? '' ) );
        $search   = sanitize_text_field( wp_unslash( $_POST['search'] ?? '' ) );
        $page     = absint( $_POST['page'] ?? 1 );

        $results = $this->search(
            [ 'category' => $category, 'search' => $search ],
            $page,
            12
        );

        wp_send_json_success( $results );
    }
}
