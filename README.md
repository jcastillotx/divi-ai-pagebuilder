# Divi AI Page Builder

[![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/jcastillotx/divi-ai-pagebuilder)
[![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-green.svg)](https://wordpress.org)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-purple.svg)](https://php.net)
[![Divi](https://img.shields.io/badge/Divi-4.14%2B-orange.svg)](https://elegantthemes.com)

A WordPress plugin that brings AI-powered design and content creation capabilities to the Divi page builder.

**Author:** [Kre8ivTech, LLC](https://www.kre8ivtech.com)
**Version:** 1.0.0
**License:** Proprietary

---

## Table of Contents

- [Overview](#overview)
- [Requirements](#requirements)
- [Installation](#installation)
- [Commands Reference](#commands-reference)
- [Project Structure](#project-structure)
- [Version History](#version-history)
- [Documentation](#documentation)
- [Development](#development)

---

## Overview

Divi AI Page Builder integrates artificial intelligence with Elegant Themes' Divi Builder, enabling users to:

- **Generate Layouts** - Create page sections and layouts from natural language descriptions
- **Write Content** - Generate headlines, paragraphs, and call-to-actions with AI
- **Optimize Designs** - Get AI suggestions for colors, typography, and spacing
- **Improve SEO** - Receive optimization recommendations for better search rankings
- **Enhance Accessibility** - Automatically identify and fix accessibility issues
- **Template Library** - Access 2000+ professionally designed templates with automatic brand customization

---

## Requirements

| Requirement | Version |
|-------------|---------|
| WordPress | 6.0+ |
| PHP | 8.0+ |
| Divi Theme or Divi Builder | 4.14+ |
| MySQL | 5.7+ / MariaDB 10.3+ |
| Node.js (dev) | 18+ |
| Composer (dev) | 2.x |

**API Keys Required:**
- OpenAI API key (for GPT-4) and/or
- Anthropic API key (for Claude)

---

## Installation

### From Source

```bash
# Clone the repository
git clone https://github.com/jcastillotx/divi-ai-pagebuilder.git

# Navigate to directory
cd divi-ai-pagebuilder

# Install dependencies
composer install
npm install

# Build assets
npm run build
```

Copy the plugin folder to your WordPress `wp-content/plugins/` directory and activate from the WordPress admin.

### Configuration

1. Navigate to **Settings > Divi AI** in WordPress admin
2. Enter your OpenAI and/or Anthropic API keys
3. Configure your Global Styles (colors, fonts) in the Customizer
4. Start using AI features in the Divi Builder

---

## Commands Reference

> **IMPORTANT:** Always refer back to this section before running commands. Update version numbers here after any changes.

### Development Commands

```bash
# Install all dependencies
composer install && npm install

# Development build with watch
npm run dev

# Production build
npm run build

# Run all tests
composer test && npm test

# Run PHP tests only
composer test

# Run JavaScript tests only
npm test

# Lint code
composer lint && npm run lint

# Auto-fix linting issues
composer lint:fix && npm run lint:fix

# Generate autoload files
composer dump-autoload
```

### WordPress Environment Commands

```bash
# Start local WordPress (wp-env)
npx wp-env start

# Stop local WordPress
npx wp-env stop

# Access WP-CLI
npx wp-env run cli wp plugin list

# View logs
npx wp-env logs

# Reset environment
npx wp-env clean all
```

### Database Commands

```bash
# Run migrations (via WP-CLI)
npx wp-env run cli wp eval "divi_ai_create_tables();"

# Export database
npx wp-env run cli wp db export backup.sql

# Import database
npx wp-env run cli wp db import backup.sql
```

### Template Library Commands

```bash
# Import templates (when CLI is implemented)
npx wp-env run cli wp divi-ai import-templates /path/to/templates --analyze --preview

# Analyze templates
npx wp-env run cli wp divi-ai analyze-templates

# Clear transformation cache
npx wp-env run cli wp divi-ai clear-cache
```

### Build & Release Commands

```bash
# Create release build
npm run build:release

# Generate translation files
npm run i18n:build

# Create plugin ZIP
npm run package
```

---

## Project Structure

```
divi-ai-pagebuilder/
├── assets/                 # Static assets (CSS, images)
├── includes/              # PHP classes and core functionality
│   ├── admin/            # WordPress admin pages
│   ├── api/              # REST API endpoints
│   ├── ai/               # AI service integrations
│   ├── builder/          # Divi Builder extensions
│   └── templates/        # Template system classes
├── src/                   # JavaScript/React source
│   ├── components/       # React components
│   ├── hooks/            # Custom React hooks
│   ├── services/         # API service layer
│   └── utils/            # Utility functions
├── templates/             # Divi JSON templates (2000+)
│   ├── full-pages/       # Complete page layouts
│   ├── sections/         # Individual sections
│   ├── headers/          # Header layouts
│   └── footers/          # Footer layouts
├── tests/                 # Test files (PHPUnit, Jest)
├── docs/                  # Documentation
├── languages/             # i18n translation files
└── vendor/                # Composer dependencies (gitignored)
```

---

## Version History

> **UPDATE THIS SECTION** with every change. Follow semantic versioning.

### Version 1.0.0 (Current)

**Release Date:** TBD (In Development)

**Status:** Initial Development

#### Features Planned
- [ ] Core plugin infrastructure
- [ ] AI service integration (OpenAI, Anthropic)
- [ ] Template Library with 2000+ templates
- [ ] Design Token System (Global Styles)
- [ ] Template transformation engine
- [ ] AI Content Generation wizard
- [ ] WordPress Customizer integration

#### Database Tables (v1.0.0)
- `{prefix}divi_ai_history` - AI generation history
- `{prefix}divi_ai_usage` - Usage tracking
- `{prefix}divi_ai_prompt_templates` - AI prompt templates
- `{prefix}divi_ai_template_library` - Divi template registry
- `{prefix}divi_ai_style_profiles` - User style profiles
- `{prefix}divi_ai_transform_cache` - Transformation cache
- `{prefix}divi_ai_wizard_sessions` - Wizard session state
- `{prefix}divi_ai_media_cache` - Media asset cache

#### Constants Defined
```php
DIVI_AI_VERSION          = '1.0.0'
DIVI_AI_MIN_PHP_VERSION  = '8.0'
DIVI_AI_MIN_WP_VERSION   = '6.0'
DIVI_AI_MIN_DIVI_VERSION = '4.14'
```

---

## Documentation

| Document | Description |
|----------|-------------|
| [INSTALL.md](INSTALL.md) | Installation guide for WordPress |
| [CHANGELOG.md](CHANGELOG.md) | Version history and release notes |
| [WIKI.md](docs/WIKI.md) | User guide and how-to documentation |
| [PLANNING.md](docs/PLANNING.md) | Architecture and feature roadmap |
| [TEMPLATE-STRATEGY.md](docs/TEMPLATE-STRATEGY.md) | Template library technical specification |
| [AI-WIZARD-FLOW.md](docs/AI-WIZARD-FLOW.md) | AI creation wizard UX and implementation |
| [AI-PERSONA.md](docs/AI-PERSONA.md) | AI persona and system prompts |
| [SETTINGS-PAGE.md](docs/SETTINGS-PAGE.md) | Admin settings page specification |
| [SETUP.md](docs/SETUP.md) | Development environment setup |
| [CLAUDE.md](CLAUDE.md) | AI assistant coding guidelines |

---

## Development

### Quick Start

```bash
# 1. Clone and setup
git clone https://github.com/jcastillotx/divi-ai-pagebuilder.git
cd divi-ai-pagebuilder
composer install && npm install

# 2. Start development
npm run dev

# 3. Start WordPress environment
npx wp-env start

# 4. Access WordPress at http://localhost:8888
#    Admin: http://localhost:8888/wp-admin (admin/password)
```

### Environment Variables

Create a `.env` file (not committed):

```bash
# AI Provider API Keys
OPENAI_API_KEY=sk-your-openai-api-key
ANTHROPIC_API_KEY=sk-ant-your-anthropic-key

# Development Settings
WP_DEBUG=true
DIVI_AI_DEV_MODE=true
DIVI_AI_LOG_LEVEL=debug
```

### Coding Standards

- **PHP:** WordPress Coding Standards with PSR-4 autoloading
- **JavaScript:** Airbnb style guide, ES6+
- **Commits:** Descriptive messages, reference issues when applicable

### Version Bumping

When making changes, update version in:
1. `divi-ai-pagebuilder.php` - Plugin header and `DIVI_AI_VERSION` constant
2. `package.json` - Version field
3. `composer.json` - Version field
4. `README.md` - Version badge and Version History section
5. `readme.txt` - Stable tag and changelog
6. `CHANGELOG.md` - Add new version section with changes

> **CLAUDE INSTRUCTION:** When making significant changes or updating to a new version, always update the CHANGELOG.md file following the [Keep a Changelog](https://keepachangelog.com/) format. Group changes under: Added, Changed, Deprecated, Removed, Fixed, Security.

---

## Support

- **Website:** [https://www.kre8ivtech.com](https://www.kre8ivtech.com)
- **Issues:** [GitHub Issues](https://github.com/jcastillotx/divi-ai-pagebuilder/issues)
- **Documentation:** [docs/](docs/)

---

## License

This project is proprietary software. Copyright (c) 2024 Kre8ivTech, LLC. All rights reserved.

---

*Built with AI for the WordPress and Divi community*
