/**
 * Admin Settings App Component
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import SettingsTabs from './components/SettingsTabs';
import GeneralTab from './components/GeneralTab';
import ProvidersTab from './components/ProvidersTab';
import TemplatesTab from './components/TemplatesTab';
import UsageTab from './components/UsageTab';
import AdvancedTab from './components/AdvancedTab';
import Notice from '../components/Notice';
import { useSettings } from '../hooks/useSettings';

const TABS = [
    { id: 'general', label: __('General', 'divi-ai-pagebuilder') },
    { id: 'providers', label: __('AI Providers', 'divi-ai-pagebuilder') },
    { id: 'templates', label: __('Templates', 'divi-ai-pagebuilder') },
    { id: 'usage', label: __('Usage & Limits', 'divi-ai-pagebuilder') },
    { id: 'advanced', label: __('Advanced', 'divi-ai-pagebuilder') },
];

export default function App() {
    const [activeTab, setActiveTab] = useState('general');
    const [notice, setNotice] = useState(null);

    const {
        settings,
        updateSetting,
        saveSettings,
        isSaving,
        isDirty,
    } = useSettings();

    const handleSave = useCallback(async () => {
        const result = await saveSettings();
        if (result.success) {
            setNotice({
                type: 'success',
                message: __('Settings saved successfully.', 'divi-ai-pagebuilder'),
            });
        } else {
            setNotice({
                type: 'error',
                message: result.error || __('Failed to save settings.', 'divi-ai-pagebuilder'),
            });
        }
    }, [saveSettings]);

    const renderTabContent = () => {
        switch (activeTab) {
            case 'general':
                return (
                    <GeneralTab
                        settings={settings}
                        onUpdate={updateSetting}
                    />
                );
            case 'providers':
                return (
                    <ProvidersTab
                        settings={settings}
                        onUpdate={updateSetting}
                        setNotice={setNotice}
                    />
                );
            case 'templates':
                return (
                    <TemplatesTab
                        settings={settings}
                        onUpdate={updateSetting}
                        setNotice={setNotice}
                    />
                );
            case 'usage':
                return (
                    <UsageTab
                        settings={settings}
                        onUpdate={updateSetting}
                    />
                );
            case 'advanced':
                return (
                    <AdvancedTab
                        settings={settings}
                        onUpdate={updateSetting}
                        setNotice={setNotice}
                    />
                );
            default:
                return null;
        }
    };

    return (
        <div className="divi-ai-settings">
            <div className="divi-ai-settings__header">
                <h1>{__('Divi AI Page Builder Settings', 'divi-ai-pagebuilder')}</h1>
            </div>

            {notice && (
                <Notice
                    type={notice.type}
                    message={notice.message}
                    onDismiss={() => setNotice(null)}
                />
            )}

            <SettingsTabs
                tabs={TABS}
                activeTab={activeTab}
                onTabChange={setActiveTab}
            />

            <div className="divi-ai-settings__content">
                {renderTabContent()}
            </div>

            <div className="divi-ai-settings__footer">
                <button
                    type="button"
                    className="button button-primary"
                    onClick={handleSave}
                    disabled={isSaving || !isDirty}
                >
                    {isSaving
                        ? __('Saving...', 'divi-ai-pagebuilder')
                        : __('Save Changes', 'divi-ai-pagebuilder')
                    }
                </button>
            </div>
        </div>
    );
}
