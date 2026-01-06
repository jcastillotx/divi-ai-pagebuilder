# AGENTS.md

This repository is a **WordPress plugin**: **Divi AI Page Builder**.

Use this file as the quick, operational playbook for coding agents working in this codebase.
For full commands and version info, defer to `README.md` and `docs/SETUP.md`.

## What this repo is

- **Plugin name**: Divi AI Page Builder
- **Backend**: PHP (WordPress plugin), namespaced under `DiviAI\\` (autoload in `composer.json`)
- **Frontend**: React/JS bundled with Webpack (source under `src/`)
- **AI Providers**: OpenAI + Anthropic implementations under `includes/AI/`
- **REST API**: endpoints/controller(s) under `includes/API/`

## Golden rules

- **Never commit secrets** (API keys, `.env`, credentials). Keep secrets out of frontend bundles.
- **Sanitize all inputs, escape all outputs** (WordPress standards). Validate any AI output before storing/rendering.
- **Prefer smallest safe change**; keep backward compatibility with supported WP/Divi versions.
- **Follow existing patterns** in `includes/` (PHP) and `src/` (React) before introducing new architecture.

## Local setup

### Dependencies

- PHP **8.0+**
- Composer **2.x**
- Node **18+** / npm **9+**

### Install

```bash
composer install
npm install
```

## Build / test / lint

### JavaScript

```bash
npm run dev        # webpack watch
npm run build      # production build
npm run lint       # eslint
npm run lint:fix
npm test
```

### PHP

```bash
composer test      # phpunit
composer lint      # phpcs (WordPress)
composer lint:fix  # phpcbf
```

## WordPress environment (recommended)

This repo includes `.wp-env.json`.

```bash
npx wp-env start
npx wp-env stop
npx wp-env logs
npx wp-env run cli wp plugin list
```

If you need a DB reset:

```bash
npx wp-env clean all
```

## Where to make changes

- **Main plugin entry**: `divi-ai-pagebuilder.php`
- **PHP core/services**: `includes/Core/`
- **Admin UI (PHP)**: `includes/Admin/`
- **AI provider layer**: `includes/AI/`
- **REST API**: `includes/API/`
- **Wizard flow (PHP)**: `includes/Wizard/`
- **React admin app**: `src/admin/`
- **Shared React components**: `src/components/`
- **API client**: `src/services/api.js`
- **Settings hook**: `src/hooks/useSettings.js`

## Coding conventions (project-specific)

### PHP

- Namespace under `DiviAI\\` (autoloaded from `includes/`).
- Prefer WordPress APIs, nonces, capabilities checks.
- Keep REST responses predictable; validate and sanitize request params.

### JavaScript/React

- Prefer hooks and small components.
- Avoid storing secrets client-side; API calls should go through WP REST with nonces.

## Versioning & changelog discipline

When making changes that affect behavior, features, or releases, update:

- `divi-ai-pagebuilder.php` (header + `DIVI_AI_VERSION` constant)
- `package.json` version
- `composer.json` version
- `README.md` version badge / version history
- `readme.txt` stable tag + changelog
- `CHANGELOG.md` (Keep a Changelog format)

## Documentation pointers

- `README.md`: authoritative commands + overall project info
- `docs/SETUP.md`: development environment setup details
- `docs/PLANNING.md`: architecture/roadmap
- `docs/SETTINGS-PAGE.md`: admin settings spec
- `docs/AI-WIZARD-FLOW.md`: wizard UX/flow

