/**
 * Divi Builder Integration Entry Point
 *
 * @package DiviAI
 */

import './styles/builder.scss';

/**
 * Initialize Divi AI integration with Divi Builder
 */
document.addEventListener('DOMContentLoaded', () => {
    // Check if Divi Builder is available
    if (typeof ETBuilderBackend === 'undefined') {
        return;
    }

    // Add AI button to Divi Builder toolbar
    initToolbarButton();

    // Listen for Divi Builder ready event
    document.addEventListener('et_fb_section_content_change', handleContentChange);
});

/**
 * Initialize the AI toolbar button
 */
function initToolbarButton() {
    // Wait for Divi Builder to fully load
    const checkBuilder = setInterval(() => {
        const toolbar = document.querySelector('.et-fb-page-settings-bar');

        if (toolbar) {
            clearInterval(checkBuilder);
            addAIButton(toolbar);
        }
    }, 1000);

    // Stop checking after 30 seconds
    setTimeout(() => clearInterval(checkBuilder), 30000);
}

/**
 * Add AI button to toolbar
 */
function addAIButton(toolbar) {
    const button = document.createElement('button');
    button.className = 'divi-ai-toolbar-button';
    button.innerHTML = `
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
        </svg>
        <span>AI</span>
    `;
    button.title = 'Divi AI';

    button.addEventListener('click', openAIPanel);

    toolbar.appendChild(button);
}

/**
 * Open the AI panel
 */
function openAIPanel() {
    // Check if panel already exists
    let panel = document.getElementById('divi-ai-builder-panel');

    if (panel) {
        panel.classList.toggle('is-open');
        return;
    }

    // Create panel
    panel = document.createElement('div');
    panel.id = 'divi-ai-builder-panel';
    panel.className = 'divi-ai-builder-panel is-open';
    panel.innerHTML = `
        <div class="divi-ai-builder-panel__header">
            <h3>Divi AI Assistant</h3>
            <button class="divi-ai-builder-panel__close" aria-label="Close">&times;</button>
        </div>
        <div class="divi-ai-builder-panel__content">
            <div class="divi-ai-builder-panel__actions">
                <button class="divi-ai-action" data-action="generate-section">
                    <span class="divi-ai-action__icon">+</span>
                    <span class="divi-ai-action__label">Generate Section</span>
                </button>
                <button class="divi-ai-action" data-action="browse-templates">
                    <span class="divi-ai-action__icon">&#9783;</span>
                    <span class="divi-ai-action__label">Browse Templates</span>
                </button>
                <button class="divi-ai-action" data-action="improve-content">
                    <span class="divi-ai-action__icon">&#9998;</span>
                    <span class="divi-ai-action__label">Improve Content</span>
                </button>
            </div>
            <div class="divi-ai-builder-panel__prompt">
                <textarea placeholder="Describe what you want to create or modify..."></textarea>
                <button class="button button-primary">Generate</button>
            </div>
        </div>
    `;

    document.body.appendChild(panel);

    // Bind events
    panel.querySelector('.divi-ai-builder-panel__close').addEventListener('click', () => {
        panel.classList.remove('is-open');
    });

    panel.querySelectorAll('.divi-ai-action').forEach((btn) => {
        btn.addEventListener('click', (e) => {
            const action = e.currentTarget.dataset.action;
            handleAction(action);
        });
    });
}

/**
 * Handle AI action
 */
function handleAction(action) {
    switch (action) {
        case 'generate-section':
            window.open(window.diviAIAdmin?.wizardUrl || '/wp-admin/admin.php?page=divi-ai-wizard', '_blank');
            break;
        case 'browse-templates':
            openTemplateBrowser();
            break;
        case 'improve-content':
            improveSelectedContent();
            break;
    }
}

/**
 * Open template browser modal
 */
function openTemplateBrowser() {
    // Create modal
    const modal = document.createElement('div');
    modal.id = 'divi-ai-template-modal';
    modal.className = 'divi-ai-modal';
    modal.innerHTML = `
        <div class="divi-ai-modal__backdrop"></div>
        <div class="divi-ai-modal__content">
            <div id="divi-ai-template-browser-root"></div>
        </div>
    `;

    document.body.appendChild(modal);

    // Initialize React component
    import('../template-browser').then(({ TemplateBrowser }) => {
        const { createRoot } = wp.element;
        const rootElement = document.getElementById('divi-ai-template-browser-root');

        if (rootElement) {
            const root = createRoot(rootElement);
            root.render(
                wp.element.createElement(TemplateBrowser, {
                    onSelect: (template) => {
                        insertTemplate(template);
                        closeModal();
                    },
                    onClose: closeModal,
                })
            );
        }
    });

    modal.querySelector('.divi-ai-modal__backdrop').addEventListener('click', closeModal);

    function closeModal() {
        modal.remove();
    }
}

/**
 * Insert template into Divi Builder
 */
function insertTemplate(template) {
    // This would integrate with Divi Builder's API
    console.log('Inserting template:', template);

    // Placeholder: In production, this would use Divi Builder's API
    // to insert the template JSON into the page
}

/**
 * Improve selected content
 */
async function improveSelectedContent() {
    const selectedText = window.getSelection().toString();

    if (!selectedText) {
        alert('Please select some text to improve.');
        return;
    }

    try {
        const response = await fetch(window.diviAIAdmin.restUrl + 'generate/content', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-WP-Nonce': window.diviAIAdmin.restNonce,
            },
            body: JSON.stringify({
                prompt: `Improve this content while maintaining its meaning:\n\n${selectedText}`,
                type: 'general',
            }),
        });

        const result = await response.json();

        if (result.success) {
            // Show result to user
            showImprovedContent(result.content);
        }
    } catch (error) {
        console.error('Failed to improve content:', error);
    }
}

/**
 * Show improved content modal
 */
function showImprovedContent(content) {
    const modal = document.createElement('div');
    modal.className = 'divi-ai-modal';
    modal.innerHTML = `
        <div class="divi-ai-modal__backdrop"></div>
        <div class="divi-ai-modal__content divi-ai-modal__content--small">
            <h3>Improved Content</h3>
            <div class="divi-ai-improved-content">${content}</div>
            <div class="divi-ai-modal__actions">
                <button class="button" data-action="cancel">Cancel</button>
                <button class="button button-primary" data-action="apply">Apply</button>
            </div>
        </div>
    `;

    document.body.appendChild(modal);

    modal.querySelector('[data-action="cancel"]').addEventListener('click', () => modal.remove());
    modal.querySelector('[data-action="apply"]').addEventListener('click', () => {
        // Apply content logic would go here
        modal.remove();
    });
    modal.querySelector('.divi-ai-modal__backdrop').addEventListener('click', () => modal.remove());
}

/**
 * Handle content change in Divi Builder
 */
function handleContentChange(event) {
    // Track content changes for AI suggestions
    console.log('Content changed:', event.detail);
}
