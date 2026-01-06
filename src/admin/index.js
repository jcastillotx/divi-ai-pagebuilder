/**
 * Admin Settings Page Entry Point
 *
 * @package DiviAI
 */

import { createRoot } from '@wordpress/element';
import App from './App';
import './styles/admin.scss';

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('divi-ai-settings-root');

    if (rootElement) {
        const root = createRoot(rootElement);
        root.render(<App />);
    }
});
