/**
 * Template Browser Entry Point
 *
 * @package DiviAI
 */

import { createRoot } from '@wordpress/element';
import TemplateBrowser from './TemplateBrowser';
import './styles/template-browser.scss';

// Export for modal usage
export { TemplateBrowser };

// Initialize if root element exists
document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('divi-ai-template-browser-root');

    if (rootElement) {
        const root = createRoot(rootElement);
        root.render(<TemplateBrowser />);
    }
});
