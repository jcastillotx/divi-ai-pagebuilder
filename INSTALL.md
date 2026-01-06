# Installation Guide

Complete installation instructions for the Divi AI Page Builder WordPress plugin.

---

## Table of Contents

- [Requirements](#requirements)
- [Installation Methods](#installation-methods)
  - [Method 1: WordPress Admin Upload](#method-1-wordpress-admin-upload)
  - [Method 2: FTP/SFTP Upload](#method-2-ftpsftp-upload)
  - [Method 3: From Source (Developers)](#method-3-from-source-developers)
- [Post-Installation Setup](#post-installation-setup)
- [Configuration](#configuration)
- [Verification](#verification)
- [Troubleshooting](#troubleshooting)
- [Uninstallation](#uninstallation)

---

## Requirements

Before installing, ensure your server meets these requirements:

| Requirement | Minimum Version | Recommended |
|-------------|-----------------|-------------|
| WordPress | 6.0+ | 6.4+ |
| PHP | 8.0+ | 8.2+ |
| MySQL | 5.7+ | 8.0+ |
| MariaDB | 10.3+ | 10.6+ |
| Divi Theme/Builder | 4.14+ | Latest |

### Additional Requirements

- **HTTPS**: Required for secure API communication
- **Memory Limit**: Minimum 128MB (256MB recommended)
- **Max Execution Time**: Minimum 60 seconds
- **API Keys**: OpenAI and/or Anthropic API key

### Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

---

## Installation Methods

### Method 1: WordPress Admin Upload

**Best for:** Most users

1. **Download the Plugin**
   - Download `divi-ai-pagebuilder.zip` from your purchase location

2. **Navigate to Plugin Upload**
   - Log in to your WordPress admin dashboard
   - Go to **Plugins > Add New**
   - Click the **Upload Plugin** button at the top

3. **Upload and Install**
   - Click **Choose File** and select `divi-ai-pagebuilder.zip`
   - Click **Install Now**
   - Wait for the installation to complete

4. **Activate the Plugin**
   - Click **Activate Plugin**
   - Or go to **Plugins > Installed Plugins** and click **Activate** under "Divi AI Page Builder"

```
WordPress Admin
└── Plugins
    └── Add New
        └── Upload Plugin
            └── Choose File → divi-ai-pagebuilder.zip
                └── Install Now
                    └── Activate Plugin
```

---

### Method 2: FTP/SFTP Upload

**Best for:** Users who prefer manual installation or have upload limitations

1. **Download and Extract**
   - Download `divi-ai-pagebuilder.zip`
   - Extract the ZIP file on your computer
   - You should have a folder named `divi-ai-pagebuilder`

2. **Connect via FTP/SFTP**
   - Use an FTP client (FileZilla, Cyberduck, etc.)
   - Connect to your server using your FTP credentials

3. **Upload the Plugin Folder**
   - Navigate to `/wp-content/plugins/`
   - Upload the entire `divi-ai-pagebuilder` folder
   - Ensure all files are transferred completely

4. **Activate in WordPress**
   - Log in to WordPress admin
   - Go to **Plugins > Installed Plugins**
   - Find "Divi AI Page Builder" and click **Activate**

```
Your Server
└── public_html (or www)
    └── wp-content
        └── plugins
            └── divi-ai-pagebuilder/    ← Upload here
                ├── divi-ai-pagebuilder.php
                ├── includes/
                ├── assets/
                └── ...
```

---

### Method 3: From Source (Developers)

**Best for:** Developers and contributors

1. **Clone the Repository**
   ```bash
   cd /path/to/wordpress/wp-content/plugins/
   git clone https://github.com/jcastillotx/divi-ai-pagebuilder.git
   cd divi-ai-pagebuilder
   ```

2. **Install Dependencies**
   ```bash
   # Install PHP dependencies
   composer install

   # Install Node.js dependencies
   npm install
   ```

3. **Build Assets**
   ```bash
   # For production
   npm run build

   # For development (with watch)
   npm run dev
   ```

4. **Activate the Plugin**
   - Log in to WordPress admin
   - Go to **Plugins > Installed Plugins**
   - Find "Divi AI Page Builder" and click **Activate**

### Using wp-env (Local Development)

```bash
# Clone and setup
git clone https://github.com/jcastillotx/divi-ai-pagebuilder.git
cd divi-ai-pagebuilder

# Install dependencies
composer install && npm install

# Build assets
npm run build

# Start local WordPress environment
npx wp-env start

# Access at http://localhost:8888
# Admin: http://localhost:8888/wp-admin
# Username: admin | Password: password
```

---

## Post-Installation Setup

After activating the plugin, complete these setup steps:

### Step 1: Verify Divi is Active

The plugin requires Divi Theme or Divi Builder Plugin. If not detected, you'll see an admin notice:

```
⚠️ Divi AI Page Builder requires the Divi theme or Divi Builder plugin
   to be installed and active.
```

**Solution:** Install and activate Divi from Elegant Themes.

### Step 2: Configure API Keys

1. Go to **Settings > Divi AI**
2. Navigate to the **AI Providers** tab
3. Enter your API keys:
   - **OpenAI API Key**: Get from [platform.openai.com](https://platform.openai.com/api-keys)
   - **Anthropic API Key**: Get from [console.anthropic.com](https://console.anthropic.com/)
4. Click **Test Connection** to verify each key
5. Click **Save Changes**

### Step 3: Set Up Global Styles

1. Go to **Appearance > Customize**
2. Find **Divi AI Global Styles** panel
3. Configure your brand:
   - **Colors**: Primary, secondary, accent colors
   - **Typography**: Heading and body fonts
4. Click **Publish** to save

### Step 4: Database Tables

Database tables are created automatically on activation. To verify:

```bash
# Via WP-CLI
wp db query "SHOW TABLES LIKE '%divi_ai%'"
```

Expected tables:
- `wp_divi_ai_history`
- `wp_divi_ai_usage`
- `wp_divi_ai_prompt_templates`
- `wp_divi_ai_template_library`
- `wp_divi_ai_style_profiles`
- `wp_divi_ai_transform_cache`
- `wp_divi_ai_wizard_sessions`
- `wp_divi_ai_media_cache`

---

## Configuration

### Settings Location

**Settings > Divi AI** - Main plugin configuration

### Required Configuration

| Setting | Location | Required |
|---------|----------|----------|
| API Key (OpenAI or Anthropic) | Settings > Divi AI > AI Providers | Yes |
| Brand Colors | Appearance > Customize > Divi AI Global Styles | Recommended |
| Brand Fonts | Appearance > Customize > Divi AI Global Styles | Recommended |

### Optional Configuration

| Setting | Location | Default |
|---------|----------|---------|
| Default AI Provider | Settings > Divi AI > AI Providers | OpenAI |
| Rate Limiting | Settings > Divi AI > Usage & Limits | 100/hour |
| Cache Duration | Settings > Divi AI > Templates | 24 hours |
| Debug Mode | Settings > Divi AI > Advanced | Off |

### Environment Variables (Optional)

For advanced configuration, create a `.env` file in the plugin directory:

```bash
# AI Provider API Keys (alternative to admin settings)
OPENAI_API_KEY=sk-your-openai-api-key
ANTHROPIC_API_KEY=sk-ant-your-anthropic-key

# Development Settings
WP_DEBUG=true
DIVI_AI_DEV_MODE=true
DIVI_AI_LOG_LEVEL=debug
```

---

## Verification

### Check Installation Status

1. Go to **Plugins > Installed Plugins**
2. Find "Divi AI Page Builder"
3. Verify status shows "Active"
4. Check version number matches expected version

### Test AI Connection

1. Go to **Settings > Divi AI > AI Providers**
2. Click **Test Connection** for each configured provider
3. Verify "Connection successful!" message appears

### Test Template Library

1. Open any page in Divi Builder
2. Look for the "AI" button in the builder toolbar
3. Click to open the AI Creation Wizard
4. Verify template categories load correctly

### Health Check via WP-CLI

```bash
# Check plugin status
wp plugin list --name=divi-ai-pagebuilder

# Check database tables
wp db query "SELECT COUNT(*) FROM wp_divi_ai_template_library"

# Check options
wp option get divi_ai_settings --format=json
```

---

## Troubleshooting

### Common Issues

#### Plugin Won't Activate

**Error:** "Plugin could not be activated because it triggered a fatal error."

**Solutions:**
1. Verify PHP version is 8.0+:
   ```bash
   php -v
   ```
2. Check WordPress version is 6.0+
3. Ensure Divi is installed and active
4. Check PHP error logs for specific error

#### "Divi Not Detected" Warning

**Error:** "Divi AI Page Builder requires the Divi theme or Divi Builder plugin..."

**Solutions:**
1. Install Divi Theme from Elegant Themes
2. Or install Divi Builder Plugin
3. Activate Divi before activating this plugin
4. If using Extra theme, ensure it's active (uses Divi Builder)

#### API Connection Failed

**Error:** "Connection failed. Please check your API key."

**Solutions:**
1. Verify API key is correct (no extra spaces)
2. Check API key has sufficient credits/quota
3. Ensure server can make outbound HTTPS requests
4. Check if firewall blocks api.openai.com or api.anthropic.com

#### Database Tables Not Created

**Solutions:**
1. Deactivate and reactivate the plugin
2. Manually trigger table creation:
   ```bash
   wp eval "divi_ai_create_tables();"
   ```
3. Check database user has CREATE TABLE permission

#### JavaScript Errors in Builder

**Solutions:**
1. Clear browser cache
2. Deactivate other plugins to check conflicts
3. Check browser console for specific errors
4. Ensure assets are built: `npm run build`

### Debug Mode

Enable debug mode to get detailed logs:

1. Go to **Settings > Divi AI > Advanced**
2. Enable **Debug Mode**
3. Set **Log Level** to "Debug"
4. Check logs at **Settings > Divi AI > Advanced > View Debug Log**

Or via wp-config.php:
```php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'DIVI_AI_DEV_MODE', true );
```

### Getting Help

- **Documentation:** [docs/](docs/)
- **GitHub Issues:** [Report a bug](https://github.com/jcastillotx/divi-ai-pagebuilder/issues)
- **Website:** [https://www.kre8ivtech.com](https://www.kre8ivtech.com)

---

## Uninstallation

### Standard Uninstall

1. Go to **Plugins > Installed Plugins**
2. Click **Deactivate** under "Divi AI Page Builder"
3. Click **Delete** to remove plugin files

### Complete Removal (Including Data)

Before uninstalling, to remove all plugin data:

1. Go to **Settings > Divi AI > Advanced**
2. Enable **Remove data on uninstall**
3. Click **Save Changes**
4. Then deactivate and delete the plugin

This will remove:
- All database tables
- All plugin options
- AI generation history
- Template cache
- Style profiles

### Manual Database Cleanup

If needed, remove tables manually:

```sql
DROP TABLE IF EXISTS wp_divi_ai_history;
DROP TABLE IF EXISTS wp_divi_ai_usage;
DROP TABLE IF EXISTS wp_divi_ai_prompt_templates;
DROP TABLE IF EXISTS wp_divi_ai_template_library;
DROP TABLE IF EXISTS wp_divi_ai_style_profiles;
DROP TABLE IF EXISTS wp_divi_ai_transform_cache;
DROP TABLE IF EXISTS wp_divi_ai_wizard_sessions;
DROP TABLE IF EXISTS wp_divi_ai_media_cache;

DELETE FROM wp_options WHERE option_name LIKE 'divi_ai_%';
```

---

## Next Steps

After installation:

1. **Read the User Guide:** [docs/WIKI.md](docs/WIKI.md)
2. **Configure Global Styles:** Set up your brand colors and fonts
3. **Try the AI Wizard:** Create your first AI-generated page
4. **Explore Templates:** Browse 2000+ professionally designed templates

---

*For additional support, visit [https://www.kre8ivtech.com](https://www.kre8ivtech.com)*
