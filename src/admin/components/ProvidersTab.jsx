/**
 * AI Providers Settings Tab
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { SelectControl, Button, Spinner } from '@wordpress/components';
import SettingsCard from './SettingsCard';
import { testProvider, saveApiKey } from '../../services/api';

export default function ProvidersTab({ settings, onUpdate, setNotice }) {
    const [testing, setTesting] = useState(null);
    const [apiKeys, setApiKeys] = useState({
        openai: '',
        anthropic: '',
    });

    const providers = window.diviAIAdmin?.providers || {};

    const handleTest = useCallback(async (provider) => {
        setTesting(provider);
        try {
            const result = await testProvider(provider, apiKeys[provider]);
            if (result.success) {
                setNotice({
                    type: 'success',
                    message: __('Connection successful!', 'divi-ai-pagebuilder'),
                });
            } else {
                setNotice({
                    type: 'error',
                    message: result.message || __('Connection failed.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message || __('Connection failed.', 'divi-ai-pagebuilder'),
            });
        } finally {
            setTesting(null);
        }
    }, [apiKeys, setNotice]);

    const handleSaveKey = useCallback(async (provider) => {
        try {
            const result = await saveApiKey(provider, apiKeys[provider]);
            if (result.success) {
                setNotice({
                    type: 'success',
                    message: __('API key saved.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message,
            });
        }
    }, [apiKeys, setNotice]);

    return (
        <div className="divi-ai-tab-content">
            <SettingsCard
                title={__('OpenAI', 'divi-ai-pagebuilder')}
                actions={
                    <Button
                        variant="secondary"
                        onClick={() => handleTest('openai')}
                        disabled={testing === 'openai' || !apiKeys.openai}
                    >
                        {testing === 'openai' ? <Spinner /> : __('Test', 'divi-ai-pagebuilder')}
                    </Button>
                }
            >
                <div className="divi-ai-field">
                    <label htmlFor="openai-key">{__('API Key', 'divi-ai-pagebuilder')}</label>
                    <div className="divi-ai-field__input-group">
                        <input
                            id="openai-key"
                            type="password"
                            value={apiKeys.openai}
                            onChange={(e) => setApiKeys({ ...apiKeys, openai: e.target.value })}
                            placeholder="sk-..."
                            className="regular-text"
                        />
                        <Button
                            variant="secondary"
                            onClick={() => handleSaveKey('openai')}
                            disabled={!apiKeys.openai}
                        >
                            {__('Save Key', 'divi-ai-pagebuilder')}
                        </Button>
                    </div>
                    <p className="description">
                        {__('Your API key is encrypted and stored securely.', 'divi-ai-pagebuilder')}
                    </p>
                </div>

                <SelectControl
                    label={__('Model', 'divi-ai-pagebuilder')}
                    value={settings.openai_model ?? 'gpt-4-turbo'}
                    options={Object.entries(providers.openai?.models || {}).map(([value, label]) => ({
                        value,
                        label,
                    }))}
                    onChange={(value) => onUpdate('openai_model', value)}
                />
            </SettingsCard>

            <SettingsCard
                title={__('Anthropic', 'divi-ai-pagebuilder')}
                actions={
                    <Button
                        variant="secondary"
                        onClick={() => handleTest('anthropic')}
                        disabled={testing === 'anthropic' || !apiKeys.anthropic}
                    >
                        {testing === 'anthropic' ? <Spinner /> : __('Test', 'divi-ai-pagebuilder')}
                    </Button>
                }
            >
                <div className="divi-ai-field">
                    <label htmlFor="anthropic-key">{__('API Key', 'divi-ai-pagebuilder')}</label>
                    <div className="divi-ai-field__input-group">
                        <input
                            id="anthropic-key"
                            type="password"
                            value={apiKeys.anthropic}
                            onChange={(e) => setApiKeys({ ...apiKeys, anthropic: e.target.value })}
                            placeholder="sk-ant-..."
                            className="regular-text"
                        />
                        <Button
                            variant="secondary"
                            onClick={() => handleSaveKey('anthropic')}
                            disabled={!apiKeys.anthropic}
                        >
                            {__('Save Key', 'divi-ai-pagebuilder')}
                        </Button>
                    </div>
                    <p className="description">
                        {__('Your API key is encrypted and stored securely.', 'divi-ai-pagebuilder')}
                    </p>
                </div>

                <SelectControl
                    label={__('Model', 'divi-ai-pagebuilder')}
                    value={settings.anthropic_model ?? 'claude-3-sonnet-20240229'}
                    options={Object.entries(providers.anthropic?.models || {}).map(([value, label]) => ({
                        value,
                        label,
                    }))}
                    onChange={(value) => onUpdate('anthropic_model', value)}
                />
            </SettingsCard>

            <SettingsCard title={__('Provider Settings', 'divi-ai-pagebuilder')}>
                <SelectControl
                    label={__('Default Provider', 'divi-ai-pagebuilder')}
                    value={settings.default_provider ?? 'openai'}
                    options={[
                        { label: 'OpenAI', value: 'openai' },
                        { label: 'Anthropic', value: 'anthropic' },
                    ]}
                    onChange={(value) => onUpdate('default_provider', value)}
                />

                <SelectControl
                    label={__('Fallback Provider', 'divi-ai-pagebuilder')}
                    help={__('Used if the default provider fails.', 'divi-ai-pagebuilder')}
                    value={settings.fallback_provider ?? ''}
                    options={[
                        { label: __('None', 'divi-ai-pagebuilder'), value: '' },
                        { label: 'OpenAI', value: 'openai' },
                        { label: 'Anthropic', value: 'anthropic' },
                    ]}
                    onChange={(value) => onUpdate('fallback_provider', value)}
                />
            </SettingsCard>
        </div>
    );
}
