/**
 * Section Wizard Component
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Button, SelectControl, TextareaControl } from '@wordpress/components';

const SECTION_TYPES = [
    { label: __('Hero / Banner', 'divi-ai-pagebuilder'), value: 'hero' },
    { label: __('Features', 'divi-ai-pagebuilder'), value: 'features' },
    { label: __('Services', 'divi-ai-pagebuilder'), value: 'services' },
    { label: __('Testimonials', 'divi-ai-pagebuilder'), value: 'testimonials' },
    { label: __('Pricing', 'divi-ai-pagebuilder'), value: 'pricing' },
    { label: __('Call to Action', 'divi-ai-pagebuilder'), value: 'cta' },
    { label: __('Team', 'divi-ai-pagebuilder'), value: 'team' },
    { label: __('FAQ', 'divi-ai-pagebuilder'), value: 'faq' },
    { label: __('Gallery', 'divi-ai-pagebuilder'), value: 'gallery' },
    { label: __('Contact', 'divi-ai-pagebuilder'), value: 'contact' },
];

const BACKGROUND_TYPES = [
    { label: __('Light', 'divi-ai-pagebuilder'), value: 'light' },
    { label: __('Dark', 'divi-ai-pagebuilder'), value: 'dark' },
    { label: __('Gradient', 'divi-ai-pagebuilder'), value: 'gradient' },
    { label: __('Image', 'divi-ai-pagebuilder'), value: 'image' },
];

export default function SectionWizard({ sessionId, onBack, setNotice }) {
    const [generating, setGenerating] = useState(false);
    const [formData, setFormData] = useState({
        section_type: 'hero',
        background_type: 'light',
        content_description: '',
    });
    const [result, setResult] = useState(null);

    const updateField = useCallback((field, value) => {
        setFormData((prev) => ({ ...prev, [field]: value }));
    }, []);

    const handleGenerate = useCallback(async () => {
        setGenerating(true);
        try {
            const response = await fetch(window.diviAIWizard.restUrl + 'generate/layout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': window.diviAIWizard.restNonce,
                },
                body: JSON.stringify({
                    prompt: `Create a ${formData.section_type} section. ${formData.content_description}`,
                    type: 'section',
                }),
            });

            const data = await response.json();

            if (data.success) {
                setResult(data.layout);
            } else {
                setNotice({
                    type: 'error',
                    message: data.error || __('Generation failed.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message,
            });
        } finally {
            setGenerating(false);
        }
    }, [formData, setNotice]);

    return (
        <div className="divi-ai-wizard__section-wizard">
            <h2>{__('Create a Section', 'divi-ai-pagebuilder')}</h2>

            <div className="divi-ai-wizard__form">
                <SelectControl
                    label={__('Section Type', 'divi-ai-pagebuilder')}
                    value={formData.section_type}
                    options={SECTION_TYPES}
                    onChange={(value) => updateField('section_type', value)}
                />

                <SelectControl
                    label={__('Background', 'divi-ai-pagebuilder')}
                    value={formData.background_type}
                    options={BACKGROUND_TYPES}
                    onChange={(value) => updateField('background_type', value)}
                />

                <TextareaControl
                    label={__('Content Description', 'divi-ai-pagebuilder')}
                    value={formData.content_description}
                    onChange={(value) => updateField('content_description', value)}
                    placeholder={__('Describe what you want in this section...', 'divi-ai-pagebuilder')}
                    rows={4}
                />
            </div>

            {result && (
                <div className="divi-ai-wizard__preview">
                    <h3>{__('Generated Section', 'divi-ai-pagebuilder')}</h3>
                    <div className="divi-ai-wizard__preview-section">
                        <p><strong>{result.sections?.[0]?.headline}</strong></p>
                        <p>{result.sections?.[0]?.subheadline}</p>
                        <p>{result.sections?.[0]?.body}</p>
                    </div>
                </div>
            )}

            <div className="divi-ai-wizard__actions">
                <Button variant="secondary" onClick={onBack}>
                    {__('Back', 'divi-ai-pagebuilder')}
                </Button>

                {!result ? (
                    <Button
                        variant="primary"
                        onClick={handleGenerate}
                        disabled={generating || !formData.content_description}
                    >
                        {generating ? __('Generating...', 'divi-ai-pagebuilder') : __('Generate Section', 'divi-ai-pagebuilder')}
                    </Button>
                ) : (
                    <Button
                        variant="primary"
                        onClick={() => {
                            setNotice({
                                type: 'success',
                                message: __('Section created!', 'divi-ai-pagebuilder'),
                            });
                        }}
                    >
                        {__('Insert Section', 'divi-ai-pagebuilder')}
                    </Button>
                )}
            </div>
        </div>
    );
}
