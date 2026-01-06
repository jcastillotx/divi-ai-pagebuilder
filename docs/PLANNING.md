# Project Planning - Divi AI Page Builder

## Vision

Create a powerful WordPress plugin that brings AI-assisted design and content creation capabilities to the Divi page builder, enabling users to build professional websites faster through natural language interactions.

## Goals

1. **Democratize Web Design** - Allow non-designers to create professional layouts
2. **Accelerate Workflow** - Reduce page building time by 50%+
3. **Maintain Quality** - Ensure AI outputs meet professional standards
4. **Seamless Integration** - Work naturally within existing Divi workflows

---

## Architecture Overview

### High-Level Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        WordPress Site                           │
├─────────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────────┐  │
│  │   Divi       │  │  Divi AI     │  │    WordPress         │  │
│  │   Theme      │◄─┤  Plugin      │◄─┤    Admin             │  │
│  │              │  │              │  │                      │  │
│  └──────────────┘  └──────┬───────┘  └──────────────────────┘  │
│                           │                                     │
│                    ┌──────▼───────┐                            │
│                    │  REST API    │                            │
│                    │  Endpoints   │                            │
│                    └──────┬───────┘                            │
└───────────────────────────┼─────────────────────────────────────┘
                            │
                    ┌───────▼───────┐
                    │  AI Gateway   │
                    │  Service      │
                    └───────┬───────┘
                            │
            ┌───────────────┼───────────────┐
            │               │               │
    ┌───────▼─────┐ ┌───────▼─────┐ ┌───────▼─────┐
    │   OpenAI    │ │  Anthropic  │ │   Custom    │
    │   GPT-4     │ │   Claude    │ │   Models    │
    └─────────────┘ └─────────────┘ └─────────────┘
```

### Component Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Plugin Core                               │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  ┌─────────────┐  ┌─────────────┐  ┌─────────────────────┐  │
│  │   Admin     │  │   Builder   │  │    AI Services      │  │
│  │   Panel     │  │   Module    │  │                     │  │
│  │             │  │             │  │  ┌───────────────┐  │  │
│  │ - Settings  │  │ - UI Panel  │  │  │LayoutGenerator│  │  │
│  │ - API Keys  │  │ - Preview   │  │  │ContentWriter  │  │  │
│  │ - Usage     │  │ - Actions   │  │  │StyleOptimizer │  │  │
│  │             │  │             │  │  │ImageSuggester │  │  │
│  └─────────────┘  └─────────────┘  │  └───────────────┘  │  │
│                                     └─────────────────────┘  │
│                                                              │
│  ┌─────────────────────────────────────────────────────────┐ │
│  │                    Data Layer                           │ │
│  │  - Prompt Templates  - Usage Tracking  - Cache Layer   │ │
│  └─────────────────────────────────────────────────────────┘ │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

---

## Feature Roadmap

### Phase 1: Foundation (MVP)

**Objective**: Establish core plugin infrastructure and basic AI integration

- [ ] Plugin scaffolding and WordPress integration
- [ ] Admin settings page with API key management
- [ ] Basic REST API endpoints
- [ ] OpenAI integration for text generation
- [ ] Simple content generation (headings, paragraphs)
- [ ] Basic Divi module integration

**Deliverables**:
- Working plugin that installs on WordPress
- Settings page for API configuration
- Basic "Generate Content" button in Divi

### Phase 1.5: Template Library Foundation ⭐ NEW

**Objective**: Integrate 2000+ Divi templates with dynamic customization

> 📖 See [TEMPLATE-STRATEGY.md](./TEMPLATE-STRATEGY.md) for complete technical specification

- [ ] Create template directory structure and organization system
- [ ] Build template import/analysis CLI tool
- [ ] Generate template metadata index (categories, colors, fonts, tags)
- [ ] Design Token System implementation
  - [ ] Define token schema (colors, typography, spacing)
  - [ ] WordPress Customizer "Global Styles" panel
  - [ ] Color palette presets (10+ themes)
  - [ ] Google Fonts integration
- [ ] Template Transformation Engine
  - [ ] Divi JSON parser
  - [ ] Color role detection (semantic clustering)
  - [ ] Font role mapping (heading vs body)
  - [ ] Transformation pipeline with caching
- [ ] Template Browser UI
  - [ ] Category navigation sidebar
  - [ ] Search and filter capabilities
  - [ ] Live preview with user's colors/fonts
  - [ ] "Insert with Customization" workflow

**Deliverables**:
- Organized template library (2000+ templates)
- WordPress Customizer panel for brand colors/fonts
- Template browser modal in Divi Builder
- One-click insertion with automatic brand styling

**Key Components**:

```
┌─────────────────────────────────────────────────────────────┐
│              TEMPLATE CUSTOMIZATION FLOW                     │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Template Library    →   User's Style Profile   →   Output  │
│  (2000+ JSON files)      (Customizer tokens)       (Divi)   │
│                                                              │
│  Colors: #3366ff    →   Primary: #your-brand   →   #brand   │
│  Fonts: Montserrat  →   Heading: Poppins       →   Poppins  │
│                                                              │
└─────────────────────────────────────────────────────────────┘
```

### Phase 2: Layout Generation

**Objective**: Enable AI-powered layout creation

- [ ] Layout prompt parser
- [ ] Section/row/module structure generation
- [ ] **Integration with Template Library** (AI selects best template)
- [ ] Preview before insert functionality
- [ ] Undo/redo support for AI changes
- [ ] Multiple layout suggestions

**Deliverables**:
- "Generate Layout" feature in Divi Builder
- Natural language layout descriptions
- Layout preview modal
- AI-assisted template selection

### Phase 3: Content Enhancement

**Objective**: Advanced content creation and optimization

- [ ] Long-form content generation
- [ ] SEO optimization suggestions
- [ ] Tone/style customization
- [ ] Multi-language support
- [ ] Content rewriting/improvement
- [ ] Call-to-action optimization

**Deliverables**:
- Content wizard with style options
- SEO score integration
- Translation/localization support

### Phase 4: Design Intelligence

**Objective**: AI-powered design improvements

- [ ] Color scheme suggestions
- [ ] Typography recommendations
- [ ] Spacing/layout optimization
- [ ] Mobile responsiveness checks
- [ ] Accessibility analysis
- [ ] Visual hierarchy improvements

**Deliverables**:
- Design assistant panel
- One-click design improvements
- Accessibility audit tool

### Phase 5: Advanced Features

**Objective**: Enterprise and power user features

- [ ] Custom AI model integration
- [ ] Team collaboration features
- [ ] Usage analytics dashboard
- [ ] API for external integrations
- [ ] White-label options
- [ ] Batch processing

**Deliverables**:
- Enterprise admin panel
- API documentation
- White-label customization

---

## Technical Specifications

### Minimum Requirements

- WordPress 6.0+
- PHP 8.0+
- Divi Theme 4.14+ or Divi Builder Plugin 4.14+
- MySQL 5.7+ / MariaDB 10.3+
- HTTPS enabled (for API security)

### Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

### Performance Targets

- API response time: < 3 seconds (excluding AI processing)
- AI generation time: < 30 seconds for complex layouts
- Plugin activation: < 500ms impact on page load
- Memory usage: < 50MB during AI operations

---

## Database Schema

### Custom Tables

```sql
-- AI Generation History
CREATE TABLE {prefix}divi_ai_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    prompt TEXT NOT NULL,
    response LONGTEXT,
    ai_provider VARCHAR(50),
    tokens_used INT UNSIGNED,
    generation_type VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
);

-- Usage Tracking
CREATE TABLE {prefix}divi_ai_usage (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    period_start DATE NOT NULL,
    tokens_used BIGINT UNSIGNED DEFAULT 0,
    requests_count INT UNSIGNED DEFAULT 0,
    UNIQUE KEY unique_user_period (user_id, period_start)
);

-- Prompt Templates (AI prompts)
CREATE TABLE {prefix}divi_ai_prompt_templates (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    prompt_template TEXT NOT NULL,
    is_system TINYINT(1) DEFAULT 0,
    created_by BIGINT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Divi Template Library (2000+ layout templates)
CREATE TABLE {prefix}divi_ai_template_library (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id VARCHAR(100) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    subcategory VARCHAR(100),
    tags JSON,
    industry JSON,
    color_palette JSON,
    fonts_used JSON,
    module_count INT UNSIGNED,
    preview_url VARCHAR(500),
    json_path VARCHAR(500),
    json_content LONGTEXT,
    popularity_score DECIMAL(3,2) DEFAULT 0.00,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_subcategory (subcategory),
    INDEX idx_popularity (popularity_score),
    FULLTEXT idx_search (name, category, subcategory)
);

-- User Style Profiles (Design Tokens per site)
CREATE TABLE {prefix}divi_ai_style_profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    profile_name VARCHAR(100) NOT NULL,
    is_active TINYINT(1) DEFAULT 0,
    color_primary VARCHAR(7),
    color_secondary VARCHAR(7),
    color_accent VARCHAR(7),
    color_text_primary VARCHAR(7),
    color_text_secondary VARCHAR(7),
    color_text_light VARCHAR(7),
    color_bg_primary VARCHAR(7),
    color_bg_secondary VARCHAR(7),
    color_bg_dark VARCHAR(7),
    font_heading VARCHAR(100),
    font_body VARCHAR(100),
    font_accent VARCHAR(100),
    custom_tokens JSON,
    created_by BIGINT UNSIGNED,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_active (is_active)
);

-- Template Transformation Cache
CREATE TABLE {prefix}divi_ai_transform_cache (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    template_id VARCHAR(100) NOT NULL,
    profile_hash VARCHAR(32) NOT NULL,
    transformed_json LONGTEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME,
    UNIQUE KEY unique_transform (template_id, profile_hash),
    INDEX idx_expires (expires_at)
);
```

---

## API Endpoints

### REST API Structure

```
/wp-json/divi-ai/v1/

POST /generate/content     - Generate text content
POST /generate/layout      - Generate page layout
POST /generate/image-alt   - Generate image alt text
POST /optimize/seo         - Get SEO suggestions
POST /optimize/design      - Get design suggestions
GET  /usage                - Get usage statistics
GET  /templates            - List prompt templates
POST /templates            - Save custom template
```

---

## Security Measures

1. **API Key Storage**: Encrypted in database using WordPress salts
2. **Rate Limiting**: Per-user request limits to prevent abuse
3. **Input Validation**: All prompts sanitized before AI submission
4. **Output Sanitization**: AI responses cleaned before rendering
5. **Nonce Verification**: All AJAX/REST requests verified
6. **Capability Checks**: Admin-level permissions for settings
7. **Audit Logging**: All AI operations logged for review

---

## Risk Assessment

| Risk | Likelihood | Impact | Mitigation |
|------|------------|--------|------------|
| AI API downtime | Medium | High | Fallback providers, graceful degradation |
| Cost overrun (API) | Medium | Medium | Usage limits, cost alerts, caching |
| Security breach | Low | High | Encryption, audits, penetration testing |
| Divi compatibility | Medium | High | Version detection, compatibility layer |
| Poor AI output | Medium | Medium | Output validation, user feedback loop |

---

## Success Metrics

### Key Performance Indicators (KPIs)

1. **Adoption Rate**: Active installations vs downloads
2. **User Engagement**: AI features used per session
3. **Time Savings**: Average page build time reduction
4. **User Satisfaction**: Support tickets, reviews, NPS score
5. **Revenue**: Subscription conversions, renewal rate

### Technical Metrics

1. **API Latency**: P95 response time < 5s
2. **Error Rate**: < 1% failed AI requests
3. **Uptime**: 99.5% availability
4. **Cache Hit Rate**: > 70% for common prompts

---

## Open Questions

### General
1. Should we support Divi Builder plugin standalone (without theme)?
2. What pricing model? (Freemium, subscription, one-time)
3. Should AI-generated layouts be shareable/exportable?
4. Integration with other page builders in the future?
5. White-label/agency version requirements?

### Template Library Specific
6. **Template licensing**: How to handle attribution for divi.express templates?
7. **Partial transformation**: Should users be able to customize only colors OR only fonts?
8. **Gradient handling**: Templates with gradients have multiple color stops - transform all or primary only?
9. **Custom palette saving**: Should users be able to save their own style presets?
10. **Image color matching**: Templates with colored icons/images - replace or keep original?
11. **Divi preset integration**: Sync with Divi's built-in Global Presets system?
12. **Template updates**: How to update templates while preserving user customizations?
13. **Offline support**: Store templates locally or fetch from CDN?

---

## References

- [Divi Developer Portal](https://www.elegantthemes.com/developers/)
- [WordPress REST API Handbook](https://developer.wordpress.org/rest-api/)
- [OpenAI Best Practices](https://platform.openai.com/docs/guides/safety-best-practices)
- [WordPress Security Best Practices](https://developer.wordpress.org/plugins/security/)
