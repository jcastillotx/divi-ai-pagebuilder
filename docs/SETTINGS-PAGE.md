# Settings Page Documentation

> Technical specification for the Divi AI Page Builder admin settings page.

## Overview

The Settings page (`Settings > Divi AI`) provides administrators with the ability to configure AI providers, manage API keys, set usage limits, and customize plugin behavior.

---

## Page Structure

### Settings Page Location
- **Menu Location:** Settings > Divi AI
- **Capability Required:** `manage_options`
- **Page Slug:** `divi-ai-settings`
- **Screen ID:** `settings_page_divi-ai-settings`

### Settings Tabs

```
┌─────────────────────────────────────────────────────────────────────────┐
│  Divi AI Page Builder Settings                                          │
├─────────────────────────────────────────────────────────────────────────┤
│  [General] [AI Providers] [Templates] [Usage & Limits] [Advanced]       │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Tab content area                                                        │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Tab 1: General Settings

### Fields

| Field | Type | Description | Default |
|-------|------|-------------|---------|
| Enable AI Features | Toggle | Master switch to enable/disable AI | On |
| Default Creation Type | Select | Default wizard entry (Page/Section/Site Setup) | Page |
| Show Welcome Screen | Toggle | Show welcome tutorial for new users | On |
| Notification Preferences | Checkboxes | Email notifications for usage alerts | All enabled |

### UI Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  General Settings                                                        │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Enable AI Features                                                      │
│  ┌──────┐                                                                │
│  │ ● On │  Enable AI-powered features in Divi Builder                   │
│  └──────┘                                                                │
│                                                                          │
│  Default Creation Type                                                   │
│  ┌─────────────────────────────────────┐                                │
│  │ Full Page                        ▼ │                                 │
│  └─────────────────────────────────────┘                                │
│  The default option when opening the AI Creation Wizard                  │
│                                                                          │
│  Welcome Screen                                                          │
│  ┌──────┐                                                                │
│  │ ● On │  Show onboarding tutorial for new users                       │
│  └──────┘                                                                │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐   │
│  │                        [Save Changes]                             │   │
│  └──────────────────────────────────────────────────────────────────┘   │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Tab 2: AI Providers

### Fields

| Field | Type | Description | Validation |
|-------|------|-------------|------------|
| OpenAI API Key | Password | API key for GPT-4 | Required format: `sk-*` |
| OpenAI Model | Select | GPT model to use | gpt-4, gpt-4-turbo, gpt-4o |
| Anthropic API Key | Password | API key for Claude | Required format: `sk-ant-*` |
| Anthropic Model | Select | Claude model to use | claude-3-opus, claude-3-sonnet |
| Default Provider | Select | Primary AI provider | OpenAI, Anthropic |
| Fallback Provider | Select | Backup if primary fails | None, OpenAI, Anthropic |

### UI Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  AI Provider Configuration                                               │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  OpenAI                                                    [Test] │   │
│  ├─────────────────────────────────────────────────────────────────┤    │
│  │                                                                   │    │
│  │  API Key                                                          │    │
│  │  ┌─────────────────────────────────────────────────────────┐     │    │
│  │  │ sk-••••••••••••••••••••••••••••••••••••••••••          │     │    │
│  │  └─────────────────────────────────────────────────────────┘     │    │
│  │  🔒 Encrypted and stored securely                                 │    │
│  │                                                                   │    │
│  │  Model                                                            │    │
│  │  ┌───────────────────────────────┐                               │    │
│  │  │ GPT-4 Turbo              ▼ │                                 │    │
│  │  └───────────────────────────────┘                               │    │
│  │                                                                   │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  Anthropic                                                 [Test] │   │
│  ├─────────────────────────────────────────────────────────────────┤    │
│  │                                                                   │    │
│  │  API Key                                                          │    │
│  │  ┌─────────────────────────────────────────────────────────┐     │    │
│  │  │ sk-ant-••••••••••••••••••••••••••••••••••••••••••      │     │    │
│  │  └─────────────────────────────────────────────────────────┘     │    │
│  │  🔒 Encrypted and stored securely                                 │    │
│  │                                                                   │    │
│  │  Model                                                            │    │
│  │  ┌───────────────────────────────┐                               │    │
│  │  │ Claude 3 Sonnet          ▼ │                                 │    │
│  │  └───────────────────────────────┘                               │    │
│  │                                                                   │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  Provider Settings                                                       │
│  ─────────────────                                                       │
│                                                                          │
│  Default Provider                    Fallback Provider                   │
│  ┌─────────────────────┐            ┌─────────────────────┐             │
│  │ OpenAI          ▼ │            │ Anthropic       ▼ │             │
│  └─────────────────────┘            └─────────────────────┘             │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐   │
│  │                        [Save Changes]                             │   │
│  └──────────────────────────────────────────────────────────────────┘   │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

### API Key Security

API keys are encrypted before storage using WordPress authentication salts:

```php
// Encryption
$encrypted = openssl_encrypt(
    $api_key,
    'aes-256-cbc',
    wp_salt( 'auth' ),
    0,
    wp_salt( 'secure_auth' )
);

// Store encrypted key
update_option( 'divi_ai_openai_key', $encrypted );
```

### Test Connection Button

AJAX endpoint for testing API connectivity:

```php
// AJAX Action: divi_ai_test_provider
add_action( 'wp_ajax_divi_ai_test_provider', 'divi_ai_handle_test_provider' );

function divi_ai_handle_test_provider() {
    check_ajax_referer( 'divi_ai_settings_nonce', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( 'Unauthorized' );
    }

    $provider = sanitize_text_field( $_POST['provider'] );
    $result = DiviAI\AI\ProviderFactory::test_connection( $provider );

    wp_send_json( $result );
}
```

---

## Tab 3: Templates

### Fields

| Field | Type | Description |
|-------|------|-------------|
| Template Sources | Checkboxes | Enable/disable template categories |
| Auto-update Templates | Toggle | Automatically update template library |
| Cache Duration | Number | Hours to cache transformed templates |
| Clear Cache | Button | Manually clear transformation cache |

### UI Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  Template Library Settings                                               │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Template Categories                                                     │
│  ──────────────────                                                      │
│  ☑ Full Page Layouts (500+ templates)                                   │
│  ☑ Section Templates (800+ templates)                                   │
│  ☑ Header Templates (200+ templates)                                    │
│  ☑ Footer Templates (200+ templates)                                    │
│  ☑ 404 Page Templates (100+ templates)                                  │
│  ☐ Coming Soon Pages (50 templates)                                     │
│                                                                          │
│  Cache Settings                                                          │
│  ──────────────                                                          │
│                                                                          │
│  Cache Duration (hours)                                                  │
│  ┌──────────┐                                                           │
│  │    24    │  Transformed templates are cached for this duration       │
│  └──────────┘                                                           │
│                                                                          │
│  Current cache: 156 items (12.4 MB)                                     │
│  ┌────────────────────┐                                                 │
│  │  [Clear Cache]     │                                                 │
│  └────────────────────┘                                                 │
│                                                                          │
│  Template Statistics                                                     │
│  ───────────────────                                                     │
│  Total templates: 2,145                                                  │
│  Last sync: January 5, 2026 at 3:45 PM                                  │
│  ┌────────────────────┐                                                 │
│  │  [Sync Templates]  │                                                 │
│  └────────────────────┘                                                 │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐   │
│  │                        [Save Changes]                             │   │
│  └──────────────────────────────────────────────────────────────────┘   │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Tab 4: Usage & Limits

### Fields

| Field | Type | Description |
|-------|------|-------------|
| Rate Limit | Number | Max requests per period |
| Rate Period | Select | Period for rate limiting (hour/day/month) |
| Token Budget | Number | Maximum tokens per period |
| Alert Threshold | Number | Percentage at which to alert (0-100) |
| Alert Email | Email | Email for usage alerts |

### UI Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  Usage & Limits                                                          │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Current Usage (This Month)                                              │
│  ──────────────────────────                                              │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  API Requests                                                     │    │
│  │  ████████████████████░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░  45%       │    │
│  │  450 / 1,000 requests                                             │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  Tokens Used                                                      │    │
│  │  ██████████████████████████░░░░░░░░░░░░░░░░░░░░░░░░  62%        │    │
│  │  620,000 / 1,000,000 tokens                                       │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  Rate Limiting                                                           │
│  ─────────────                                                           │
│                                                                          │
│  Requests per period          Period                                     │
│  ┌──────────────┐             ┌─────────────────────┐                   │
│  │     100      │             │ Hour           ▼ │                     │
│  └──────────────┘             └─────────────────────┘                   │
│                                                                          │
│  Monthly token budget                                                    │
│  ┌──────────────┐                                                       │
│  │  1,000,000   │  Set to 0 for unlimited                              │
│  └──────────────┘                                                       │
│                                                                          │
│  Alerts                                                                  │
│  ──────                                                                  │
│                                                                          │
│  Alert at usage threshold                                                │
│  ┌──────────────┐                                                       │
│  │    80%       │  Send alert when usage reaches this percentage       │
│  └──────────────┘                                                       │
│                                                                          │
│  Alert email                                                             │
│  ┌────────────────────────────────────────────────┐                     │
│  │ admin@example.com                              │                     │
│  └────────────────────────────────────────────────┘                     │
│                                                                          │
│  ┌────────────────────────────┐                                         │
│  │  [View Detailed Analytics] │                                         │
│  └────────────────────────────┘                                         │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐   │
│  │                        [Save Changes]                             │   │
│  └──────────────────────────────────────────────────────────────────┘   │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## Tab 5: Advanced

### Fields

| Field | Type | Description |
|-------|------|-------------|
| Debug Mode | Toggle | Enable verbose logging |
| Log Level | Select | Logging verbosity (error/warning/info/debug) |
| Cleanup on Uninstall | Toggle | Delete all data when uninstalling |
| Export Settings | Button | Export settings to JSON |
| Import Settings | File Upload | Import settings from JSON |
| Reset to Defaults | Button | Reset all settings to defaults |

### UI Layout

```
┌─────────────────────────────────────────────────────────────────────────┐
│  Advanced Settings                                                       │
├─────────────────────────────────────────────────────────────────────────┤
│                                                                          │
│  Debugging                                                               │
│  ─────────                                                               │
│                                                                          │
│  Debug Mode                                                              │
│  ┌───────┐                                                              │
│  │ ○ Off │  Enable detailed logging for troubleshooting                 │
│  └───────┘                                                              │
│                                                                          │
│  Log Level                                                               │
│  ┌─────────────────────┐                                                │
│  │ Warning        ▼ │                                                  │
│  └─────────────────────┘                                                │
│                                                                          │
│  ┌─────────────────────────┐                                            │
│  │  [View Debug Log]       │                                            │
│  └─────────────────────────┘                                            │
│                                                                          │
│  Data Management                                                         │
│  ───────────────                                                         │
│                                                                          │
│  Remove data on uninstall                                                │
│  ┌───────┐                                                              │
│  │ ○ Off │  ⚠️ This will delete all history and settings               │
│  └───────┘                                                              │
│                                                                          │
│  Settings Backup                                                         │
│  ────────────────                                                        │
│                                                                          │
│  ┌─────────────────────┐  ┌─────────────────────┐                       │
│  │  [Export Settings]  │  │  [Import Settings]  │                       │
│  └─────────────────────┘  └─────────────────────┘                       │
│                                                                          │
│  Danger Zone                                                             │
│  ───────────                                                             │
│                                                                          │
│  ┌─────────────────────────────────────────────────────────────────┐    │
│  │  ⚠️ These actions cannot be undone                               │    │
│  │                                                                   │    │
│  │  ┌──────────────────────┐  ┌──────────────────────────────┐     │    │
│  │  │  [Reset to Defaults] │  │  [Clear All AI History]      │     │    │
│  │  └──────────────────────┘  └──────────────────────────────┘     │    │
│  │                                                                   │    │
│  └─────────────────────────────────────────────────────────────────┘    │
│                                                                          │
│  ┌──────────────────────────────────────────────────────────────────┐   │
│  │                        [Save Changes]                             │   │
│  └──────────────────────────────────────────────────────────────────┘   │
│                                                                          │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## WordPress Options

### Option Names and Structure

```php
// Main settings option
'divi_ai_settings' => [
    'version'             => '1.0.0',
    'installed_at'        => '2026-01-06 12:00:00',
    'enable_ai'           => true,
    'default_creation'    => 'page',
    'show_welcome'        => true,
    'default_provider'    => 'openai',
    'fallback_provider'   => 'anthropic',
    'openai_model'        => 'gpt-4-turbo',
    'anthropic_model'     => 'claude-3-sonnet',
    'rate_limit'          => 100,
    'rate_period'         => 'hour',
    'token_budget'        => 1000000,
    'alert_threshold'     => 80,
    'alert_email'         => '',
    'cache_duration'      => 24,
    'debug_mode'          => false,
    'log_level'           => 'warning',
    'cleanup_uninstall'   => false,
];

// Encrypted API keys (stored separately)
'divi_ai_openai_key'     => '[encrypted]',
'divi_ai_anthropic_key'  => '[encrypted]',

// Template settings
'divi_ai_template_categories' => [
    'full_pages'   => true,
    'sections'     => true,
    'headers'      => true,
    'footers'      => true,
    'error_pages'  => true,
    'coming_soon'  => false,
];

// Database version
'divi_ai_db_version' => '1.0.0',
```

---

## PHP Implementation

### Settings Page Registration

```php
<?php
namespace DiviAI\Admin;

class SettingsPage {

    /**
     * Initialize the settings page.
     */
    public function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    }

    /**
     * Add the settings menu page.
     */
    public function add_menu_page() {
        add_options_page(
            __( 'Divi AI Settings', 'divi-ai-pagebuilder' ),
            __( 'Divi AI', 'divi-ai-pagebuilder' ),
            'manage_options',
            'divi-ai-settings',
            [ $this, 'render_page' ]
        );
    }

    /**
     * Register settings sections and fields.
     */
    public function register_settings() {
        register_setting(
            'divi_ai_settings_group',
            'divi_ai_settings',
            [ $this, 'sanitize_settings' ]
        );

        // General settings section
        add_settings_section(
            'divi_ai_general',
            __( 'General Settings', 'divi-ai-pagebuilder' ),
            [ $this, 'render_general_section' ],
            'divi-ai-settings'
        );

        // Add fields...
    }

    /**
     * Enqueue admin scripts and styles.
     *
     * @param string $hook The current admin page hook.
     */
    public function enqueue_scripts( $hook ) {
        if ( 'settings_page_divi-ai-settings' !== $hook ) {
            return;
        }

        wp_enqueue_style(
            'divi-ai-admin',
            DIVI_AI_PLUGIN_URL . 'assets/dist/css/admin.css',
            [],
            DIVI_AI_VERSION
        );

        wp_enqueue_script(
            'divi-ai-admin',
            DIVI_AI_PLUGIN_URL . 'assets/dist/js/admin.js',
            [ 'jquery', 'wp-element', 'wp-components' ],
            DIVI_AI_VERSION,
            true
        );

        wp_localize_script( 'divi-ai-admin', 'diviAIAdmin', [
            'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'divi_ai_settings_nonce' ),
            'strings'  => [
                'testSuccess' => __( 'Connection successful!', 'divi-ai-pagebuilder' ),
                'testFailed'  => __( 'Connection failed. Please check your API key.', 'divi-ai-pagebuilder' ),
            ],
        ] );
    }

    /**
     * Sanitize settings before saving.
     *
     * @param array $input The submitted settings.
     * @return array Sanitized settings.
     */
    public function sanitize_settings( $input ) {
        $sanitized = [];

        // Boolean fields
        $sanitized['enable_ai']        = ! empty( $input['enable_ai'] );
        $sanitized['show_welcome']     = ! empty( $input['show_welcome'] );
        $sanitized['debug_mode']       = ! empty( $input['debug_mode'] );
        $sanitized['cleanup_uninstall'] = ! empty( $input['cleanup_uninstall'] );

        // Select fields
        $sanitized['default_creation']   = sanitize_text_field( $input['default_creation'] ?? 'page' );
        $sanitized['default_provider']   = sanitize_text_field( $input['default_provider'] ?? 'openai' );
        $sanitized['fallback_provider']  = sanitize_text_field( $input['fallback_provider'] ?? '' );
        $sanitized['openai_model']       = sanitize_text_field( $input['openai_model'] ?? 'gpt-4-turbo' );
        $sanitized['anthropic_model']    = sanitize_text_field( $input['anthropic_model'] ?? 'claude-3-sonnet' );
        $sanitized['rate_period']        = sanitize_text_field( $input['rate_period'] ?? 'hour' );
        $sanitized['log_level']          = sanitize_text_field( $input['log_level'] ?? 'warning' );

        // Numeric fields
        $sanitized['rate_limit']       = absint( $input['rate_limit'] ?? 100 );
        $sanitized['token_budget']     = absint( $input['token_budget'] ?? 1000000 );
        $sanitized['alert_threshold']  = min( 100, max( 0, absint( $input['alert_threshold'] ?? 80 ) ) );
        $sanitized['cache_duration']   = absint( $input['cache_duration'] ?? 24 );

        // Email field
        $sanitized['alert_email'] = sanitize_email( $input['alert_email'] ?? '' );

        return $sanitized;
    }

    /**
     * Render the settings page.
     */
    public function render_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'You do not have sufficient permissions.', 'divi-ai-pagebuilder' ) );
        }

        // React will render the page
        echo '<div id="divi-ai-settings-root"></div>';
    }
}
```

---

## AJAX Endpoints

### Test Provider Connection

```php
add_action( 'wp_ajax_divi_ai_test_provider', function() {
    check_ajax_referer( 'divi_ai_settings_nonce', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized' ], 403 );
    }

    $provider = sanitize_text_field( $_POST['provider'] ?? '' );

    if ( ! in_array( $provider, [ 'openai', 'anthropic' ], true ) ) {
        wp_send_json_error( [ 'message' => 'Invalid provider' ], 400 );
    }

    $result = DiviAI\AI\ProviderFactory::test_connection( $provider );

    if ( $result['success'] ) {
        wp_send_json_success( [
            'message' => __( 'Connection successful!', 'divi-ai-pagebuilder' ),
            'model'   => $result['model'],
        ] );
    } else {
        wp_send_json_error( [
            'message' => $result['error'],
        ], 400 );
    }
});
```

### Clear Cache

```php
add_action( 'wp_ajax_divi_ai_clear_cache', function() {
    check_ajax_referer( 'divi_ai_settings_nonce', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized' ], 403 );
    }

    global $wpdb;

    $deleted = $wpdb->query(
        "TRUNCATE TABLE {$wpdb->prefix}divi_ai_transform_cache"
    );

    wp_send_json_success( [
        'message' => __( 'Cache cleared successfully.', 'divi-ai-pagebuilder' ),
    ] );
});
```

### Export Settings

```php
add_action( 'wp_ajax_divi_ai_export_settings', function() {
    check_ajax_referer( 'divi_ai_settings_nonce', 'nonce' );

    if ( ! current_user_can( 'manage_options' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized' ], 403 );
    }

    $settings = get_option( 'divi_ai_settings', [] );
    $categories = get_option( 'divi_ai_template_categories', [] );

    // Don't export API keys
    $export = [
        'version'    => DIVI_AI_VERSION,
        'exported'   => current_time( 'mysql' ),
        'settings'   => $settings,
        'categories' => $categories,
    ];

    wp_send_json_success( $export );
});
```

---

## React Component Structure

```
src/admin/
├── index.js                    # Entry point
├── App.jsx                     # Main app component
├── components/
│   ├── SettingsTabs.jsx       # Tab navigation
│   ├── GeneralTab.jsx         # General settings
│   ├── ProvidersTab.jsx       # AI providers config
│   ├── TemplatesTab.jsx       # Template settings
│   ├── UsageTab.jsx           # Usage & limits
│   ├── AdvancedTab.jsx        # Advanced settings
│   └── common/
│       ├── Toggle.jsx         # Toggle switch
│       ├── Select.jsx         # Dropdown select
│       ├── Input.jsx          # Text/number input
│       ├── Button.jsx         # Button component
│       ├── Card.jsx           # Card container
│       └── ProgressBar.jsx    # Usage progress
├── hooks/
│   ├── useSettings.js         # Settings state management
│   └── useAjax.js             # AJAX request hook
└── utils/
    └── validation.js          # Form validation
```

---

## Security Considerations

1. **Capability Checks**: All settings require `manage_options` capability
2. **Nonce Verification**: All AJAX requests verified with nonces
3. **Input Sanitization**: All inputs sanitized before storage
4. **API Key Encryption**: Keys encrypted with WordPress salts
5. **Output Escaping**: All output properly escaped
6. **CSRF Protection**: Settings form includes nonce field

---

## Accessibility

- All form fields have associated labels
- Tab navigation supports keyboard access
- Focus states clearly visible
- Error messages announced to screen readers
- Color contrast meets WCAG 2.1 AA standards
