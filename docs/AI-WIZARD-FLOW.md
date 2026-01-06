# AI Creation Wizard Flow

## Overview

This document defines the user experience and technical implementation for the AI-powered content creation wizard in Divi AI Page Builder.

**Goal:** Enable users to create full hi-def website pages and sections through a guided, conversational AI interface.

---

## Entry Point

The wizard is accessed via a prominent "AI Create" button in the Divi Builder interface. The first question establishes the scope of creation.

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    🤖 What would you like to create?                     │
│                                                                          │
│         ┌─────────────────┐         ┌─────────────────┐                 │
│         │                 │         │                 │                 │
│         │   📄 FULL PAGE  │         │   📦 SECTION    │                 │
│         │                 │         │                 │                 │
│         │  Complete page  │         │  Single section │                 │
│         │  with multiple  │         │  to add to an   │                 │
│         │  sections       │         │  existing page  │                 │
│         │                 │         │                 │                 │
│         └─────────────────┘         └─────────────────┘                 │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Section Creation Flow

When user selects **SECTION**, they enter a focused flow for creating a single section.

### Step 1: Section Type Selection

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    What type of section do you need?                     │
│                                                                          │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐      │
│  │   Hero   │ │ Features │ │   CTA    │ │Testimonial│ │ Pricing  │      │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────┘      │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐      │
│  │   Team   │ │   FAQ    │ │ Gallery  │ │  Stats   │ │ Contact  │      │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────┘      │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐                                 │
│  │  Blog    │ │Portfolio │ │  Custom  │                                 │
│  └──────────┘ └──────────┘ └──────────┘                                 │
│                                                                          │
│  Or describe it: [________________________________________]             │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

**Section Types Available:**
| Type | Description | Common Elements |
|------|-------------|-----------------|
| Hero | Top banner/header area | Headline, subhead, CTA button, background |
| Features | Showcase features/benefits | Icons, titles, descriptions, grid layout |
| CTA | Call-to-action | Compelling text, button, urgency |
| Testimonials | Customer reviews | Quotes, photos, names, ratings |
| Pricing | Pricing tables | Plans, features, prices, CTA buttons |
| Team | Team members | Photos, names, roles, social links |
| FAQ | Questions & answers | Accordion, search |
| Gallery | Image showcase | Grid, lightbox, captions |
| Stats | Numbers/metrics | Counters, icons, labels |
| Contact | Contact form | Form fields, map, info |
| Blog | Blog post grid | Thumbnails, excerpts, dates |
| Portfolio | Work showcase | Filterable grid, overlays |
| Custom | AI interprets | Natural language description |

### Step 2: Background Options

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    Do you need a background for this section?            │
│                                                                          │
│    ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │
│    │                 │  │                 │  │                 │        │
│    │   🖼️ IMAGE      │  │   🎨 DESIGN     │  │   ⬜ SOLID/NONE │        │
│    │                 │  │                 │  │                 │        │
│    │  AI-generated   │  │  Gradient,      │  │  Use brand      │        │
│    │  or stock photo │  │  pattern, or    │  │  colors or      │        │
│    │                 │  │  abstract       │  │  transparent    │        │
│    │                 │  │                 │  │                 │        │
│    └─────────────────┘  └─────────────────┘  └─────────────────┘        │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

#### If IMAGE selected:

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    Choose your image source:                             │
│                                                                          │
│    ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │
│    │                 │  │                 │  │                 │        │
│    │  🤖 AI GENERATE │  │  📷 UNSPLASH    │  │  🎬 ENVATO      │        │
│    │                 │  │                 │  │                 │        │
│    │  DALL-E creates │  │  Search free    │  │  Premium stock  │        │
│    │  custom image   │  │  stock photos   │  │  from Elements  │        │
│    │                 │  │                 │  │                 │        │
│    └─────────────────┘  └─────────────────┘  └─────────────────┘        │
│                                                                          │
│    ┌─────────────────┐                                                  │
│    │                 │                                                  │
│    │  📁 UPLOAD      │  Describe the image you want:                    │
│    │                 │  [________________________________________]      │
│    │  Use your own   │                                                  │
│    │  image file     │                                                  │
│    │                 │                                                  │
│    └─────────────────┘                                                  │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

#### If DESIGN selected:

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    Choose your design style:                             │
│                                                                          │
│    ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │
│    │  ████████████   │  │  ▓▓▓░░░░░▓▓▓   │  │  ◆ ◇ ◆ ◇ ◆ ◇   │        │
│    │  ████████████   │  │  ▓▓░░░░░░░▓▓   │  │  ◇ ◆ ◇ ◆ ◇ ◆   │        │
│    │  ████████████   │  │  ░░░░░░░░░░░   │  │  ◆ ◇ ◆ ◇ ◆ ◇   │        │
│    │                 │  │                 │  │                 │        │
│    │   GRADIENT      │  │   MESH          │  │   PATTERN       │        │
│    └─────────────────┘  └─────────────────┘  └─────────────────┘        │
│                                                                          │
│    ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐        │
│    │     ╱╲╱╲╱╲      │  │  ○  ○  ○  ○    │  │  ▄▄▄▄▄▄▄▄▄▄▄   │        │
│    │    ╱╲╱╲╱╲╱      │  │    ○  ○  ○     │  │  ▀▀▀▀▀▀▀▀▀▀▀   │        │
│    │   ╱╲╱╲╱╲╱╲      │  │  ○  ○  ○  ○    │  │  ▄▄▄▄▄▄▄▄▄▄▄   │        │
│    │                 │  │                 │  │                 │        │
│    │   WAVES         │  │   DOTS          │  │   LINES         │        │
│    └─────────────────┘  └─────────────────┘  └─────────────────┘        │
│                                                                          │
│    Uses your brand colors automatically                                  │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Step 3: Content Description

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Tell us about the content for this section:                 │
│                                                                          │
│  ┌───────────────────────────────────────────────────────────────────┐  │
│  │                                                                   │  │
│  │  Describe what you want in this section. Include:                 │  │
│  │  • Main message or headline idea                                  │  │
│  │  • Key points or features to highlight                            │  │
│  │  • Call-to-action (what should visitors do?)                      │  │
│  │  • Tone (professional, friendly, urgent, etc.)                    │  │
│  │                                                                   │  │
│  │  Example: "A hero section for our SaaS product that helps         │  │
│  │  small businesses manage inventory. Emphasize ease of use         │  │
│  │  and time savings. CTA should be 'Start Free Trial'"              │  │
│  │                                                                   │  │
│  │  [____________________________________________________________]   │  │
│  │  [____________________________________________________________]   │  │
│  │  [____________________________________________________________]   │  │
│  │                                                                   │  │
│  └───────────────────────────────────────────────────────────────────┘  │
│                                                                          │
│                                              [Continue →]                │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Page Creation Flow

When user selects **FULL PAGE**, they enter a comprehensive flow for creating an entire page.

### Step 1: Page Type Selection

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    What type of page are you creating?                   │
│                                                                          │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐      │
│  │ Landing  │ │  About   │ │ Services │ │ Contact  │ │Portfolio │      │
│  │  Page    │ │   Us     │ │          │ │          │ │          │      │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────┘      │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐      │
│  │  Blog    │ │ Pricing  │ │   Team   │ │  FAQ     │ │  Custom  │      │
│  │  Index   │ │          │ │          │ │          │ │          │      │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘ └──────────┘      │
│                                                                          │
│  Or describe it: [________________________________________]             │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

**Page Types:**
| Type | Default Sections | Purpose |
|------|------------------|---------|
| Landing Page | Hero, Features, Social Proof, CTA, FAQ | Conversion-focused |
| About Us | Hero, Story, Team, Values, CTA | Company introduction |
| Services | Hero, Services Grid, Process, CTA | Service showcase |
| Contact | Hero, Contact Form, Map, FAQ | Lead capture |
| Portfolio | Hero, Portfolio Grid, Testimonials, CTA | Work showcase |
| Blog Index | Hero, Blog Grid, Categories, Newsletter | Content hub |
| Pricing | Hero, Pricing Table, FAQ, CTA | Plan comparison |
| Team | Hero, Team Grid, Culture, CTA | Team showcase |
| FAQ | Hero, FAQ Accordion, Contact CTA | Support |
| Custom | AI determines based on description | Flexible |

### Step 2: Layout Preference

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    What layout style do you prefer?                      │
│                                                                          │
│  ┌───────────────────┐  ┌───────────────────┐  ┌───────────────────┐    │
│  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │    │
│  │ ████████████████ │  │ ████░░░░████░░░░ │  │ ░░░░████████░░░░ │    │
│  │ ░░░░░░░░░░░░░░░░ │  │ ████░░░░████░░░░ │  │ ████░░░░░░░░████ │    │
│  │ ████████████████ │  │ ░░░░░░░░░░░░░░░░ │  │ ████░░░░░░░░████ │    │
│  │                   │  │                   │  │                   │    │
│  │   CLASSIC         │  │   MODERN GRID     │  │   ASYMMETRIC      │    │
│  │   Full-width      │  │   Multi-column    │  │   Creative        │    │
│  │   sections        │  │   layouts         │  │   layouts         │    │
│  └───────────────────┘  └───────────────────┘  └───────────────────┘    │
│                                                                          │
│  ┌───────────────────┐  ┌───────────────────┐                           │
│  │ ████████████████ │  │                   │                           │
│  │ ████████████████ │  │   🤖 AI DECIDES   │                           │
│  │ ████████████████ │  │                   │                           │
│  │ ████████████████ │  │   Let AI choose   │                           │
│  │                   │  │   the best layout │                           │
│  │   MINIMAL         │  │                   │                           │
│  │   Clean, simple   │  └───────────────────┘                           │
│  └───────────────────┘                                                  │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Step 3: Content Overview

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Tell us about your business and page content:               │
│                                                                          │
│  Business/Product Name:                                                  │
│  [____________________________________________________________]         │
│                                                                          │
│  Industry/Niche:                                                         │
│  [____________________________________________________________]         │
│                                                                          │
│  What does your business do? (2-3 sentences):                           │
│  [____________________________________________________________]         │
│  [____________________________________________________________]         │
│                                                                          │
│  Target audience:                                                        │
│  [____________________________________________________________]         │
│                                                                          │
│  Key message or unique value proposition:                                │
│  [____________________________________________________________]         │
│                                                                          │
│  Desired tone:                                                           │
│  ○ Professional  ○ Friendly  ○ Bold  ○ Elegant  ○ Playful              │
│                                                                          │
│                                              [Continue →]                │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Step 4: Media Requirements

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│                    What media do you need for this page?                 │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  IMAGES                                                         │    │
│  │  ☑ Hero/Banner image                                            │    │
│  │  ☑ Feature icons or illustrations                               │    │
│  │  ☐ Team photos (I'll upload my own)                             │    │
│  │  ☐ Product screenshots (I'll upload my own)                     │    │
│  │  ☑ Background images/patterns                                   │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  Image Source Preference:                                                │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐ ┌─────────────┐        │
│  │ 🤖 AI Gen   │ │ 📷 Unsplash │ │ 🎬 Envato   │ │ 🔀 Mix      │        │
│  │             │ │             │ │  Elements   │ │             │        │
│  └─────────────┘ └─────────────┘ └─────────────┘ └─────────────┘        │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  VIDEO                                                          │    │
│  │  ☐ Hero background video                                        │    │
│  │  ☐ Explainer/demo video embed                                   │    │
│  │  ☐ Testimonial videos                                           │    │
│  │                                                                 │    │
│  │  Video URL (optional): [_________________________________]      │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│                                              [Generate Page →]           │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Media Integration

### Supported Sources

| Source | Type | API | Cost | Quality |
|--------|------|-----|------|---------|
| **Unsplash** | Stock Photos | Unsplash API | Free | High |
| **Envato Elements** | Premium Stock | Envato API | Subscription | Premium |
| **DALL-E** | AI Generated | OpenAI API | Per-image | Custom |
| **Upload** | User Files | Local | Free | Variable |

### Unsplash Integration

```php
<?php
class UnsplashService {
    private string $access_key;
    private string $api_base = 'https://api.unsplash.com';

    public function search(string $query, array $options = []): array {
        $params = [
            'query' => $query,
            'per_page' => $options['per_page'] ?? 10,
            'orientation' => $options['orientation'] ?? 'landscape',
        ];

        $response = wp_remote_get(
            $this->api_base . '/search/photos?' . http_build_query($params),
            [
                'headers' => [
                    'Authorization' => 'Client-ID ' . $this->access_key,
                ],
            ]
        );

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function download(string $photo_id): string {
        // Track download (required by Unsplash API guidelines)
        $this->trigger_download($photo_id);

        // Return optimized URL
        return $this->get_optimized_url($photo_id, [
            'w' => 1920,
            'q' => 85,
            'fm' => 'webp',
        ]);
    }
}
```

### Envato Elements Integration

```php
<?php
class EnvatoElementsService {
    private string $api_token;
    private string $api_base = 'https://api.elements.envato.com';

    public function search(string $query, string $type = 'photos'): array {
        // Types: photos, graphics, templates, video
        $response = wp_remote_get(
            $this->api_base . '/v1/items?' . http_build_query([
                'q' => $query,
                'type' => $type,
                'page_size' => 20,
            ]),
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_token,
                ],
            ]
        );

        return json_decode(wp_remote_retrieve_body($response), true);
    }

    public function license_and_download(string $item_id): array {
        // License the item first
        $license = $this->create_license($item_id);

        // Then download
        return [
            'url' => $license['download_url'],
            'license_id' => $license['id'],
        ];
    }
}
```

### AI Image Generation (DALL-E)

```php
<?php
class DallEService {
    private string $api_key;

    public function generate(string $prompt, array $options = []): array {
        $response = wp_remote_post(
            'https://api.openai.com/v1/images/generations',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->api_key,
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode([
                    'model' => 'dall-e-3',
                    'prompt' => $this->enhance_prompt($prompt),
                    'n' => 1,
                    'size' => $options['size'] ?? '1792x1024',
                    'quality' => $options['quality'] ?? 'hd',
                    'style' => $options['style'] ?? 'natural',
                ]),
            ]
        );

        $data = json_decode(wp_remote_retrieve_body($response), true);
        return $data['data'][0];
    }

    private function enhance_prompt(string $prompt): string {
        // Add quality modifiers for better results
        return $prompt . ', professional photography, high resolution, ' .
               'commercial quality, clean composition, modern aesthetic';
    }
}
```

---

## Design Background Generation

### CSS-Based Backgrounds

For design backgrounds, we generate CSS rather than images for better performance:

```php
<?php
class DesignBackgroundGenerator {

    public function generate_gradient(array $colors, string $type = 'linear'): string {
        switch ($type) {
            case 'linear':
                return sprintf(
                    'linear-gradient(135deg, %s 0%%, %s 100%%)',
                    $colors['primary'],
                    $colors['secondary']
                );

            case 'radial':
                return sprintf(
                    'radial-gradient(circle at center, %s 0%%, %s 100%%)',
                    $colors['primary'],
                    $colors['secondary']
                );

            case 'mesh':
                return $this->generate_mesh_gradient($colors);

            default:
                return $colors['primary'];
        }
    }

    public function generate_pattern(string $type, array $colors): string {
        $patterns = [
            'dots' => $this->dots_pattern($colors),
            'lines' => $this->lines_pattern($colors),
            'waves' => $this->waves_pattern($colors),
            'grid' => $this->grid_pattern($colors),
            'diagonal' => $this->diagonal_pattern($colors),
        ];

        return $patterns[$type] ?? $patterns['dots'];
    }

    private function dots_pattern(array $colors): string {
        return sprintf(
            'radial-gradient(%s 1px, transparent 1px)',
            $colors['accent']
        ) . ', ' . $colors['background'];
    }

    private function waves_pattern(array $colors): string {
        // SVG-based wave pattern encoded as data URI
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">' .
               '<path fill="' . $colors['primary'] . '" fill-opacity="0.1" ' .
               'd="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7' .
               'C672,235,768,181,864,181.3C960,181,1056,235,1152,234.7C1248,235,1344,' .
               '181,1392,154.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320' .
               'C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,' .
               '288,320C192,320,96,320,48,320L0,320Z"></path></svg>';

        return 'url("data:image/svg+xml,' . rawurlencode($svg) . '")';
    }
}
```

---

## Generation Process

### Section Generation Pipeline

```
┌─────────────────────────────────────────────────────────────────────────┐
│                      SECTION GENERATION PIPELINE                         │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  1. TEMPLATE SELECTION                                                  │
│     ├── AI analyzes: section type + content description                 │
│     ├── Queries template library with semantic search                   │
│     ├── Scores templates on relevance (0-100)                          │
│     └── Returns top 3 matches                                           │
│                                                                          │
│  2. CONTENT GENERATION                                                  │
│     ├── AI generates copy based on user description                     │
│     ├── Headline, subhead, body text, CTA                              │
│     ├── Respects tone preference                                        │
│     └── SEO-optimized text                                              │
│                                                                          │
│  3. MEDIA ACQUISITION                                                   │
│     ├── If AI image: Generate via DALL-E                               │
│     ├── If Unsplash: Search and select best match                      │
│     ├── If Envato: Search, license, download                           │
│     ├── If design: Generate CSS background                             │
│     └── Optimize and cache all media                                    │
│                                                                          │
│  4. TEMPLATE TRANSFORMATION                                             │
│     ├── Apply user's brand colors (Design Tokens)                      │
│     ├── Apply user's fonts                                              │
│     ├── Insert generated content                                        │
│     ├── Insert media URLs                                               │
│     └── Generate final Divi JSON                                        │
│                                                                          │
│  5. PREVIEW & INSERT                                                    │
│     ├── Render live preview                                             │
│     ├── Allow adjustments                                               │
│     └── Insert into Divi Builder                                        │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Page Generation Pipeline

```
┌─────────────────────────────────────────────────────────────────────────┐
│                       PAGE GENERATION PIPELINE                           │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  1. PAGE STRUCTURE PLANNING                                             │
│     ├── AI determines required sections based on page type              │
│     ├── Orders sections logically                                       │
│     ├── Considers user's content overview                               │
│     └── Creates section generation queue                                │
│                                                                          │
│  2. BATCH TEMPLATE SELECTION                                            │
│     ├── For each section in queue:                                      │
│     │   └── Select best matching template                               │
│     ├── Ensure visual consistency across sections                       │
│     └── Avoid repetitive layouts                                        │
│                                                                          │
│  3. CONTENT GENERATION (Batch)                                          │
│     ├── Generate all section content in one AI call                     │
│     ├── Maintain consistent messaging                                   │
│     ├── Cross-reference sections for coherence                          │
│     └── Distribute keywords for SEO                                     │
│                                                                          │
│  4. MEDIA ACQUISITION (Parallel)                                        │
│     ├── Queue all media requests                                        │
│     ├── Process in parallel for speed                                   │
│     ├── Cache results                                                   │
│     └── Generate fallbacks if any fail                                  │
│                                                                          │
│  5. PAGE ASSEMBLY                                                       │
│     ├── Transform each section template                                 │
│     ├── Combine into single page JSON                                   │
│     ├── Add page-level settings                                         │
│     └── Validate complete structure                                     │
│                                                                          │
│  6. PREVIEW & INSERT                                                    │
│     ├── Full-page preview with scroll                                   │
│     ├── Section-by-section editing option                               │
│     └── One-click insert entire page                                    │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## AI Prompts

### Template Selection Prompt

```
You are a web design expert. Given the following requirements, select the best
template from the library.

SECTION TYPE: {section_type}
CONTENT DESCRIPTION: {user_description}
INDUSTRY: {industry}
TONE: {tone}

Available templates (JSON):
{template_metadata_list}

Return the top 3 template IDs with confidence scores (0-100) and brief reasoning.

Response format:
{
  "selections": [
    {"template_id": "xxx", "score": 95, "reason": "..."},
    {"template_id": "yyy", "score": 87, "reason": "..."},
    {"template_id": "zzz", "score": 82, "reason": "..."}
  ]
}
```

### Content Generation Prompt

```
You are a professional copywriter creating content for a website section.

SECTION TYPE: {section_type}
BUSINESS: {business_name}
INDUSTRY: {industry}
DESCRIPTION: {user_description}
TONE: {tone}
TARGET AUDIENCE: {target_audience}

Generate the following content elements:
1. Headline (max 10 words, compelling, benefit-focused)
2. Subheadline (max 20 words, supports headline)
3. Body text (2-3 sentences, value proposition)
4. CTA button text (2-4 words, action-oriented)
5. Supporting bullet points (3-5 items if applicable)

Response format:
{
  "headline": "...",
  "subheadline": "...",
  "body": "...",
  "cta": "...",
  "bullets": ["...", "...", "..."]
}
```

### Image Search Prompt (for Unsplash/Envato)

```
Based on this section description, generate 3 search queries for stock photos.

SECTION: {section_type}
CONTENT: {content_description}
INDUSTRY: {industry}
STYLE: {design_style}

Requirements:
- Queries should find professional, modern images
- Avoid clichés (no handshakes, pointing at screens, etc.)
- Consider the emotional tone needed
- Think about composition (hero = wide, features = icons/illustrations)

Response format:
{
  "queries": [
    {"query": "...", "orientation": "landscape|portrait|square"},
    {"query": "...", "orientation": "..."},
    {"query": "...", "orientation": "..."}
  ]
}
```

---

## Database Schema Addition

```sql
-- AI Generation Sessions (tracks wizard progress)
CREATE TABLE {prefix}divi_ai_wizard_sessions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    session_type ENUM('page', 'section') NOT NULL,
    wizard_step INT UNSIGNED DEFAULT 1,
    wizard_data JSON,
    selected_templates JSON,
    generated_content JSON,
    media_assets JSON,
    status ENUM('in_progress', 'completed', 'abandoned') DEFAULT 'in_progress',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    completed_at DATETIME,
    INDEX idx_user_status (user_id, status),
    INDEX idx_created (created_at)
);

-- Media Library Cache (downloaded/generated images)
CREATE TABLE {prefix}divi_ai_media_cache (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    source ENUM('unsplash', 'envato', 'dalle', 'upload') NOT NULL,
    source_id VARCHAR(255),
    search_query VARCHAR(500),
    local_path VARCHAR(500),
    local_url VARCHAR(500),
    metadata JSON,
    license_info JSON,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    INDEX idx_source (source, source_id),
    INDEX idx_query (search_query(100))
);
```

---

## API Endpoints

```
POST /wp-json/divi-ai/v1/wizard/start
     Body: { type: 'page'|'section' }
     Returns: { session_id, next_step }

POST /wp-json/divi-ai/v1/wizard/{session_id}/step
     Body: { step_data }
     Returns: { next_step, options }

GET  /wp-json/divi-ai/v1/wizard/{session_id}/preview
     Returns: { preview_html, preview_json }

POST /wp-json/divi-ai/v1/wizard/{session_id}/generate
     Triggers full generation pipeline
     Returns: { status: 'processing', job_id }

GET  /wp-json/divi-ai/v1/wizard/{session_id}/status
     Returns: { status, progress_percent, current_step }

POST /wp-json/divi-ai/v1/wizard/{session_id}/insert
     Inserts generated content into Divi
     Returns: { success, inserted_ids }

POST /wp-json/divi-ai/v1/media/search
     Body: { source: 'unsplash'|'envato', query, options }
     Returns: { results: [...] }

POST /wp-json/divi-ai/v1/media/generate
     Body: { prompt, style, size }
     Returns: { image_url, job_id }

POST /wp-json/divi-ai/v1/media/download
     Body: { source, source_id }
     Returns: { local_url }
```

---

## Settings Required

```php
<?php
// Settings page additions
$wizard_settings = [
    // Media Sources
    'unsplash_access_key' => '',
    'unsplash_enabled' => true,

    'envato_api_token' => '',
    'envato_enabled' => false,

    'dalle_enabled' => true,  // Uses main OpenAI key

    // Default Preferences
    'default_image_source' => 'unsplash',  // unsplash, envato, dalle
    'default_image_style' => 'modern',
    'default_tone' => 'professional',

    // Generation Limits
    'max_dalle_images_per_page' => 5,
    'max_sections_per_page' => 10,

    // Caching
    'media_cache_duration' => 7 * DAY_IN_SECONDS,
];
```

---

## Next Steps

1. **Immediate**: Implement wizard UI component structure
2. **Immediate**: Set up Unsplash API integration
3. **Short-term**: Build content generation prompts
4. **Short-term**: Create template selection algorithm
5. **Medium-term**: Add Envato Elements integration
6. **Medium-term**: Implement DALL-E image generation

---

## References

- [Unsplash API Documentation](https://unsplash.com/documentation)
- [Envato Elements API](https://elements.envato.com/api)
- [OpenAI DALL-E API](https://platform.openai.com/docs/guides/images)
- [Divi Developer Portal](https://www.elegantthemes.com/developers/)
