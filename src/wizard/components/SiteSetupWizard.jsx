/**
 * Site Setup Wizard Component
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Button, CheckboxControl } from '@wordpress/components';

const STEPS = ['header', 'footer', 'pages', 'complete'];

export default function SiteSetupWizard({ sessionId, onBack, setNotice }) {
    const [step, setStep] = useState(0);
    const [formData, setFormData] = useState({
        header_template: null,
        footer_template: null,
        create_pages: {
            home: true,
            about: true,
            services: true,
            contact: true,
            blog: false,
        },
    });

    const handleNext = useCallback(() => {
        setStep(step + 1);
    }, [step]);

    const handlePrev = useCallback(() => {
        if (step === 0) {
            onBack();
        } else {
            setStep(step - 1);
        }
    }, [step, onBack]);

    const renderStep = () => {
        switch (STEPS[step]) {
            case 'header':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Choose a Header Template', 'divi-ai-pagebuilder')}</h2>
                        <div className="divi-ai-wizard__template-grid">
                            {['standard', 'centered', 'transparent'].map((type) => (
                                <button
                                    key={type}
                                    type="button"
                                    className={`divi-ai-wizard__template-card ${formData.header_template === type ? 'is-selected' : ''}`}
                                    onClick={() => setFormData({ ...formData, header_template: type })}
                                >
                                    <div className="divi-ai-wizard__template-preview">
                                        {/* Placeholder for preview */}
                                    </div>
                                    <span>{type.charAt(0).toUpperCase() + type.slice(1)}</span>
                                </button>
                            ))}
                        </div>
                    </div>
                );

            case 'footer':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Choose a Footer Template', 'divi-ai-pagebuilder')}</h2>
                        <div className="divi-ai-wizard__template-grid">
                            {['simple', 'mega', 'minimal'].map((type) => (
                                <button
                                    key={type}
                                    type="button"
                                    className={`divi-ai-wizard__template-card ${formData.footer_template === type ? 'is-selected' : ''}`}
                                    onClick={() => setFormData({ ...formData, footer_template: type })}
                                >
                                    <div className="divi-ai-wizard__template-preview">
                                        {/* Placeholder for preview */}
                                    </div>
                                    <span>{type.charAt(0).toUpperCase() + type.slice(1)}</span>
                                </button>
                            ))}
                        </div>
                    </div>
                );

            case 'pages':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Create Essential Pages', 'divi-ai-pagebuilder')}</h2>
                        <p>{__('Select which pages to create for your site:', 'divi-ai-pagebuilder')}</p>

                        <div className="divi-ai-wizard__page-list">
                            {Object.entries(formData.create_pages).map(([page, checked]) => (
                                <CheckboxControl
                                    key={page}
                                    label={page.charAt(0).toUpperCase() + page.slice(1) + ' Page'}
                                    checked={checked}
                                    onChange={(value) => setFormData({
                                        ...formData,
                                        create_pages: {
                                            ...formData.create_pages,
                                            [page]: value,
                                        },
                                    })}
                                />
                            ))}
                        </div>
                    </div>
                );

            case 'complete':
                return (
                    <div className="divi-ai-wizard__step divi-ai-wizard__complete">
                        <h2>{__('Site Setup Complete!', 'divi-ai-pagebuilder')}</h2>
                        <p>{__('Your site structure has been configured.', 'divi-ai-pagebuilder')}</p>

                        <div className="divi-ai-wizard__summary">
                            <h3>{__('Summary', 'divi-ai-pagebuilder')}</h3>
                            <ul>
                                <li>
                                    <strong>{__('Header:', 'divi-ai-pagebuilder')}</strong>{' '}
                                    {formData.header_template || __('None selected', 'divi-ai-pagebuilder')}
                                </li>
                                <li>
                                    <strong>{__('Footer:', 'divi-ai-pagebuilder')}</strong>{' '}
                                    {formData.footer_template || __('None selected', 'divi-ai-pagebuilder')}
                                </li>
                                <li>
                                    <strong>{__('Pages:', 'divi-ai-pagebuilder')}</strong>{' '}
                                    {Object.entries(formData.create_pages)
                                        .filter(([, v]) => v)
                                        .map(([k]) => k.charAt(0).toUpperCase() + k.slice(1))
                                        .join(', ') || __('None', 'divi-ai-pagebuilder')
                                    }
                                </li>
                            </ul>
                        </div>
                    </div>
                );

            default:
                return null;
        }
    };

    return (
        <div className="divi-ai-wizard__site-setup">
            <div className="divi-ai-wizard__progress">
                {STEPS.map((s, i) => (
                    <div
                        key={s}
                        className={`divi-ai-wizard__progress-step ${i <= step ? 'is-active' : ''} ${i < step ? 'is-complete' : ''}`}
                    />
                ))}
            </div>

            {renderStep()}

            <div className="divi-ai-wizard__actions">
                <Button variant="secondary" onClick={handlePrev}>
                    {step === 0 ? __('Back', 'divi-ai-pagebuilder') : __('Previous', 'divi-ai-pagebuilder')}
                </Button>

                {step < STEPS.length - 1 ? (
                    <Button variant="primary" onClick={handleNext}>
                        {__('Next', 'divi-ai-pagebuilder')}
                    </Button>
                ) : (
                    <Button
                        variant="primary"
                        onClick={() => {
                            setNotice({
                                type: 'success',
                                message: __('Site setup completed!', 'divi-ai-pagebuilder'),
                            });
                        }}
                    >
                        {__('Finish Setup', 'divi-ai-pagebuilder')}
                    </Button>
                )}
            </div>
        </div>
    );
}
