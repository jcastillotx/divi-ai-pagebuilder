/**
 * Customizer Entry Point
 *
 * @package DiviAI
 */

import './styles/customizer.scss';

// Customizer live preview handling
document.addEventListener('DOMContentLoaded', () => {
    if (typeof wp === 'undefined' || !wp.customize) {
        return;
    }

    const colorSettings = [
        'divi_ai_color_primary',
        'divi_ai_color_secondary',
        'divi_ai_color_accent',
        'divi_ai_color_text_primary',
        'divi_ai_color_text_secondary',
        'divi_ai_color_text_light',
        'divi_ai_color_bg_primary',
        'divi_ai_color_bg_secondary',
        'divi_ai_color_bg_dark',
    ];

    const fontSettings = [
        'divi_ai_font_heading',
        'divi_ai_font_body',
        'divi_ai_font_accent',
    ];

    // Bind color settings
    colorSettings.forEach((setting) => {
        wp.customize(setting, (value) => {
            value.bind((newValue) => {
                const varName = `--divi-ai-${setting.replace('divi_ai_color_', '').replace(/_/g, '-')}`;
                document.documentElement.style.setProperty(varName, newValue);
            });
        });
    });

    // Bind font settings
    fontSettings.forEach((setting) => {
        wp.customize(setting, (value) => {
            value.bind((newValue) => {
                const varName = `--divi-ai-${setting.replace('divi_ai_font_', 'font-')}`;
                document.documentElement.style.setProperty(varName, newValue);

                // Load Google Font
                loadGoogleFont(newValue);
            });
        });
    });
});

/**
 * Load a Google Font dynamically
 */
function loadGoogleFont(fontName) {
    const fontId = `google-font-${fontName.toLowerCase().replace(/\s+/g, '-')}`;

    if (document.getElementById(fontId)) {
        return;
    }

    const link = document.createElement('link');
    link.id = fontId;
    link.rel = 'stylesheet';
    link.href = `https://fonts.googleapis.com/css2?family=${encodeURIComponent(fontName)}:wght@400;500;600;700&display=swap`;

    document.head.appendChild(link);
}
