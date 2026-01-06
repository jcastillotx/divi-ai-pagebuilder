# CLAUDE.md - Project Instructions for Claude Code

## Project Overview

**Divi AI Page Builder** is a WordPress plugin that integrates AI capabilities with the Divi theme/page builder. The goal is to enable users to generate, modify, and optimize page layouts, content, and designs using natural language prompts.

- **Version:** 1.0.0
- **Author:** Kre8ivTech, LLC
- **Website:** https://www.kre8ivtech.com

> **IMPORTANT:** Always refer to `README.md` for the latest commands and version information. Update version numbers in all files when making changes.

## Tech Stack

- **Backend**: PHP 8.0+ (WordPress Plugin)
- **Frontend**: JavaScript/React (Divi Builder integration)
- **AI Integration**: OpenAI API / Anthropic Claude API
- **WordPress**: 6.0+ with Divi Theme 4.x+
- **Build Tools**: Node.js, npm/yarn, Webpack

## Project Structure

```
divi-ai-pagebuilder/
├── assets/                 # Static assets (CSS, images)
├── includes/              # PHP classes and core functionality
│   ├── admin/            # WordPress admin pages
│   ├── api/              # REST API endpoints
│   ├── ai/               # AI service integrations
│   └── builder/          # Divi Builder extensions
├── src/                   # JavaScript/React source
│   ├── components/       # React components
│   ├── hooks/            # Custom React hooks
│   ├── services/         # API service layer
│   └── utils/            # Utility functions
├── templates/             # PHP template files
├── tests/                 # Test files (PHPUnit, Jest)
├── docs/                  # Documentation
├── languages/             # i18n translation files
└── vendor/                # Composer dependencies (gitignored)
```

## Development Commands

```bash
# Install dependencies
composer install
npm install

# Development build with watch
npm run dev

# Production build
npm run build

# Run PHP tests
composer test

# Run JavaScript tests
npm test

# Lint code
npm run lint
composer lint

# Start local WordPress environment (if using wp-env)
npx wp-env start
```

## Coding Standards

### PHP
- Follow WordPress Coding Standards
- Use PSR-4 autoloading
- Prefix all functions/classes with `divi_ai_` or namespace under `DiviAI`
- Document all functions with PHPDoc blocks
- Sanitize all inputs, escape all outputs

### JavaScript/React
- Use ES6+ syntax
- Follow Airbnb style guide
- Use TypeScript for type safety (preferred)
- Use React hooks over class components
- Keep components small and focused

### Git Workflow
- Feature branches: `feature/descriptive-name`
- Bug fixes: `fix/issue-description`
- Always write descriptive commit messages
- Create PRs for all changes

## Key Files

- `divi-ai-pagebuilder.php` - Main plugin entry point
- `includes/class-plugin.php` - Core plugin class
- `includes/ai/class-ai-service.php` - AI service abstraction
- `src/index.js` - React app entry point

## AI Integration Notes

### Supported AI Providers
1. **OpenAI** - GPT-4/GPT-4o for content generation
2. **Anthropic Claude** - Claude for complex reasoning tasks
3. **Custom** - Extensible for other providers

### AI Features to Implement
- Layout generation from text prompts
- Content writing and optimization
- Image suggestions and alt text generation
- SEO optimization recommendations
- Accessibility improvements
- Style/design suggestions

## Testing Guidelines

- Write unit tests for all PHP classes
- Write integration tests for REST API endpoints
- Write component tests for React components
- Minimum 80% code coverage target
- Test with multiple Divi versions

## Security Considerations

- Never expose API keys in frontend code
- Validate all AI-generated content before rendering
- Implement rate limiting on API endpoints
- Use nonces for all AJAX/REST requests
- Sanitize AI outputs before database storage

## Common Tasks

### Adding a new AI feature
1. Define the feature in `includes/ai/` with proper interface
2. Create REST endpoint in `includes/api/`
3. Build React component in `src/components/`
4. Add tests for all layers
5. Update documentation

### Extending Divi Builder
1. Register new module in `includes/builder/`
2. Create React component for visual builder
3. Implement save/render callbacks
4. Test in both frontend and visual builder

## Environment Variables

Create a `.env` file (not committed) with:
```
OPENAI_API_KEY=your_openai_key
ANTHROPIC_API_KEY=your_anthropic_key
WP_DEBUG=true
```

## Useful Links

- [Divi Developer Documentation](https://www.elegantthemes.com/developers/)
- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/)
- [OpenAI API Documentation](https://platform.openai.com/docs/)
- [Anthropic API Documentation](https://docs.anthropic.com/)

## Notes for Claude

- Always check WordPress coding standards before suggesting PHP code
- Remember that Divi uses its own module system - familiarize with their patterns
- AI responses need sanitization before being used in WordPress
- Consider backward compatibility with older Divi versions
- The plugin should work without AI keys (graceful degradation)
