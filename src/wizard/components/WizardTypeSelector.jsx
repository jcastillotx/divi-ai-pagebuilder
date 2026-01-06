/**
 * Wizard Type Selector Component
 *
 * @package DiviAI
 */

import { __ } from '@wordpress/i18n';

const WIZARD_TYPES = [
    {
        id: 'page',
        title: __('Full Page', 'divi-ai-pagebuilder'),
        description: __('Create a complete page layout with multiple sections', 'divi-ai-pagebuilder'),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <rect x="3" y="3" width="18" height="18" rx="2" />
                <line x1="3" y1="9" x2="21" y2="9" />
                <line x1="9" y1="21" x2="9" y2="9" />
            </svg>
        ),
    },
    {
        id: 'section',
        title: __('Section', 'divi-ai-pagebuilder'),
        description: __('Add a single section to an existing page', 'divi-ai-pagebuilder'),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <rect x="3" y="7" width="18" height="10" rx="2" />
            </svg>
        ),
    },
    {
        id: 'site_setup',
        title: __('Site Setup', 'divi-ai-pagebuilder'),
        description: __('Configure header, footer, and global elements', 'divi-ai-pagebuilder'),
        icon: (
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                <circle cx="12" cy="12" r="3" />
                <path d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
            </svg>
        ),
    },
];

export default function WizardTypeSelector({ onSelect }) {
    return (
        <div className="divi-ai-wizard__type-selector">
            <h2>{__('What would you like to create?', 'divi-ai-pagebuilder')}</h2>

            <div className="divi-ai-wizard__types">
                {WIZARD_TYPES.map((type) => (
                    <button
                        key={type.id}
                        type="button"
                        className="divi-ai-wizard__type-card"
                        onClick={() => onSelect(type.id)}
                    >
                        <div className="divi-ai-wizard__type-icon">
                            {type.icon}
                        </div>
                        <h3>{type.title}</h3>
                        <p>{type.description}</p>
                    </button>
                ))}
            </div>
        </div>
    );
}
