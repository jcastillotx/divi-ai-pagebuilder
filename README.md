# Divi AI Page Builder

A WordPress plugin that brings AI-powered design and content creation capabilities to the Divi page builder.

## Overview

Divi AI Page Builder integrates artificial intelligence with Elegant Themes' Divi Builder, enabling users to:

- **Generate Layouts** - Create page sections and layouts from natural language descriptions
- **Write Content** - Generate headlines, paragraphs, and call-to-actions with AI
- **Optimize Designs** - Get AI suggestions for colors, typography, and spacing
- **Improve SEO** - Receive optimization recommendations for better search rankings
- **Enhance Accessibility** - Automatically identify and fix accessibility issues

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Divi Theme 4.14+ or Divi Builder Plugin 4.14+
- OpenAI API key and/or Anthropic API key

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
3. Configure usage limits and preferences
4. Start using AI features in the Divi Builder

## Features

### Layout Generation
Describe the page you want to create in plain English, and let AI generate a complete layout with sections, rows, and modules.

### Content Writing
Generate professional copy for any module - headlines, body text, buttons, and more. Supports multiple tones and styles.

### Design Assistant
Get intelligent suggestions for improving your design's visual hierarchy, color contrast, and overall aesthetics.

### SEO Optimization
Receive actionable recommendations for improving your content's search engine visibility.

## Documentation

- [Setup Guide](docs/SETUP.md) - Development environment setup
- [Planning Document](docs/PLANNING.md) - Architecture and roadmap
- [Claude Instructions](CLAUDE.md) - AI assistant guidelines

## Development

```bash
# Install dependencies
composer install && npm install

# Start development build with watch
npm run dev

# Run tests
composer test && npm test

# Lint code
composer lint && npm run lint
```

See [docs/SETUP.md](docs/SETUP.md) for detailed development instructions.

## Project Status

🚧 **Early Development** - This project is in the initial planning and scaffolding phase.

## Contributing

Contributions are welcome! Please read our contributing guidelines and submit pull requests to the `main` branch.

## License

This project is proprietary software. All rights reserved.

## Author

**Jeremiah Castillo**
Email: kre8ivtech@gmail.com

---

*Built for the WordPress and Divi community*
