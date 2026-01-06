/**
 * AI Creation Wizard Entry Point
 *
 * @package DiviAI
 */

import { createRoot } from '@wordpress/element';
import WizardApp from './WizardApp';
import './styles/wizard.scss';

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', () => {
    const rootElement = document.getElementById('divi-ai-wizard-root');

    if (rootElement) {
        const root = createRoot(rootElement);
        root.render(<WizardApp />);
    }
});
