# Development Setup Guide

This guide will help you set up your local development environment for the Divi AI Page Builder plugin.

## Prerequisites

Before starting, ensure you have the following installed:

- **PHP 8.0+** with extensions: curl, json, mbstring, xml
- **Composer 2.x** - PHP dependency manager
- **Node.js 18+** - JavaScript runtime
- **npm 9+** or **Yarn 1.22+** - Package managers
- **MySQL 5.7+** or **MariaDB 10.3+** - Database
- **Git** - Version control
- **WordPress 6.0+** - Local WordPress installation
- **Divi Theme 4.14+** - Divi theme or builder plugin

---

## Quick Start

### 1. Clone the Repository

```bash
git clone https://github.com/jcastillotx/divi-ai-pagebuilder.git
cd divi-ai-pagebuilder
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Configure Environment

```bash
# Copy example environment file
cp .env.example .env

# Edit with your API keys and configuration
nano .env
```

### 4. Build Assets

```bash
# Development build with watch mode
npm run dev

# Or production build
npm run build
```

### 5. Link to WordPress

```bash
# Create symlink in WordPress plugins directory
ln -s /path/to/divi-ai-pagebuilder /path/to/wordpress/wp-content/plugins/divi-ai-pagebuilder
```

### 6. Activate Plugin

- Go to WordPress Admin > Plugins
- Find "Divi AI Page Builder"
- Click "Activate"

---

## Detailed Setup Options

### Option A: Local Development with wp-env

WordPress's official development environment (recommended for consistency):

```bash
# Install wp-env globally
npm install -g @wordpress/env

# Start the environment
npx wp-env start

# The site will be available at http://localhost:8888
# Admin: http://localhost:8888/wp-admin (admin/password)
```

**wp-env Configuration** (`.wp-env.json`):
```json
{
  "core": "WordPress/WordPress#6.4",
  "plugins": ["."],
  "themes": [],
  "config": {
    "WP_DEBUG": true,
    "WP_DEBUG_LOG": true,
    "SCRIPT_DEBUG": true
  },
  "mappings": {
    "wp-content/plugins/divi": "./vendor/divi"
  }
}
```

### Option B: Local by Flywheel / LocalWP

1. Download and install [LocalWP](https://localwp.com/)
2. Create a new WordPress site
3. Clone this repo into `app/public/wp-content/plugins/`
4. Install Divi theme on the site
5. Activate the plugin

### Option C: Docker Setup

```bash
# Start WordPress with Docker
docker-compose up -d

# Access at http://localhost:8080
```

**docker-compose.yml**:
```yaml
version: '3.8'

services:
  wordpress:
    image: wordpress:latest
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: db
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
      WORDPRESS_DB_NAME: wordpress
      WORDPRESS_DEBUG: 1
    volumes:
      - wordpress_data:/var/www/html
      - .:/var/www/html/wp-content/plugins/divi-ai-pagebuilder

  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: wordpress
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
      MYSQL_ROOT_PASSWORD: rootpassword
    volumes:
      - db_data:/var/lib/mysql

volumes:
  wordpress_data:
  db_data:
```

### Option D: XAMPP/MAMP/WAMP

1. Install your preferred stack (XAMPP, MAMP, or WAMP)
2. Start Apache and MySQL
3. Create a database for WordPress
4. Install WordPress in `htdocs/` or `www/`
5. Clone this repo into `wp-content/plugins/`
6. Install and activate Divi theme

---

## Environment Configuration

### Required Environment Variables

Create a `.env` file in the project root:

```bash
# AI Provider API Keys
OPENAI_API_KEY=sk-your-openai-api-key
ANTHROPIC_API_KEY=sk-ant-your-anthropic-key

# WordPress Configuration (for wp-env)
WP_DEBUG=true
WP_DEBUG_LOG=true
SCRIPT_DEBUG=true

# Development Settings
DIVI_AI_DEV_MODE=true
DIVI_AI_LOG_LEVEL=debug

# Optional: Rate Limiting
DIVI_AI_RATE_LIMIT=100
DIVI_AI_RATE_PERIOD=3600
```

### Getting API Keys

**OpenAI**:
1. Go to [OpenAI Platform](https://platform.openai.com/)
2. Sign up or log in
3. Navigate to API Keys
4. Create a new secret key
5. Copy and add to `.env`

**Anthropic**:
1. Go to [Anthropic Console](https://console.anthropic.com/)
2. Sign up or log in
3. Navigate to API Keys
4. Create a new key
5. Copy and add to `.env`

---

## Development Commands

### PHP Commands

```bash
# Install dependencies
composer install

# Run PHP tests
composer test

# Run specific test file
composer test -- --filter TestClassName

# Check coding standards
composer lint

# Auto-fix coding standards
composer lint:fix

# Generate autoload files
composer dump-autoload
```

### JavaScript/Node Commands

```bash
# Install dependencies
npm install

# Development build with watch
npm run dev

# Production build
npm run build

# Run JavaScript tests
npm test

# Run tests with coverage
npm run test:coverage

# Lint JavaScript
npm run lint

# Fix linting issues
npm run lint:fix

# Type checking (if using TypeScript)
npm run typecheck
```

### WordPress Commands

```bash
# Start wp-env
npx wp-env start

# Stop wp-env
npx wp-env stop

# Access WP-CLI
npx wp-env run cli wp plugin list

# View logs
npx wp-env logs

# Reset environment
npx wp-env clean all
```

---

## IDE Setup

### VS Code Extensions

Recommended extensions for development:

```json
{
  "recommendations": [
    "bmewburn.vscode-intelephense-client",
    "dbaeumer.vscode-eslint",
    "esbenp.prettier-vscode",
    "EditorConfig.EditorConfig",
    "xdebug.php-debug",
    "wordpresstoolbox.wordpress-toolbox"
  ]
}
```

### VS Code Settings

Add to `.vscode/settings.json`:

```json
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  "[php]": {
    "editor.defaultFormatter": "bmewburn.vscode-intelephense-client"
  },
  "intelephense.environment.includePaths": [
    "vendor/wordpress/wordpress-src"
  ],
  "eslint.validate": ["javascript", "javascriptreact", "typescript", "typescriptreact"]
}
```

### PHPStorm Setup

1. Open project in PHPStorm
2. Configure PHP interpreter (8.0+)
3. Set up WordPress coding style:
   - Settings > Editor > Code Style > PHP
   - Set from: WordPress
4. Configure PHPUnit:
   - Settings > PHP > Test Frameworks
   - Add PHPUnit by Remote Interpreter

---

## Debugging

### PHP Debugging with Xdebug

1. Install Xdebug for your PHP version
2. Configure `php.ini`:

```ini
[xdebug]
xdebug.mode=debug
xdebug.start_with_request=yes
xdebug.client_port=9003
xdebug.client_host=localhost
```

3. Configure VS Code launch.json:

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www/html/wp-content/plugins/divi-ai-pagebuilder": "${workspaceFolder}"
      }
    }
  ]
}
```

### JavaScript Debugging

Use browser DevTools or VS Code debugger for React:

```json
{
  "type": "chrome",
  "request": "launch",
  "name": "Debug in Chrome",
  "url": "http://localhost:8888",
  "webRoot": "${workspaceFolder}/src"
}
```

### WordPress Debug Log

Enable in `wp-config.php`:

```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

View logs at `wp-content/debug.log`.

---

## Testing

### Running Tests

```bash
# Run all tests
npm test && composer test

# Run PHP unit tests only
composer test

# Run JavaScript tests only
npm test

# Run tests in watch mode
npm run test:watch

# Generate coverage report
npm run test:coverage
composer test -- --coverage-html coverage/
```

### Writing Tests

**PHP Test Example**:
```php
<?php
class Test_AI_Service extends WP_UnitTestCase {
    public function test_generate_content() {
        $service = new DiviAI\AI\Service();
        $result = $service->generate_content('Test prompt');

        $this->assertNotEmpty($result);
        $this->assertIsString($result);
    }
}
```

**JavaScript Test Example**:
```javascript
import { render, screen } from '@testing-library/react';
import AIPanel from '../components/AIPanel';

test('renders AI panel with prompt input', () => {
  render(<AIPanel />);
  const input = screen.getByPlaceholderText(/describe your page/i);
  expect(input).toBeInTheDocument();
});
```

---

## Troubleshooting

### Common Issues

**"Plugin requires Divi theme"**
- Ensure Divi theme or Divi Builder plugin is installed and active
- Check Divi version is 4.14 or higher

**"API key invalid"**
- Verify API key in Settings > Divi AI
- Check `.env` file for correct key format
- Ensure no extra whitespace in key

**"Build failed"**
- Delete `node_modules` and run `npm install` again
- Check Node.js version: `node -v` (should be 18+)
- Clear npm cache: `npm cache clean --force`

**"PHP memory exhausted"**
- Increase memory in `php.ini`: `memory_limit = 512M`
- Or in `wp-config.php`: `define('WP_MEMORY_LIMIT', '512M');`

**"Xdebug not connecting"**
- Verify Xdebug is installed: `php -v`
- Check port 9003 is not blocked
- Ensure IDE is listening for connections

### Getting Help

- Check [GitHub Issues](https://github.com/jcastillotx/divi-ai-pagebuilder/issues)
- Review WordPress debug log
- Enable `DIVI_AI_DEV_MODE` for verbose logging

---

## Next Steps

After setup, you can:

1. Read the [PLANNING.md](./PLANNING.md) for architecture overview
2. Review [CLAUDE.md](../CLAUDE.md) for coding guidelines
3. Check open issues for contribution opportunities
4. Join the development discussion
