# Divi Template Library Strategy

## Executive Summary

This document outlines the strategy for integrating 2000+ Divi JSON templates from divi.express into the Divi AI Page Builder plugin, with dynamic customization through WordPress Customizer.

> **Licensing**: Full commercial usage rights for divi.express templates have been secured.

**Key Goals:**
1. Organize and categorize 2000+ templates for easy discovery
2. Enable dynamic font and color customization via Customizer
3. Maintain template quality while applying user branding
4. Ensure performance with large template library

---

## The Challenge

### Current State of Divi Templates

Divi JSON templates store styling **inline** within each module:

```json
{
  "et_pb_section": {
    "background_color": "#3366ff",
    "custom_padding": "80px||80px|",
    "et_pb_row": {
      "et_pb_text": {
        "text_font": "Montserrat|700|||||||",
        "text_text_color": "#ffffff",
        "text_font_size": "48px"
      }
    }
  }
}
```

**Problems with hardcoded values:**
- Templates look inconsistent with user's brand
- Manual editing of 2000+ templates is impractical
- No connection to WordPress Customizer
- Colors/fonts scattered throughout nested JSON

### Requirements

1. **Brand Consistency** - Templates should use the user's colors/fonts
2. **Zero Manual Work** - Transformation must be automatic
3. **Preserve Design** - Don't break the visual harmony of templates
4. **Performance** - Handle 2000+ templates efficiently
5. **Flexibility** - Support various template types (pages, sections, headers, footers)

---

## Solution Architecture

### Design Token System

We implement a **Design Token System** that creates an abstraction layer between templates and user preferences.

```
┌─────────────────────────────────────────────────────────────────────────┐
│                         TEMPLATE PIPELINE                                │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│   STORAGE          PROCESSING           CUSTOMIZER        OUTPUT        │
│   ───────          ──────────           ──────────        ──────        │
│                                                                          │
│  ┌──────────┐    ┌─────────────┐     ┌─────────────┐   ┌────────────┐  │
│  │ Template │    │  Analysis   │     │   Style     │   │ Customized │  │
│  │ Library  │───▶│  & Index    │     │   Profile   │──▶│  Template  │  │
│  │ (JSON)   │    │  Service    │     │   (tokens)  │   │   (JSON)   │  │
│  └──────────┘    └──────┬──────┘     └──────▲──────┘   └────────────┘  │
│                         │                   │                           │
│                         │            ┌──────┴──────┐                   │
│                         │            │  WordPress  │                   │
│                         ▼            │  Customizer │                   │
│                  ┌─────────────┐     └─────────────┘                   │
│                  │  Metadata   │                                        │
│                  │   Index     │     Design Tokens:                    │
│                  │             │     • --color-primary                 │
│                  │ • category  │     • --color-secondary               │
│                  │ • colors    │     • --color-accent                  │
│                  │ • fonts     │     • --font-heading                  │
│                  │ • tags      │     • --font-body                     │
│                  └─────────────┘     • --spacing-section               │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Core Components

#### 1. Template Library (`/templates`)

```
templates/
├── full-pages/           # Complete page layouts
│   ├── landing/         # Landing pages
│   ├── about/           # About pages
│   ├── services/        # Services pages
│   ├── contact/         # Contact pages
│   ├── portfolio/       # Portfolio pages
│   └── blog/            # Blog layouts
├── sections/             # Individual sections
│   ├── hero/            # Hero/banner sections
│   ├── features/        # Feature showcases
│   ├── testimonials/    # Testimonial sections
│   ├── pricing/         # Pricing tables
│   ├── cta/             # Call-to-action
│   ├── team/            # Team members
│   ├── faq/             # FAQ sections
│   └── gallery/         # Image galleries
├── headers/              # Header layouts
│   ├── standard/        # Standard headers
│   ├── mega-menu/       # Mega menu headers
│   └── transparent/     # Transparent/overlay
├── footers/              # Footer layouts
│   ├── simple/          # Minimal footers
│   ├── mega/            # Multi-column footers
│   └── cta/             # CTA footers
└── modules/              # Individual modules
    ├── buttons/         # Button styles
    ├── cards/           # Card layouts
    └── forms/           # Form designs
```

#### 2. Template Metadata Index

Each template has associated metadata for discovery and transformation:

```json
{
  "id": "hero-gradient-001",
  "name": "Gradient Hero with CTA",
  "category": "sections/hero",
  "tags": ["gradient", "cta", "bold", "modern"],
  "industry": ["saas", "tech", "agency"],
  "colors": {
    "primary": ["#3366ff", "#4477ff"],
    "secondary": ["#ff6633"],
    "background": ["#ffffff", "#f8f9fa"],
    "text": ["#333333", "#666666", "#ffffff"]
  },
  "fonts": {
    "headings": ["Montserrat"],
    "body": ["Open Sans"]
  },
  "modules": ["et_pb_section", "et_pb_row", "et_pb_text", "et_pb_button"],
  "preview_image": "hero-gradient-001.jpg",
  "created": "2024-01-15",
  "popularity": 4.5
}
```

#### 3. Design Token Schema

The token system defines customizable properties:

```php
<?php
// Token definitions
$design_tokens = [
    // Color Tokens
    'colors' => [
        'primary' => [
            'label' => 'Primary Color',
            'default' => '#3366ff',
            'variants' => ['light', 'dark', 'contrast'],
            'description' => 'Main brand color for buttons, links, accents'
        ],
        'secondary' => [
            'label' => 'Secondary Color',
            'default' => '#ff6633',
            'variants' => ['light', 'dark', 'contrast'],
            'description' => 'Supporting brand color'
        ],
        'accent' => [
            'label' => 'Accent Color',
            'default' => '#00cc88',
            'variants' => ['light', 'dark'],
            'description' => 'Highlight color for special elements'
        ],
        'text_primary' => [
            'label' => 'Primary Text',
            'default' => '#333333',
            'description' => 'Main body text color'
        ],
        'text_secondary' => [
            'label' => 'Secondary Text',
            'default' => '#666666',
            'description' => 'Muted/secondary text'
        ],
        'text_light' => [
            'label' => 'Light Text',
            'default' => '#ffffff',
            'description' => 'Text on dark backgrounds'
        ],
        'background_primary' => [
            'label' => 'Primary Background',
            'default' => '#ffffff',
            'description' => 'Main page background'
        ],
        'background_secondary' => [
            'label' => 'Secondary Background',
            'default' => '#f8f9fa',
            'description' => 'Alternate section background'
        ],
        'background_dark' => [
            'label' => 'Dark Background',
            'default' => '#1a1a2e',
            'description' => 'Dark section background'
        ],
    ],

    // Typography Tokens
    'typography' => [
        'font_heading' => [
            'label' => 'Heading Font',
            'default' => 'Montserrat',
            'type' => 'font-family',
            'description' => 'Font for headings (H1-H6)'
        ],
        'font_body' => [
            'label' => 'Body Font',
            'default' => 'Open Sans',
            'type' => 'font-family',
            'description' => 'Font for body text'
        ],
        'font_accent' => [
            'label' => 'Accent Font',
            'default' => 'Playfair Display',
            'type' => 'font-family',
            'description' => 'Decorative/accent font'
        ],
    ],

    // Spacing Tokens (optional advanced)
    'spacing' => [
        'section_padding' => [
            'label' => 'Section Padding',
            'default' => '80px',
            'description' => 'Default vertical padding for sections'
        ],
    ],
];
```

#### 4. Color Intelligence System

Smart color mapping that understands design context:

```php
<?php
class ColorMapper {

    /**
     * Analyze template colors and map to semantic roles
     */
    public function analyze_template_colors(array $template_colors): array {
        $mapping = [];

        foreach ($template_colors as $color) {
            $role = $this->determine_color_role($color);
            $mapping[$color] = $role;
        }

        return $mapping;
    }

    /**
     * Determine semantic role of a color
     * Based on: saturation, luminance, frequency of use
     */
    private function determine_color_role(string $hex): string {
        $hsl = $this->hex_to_hsl($hex);

        // High saturation, medium luminance = likely primary/accent
        if ($hsl['s'] > 50 && $hsl['l'] > 30 && $hsl['l'] < 70) {
            return 'primary';
        }

        // Very light colors = backgrounds
        if ($hsl['l'] > 90) {
            return 'background_primary';
        }

        // Light colors with low saturation = secondary backgrounds
        if ($hsl['l'] > 80 && $hsl['s'] < 20) {
            return 'background_secondary';
        }

        // Very dark colors = text or dark backgrounds
        if ($hsl['l'] < 20) {
            return 'text_primary';
        }

        // Medium gray = secondary text
        if ($hsl['s'] < 10 && $hsl['l'] > 30 && $hsl['l'] < 60) {
            return 'text_secondary';
        }

        // Pure white
        if ($hex === '#ffffff' || $hex === '#fff') {
            return 'text_light';
        }

        return 'accent';
    }
}
```

#### 5. Template Transformation Engine

The engine that applies user tokens to templates:

```php
<?php
class TemplateTransformer {

    private array $color_mapping;
    private array $user_tokens;

    public function transform(array $template, array $user_tokens): array {
        $this->user_tokens = $user_tokens;

        // Walk the template tree and transform values
        return $this->walk_and_transform($template);
    }

    private function walk_and_transform(array $node): array {
        foreach ($node as $key => $value) {
            if (is_array($value)) {
                $node[$key] = $this->walk_and_transform($value);
            } elseif (is_string($value)) {
                $node[$key] = $this->transform_value($key, $value);
            }
        }
        return $node;
    }

    private function transform_value(string $key, string $value): string {
        // Color properties
        if ($this->is_color_property($key)) {
            return $this->transform_color($value);
        }

        // Font properties
        if ($this->is_font_property($key)) {
            return $this->transform_font($value);
        }

        return $value;
    }

    private function is_color_property(string $key): bool {
        $color_properties = [
            'background_color', 'text_color', 'text_text_color',
            'button_bg_color', 'button_text_color', 'border_color',
            'header_text_color', 'body_text_color', 'link_color',
            'icon_color', 'circle_color', 'bar_bg_color'
        ];

        foreach ($color_properties as $prop) {
            if (strpos($key, $prop) !== false) {
                return true;
            }
        }
        return false;
    }

    private function transform_color(string $color): string {
        // Normalize color format
        $normalized = $this->normalize_color($color);

        // Find the semantic role of this color
        $role = $this->color_mapping[$normalized] ?? null;

        if ($role && isset($this->user_tokens['colors'][$role])) {
            return $this->user_tokens['colors'][$role];
        }

        // If no direct mapping, try to find closest match
        return $this->find_closest_token_color($normalized);
    }
}
```

---

## Implementation Phases

### Phase 1: Template Library Foundation

**Duration: Foundation work**

**Tasks:**
1. [ ] Create template directory structure
2. [ ] Build template import script (process 2000+ JSONs)
3. [ ] Develop template analysis service (extract colors, fonts, metadata)
4. [ ] Generate template index JSON
5. [ ] Create template preview image generator
6. [ ] Build template search/filter API

**Deliverables:**
- Organized template library with categories
- Searchable metadata index
- Preview images for all templates

**Database Schema:**

```sql
-- Template Registry
CREATE TABLE {prefix}divi_ai_template_library (
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
    popularity_score DECIMAL(3,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_tags ((CAST(tags AS CHAR(500)))),
    FULLTEXT idx_search (name, category, subcategory)
);
```

### Phase 2: Design Token System

**Duration: Core system**

**Tasks:**
1. [ ] Define complete token schema
2. [ ] Build WordPress Customizer panel
3. [ ] Create color palette presets (10+ themes)
4. [ ] Implement Google Fonts integration
5. [ ] Add live preview support
6. [ ] Build token storage/retrieval API

**Deliverables:**
- "Global Styles" Customizer section
- Color picker with palette presets
- Font selector with Google Fonts
- Live preview in Customizer

**Customizer Structure:**

```php
<?php
// Customizer Panel: Divi AI Global Styles
add_action('customize_register', function($wp_customize) {

    // Panel
    $wp_customize->add_panel('divi_ai_global_styles', [
        'title' => 'Divi AI Global Styles',
        'priority' => 30,
    ]);

    // Section: Colors
    $wp_customize->add_section('divi_ai_colors', [
        'title' => 'Color Palette',
        'panel' => 'divi_ai_global_styles',
    ]);

    // Section: Typography
    $wp_customize->add_section('divi_ai_typography', [
        'title' => 'Typography',
        'panel' => 'divi_ai_global_styles',
    ]);

    // Section: Presets
    $wp_customize->add_section('divi_ai_presets', [
        'title' => 'Style Presets',
        'panel' => 'divi_ai_global_styles',
    ]);
});
```

### Phase 3: Transformation Engine

**Duration: Core processing**

**Tasks:**
1. [ ] Build Divi JSON parser
2. [ ] Implement color clustering algorithm
3. [ ] Create font detection/mapping logic
4. [ ] Build transformation pipeline
5. [ ] Add caching layer for transformed templates
6. [ ] Create batch transformation CLI tool

**Deliverables:**
- Working transformation engine
- Cached transformation results
- CLI for bulk operations

**Transformation Flow:**

```
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│   Original   │────▶│    Parse &   │────▶│   Identify   │
│   Template   │     │   Validate   │     │   Elements   │
│   (JSON)     │     │              │     │              │
└──────────────┘     └──────────────┘     └──────┬───────┘
                                                  │
                                                  ▼
┌──────────────┐     ┌──────────────┐     ┌──────────────┐
│  Customized  │◀────│    Apply     │◀────│    Match     │
│   Output     │     │    Tokens    │     │   to Tokens  │
│              │     │              │     │              │
└──────────────┘     └──────────────┘     └──────────────┘
```

### Phase 4: UI Integration

**Duration: User experience**

**Tasks:**
1. [ ] Build template browser modal
2. [ ] Create category/filter sidebar
3. [ ] Implement search functionality
4. [ ] Add template preview panel
5. [ ] Build "Insert with Customization" flow
6. [ ] Create favorites/recent templates feature

**Deliverables:**
- Template browser in Divi Builder
- Search and filter capabilities
- Preview before insert
- One-click customized insertion

**UI Mockup:**

```
┌─────────────────────────────────────────────────────────────────────────┐
│  Template Library                                          [X] Close   │
├──────────────────┬──────────────────────────────────────────────────────┤
│                  │                                                      │
│  Categories      │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐   │
│  ─────────────   │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│  ▼ Full Pages    │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│    Landing       │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│    About         │  └─────────┘ └─────────┘ └─────────┘ └─────────┘   │
│    Services      │  Hero Grad..  CTA Split   Feature..   Minimal..   │
│                  │                                                      │
│  ▼ Sections      │  ┌─────────┐ ┌─────────┐ ┌─────────┐ ┌─────────┐   │
│    Hero ←        │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│    Features      │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│    Testimonials  │  │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│ │░░░░░░░░░│   │
│    Pricing       │  └─────────┘ └─────────┘ └─────────┘ └─────────┘   │
│    CTA           │  Bold Hero   Image BG    Video He..   Animated..  │
│                  │                                                      │
│  ▼ Headers       │  [Load More...]                                     │
│  ▼ Footers       │                                                      │
│                  │                                                      │
│  ─────────────   ├──────────────────────────────────────────────────────┤
│  Filters         │  Selected: "Hero Gradient with CTA"                 │
│  ─────────────   │  ┌────────────────────────────────────────────────┐ │
│  Industry:       │  │                                                │ │
│  [All        ▼]  │  │         [Live Preview with YOUR colors]        │ │
│                  │  │                                                │ │
│  Style:          │  │                                                │ │
│  [All        ▼]  │  │                                                │ │
│                  │  │                                                │ │
│  Colors:         │  └────────────────────────────────────────────────┘ │
│  ○ Any           │                                                      │
│  ● My Palette    │  [Preview Original]  [█████ Insert Template █████]  │
│                  │                                                      │
└──────────────────┴──────────────────────────────────────────────────────┘
```

---

## Color Mapping Strategy

### Approach: Semantic Color Clustering

Rather than simple find-replace, we use **semantic clustering** to understand the *role* each color plays:

```
TEMPLATE COLORS          ANALYSIS              USER TOKENS
───────────────         ─────────             ───────────

#3366ff ─────────────▶ High saturation ────▶ primary
                       Medium luminance
                       Used in buttons

#4488ff ─────────────▶ Similar hue ─────────▶ primary_light
                       Lighter variant

#ff6633 ─────────────▶ High saturation ────▶ secondary
                       Different hue
                       Used as accent

#333333 ─────────────▶ Very dark ───────────▶ text_primary
                       Low saturation

#666666 ─────────────▶ Medium gray ─────────▶ text_secondary

#ffffff ─────────────▶ Pure white ──────────▶ background_primary
                                              OR text_light (context)

#f8f9fa ─────────────▶ Near white ──────────▶ background_secondary
                       Slight tint
```

### Color Role Detection Algorithm

```php
<?php
class ColorRoleDetector {

    public function detect_role(string $hex, array $context = []): string {
        $hsl = $this->hex_to_hsl($hex);
        $property = $context['property'] ?? '';

        // Context-aware detection
        if (strpos($property, 'text') !== false) {
            return $this->detect_text_role($hsl);
        }

        if (strpos($property, 'background') !== false) {
            return $this->detect_background_role($hsl);
        }

        if (strpos($property, 'button') !== false) {
            return $this->detect_button_role($hsl, $property);
        }

        // Fallback to luminance-based detection
        return $this->detect_by_luminance($hsl);
    }

    private function detect_text_role(array $hsl): string {
        if ($hsl['l'] > 90) return 'text_light';
        if ($hsl['l'] < 30) return 'text_primary';
        return 'text_secondary';
    }

    private function detect_background_role(array $hsl): string {
        if ($hsl['l'] > 95) return 'background_primary';
        if ($hsl['l'] > 80) return 'background_secondary';
        if ($hsl['l'] < 25) return 'background_dark';
        if ($hsl['s'] > 50) return 'primary'; // Colored background
        return 'background_secondary';
    }
}
```

---

## Font Mapping Strategy

### Font Role Detection

Divi encodes fonts in a specific format: `"FontName|weight|style|||||||"`

```php
<?php
class FontMapper {

    // Common heading fonts (typically used for H1-H6, titles)
    private array $heading_font_indicators = [
        'Montserrat', 'Oswald', 'Playfair Display', 'Raleway',
        'Poppins', 'Roboto Slab', 'Merriweather', 'Lora',
        'Ubuntu', 'Bebas Neue', 'Anton'
    ];

    // Common body fonts
    private array $body_font_indicators = [
        'Open Sans', 'Roboto', 'Lato', 'Source Sans Pro',
        'Nunito', 'Work Sans', 'Inter', 'PT Sans'
    ];

    public function detect_font_role(string $font_string, array $context): string {
        $font_name = $this->extract_font_name($font_string);
        $property = $context['property'] ?? '';
        $font_weight = $this->extract_font_weight($font_string);

        // Property-based detection
        if (preg_match('/header|title|heading/i', $property)) {
            return 'font_heading';
        }

        if (preg_match('/body|text|paragraph/i', $property)) {
            return 'font_body';
        }

        // Weight-based detection (bold = likely heading)
        if ($font_weight >= 600) {
            return 'font_heading';
        }

        // Font family based detection
        if (in_array($font_name, $this->heading_font_indicators)) {
            return 'font_heading';
        }

        return 'font_body';
    }

    public function transform_font(string $original, string $new_font): string {
        // Preserve weight and style, replace font name
        $parts = explode('|', $original);
        $parts[0] = $new_font;
        return implode('|', $parts);
    }
}
```

---

## Performance Considerations

### Caching Strategy

```
┌─────────────────────────────────────────────────────────────┐
│                    CACHING LAYERS                            │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Layer 1: Template Index Cache                              │
│  ─────────────────────────────                              │
│  • Full template index in object cache                      │
│  • Refreshed on template library update                     │
│  • TTL: 24 hours                                            │
│                                                              │
│  Layer 2: Transformation Cache                              │
│  ────────────────────────────                               │
│  • Cache key: template_id + user_token_hash                 │
│  • Stores transformed JSON                                  │
│  • Invalidated when user changes tokens                     │
│  • TTL: 7 days                                              │
│                                                              │
│  Layer 3: Preview Cache                                     │
│  ─────────────────────                                      │
│  • Pre-rendered HTML previews                               │
│  • Generated on-demand, cached                              │
│  • TTL: 1 hour                                              │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Database Optimization

```php
<?php
// Efficient template queries
class TemplateRepository {

    public function search(array $filters, int $page = 1, int $per_page = 24): array {
        global $wpdb;

        $where = ['1=1'];
        $params = [];

        if (!empty($filters['category'])) {
            $where[] = 'category = %s';
            $params[] = $filters['category'];
        }

        if (!empty($filters['search'])) {
            $where[] = 'MATCH(name, category, subcategory) AGAINST(%s IN NATURAL LANGUAGE MODE)';
            $params[] = $filters['search'];
        }

        if (!empty($filters['industry'])) {
            $where[] = 'JSON_CONTAINS(industry, %s)';
            $params[] = json_encode($filters['industry']);
        }

        $offset = ($page - 1) * $per_page;

        $sql = $wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}divi_ai_template_library
             WHERE " . implode(' AND ', $where) . "
             ORDER BY popularity_score DESC
             LIMIT %d OFFSET %d",
            array_merge($params, [$per_page, $offset])
        );

        return $wpdb->get_results($sql, ARRAY_A);
    }
}
```

---

## Preset Palettes

Pre-built color schemes for one-click theming:

```php
<?php
$preset_palettes = [
    'professional_blue' => [
        'name' => 'Professional Blue',
        'colors' => [
            'primary' => '#2563eb',
            'secondary' => '#7c3aed',
            'accent' => '#06b6d4',
            'text_primary' => '#1e293b',
            'text_secondary' => '#64748b',
            'background_primary' => '#ffffff',
            'background_secondary' => '#f8fafc',
            'background_dark' => '#0f172a',
        ],
        'fonts' => [
            'font_heading' => 'Inter',
            'font_body' => 'Inter',
        ],
    ],
    'creative_coral' => [
        'name' => 'Creative Coral',
        'colors' => [
            'primary' => '#f43f5e',
            'secondary' => '#8b5cf6',
            'accent' => '#fbbf24',
            'text_primary' => '#18181b',
            'text_secondary' => '#71717a',
            'background_primary' => '#ffffff',
            'background_secondary' => '#fafafa',
            'background_dark' => '#18181b',
        ],
        'fonts' => [
            'font_heading' => 'Poppins',
            'font_body' => 'Open Sans',
        ],
    ],
    'nature_green' => [
        'name' => 'Nature Green',
        'colors' => [
            'primary' => '#059669',
            'secondary' => '#0891b2',
            'accent' => '#ca8a04',
            'text_primary' => '#1c1917',
            'text_secondary' => '#57534e',
            'background_primary' => '#ffffff',
            'background_secondary' => '#f5f5f4',
            'background_dark' => '#1c1917',
        ],
        'fonts' => [
            'font_heading' => 'Merriweather',
            'font_body' => 'Source Sans Pro',
        ],
    ],
    'elegant_dark' => [
        'name' => 'Elegant Dark',
        'colors' => [
            'primary' => '#c9a227',
            'secondary' => '#a78bfa',
            'accent' => '#f472b6',
            'text_primary' => '#fafafa',
            'text_secondary' => '#a1a1aa',
            'background_primary' => '#09090b',
            'background_secondary' => '#18181b',
            'background_dark' => '#000000',
        ],
        'fonts' => [
            'font_heading' => 'Playfair Display',
            'font_body' => 'Lato',
        ],
    ],
    // ... 6+ more presets
];
```

---

## API Endpoints

### Template Library API

```
GET  /wp-json/divi-ai/v1/templates
     ?category=sections/hero
     &search=gradient
     &industry=saas
     &page=1
     &per_page=24

GET  /wp-json/divi-ai/v1/templates/{id}
     Returns full template JSON

GET  /wp-json/divi-ai/v1/templates/{id}/preview
     Returns preview HTML

POST /wp-json/divi-ai/v1/templates/{id}/transform
     Body: { tokens: {...} }
     Returns transformed template JSON

GET  /wp-json/divi-ai/v1/templates/categories
     Returns category tree

GET  /wp-json/divi-ai/v1/tokens
     Returns current user tokens

POST /wp-json/divi-ai/v1/tokens
     Body: { colors: {...}, fonts: {...} }
     Saves user tokens

GET  /wp-json/divi-ai/v1/tokens/presets
     Returns available preset palettes
```

---

## Migration & Import Strategy

### Bulk Template Import Tool

```php
<?php
// WP-CLI command for importing templates
class TemplateImportCommand extends WP_CLI_Command {

    /**
     * Import templates from JSON files
     *
     * ## OPTIONS
     *
     * <source>
     * : Directory containing template JSON files
     *
     * [--analyze]
     * : Analyze templates and generate metadata
     *
     * [--preview]
     * : Generate preview images
     *
     * ## EXAMPLES
     *
     *     wp divi-ai import /path/to/templates --analyze --preview
     *
     * @param array $args
     * @param array $assoc_args
     */
    public function import($args, $assoc_args) {
        $source_dir = $args[0];
        $analyze = isset($assoc_args['analyze']);
        $preview = isset($assoc_args['preview']);

        $files = glob($source_dir . '/**/*.json', GLOB_BRACE);
        $total = count($files);

        WP_CLI::log("Found {$total} template files");

        $progress = WP_CLI\Utils\make_progress_bar('Importing', $total);

        foreach ($files as $file) {
            $this->import_template($file, $analyze, $preview);
            $progress->tick();
        }

        $progress->finish();
        WP_CLI::success("Imported {$total} templates");
    }

    private function import_template(string $file, bool $analyze, bool $preview): void {
        $json = json_decode(file_get_contents($file), true);

        $metadata = [
            'template_id' => $this->generate_template_id($file),
            'name' => $this->extract_name($file, $json),
            'category' => $this->determine_category($file),
            'json_path' => $file,
        ];

        if ($analyze) {
            $metadata = array_merge($metadata, $this->analyze_template($json));
        }

        $this->save_to_database($metadata);

        if ($preview) {
            $this->generate_preview($metadata['template_id'], $json);
        }
    }
}
```

---

## Success Metrics

### KPIs for Template System

| Metric | Target | Measurement |
|--------|--------|-------------|
| Template load time | < 200ms | API response time |
| Transformation time | < 500ms | Processing time |
| Search accuracy | > 90% | User satisfaction |
| Template usage | > 50% | % of pages using templates |
| Customization adoption | > 70% | Users who set custom tokens |

---

## Open Questions

1. **Should we support partial template transformation?** (Only colors OR only fonts)
2. **How to handle templates with gradients?** (Multiple color stops)
3. **Should users be able to save custom palettes?**
4. **Integration with Divi's built-in preset system?**
5. **How to handle templates with images/icons that use specific colors?**

---

## Next Steps

1. **Immediate**: Set up template directory structure
2. **Immediate**: Create sample template import script
3. **Short-term**: Build basic Customizer panel with color tokens
4. **Short-term**: Prototype transformation engine
5. **Medium-term**: Full UI integration

---

## References

- [Divi Developer Portal](https://www.elegantthemes.com/developers/)
- [Divi JSON Structure & Library](https://www.elegantthemes.com/developers/)
- [WordPress Customizer API](https://developer.wordpress.org/themes/customize-api/)
- [Design Tokens W3C](https://www.w3.org/community/design-tokens/)
- [Color Theory for UI](https://www.smashingmagazine.com/2021/03/complete-guide-accessible-color-contrast/)
