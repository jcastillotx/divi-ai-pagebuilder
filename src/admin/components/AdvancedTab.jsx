/**
 * Advanced Settings Tab
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { ToggleControl, SelectControl, Button } from '@wordpress/components';
import SettingsCard from './SettingsCard';
import { exportSettings, importSettings } from '../../services/api';

export default function AdvancedTab({ settings, onUpdate, setNotice }) {
    const [importing, setImporting] = useState(false);

    const handleExport = useCallback(async () => {
        try {
            const data = await exportSettings();
            const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `divi-ai-settings-${new Date().toISOString().split('T')[0]}.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            setNotice({
                type: 'success',
                message: __('Settings exported successfully.', 'divi-ai-pagebuilder'),
            });
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message,
            });
        }
    }, [setNotice]);

    const handleImport = useCallback(async (event) => {
        const file = event.target.files[0];
        if (!file) return;

        setImporting(true);
        try {
            const text = await file.text();
            const data = JSON.parse(text);
            const result = await importSettings(data);

            if (result.success) {
                setNotice({
                    type: 'success',
                    message: __('Settings imported successfully. Please refresh the page.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: __('Failed to import settings. Invalid file format.', 'divi-ai-pagebuilder'),
            });
        } finally {
            setImporting(false);
            event.target.value = '';
        }
    }, [setNotice]);

    const handleReset = useCallback(() => {
        if (!window.confirm(window.diviAIAdmin?.strings?.confirmReset)) {
            return;
        }
        // Reset logic would go here
    }, []);

    return (
        <div className="divi-ai-tab-content">
            <SettingsCard title={__('Debugging', 'divi-ai-pagebuilder')}>
                <ToggleControl
                    label={__('Debug Mode', 'divi-ai-pagebuilder')}
                    help={__('Enable detailed logging for troubleshooting.', 'divi-ai-pagebuilder')}
                    checked={settings.debug_mode ?? false}
                    onChange={(value) => onUpdate('debug_mode', value)}
                />

                <SelectControl
                    label={__('Log Level', 'divi-ai-pagebuilder')}
                    value={settings.log_level ?? 'warning'}
                    options={[
                        { label: __('Debug', 'divi-ai-pagebuilder'), value: 'debug' },
                        { label: __('Info', 'divi-ai-pagebuilder'), value: 'info' },
                        { label: __('Warning', 'divi-ai-pagebuilder'), value: 'warning' },
                        { label: __('Error', 'divi-ai-pagebuilder'), value: 'error' },
                    ]}
                    onChange={(value) => onUpdate('log_level', value)}
                />
            </SettingsCard>

            <SettingsCard title={__('Data Management', 'divi-ai-pagebuilder')}>
                <ToggleControl
                    label={__('Remove data on uninstall', 'divi-ai-pagebuilder')}
                    help={__('This will delete all history and settings when the plugin is uninstalled.', 'divi-ai-pagebuilder')}
                    checked={settings.cleanup_uninstall ?? false}
                    onChange={(value) => onUpdate('cleanup_uninstall', value)}
                />
            </SettingsCard>

            <SettingsCard title={__('Settings Backup', 'divi-ai-pagebuilder')}>
                <div className="divi-ai-button-group">
                    <Button
                        variant="secondary"
                        onClick={handleExport}
                    >
                        {__('Export Settings', 'divi-ai-pagebuilder')}
                    </Button>

                    <label className="button button-secondary">
                        {importing ? __('Importing...', 'divi-ai-pagebuilder') : __('Import Settings', 'divi-ai-pagebuilder')}
                        <input
                            type="file"
                            accept=".json"
                            onChange={handleImport}
                            disabled={importing}
                            style={{ display: 'none' }}
                        />
                    </label>
                </div>
            </SettingsCard>

            <SettingsCard
                title={__('Danger Zone', 'divi-ai-pagebuilder')}
                className="divi-ai-card--danger"
            >
                <p className="divi-ai-warning">
                    {__('These actions cannot be undone.', 'divi-ai-pagebuilder')}
                </p>

                <div className="divi-ai-button-group">
                    <Button
                        variant="secondary"
                        isDestructive
                        onClick={handleReset}
                    >
                        {__('Reset to Defaults', 'divi-ai-pagebuilder')}
                    </Button>
                </div>
            </SettingsCard>
        </div>
    );
}
