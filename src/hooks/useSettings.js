/**
 * Settings Hook
 *
 * @package DiviAI
 */

import { useState, useCallback, useMemo } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

export function useSettings() {
    const initialSettings = window.diviAIAdmin?.settings || {};

    const [settings, setSettings] = useState(initialSettings);
    const [originalSettings, setOriginalSettings] = useState(initialSettings);
    const [isSaving, setIsSaving] = useState(false);

    const isDirty = useMemo(() => {
        return JSON.stringify(settings) !== JSON.stringify(originalSettings);
    }, [settings, originalSettings]);

    const updateSetting = useCallback((key, value) => {
        setSettings((prev) => ({
            ...prev,
            [key]: value,
        }));
    }, []);

    const saveSettings = useCallback(async () => {
        setIsSaving(true);
        try {
            const response = await apiFetch({
                path: '/wp/v2/settings',
                method: 'POST',
                data: {
                    divi_ai_settings: settings,
                },
            });

            setOriginalSettings(settings);
            return { success: true };
        } catch (error) {
            return {
                success: false,
                error: error.message || 'Failed to save settings',
            };
        } finally {
            setIsSaving(false);
        }
    }, [settings]);

    const resetSettings = useCallback(() => {
        setSettings(originalSettings);
    }, [originalSettings]);

    return {
        settings,
        updateSetting,
        saveSettings,
        resetSettings,
        isSaving,
        isDirty,
    };
}
