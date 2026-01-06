/**
 * API Service
 *
 * @package DiviAI
 */

const getAdminData = () => window.diviAIAdmin || {};

/**
 * Make an AJAX request
 */
async function ajaxRequest(action, data = {}) {
    const { ajaxUrl, nonce } = getAdminData();

    const formData = new FormData();
    formData.append('action', action);
    formData.append('nonce', nonce);

    Object.entries(data).forEach(([key, value]) => {
        formData.append(key, typeof value === 'object' ? JSON.stringify(value) : value);
    });

    const response = await fetch(ajaxUrl, {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
    });

    const result = await response.json();

    if (!result.success) {
        throw new Error(result.data?.message || 'Request failed');
    }

    return result.data;
}

/**
 * Test AI provider connection
 */
export async function testProvider(provider, apiKey) {
    return ajaxRequest('divi_ai_test_provider', { provider, api_key: apiKey });
}

/**
 * Save API key
 */
export async function saveApiKey(provider, apiKey) {
    return ajaxRequest('divi_ai_save_api_key', { provider, api_key: apiKey });
}

/**
 * Clear template cache
 */
export async function clearCache() {
    return ajaxRequest('divi_ai_clear_cache');
}

/**
 * Export settings
 */
export async function exportSettings() {
    return ajaxRequest('divi_ai_export_settings');
}

/**
 * Import settings
 */
export async function importSettings(data) {
    return ajaxRequest('divi_ai_import_settings', { import_data: data });
}

/**
 * Generate content
 */
export async function generateContent(prompt, options = {}) {
    const { restUrl, restNonce } = getAdminData();

    const response = await fetch(`${restUrl}generate/content`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce,
        },
        body: JSON.stringify({ prompt, ...options }),
        credentials: 'same-origin',
    });

    const result = await response.json();

    if (!result.success) {
        throw new Error(result.error || 'Generation failed');
    }

    return result;
}

/**
 * Generate layout
 */
export async function generateLayout(prompt, options = {}) {
    const { restUrl, restNonce } = getAdminData();

    const response = await fetch(`${restUrl}generate/layout`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce,
        },
        body: JSON.stringify({ prompt, ...options }),
        credentials: 'same-origin',
    });

    const result = await response.json();

    if (!result.success) {
        throw new Error(result.error || 'Generation failed');
    }

    return result;
}

/**
 * Get templates
 */
export async function getTemplates(filters = {}) {
    const { restUrl, restNonce } = getAdminData();

    const params = new URLSearchParams(filters);
    const response = await fetch(`${restUrl}templates?${params}`, {
        headers: {
            'X-WP-Nonce': restNonce,
        },
        credentials: 'same-origin',
    });

    return response.json();
}

/**
 * Get single template
 */
export async function getTemplate(id) {
    const { restUrl, restNonce } = getAdminData();

    const response = await fetch(`${restUrl}templates/${id}`, {
        headers: {
            'X-WP-Nonce': restNonce,
        },
        credentials: 'same-origin',
    });

    return response.json();
}

/**
 * Transform template
 */
export async function transformTemplate(id, tokens) {
    const { restUrl, restNonce } = getAdminData();

    const response = await fetch(`${restUrl}templates/${id}/transform`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-WP-Nonce': restNonce,
        },
        body: JSON.stringify({ tokens }),
        credentials: 'same-origin',
    });

    return response.json();
}

/**
 * Get usage statistics
 */
export async function getUsage() {
    const { restUrl, restNonce } = getAdminData();

    const response = await fetch(`${restUrl}usage`, {
        headers: {
            'X-WP-Nonce': restNonce,
        },
        credentials: 'same-origin',
    });

    return response.json();
}
