/**
 * General Settings Tab
 *
 * @package DiviAI
 */

import { __ } from '@wordpress/i18n';
import { ToggleControl, SelectControl } from '@wordpress/components';
import SettingsCard from './SettingsCard';

export default function GeneralTab({ settings, onUpdate }) {
    return (
        <div className="divi-ai-tab-content">
            <SettingsCard
                title={__('General Settings', 'divi-ai-pagebuilder')}
            >
                <ToggleControl
                    label={__('Enable AI Features', 'divi-ai-pagebuilder')}
                    help={__('Enable AI-powered features in Divi Builder', 'divi-ai-pagebuilder')}
                    checked={settings.enable_ai ?? true}
                    onChange={(value) => onUpdate('enable_ai', value)}
                />

                <SelectControl
                    label={__('Default Creation Type', 'divi-ai-pagebuilder')}
                    help={__('The default option when opening the AI Creation Wizard', 'divi-ai-pagebuilder')}
                    value={settings.default_creation ?? 'page'}
                    options={[
                        { label: __('Full Page', 'divi-ai-pagebuilder'), value: 'page' },
                        { label: __('Section', 'divi-ai-pagebuilder'), value: 'section' },
                        { label: __('Site Setup', 'divi-ai-pagebuilder'), value: 'site_setup' },
                    ]}
                    onChange={(value) => onUpdate('default_creation', value)}
                />

                <ToggleControl
                    label={__('Show Welcome Screen', 'divi-ai-pagebuilder')}
                    help={__('Show onboarding tutorial for new users', 'divi-ai-pagebuilder')}
                    checked={settings.show_welcome ?? true}
                    onChange={(value) => onUpdate('show_welcome', value)}
                />
            </SettingsCard>
        </div>
    );
}
