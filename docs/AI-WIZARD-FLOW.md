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
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │                 │  │                 │  │                 │          │
│  │   📄 FULL PAGE  │  │   📦 SECTION    │  │   🏗️ SITE SETUP │          │
│  │                 │  │                 │  │                 │          │
│  │  Complete page  │  │  Single section │  │  Header, Footer │          │
│  │  with multiple  │  │  to add to an   │  │  404 page &     │          │
│  │  sections       │  │  existing page  │  │  Navigation     │          │
│  │                 │  │                 │  │                 │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Site Setup Flow

When user selects **SITE SETUP**, they configure site-wide elements that appear on every page.

### Step 1: Header Selection

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Choose a header style for your website:                     │
│                                                                          │
│  Source: https://divi.express/divi-headers/                             │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │          │
│  │ LOGO    ≡ NAV  │  │ LOGO  NAV  BTN │  │    CENTERED     │          │
│  │                 │  │                 │  │   LOGO + NAV    │          │
│  │   Standard      │  │   With CTA      │  │                 │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │ ████████████████│  │ TOP BAR         │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │          │
│  │ LOGO            │  │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓ │  │ MEGA MENU       │          │
│  │ NAV  NAV  NAV   │  │ LOGO    ≡ NAV  │  │ ████████████████│          │
│  │   Transparent   │  │   With Top Bar  │  │   Mega Menu     │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  [Browse All Headers...]                    [Skip - I'll add later]     │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

**Header Categories:**
| Category | Description | Best For |
|----------|-------------|----------|
| Standard | Logo left, navigation right | Most websites |
| With CTA | Includes prominent call-to-action button | Lead generation |
| Centered | Logo and nav centered | Brand-focused |
| Transparent | Overlays hero section | Visual impact |
| With Top Bar | Info bar above main header | Contact info, promos |
| Mega Menu | Expandable dropdown menus | Large sites, e-commerce |
| Sticky | Fixed on scroll | Easy navigation |
| Mobile-First | Hamburger menu default | Mobile-heavy traffic |

### Step 2: Footer Selection

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Choose a footer style for your website:                     │
│                                                                          │
│  Source: https://divi.express/divi-footers/                             │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │ ░░░░░░░░░░░░░░ │  │ ABOUT  LINKS    │  │ ████████████████│          │
│  │ © 2024 Company │  │ CONTACT SOCIAL  │  │ NEWSLETTER FORM │          │
│  │                 │  │ ░░░░░░░░░░░░░░ │  │ ░░░░░░░░░░░░░░ │          │
│  │   Minimal       │  │   4-Column      │  │   With CTA      │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │ LOGO            │  │ MAP             │  │ █ SOCIAL ██████ │          │
│  │ NAV  NAV  NAV   │  │ CONTACT  HOURS │  │ LINKS    LINKS  │          │
│  │ ░░░ SOCIAL ░░░ │  │ ░░░░░░░░░░░░░░ │  │ ░░░░░░░░░░░░░░ │          │
│  │   Centered      │  │   With Map      │  │   Social Focus  │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  [Browse All Footers...]                    [Skip - I'll add later]     │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

**Footer Categories:**
| Category | Description | Best For |
|----------|-------------|----------|
| Minimal | Simple copyright and basic links | Clean designs |
| 4-Column | Organized link sections | Information-rich sites |
| With CTA | Newsletter signup or contact form | Lead capture |
| Centered | Logo-focused, centered layout | Brand consistency |
| With Map | Embedded Google Map | Local businesses |
| Social Focus | Prominent social media links | Social-driven brands |
| Mega Footer | Extensive links and content | Large websites |

### Step 3: 404 Page Selection

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Choose a 404 error page design:                             │
│                                                                          │
│  Source: https://divi.express/divi-404-pages/                           │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │                 │  │                 │  │                 │          │
│  │      404        │  │   🔍            │  │    ¯\_(ツ)_/¯   │          │
│  │  Page Not Found │  │  404 + SEARCH   │  │                 │          │
│  │   [Go Home]     │  │  Let me help... │  │   Oops! 404     │          │
│  │                 │  │                 │  │                 │          │
│  │   Simple        │  │   With Search   │  │   Playful       │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  ┌─────────────────┐  ┌─────────────────┐  ┌─────────────────┐          │
│  │   POPULAR:      │  │   ████████████  │  │   CONTACT US    │          │
│  │   • Home        │  │   Animated 404  │  │   if you need   │          │
│  │   • Services    │  │   ████████████  │  │   help finding  │          │
│  │   • Contact     │  │                 │  │   something     │          │
│  │   With Links    │  │   Animated      │  │   Helpful       │          │
│  └─────────────────┘  └─────────────────┘  └─────────────────┘          │
│                                                                          │
│  [Browse All 404 Pages...]                  [Skip - Use Default]        │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

**404 Page Categories:**
| Category | Description | Best For |
|----------|-------------|----------|
| Simple | Clean message with home button | Minimalist sites |
| With Search | Search box to help users find content | Content-heavy sites |
| Playful | Fun, branded error message | Creative brands |
| With Links | Popular page suggestions | User retention |
| Animated | Motion graphics or animation | Modern, tech brands |
| Helpful | Contact option, assistance offer | Service businesses |

### Step 4: Logo & Menu Integration

```
┌─────────────────────────────────────────────────────────────────────────┐
│                                                                          │
│              Let's set up your logo and navigation:                      │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  COMPANY LOGO                                                   │    │
│  │                                                                 │    │
│  │  ┌─────────────────────────────┐                               │    │
│  │  │                             │                               │    │
│  │  │    [Drag logo here or       │    Current: No logo set      │    │
│  │  │     click to upload]        │                               │    │
│  │  │                             │    Recommended: SVG or PNG    │    │
│  │  │    📁                       │    Min width: 200px           │    │
│  │  │                             │                               │    │
│  │  └─────────────────────────────┘                               │    │
│  │                                                                 │    │
│  │  Or select from Media Library: [Browse...]                     │    │
│  │                                                                 │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  PRIMARY NAVIGATION MENU                                        │    │
│  │                                                                 │    │
│  │  ○ Use existing menu: [Primary Menu ▼]                         │    │
│  │                                                                 │    │
│  │  ● Create new menu from current pages:                         │    │
│  │    ┌───────────────────────────────────────────────────────┐   │    │
│  │    │ ☑ Home                                                │   │    │
│  │    │ ☑ About Us                                            │   │    │
│  │    │ ☑ Services                                            │   │    │
│  │    │ ☑ Contact                                             │   │    │
│  │    │ ☐ Blog (exclude)                                      │   │    │
│  │    │ ☐ Privacy Policy (exclude)                            │   │    │
│  │    └───────────────────────────────────────────────────────┘   │    │
│  │                                                                 │    │
│  │  Menu name: [Primary Menu_____]                                │    │
│  │                                                                 │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│                                              [Complete Setup →]          │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Site Setup Generation Process

```
┌─────────────────────────────────────────────────────────────────────────┐
│                      SITE SETUP PIPELINE                                 │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  1. TEMPLATE RETRIEVAL                                                  │
│     ├── Fetch selected header template from library                     │
│     ├── Fetch selected footer template from library                     │
│     └── Fetch selected 404 template from library                        │
│                                                                          │
│  2. LOGO INTEGRATION                                                    │
│     ├── Upload/select logo file                                         │
│     ├── Store in Media Library                                          │
│     ├── Update Site Identity settings                                   │
│     └── Insert logo URL into header template                            │
│                                                                          │
│  3. MENU CREATION/ASSIGNMENT                                            │
│     ├── Check for existing Primary Menu                                 │
│     │   └── If none: Create new menu from published pages               │
│     ├── Assign menu to Primary location                                 │
│     └── Insert menu into header template                                │
│                                                                          │
│  4. BRAND TRANSFORMATION                                                │
│     ├── Apply user's color tokens to header                             │
│     ├── Apply user's color tokens to footer                             │
│     ├── Apply user's color tokens to 404 page                           │
│     └── Apply user's fonts                                              │
│                                                                          │
│  5. DIVI THEME BUILDER ASSIGNMENT                                       │
│     ├── Create Global Header template                                   │
│     ├── Create Global Footer template                                   │
│     ├── Create 404 Page template                                        │
│     └── Assign to all pages (or specific conditions)                    │
│                                                                          │
│  6. VERIFICATION                                                        │
│     ├── Preview header on sample page                                   │
│     ├── Preview footer on sample page                                   │
│     ├── Test 404 page                                                   │
│     └── Confirm navigation works                                        │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### Auto-Menu Creation Logic

When no Primary Menu exists, the system automatically creates one:

```php
<?php
class MenuGenerator {

    /**
     * Create primary menu from existing pages
     */
    public function create_menu_from_pages(): int {
        // Get all published pages
        $pages = get_pages([
            'post_status' => 'publish',
            'sort_column' => 'menu_order,post_title',
        ]);

        // Filter out utility pages
        $excluded_slugs = [
            'privacy-policy',
            'terms-of-service',
            'terms-and-conditions',
            'cookie-policy',
            'thank-you',
            'confirmation',
            '404',
        ];

        $menu_pages = array_filter($pages, function($page) use ($excluded_slugs) {
            return !in_array($page->post_name, $excluded_slugs);
        });

        // Create the menu
        $menu_name = 'Primary Menu';
        $menu_id = wp_create_nav_menu($menu_name);

        if (is_wp_error($menu_id)) {
            return 0;
        }

        // Add pages to menu
        $menu_order = 0;
        foreach ($menu_pages as $page) {
            wp_update_nav_menu_item($menu_id, 0, [
                'menu-item-title'     => $page->post_title,
                'menu-item-object-id' => $page->ID,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $menu_order++,
            ]);
        }

        // Assign to Primary location
        $locations = get_theme_mod('nav_menu_locations', []);
        $locations['primary-menu'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);

        return $menu_id;
    }

    /**
     * Get or create primary menu
     */
    public function get_or_create_primary_menu(): int {
        $locations = get_nav_menu_locations();

        if (isset($locations['primary-menu']) && $locations['primary-menu'] > 0) {
            return $locations['primary-menu'];
        }

        return $this->create_menu_from_pages();
    }
}
```

### Template Sources

| Element | Source URL | Template Count |
|---------|------------|----------------|
| Headers | https://divi.express/divi-headers/ | 50+ |
| Footers | https://divi.express/divi-footers/ | 50+ |
| 404 Pages | https://divi.express/divi-404-pages/ | 20+ |

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

## Technical Architecture: JavaScript & AJAX

> **IMPORTANT:** The wizard runs entirely in **wp-admin** using JavaScript and AJAX for maximum responsiveness and user experience.

### Architecture Overview

```
┌─────────────────────────────────────────────────────────────────────────┐
│                    WP-ADMIN WIZARD ARCHITECTURE                          │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  FRONTEND (JavaScript/React)              BACKEND (PHP/WordPress)       │
│  ─────────────────────────────            ───────────────────────       │
│                                                                          │
│  ┌─────────────────────────┐              ┌─────────────────────┐       │
│  │   Wizard UI Component   │    AJAX      │   REST API          │       │
│  │   (React SPA in Admin)  │◄────────────►│   Controllers       │       │
│  │                         │   /wp-json/  │                     │       │
│  │   • State Management    │              │   • Validation      │       │
│  │   • Step Navigation     │              │   • AI Service      │       │
│  │   • Live Preview        │              │   • Template Engine │       │
│  │   • Media Browser       │              │   • Media Handler   │       │
│  └─────────────────────────┘              └─────────────────────┘       │
│            │                                        │                    │
│            │                                        │                    │
│            ▼                                        ▼                    │
│  ┌─────────────────────────┐              ┌─────────────────────┐       │
│  │   WordPress Admin Page  │              │   Database          │       │
│  │   (Container)           │              │   • Sessions        │       │
│  │                         │              │   • Templates       │       │
│  │   wp-admin/admin.php    │              │   • Media Cache     │       │
│  │   ?page=divi-ai-wizard  │              │   • User Profiles   │       │
│  └─────────────────────────┘              └─────────────────────┘       │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### JavaScript Application Structure

```
src/
├── admin/
│   ├── wizard/
│   │   ├── App.jsx                 # Main wizard application
│   │   ├── WizardContext.jsx       # Global state management
│   │   ├── steps/
│   │   │   ├── EntryStep.jsx       # Page/Section/Site Setup selection
│   │   │   ├── SiteSetup/
│   │   │   │   ├── HeaderSelect.jsx
│   │   │   │   ├── FooterSelect.jsx
│   │   │   │   ├── Page404Select.jsx
│   │   │   │   └── LogoMenuSetup.jsx
│   │   │   ├── PageCreation/
│   │   │   │   ├── PageTypeSelect.jsx
│   │   │   │   ├── LayoutPreference.jsx
│   │   │   │   ├── ContentOverview.jsx
│   │   │   │   └── MediaRequirements.jsx
│   │   │   ├── SectionCreation/
│   │   │   │   ├── SectionTypeSelect.jsx
│   │   │   │   ├── BackgroundOptions.jsx
│   │   │   │   └── ContentDescription.jsx
│   │   │   └── Preview/
│   │   │       ├── PreviewPane.jsx
│   │   │       └── InsertConfirm.jsx
│   │   ├── components/
│   │   │   ├── TemplateGrid.jsx    # Template browser grid
│   │   │   ├── TemplateCard.jsx    # Individual template card
│   │   │   ├── MediaBrowser.jsx    # Unsplash/Envato/DALL-E browser
│   │   │   ├── ColorPalette.jsx    # Brand colors display
│   │   │   ├── ProgressBar.jsx     # Generation progress
│   │   │   └── LivePreview.jsx     # Real-time preview iframe
│   │   ├── hooks/
│   │   │   ├── useWizardState.js   # Wizard state hook
│   │   │   ├── useTemplates.js     # Template fetching hook
│   │   │   ├── useMediaSearch.js   # Media search hook
│   │   │   └── useGeneration.js    # AI generation hook
│   │   └── services/
│   │       ├── api.js              # AJAX/REST API client
│   │       ├── templateService.js  # Template operations
│   │       └── mediaService.js     # Media operations
│   └── index.js                    # Admin entry point
```

### AJAX Endpoints (wp_ajax_*)

```php
<?php
/**
 * Register AJAX handlers for wizard
 */
class WizardAjaxHandler {

    public function __construct() {
        // Wizard session management
        add_action('wp_ajax_divi_ai_wizard_start', [$this, 'start_wizard']);
        add_action('wp_ajax_divi_ai_wizard_step', [$this, 'save_step']);
        add_action('wp_ajax_divi_ai_wizard_generate', [$this, 'generate_content']);

        // Template operations
        add_action('wp_ajax_divi_ai_get_templates', [$this, 'get_templates']);
        add_action('wp_ajax_divi_ai_preview_template', [$this, 'preview_template']);

        // Media operations
        add_action('wp_ajax_divi_ai_search_media', [$this, 'search_media']);
        add_action('wp_ajax_divi_ai_generate_image', [$this, 'generate_ai_image']);
        add_action('wp_ajax_divi_ai_upload_media', [$this, 'handle_media_upload']);

        // Site setup operations
        add_action('wp_ajax_divi_ai_create_menu', [$this, 'create_menu']);
        add_action('wp_ajax_divi_ai_set_logo', [$this, 'set_site_logo']);
        add_action('wp_ajax_divi_ai_apply_theme_builder', [$this, 'apply_theme_builder']);

        // Insert operations
        add_action('wp_ajax_divi_ai_insert_to_divi', [$this, 'insert_to_divi']);
    }

    /**
     * Start new wizard session
     */
    public function start_wizard(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $type = sanitize_text_field($_POST['type'] ?? 'page');

        $session_id = wp_generate_uuid4();
        $session_data = [
            'type' => $type,
            'step' => 1,
            'data' => [],
            'started_at' => current_time('mysql'),
        ];

        set_transient("divi_ai_wizard_{$session_id}", $session_data, HOUR_IN_SECONDS);

        wp_send_json_success([
            'session_id' => $session_id,
            'type' => $type,
            'next_step' => $this->get_first_step($type),
        ]);
    }

    /**
     * Save wizard step data
     */
    public function save_step(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $session_id = sanitize_text_field($_POST['session_id']);
        $step_data = json_decode(stripslashes($_POST['step_data']), true);

        $session = get_transient("divi_ai_wizard_{$session_id}");

        if (!$session) {
            wp_send_json_error(['message' => 'Session expired']);
            return;
        }

        $session['data'] = array_merge($session['data'], $step_data);
        $session['step']++;

        set_transient("divi_ai_wizard_{$session_id}", $session, HOUR_IN_SECONDS);

        wp_send_json_success([
            'next_step' => $this->get_next_step($session),
            'session' => $session,
        ]);
    }

    /**
     * Get templates with filtering
     */
    public function get_templates(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $category = sanitize_text_field($_POST['category'] ?? '');
        $search = sanitize_text_field($_POST['search'] ?? '');
        $page = absint($_POST['page'] ?? 1);

        global $wpdb;
        $table = $wpdb->prefix . 'divi_ai_template_library';

        $where = ['1=1'];
        $params = [];

        if ($category) {
            $where[] = 'category = %s';
            $params[] = $category;
        }

        if ($search) {
            $where[] = '(name LIKE %s OR tags LIKE %s)';
            $params[] = '%' . $wpdb->esc_like($search) . '%';
            $params[] = '%' . $wpdb->esc_like($search) . '%';
        }

        $per_page = 12;
        $offset = ($page - 1) * $per_page;

        $sql = $wpdb->prepare(
            "SELECT * FROM {$table} WHERE " . implode(' AND ', $where) .
            " ORDER BY popularity_score DESC LIMIT %d OFFSET %d",
            array_merge($params, [$per_page, $offset])
        );

        $templates = $wpdb->get_results($sql);

        wp_send_json_success([
            'templates' => $templates,
            'page' => $page,
            'has_more' => count($templates) === $per_page,
        ]);
    }

    /**
     * Search media from various sources
     */
    public function search_media(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $source = sanitize_text_field($_POST['source']);
        $query = sanitize_text_field($_POST['query']);

        $results = [];

        switch ($source) {
            case 'unsplash':
                $results = $this->search_unsplash($query);
                break;
            case 'envato':
                $results = $this->search_envato($query);
                break;
            case 'media_library':
                $results = $this->search_media_library($query);
                break;
        }

        wp_send_json_success(['results' => $results]);
    }

    /**
     * Generate AI image with DALL-E
     */
    public function generate_ai_image(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $prompt = sanitize_textarea_field($_POST['prompt']);
        $style = sanitize_text_field($_POST['style'] ?? 'natural');

        // Call DALL-E service
        $dalle = new DallEService();
        $result = $dalle->generate($prompt, ['style' => $style]);

        // Download and store in Media Library
        $attachment_id = $this->sideload_image($result['url'], $prompt);

        wp_send_json_success([
            'attachment_id' => $attachment_id,
            'url' => wp_get_attachment_url($attachment_id),
        ]);
    }

    /**
     * Apply header/footer to Theme Builder
     */
    public function apply_theme_builder(): void {
        check_ajax_referer('divi_ai_wizard', 'nonce');

        $header_json = stripslashes($_POST['header_json'] ?? '');
        $footer_json = stripslashes($_POST['footer_json'] ?? '');
        $page_404_json = stripslashes($_POST['page_404_json'] ?? '');

        // Create Theme Builder templates
        if ($header_json) {
            $this->create_theme_builder_template('header', $header_json);
        }

        if ($footer_json) {
            $this->create_theme_builder_template('footer', $footer_json);
        }

        if ($page_404_json) {
            $this->create_theme_builder_template('404', $page_404_json);
        }

        wp_send_json_success(['message' => 'Theme Builder updated']);
    }
}
```

### JavaScript API Client

```javascript
// src/admin/wizard/services/api.js

const API_BASE = '/wp-admin/admin-ajax.php';

class WizardAPI {
    constructor() {
        this.nonce = window.diviAiWizard?.nonce || '';
    }

    async request(action, data = {}) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('nonce', this.nonce);

        Object.entries(data).forEach(([key, value]) => {
            if (typeof value === 'object') {
                formData.append(key, JSON.stringify(value));
            } else {
                formData.append(key, value);
            }
        });

        const response = await fetch(API_BASE, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData,
        });

        const result = await response.json();

        if (!result.success) {
            throw new Error(result.data?.message || 'Request failed');
        }

        return result.data;
    }

    // Wizard operations
    startWizard(type) {
        return this.request('divi_ai_wizard_start', { type });
    }

    saveStep(sessionId, stepData) {
        return this.request('divi_ai_wizard_step', {
            session_id: sessionId,
            step_data: stepData,
        });
    }

    generate(sessionId) {
        return this.request('divi_ai_wizard_generate', {
            session_id: sessionId,
        });
    }

    // Template operations
    getTemplates(options = {}) {
        return this.request('divi_ai_get_templates', options);
    }

    previewTemplate(templateId, tokens) {
        return this.request('divi_ai_preview_template', {
            template_id: templateId,
            tokens,
        });
    }

    // Media operations
    searchMedia(source, query) {
        return this.request('divi_ai_search_media', { source, query });
    }

    generateImage(prompt, style) {
        return this.request('divi_ai_generate_image', { prompt, style });
    }

    // Site setup operations
    createMenu(pages) {
        return this.request('divi_ai_create_menu', { pages });
    }

    setLogo(attachmentId) {
        return this.request('divi_ai_set_logo', { attachment_id: attachmentId });
    }

    applyThemeBuilder(headerJson, footerJson, page404Json) {
        return this.request('divi_ai_apply_theme_builder', {
            header_json: headerJson,
            footer_json: footerJson,
            page_404_json: page404Json,
        });
    }

    // Insert to Divi
    insertToDivi(sessionId, targetPage) {
        return this.request('divi_ai_insert_to_divi', {
            session_id: sessionId,
            target_page: targetPage,
        });
    }
}

export default new WizardAPI();
```

### React Wizard Component Example

```jsx
// src/admin/wizard/App.jsx

import React, { useState, useEffect } from 'react';
import { WizardProvider, useWizard } from './WizardContext';
import EntryStep from './steps/EntryStep';
import SiteSetupFlow from './steps/SiteSetup';
import PageCreationFlow from './steps/PageCreation';
import SectionCreationFlow from './steps/SectionCreation';
import PreviewStep from './steps/Preview';
import api from './services/api';

const WizardApp = () => {
    const { state, dispatch } = useWizard();
    const { currentStep, wizardType, sessionId } = state;

    useEffect(() => {
        // Initialize wizard session
        if (!sessionId && wizardType) {
            api.startWizard(wizardType).then(data => {
                dispatch({ type: 'SET_SESSION', payload: data.session_id });
            });
        }
    }, [wizardType, sessionId]);

    const renderStep = () => {
        if (!wizardType) {
            return <EntryStep onSelect={type => dispatch({ type: 'SET_TYPE', payload: type })} />;
        }

        switch (wizardType) {
            case 'site-setup':
                return <SiteSetupFlow />;
            case 'page':
                return <PageCreationFlow />;
            case 'section':
                return <SectionCreationFlow />;
            default:
                return <EntryStep />;
        }
    };

    return (
        <div className="divi-ai-wizard">
            <div className="wizard-header">
                <h1>Divi AI Page Builder</h1>
                <ProgressIndicator currentStep={currentStep} wizardType={wizardType} />
            </div>

            <div className="wizard-content">
                {renderStep()}
            </div>

            <div className="wizard-footer">
                <NavigationButtons />
            </div>
        </div>
    );
};

// Entry point
const WizardRoot = () => (
    <WizardProvider>
        <WizardApp />
    </WizardProvider>
);

export default WizardRoot;
```

### Admin Page Registration

```php
<?php
/**
 * Register wizard admin page
 */
class WizardAdminPage {

    public function __construct() {
        add_action('admin_menu', [$this, 'register_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function register_menu(): void {
        add_menu_page(
            'Divi AI Wizard',
            'Divi AI',
            'edit_pages',
            'divi-ai-wizard',
            [$this, 'render_page'],
            'dashicons-art',
            30
        );
    }

    public function render_page(): void {
        echo '<div id="divi-ai-wizard-root"></div>';
    }

    public function enqueue_scripts(string $hook): void {
        if ($hook !== 'toplevel_page_divi-ai-wizard') {
            return;
        }

        wp_enqueue_script(
            'divi-ai-wizard',
            DIVI_AI_PLUGIN_URL . 'dist/admin/wizard.js',
            ['wp-element', 'wp-components', 'wp-api-fetch'],
            DIVI_AI_VERSION,
            true
        );

        wp_enqueue_style(
            'divi-ai-wizard',
            DIVI_AI_PLUGIN_URL . 'dist/admin/wizard.css',
            ['wp-components'],
            DIVI_AI_VERSION
        );

        wp_localize_script('divi-ai-wizard', 'diviAiWizard', [
            'nonce' => wp_create_nonce('divi_ai_wizard'),
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'restUrl' => rest_url('divi-ai/v1/'),
            'userTokens' => $this->get_user_tokens(),
            'siteInfo' => [
                'name' => get_bloginfo('name'),
                'logo' => get_custom_logo(),
                'hasMenu' => has_nav_menu('primary-menu'),
            ],
        ]);
    }

    private function get_user_tokens(): array {
        // Get user's brand settings from Customizer
        return [
            'colors' => [
                'primary' => get_theme_mod('divi_ai_color_primary', '#3366ff'),
                'secondary' => get_theme_mod('divi_ai_color_secondary', '#ff6633'),
                'accent' => get_theme_mod('divi_ai_color_accent', '#00cc88'),
            ],
            'fonts' => [
                'heading' => get_theme_mod('divi_ai_font_heading', 'Montserrat'),
                'body' => get_theme_mod('divi_ai_font_body', 'Open Sans'),
            ],
        ];
    }
}
```

### Loading States & Progress

```jsx
// Real-time progress during generation
const GenerationProgress = ({ sessionId }) => {
    const [progress, setProgress] = useState(0);
    const [status, setStatus] = useState('Initializing...');

    useEffect(() => {
        const pollProgress = async () => {
            const data = await api.request('divi_ai_wizard_status', {
                session_id: sessionId
            });

            setProgress(data.progress_percent);
            setStatus(data.current_step);

            if (data.status !== 'completed') {
                setTimeout(pollProgress, 1000);
            }
        };

        pollProgress();
    }, [sessionId]);

    return (
        <div className="generation-progress">
            <div className="progress-bar">
                <div className="progress-fill" style={{ width: `${progress}%` }} />
            </div>
            <p className="progress-status">{status}</p>
            <p className="progress-percent">{progress}%</p>
        </div>
    );
};
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
