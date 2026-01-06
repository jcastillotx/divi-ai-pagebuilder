# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Planning documentation for AI Creation Wizard flow
- Planning documentation for Template Library strategy
- **Core Plugin Implementation**
  - Plugin core class (`DiviAI\Core\Plugin`) with singleton pattern
  - Service container (`DiviAI\Core\Container`) for dependency injection
  - Assets manager (`DiviAI\Core\Assets`) for script/style loading
  - PSR-4 autoloading with fallback for development
- **AI Provider System**
  - Provider interface (`DiviAI\AI\ProviderInterface`)
  - Abstract provider base class with common functionality
  - Provider factory for creating AI instances
  - OpenAI GPT integration with text and image generation
  - Anthropic Claude integration with structured output support
  - API key encryption using WordPress salts
- **Admin Settings Page**
  - React-based settings UI with tabbed navigation
  - General settings (enable AI, default creation type)
  - AI provider configuration with API key management
  - Template library settings with cache management
  - Usage tracking with progress bars
  - Advanced settings (debug mode, data management)
  - Settings export/import functionality
- **REST API Endpoints**
  - Content generation endpoint
  - Layout generation endpoint
  - Image generation endpoint
  - Usage statistics endpoint
  - Template listing and transformation endpoints
  - Design tokens endpoints
- **AI Creation Wizard**
  - Type selector (Page, Section, Site Setup)
  - Page creation wizard with multi-step flow
  - Section creation wizard with content generation
  - Site setup wizard for header/footer/pages
  - Progress indicators and step navigation
- **Template Library**
  - Template library manager with search/filter
  - Template transformer for applying design tokens
  - Color role detection (semantic mapping)
  - Font transformation with role detection
  - Transformation caching system
- **Design Token System**
  - WordPress Customizer panel for global styles
  - 9 color tokens with semantic naming
  - 3 font tokens with Google Fonts integration
  - 6 preset palettes (Professional Blue, Creative Coral, etc.)
  - CSS custom properties for live preview
- **Divi Builder Integration**
  - Toolbar button for AI access
  - Slide-out AI panel
  - Template browser modal
  - Content improvement tool
- **JavaScript/React Components**
  - Admin settings app with all tab components
  - Wizard app with step components
  - Template browser component
  - Shared UI components (Notice, ProgressBar)
  - API service layer
  - Settings hook for state management
- **Styling**
  - SCSS stylesheets for all entry points
  - Responsive layouts
  - WordPress admin integration
  - Customizer panel enhancements

### Changed
- Updated Divi documentation URLs to official developer portal
- Updated main plugin file with autoloader and initialization

---

## [1.0.0] - TBD

### Added

#### Core Infrastructure
- WordPress plugin scaffolding with proper headers and constants
- PSR-4 autoloading structure via Composer
- Build system with Webpack, Babel, and PostCSS
- Local WordPress development environment (.wp-env.json)
- ESLint and PHP_CodeSniffer linting configuration
- PHPUnit testing framework setup

#### AI Integration
- AI service abstraction layer supporting multiple providers
- OpenAI GPT-4/GPT-4o integration for content generation
- Anthropic Claude integration for complex reasoning tasks
- Rate limiting and usage tracking
- Encrypted API key storage using WordPress salts

#### Template Library (2000+ templates)
- Template import and organization system
- Template metadata indexing (categories, colors, fonts, tags)
- Template browser UI with search and filtering
- Category navigation: Full pages, Sections, Headers, Footers, 404 pages
- Live preview with user's brand styling

#### Design Token System
- WordPress Customizer "Global Styles" panel
- 9 semantic color tokens (primary, secondary, accent, text variants, backgrounds)
- 3 font tokens (heading, body, accent)
- 10+ preset color palettes
- Google Fonts integration
- Template transformation engine with caching

#### AI Creation Wizard
- Three entry points: Full Page, Section, Site Setup
- Page creation flow: Type → Layout → Content → Media
- Section creation flow: Type → Background → Content
- Site Setup flow: Header → Footer → 404 → Logo/Menu
- Auto-generated backgrounds (AI images, design patterns)
- Multi-source media integration:
  - Unsplash API (free stock photos)
  - Envato Elements API (premium stock)
  - DALL-E (AI image generation)
- Auto-menu creation from published pages
- Live preview and one-click insert

#### Database
- `{prefix}divi_ai_history` - AI generation history
- `{prefix}divi_ai_usage` - Usage tracking
- `{prefix}divi_ai_prompt_templates` - AI prompt templates
- `{prefix}divi_ai_template_library` - Divi template registry
- `{prefix}divi_ai_style_profiles` - User style profiles
- `{prefix}divi_ai_transform_cache` - Transformation cache
- `{prefix}divi_ai_wizard_sessions` - Wizard session state
- `{prefix}divi_ai_media_cache` - Media asset cache

#### REST API Endpoints
- `POST /wp-json/divi-ai/v1/generate/content` - Generate text content
- `POST /wp-json/divi-ai/v1/generate/layout` - Generate page layout
- `POST /wp-json/divi-ai/v1/generate/image-alt` - Generate image alt text
- `POST /wp-json/divi-ai/v1/optimize/seo` - Get SEO suggestions
- `POST /wp-json/divi-ai/v1/optimize/design` - Get design suggestions
- `GET /wp-json/divi-ai/v1/usage` - Get usage statistics
- `GET /wp-json/divi-ai/v1/templates` - List templates with filtering
- `POST /wp-json/divi-ai/v1/templates/transform` - Transform template with tokens

### Security
- Nonce verification on all AJAX/REST requests
- Capability checks (administrator level for settings)
- Input sanitization before AI submission
- Output sanitization before rendering
- Encrypted API key storage
- Rate limiting per user
- Audit logging for all AI operations

### Requirements
- WordPress 6.0+
- PHP 8.0+
- Divi Theme 4.14+ or Divi Builder Plugin 4.14+
- MySQL 5.7+ / MariaDB 10.3+
- HTTPS enabled

---

## Version Guidelines

When updating the version, ensure the following files are updated:

1. `divi-ai-pagebuilder.php` - Plugin header `Version:` and `DIVI_AI_VERSION` constant
2. `package.json` - `version` field
3. `composer.json` - `version` field
4. `README.md` - Version badge and Version History section
5. `readme.txt` - `Stable tag:` and Changelog section
6. `CHANGELOG.md` - Add new version section (this file)

---

[Unreleased]: https://github.com/jcastillotx/divi-ai-pagebuilder/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/jcastillotx/divi-ai-pagebuilder/releases/tag/v1.0.0
