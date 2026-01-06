/**
 * Templates Settings Tab
 *
 * @package DiviAI
 */

import { useState, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { CheckboxControl, Button, Spinner } from '@wordpress/components';
import SettingsCard from './SettingsCard';
import { clearCache } from '../../services/api';

export default function TemplatesTab({ settings, onUpdate, setNotice }) {
    const [clearing, setClearing] = useState(false);

    const handleClearCache = useCallback(async () => {
        if (!window.confirm(window.diviAIAdmin?.strings?.confirmClear)) {
            return;
        }

        setClearing(true);
        try {
            const result = await clearCache();
            if (result.success) {
                setNotice({
                    type: 'success',
                    message: __('Cache cleared successfully.', 'divi-ai-pagebuilder'),
                });
            }
        } catch (error) {
            setNotice({
                type: 'error',
                message: error.message,
            });
        } finally {
            setClearing(false);
        }
    }, [setNotice]);

    const categories = {
        full_pages: __('Full Page Layouts (500+ templates)', 'divi-ai-pagebuilder'),
        sections: __('Section Templates (800+ templates)', 'divi-ai-pagebuilder'),
        headers: __('Header Templates (200+ templates)', 'divi-ai-pagebuilder'),
        footers: __('Footer Templates (200+ templates)', 'divi-ai-pagebuilder'),
        error_pages: __('404 Page Templates (100+ templates)', 'divi-ai-pagebuilder'),
        coming_soon: __('Coming Soon Pages (50 templates)', 'divi-ai-pagebuilder'),
    };

    return (
        <div className="divi-ai-tab-content">
            <SettingsCard title={__('Template Categories', 'divi-ai-pagebuilder')}>
                {Object.entries(categories).map(([key, label]) => (
                    <CheckboxControl
                        key={key}
                        label={label}
                        checked={settings.template_categories?.[key] ?? true}
                        onChange={(value) => {
                            const newCategories = {
                                ...settings.template_categories,
                                [key]: value,
                            };
                            onUpdate('template_categories', newCategories);
                        }}
                    />
                ))}
            </SettingsCard>

            <SettingsCard title={__('Cache Settings', 'divi-ai-pagebuilder')}>
                <div className="divi-ai-field">
                    <label htmlFor="cache-duration">
                        {__('Cache Duration (hours)', 'divi-ai-pagebuilder')}
                    </label>
                    <input
                        id="cache-duration"
                        type="number"
                        min="1"
                        max="168"
                        value={settings.cache_duration ?? 24}
                        onChange={(e) => onUpdate('cache_duration', parseInt(e.target.value, 10))}
                        className="small-text"
                    />
                    <p className="description">
                        {__('Transformed templates are cached for this duration.', 'divi-ai-pagebuilder')}
                    </p>
                </div>

                <div className="divi-ai-field">
                    <Button
                        variant="secondary"
                        onClick={handleClearCache}
                        disabled={clearing}
                    >
                        {clearing ? <Spinner /> : __('Clear Cache', 'divi-ai-pagebuilder')}
                    </Button>
                </div>
            </SettingsCard>
        </div>
    );
}
