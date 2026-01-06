/**
 * AI Creation Wizard App
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import WizardTypeSelector from './components/WizardTypeSelector';
import PageWizard from './components/PageWizard';
import SectionWizard from './components/SectionWizard';
import SiteSetupWizard from './components/SiteSetupWizard';
import Notice from '../components/Notice';

export default function WizardApp() {
    const [wizardType, setWizardType] = useState(null);
    const [sessionId, setSessionId] = useState(null);
    const [notice, setNotice] = useState(null);

    const handleTypeSelect = useCallback(async (type) => {
        // Start wizard session
        try {
            const response = await fetch(window.diviAIWizard.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'divi_ai_wizard_start',
                    nonce: window.diviAIWizard.nonce,
                    type,
                }),
            });

            const result = await response.json();

            if (result.success) {
                setSessionId(result.data.session_id);
                setWizardType(type);
            } else {
                setNotice({
                    type: 'error',
                    message: result.data?.message || __('Failed to start wizard.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message,
            });
        }
    }, []);

    const handleBack = useCallback(() => {
        setWizardType(null);
        setSessionId(null);
    }, []);

    const renderWizard = () => {
        switch (wizardType) {
            case 'page':
                return (
                    <PageWizard
                        sessionId={sessionId}
                        onBack={handleBack}
                        setNotice={setNotice}
                    />
                );
            case 'section':
                return (
                    <SectionWizard
                        sessionId={sessionId}
                        onBack={handleBack}
                        setNotice={setNotice}
                    />
                );
            case 'site_setup':
                return (
                    <SiteSetupWizard
                        sessionId={sessionId}
                        onBack={handleBack}
                        setNotice={setNotice}
                    />
                );
            default:
                return null;
        }
    };

    return (
        <div className="divi-ai-wizard">
            <div className="divi-ai-wizard__header">
                <h1>{__('Divi AI Creation Wizard', 'divi-ai-pagebuilder')}</h1>
                <p className="divi-ai-wizard__subtitle">
                    {__('Create stunning designs powered by AI', 'divi-ai-pagebuilder')}
                </p>
            </div>

            {notice && (
                <Notice
                    type={notice.type}
                    message={notice.message}
                    onDismiss={() => setNotice(null)}
                />
            )}

            <div className="divi-ai-wizard__content">
                {!wizardType ? (
                    <WizardTypeSelector onSelect={handleTypeSelect} />
                ) : (
                    renderWizard()
                )}
            </div>
        </div>
    );
}
