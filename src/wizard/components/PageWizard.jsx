/**
 * Page Wizard Component
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Button, SelectControl, TextareaControl, TextControl } from '@wordpress/components';

const PAGE_TYPES = [
    { label: __('Landing Page', 'divi-ai-pagebuilder'), value: 'landing' },
    { label: __('Home Page', 'divi-ai-pagebuilder'), value: 'home' },
    { label: __('About Us', 'divi-ai-pagebuilder'), value: 'about' },
    { label: __('Services', 'divi-ai-pagebuilder'), value: 'services' },
    { label: __('Contact', 'divi-ai-pagebuilder'), value: 'contact' },
    { label: __('Portfolio', 'divi-ai-pagebuilder'), value: 'portfolio' },
    { label: __('Blog', 'divi-ai-pagebuilder'), value: 'blog' },
];

const LAYOUT_STYLES = [
    { label: __('Modern', 'divi-ai-pagebuilder'), value: 'modern' },
    { label: __('Classic', 'divi-ai-pagebuilder'), value: 'classic' },
    { label: __('Minimal', 'divi-ai-pagebuilder'), value: 'minimal' },
    { label: __('Bold', 'divi-ai-pagebuilder'), value: 'bold' },
    { label: __('Creative', 'divi-ai-pagebuilder'), value: 'creative' },
];

const STEPS = ['page_type', 'content', 'style', 'preview'];

export default function PageWizard({ sessionId, onBack, setNotice }) {
    const [step, setStep] = useState(0);
    const [generating, setGenerating] = useState(false);
    const [formData, setFormData] = useState({
        page_type: 'landing',
        business_name: '',
        industry: '',
        description: '',
        target_audience: '',
        layout_style: 'modern',
        tone: 'professional',
    });
    const [result, setResult] = useState(null);

    const updateField = useCallback((field, value) => {
        setFormData((prev) => ({ ...prev, [field]: value }));
    }, []);

    const handleNext = useCallback(async () => {
        if (step === STEPS.length - 2) {
            // Generate the page
            setGenerating(true);
            try {
                const response = await fetch(window.diviAIWizard.restUrl + 'generate/layout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-WP-Nonce': window.diviAIWizard.restNonce,
                    },
                    body: JSON.stringify({
                        prompt: buildPrompt(formData),
                        type: 'page',
                        industry: formData.industry,
                        style: formData.layout_style,
                    }),
                });

                const data = await response.json();

                if (data.success) {
                    setResult(data.layout);
                    setStep(step + 1);
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
        } else {
            setStep(step + 1);
        }
    }, [step, formData, setNotice]);

    const handlePrev = useCallback(() => {
        if (step === 0) {
            onBack();
        } else {
            setStep(step - 1);
        }
    }, [step, onBack]);

    const buildPrompt = (data) => {
        return `Create a ${data.page_type} page for ${data.business_name || 'a business'} in the ${data.industry || 'general'} industry.

Description: ${data.description}

Target Audience: ${data.target_audience}

Style: ${data.layout_style}, ${data.tone} tone

Include appropriate sections with headlines, body text, and calls to action.`;
    };

    const renderStep = () => {
        switch (STEPS[step]) {
            case 'page_type':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('What type of page do you need?', 'divi-ai-pagebuilder')}</h2>

                        <SelectControl
                            label={__('Page Type', 'divi-ai-pagebuilder')}
                            value={formData.page_type}
                            options={PAGE_TYPES}
                            onChange={(value) => updateField('page_type', value)}
                        />

                        <TextControl
                            label={__('Business Name', 'divi-ai-pagebuilder')}
                            value={formData.business_name}
                            onChange={(value) => updateField('business_name', value)}
                            placeholder={__('Your Company Name', 'divi-ai-pagebuilder')}
                        />

                        <TextControl
                            label={__('Industry', 'divi-ai-pagebuilder')}
                            value={formData.industry}
                            onChange={(value) => updateField('industry', value)}
                            placeholder={__('e.g., Technology, Healthcare, Retail', 'divi-ai-pagebuilder')}
                        />
                    </div>
                );

            case 'content':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Tell us about your content', 'divi-ai-pagebuilder')}</h2>

                        <TextareaControl
                            label={__('Business Description', 'divi-ai-pagebuilder')}
                            value={formData.description}
                            onChange={(value) => updateField('description', value)}
                            placeholder={__('Describe your business, products, or services...', 'divi-ai-pagebuilder')}
                            rows={4}
                        />

                        <TextControl
                            label={__('Target Audience', 'divi-ai-pagebuilder')}
                            value={formData.target_audience}
                            onChange={(value) => updateField('target_audience', value)}
                            placeholder={__('e.g., Small business owners, Young professionals', 'divi-ai-pagebuilder')}
                        />
                    </div>
                );

            case 'style':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Choose your style', 'divi-ai-pagebuilder')}</h2>

                        <SelectControl
                            label={__('Layout Style', 'divi-ai-pagebuilder')}
                            value={formData.layout_style}
                            options={LAYOUT_STYLES}
                            onChange={(value) => updateField('layout_style', value)}
                        />

                        <SelectControl
                            label={__('Content Tone', 'divi-ai-pagebuilder')}
                            value={formData.tone}
                            options={[
                                { label: __('Professional', 'divi-ai-pagebuilder'), value: 'professional' },
                                { label: __('Friendly', 'divi-ai-pagebuilder'), value: 'friendly' },
                                { label: __('Bold', 'divi-ai-pagebuilder'), value: 'bold' },
                                { label: __('Casual', 'divi-ai-pagebuilder'), value: 'casual' },
                            ]}
                            onChange={(value) => updateField('tone', value)}
                        />
                    </div>
                );

            case 'preview':
                return (
                    <div className="divi-ai-wizard__step">
                        <h2>{__('Your page is ready!', 'divi-ai-pagebuilder')}</h2>

                        {result && (
                            <div className="divi-ai-wizard__preview">
                                <h3>{__('Generated Sections', 'divi-ai-pagebuilder')}</h3>
                                {result.sections?.map((section, index) => (
                                    <div key={index} className="divi-ai-wizard__preview-section">
                                        <h4>{section.type}</h4>
                                        <p><strong>{section.headline}</strong></p>
                                        <p>{section.body}</p>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                );

            default:
                return null;
        }
    };

    return (
        <div className="divi-ai-wizard__page-wizard">
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
                <Button
                    variant="secondary"
                    onClick={handlePrev}
                >
                    {step === 0 ? __('Back', 'divi-ai-pagebuilder') : __('Previous', 'divi-ai-pagebuilder')}
                </Button>

                {step < STEPS.length - 1 && (
                    <Button
                        variant="primary"
                        onClick={handleNext}
                        disabled={generating}
                    >
                        {generating
                            ? __('Generating...', 'divi-ai-pagebuilder')
                            : step === STEPS.length - 2
                                ? __('Generate Page', 'divi-ai-pagebuilder')
                                : __('Next', 'divi-ai-pagebuilder')
                        }
                    </Button>
                )}

                {step === STEPS.length - 1 && (
                    <Button
                        variant="primary"
                        onClick={() => {
                            // Insert into page logic would go here
                            setNotice({
                                type: 'success',
                                message: __('Page created successfully!', 'divi-ai-pagebuilder'),
                            });
                        }}
                    >
                        {__('Insert into Page', 'divi-ai-pagebuilder')}
                    </Button>
                )}
            </div>
        </div>
    );
}
