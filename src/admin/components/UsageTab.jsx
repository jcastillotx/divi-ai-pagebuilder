/**
 * Usage & Limits Settings Tab
 *
 * @package DiviAI
 */

import { __ } from '@wordpress/i18n';
import { SelectControl } from '@wordpress/components';
import SettingsCard from './SettingsCard';
import ProgressBar from '../../components/ProgressBar';

export default function UsageTab({ settings, onUpdate }) {
    const usage = window.diviAIAdmin?.usage || {};
    const rateLimit = settings.rate_limit ?? 100;
    const tokenBudget = settings.token_budget ?? 1000000;

    const requestsPercent = rateLimit > 0
        ? Math.round((usage.requests_count || 0) / rateLimit * 100)
        : 0;

    const tokensPercent = tokenBudget > 0
        ? Math.round((usage.tokens_used || 0) / tokenBudget * 100)
        : 0;

    const formatTokens = (tokens) => {
        if (tokens >= 1000000) {
            return (tokens / 1000000).toFixed(1) + 'M';
        }
        if (tokens >= 1000) {
            return (tokens / 1000).toFixed(0) + 'K';
        }
        return tokens.toString();
    };

    return (
        <div className="divi-ai-tab-content">
            <SettingsCard title={__('Current Usage (This Month)', 'divi-ai-pagebuilder')}>
                <div className="divi-ai-usage-stats">
                    <div className="divi-ai-usage-stat">
                        <h4>{__('API Requests', 'divi-ai-pagebuilder')}</h4>
                        <ProgressBar
                            value={requestsPercent}
                            label={`${usage.requests_count || 0} / ${formatTokens(rateLimit)} requests`}
                        />
                    </div>

                    <div className="divi-ai-usage-stat">
                        <h4>{__('Tokens Used', 'divi-ai-pagebuilder')}</h4>
                        <ProgressBar
                            value={tokensPercent}
                            label={`${formatTokens(usage.tokens_used || 0)} / ${formatTokens(tokenBudget)} tokens`}
                        />
                    </div>
                </div>
            </SettingsCard>

            <SettingsCard title={__('Rate Limiting', 'divi-ai-pagebuilder')}>
                <div className="divi-ai-field-row">
                    <div className="divi-ai-field">
                        <label htmlFor="rate-limit">
                            {__('Requests per period', 'divi-ai-pagebuilder')}
                        </label>
                        <input
                            id="rate-limit"
                            type="number"
                            min="0"
                            value={settings.rate_limit ?? 100}
                            onChange={(e) => onUpdate('rate_limit', parseInt(e.target.value, 10))}
                            className="small-text"
                        />
                    </div>

                    <SelectControl
                        label={__('Period', 'divi-ai-pagebuilder')}
                        value={settings.rate_period ?? 'hour'}
                        options={[
                            { label: __('Hour', 'divi-ai-pagebuilder'), value: 'hour' },
                            { label: __('Day', 'divi-ai-pagebuilder'), value: 'day' },
                            { label: __('Month', 'divi-ai-pagebuilder'), value: 'month' },
                        ]}
                        onChange={(value) => onUpdate('rate_period', value)}
                    />
                </div>

                <div className="divi-ai-field">
                    <label htmlFor="token-budget">
                        {__('Monthly token budget', 'divi-ai-pagebuilder')}
                    </label>
                    <input
                        id="token-budget"
                        type="number"
                        min="0"
                        step="10000"
                        value={settings.token_budget ?? 1000000}
                        onChange={(e) => onUpdate('token_budget', parseInt(e.target.value, 10))}
                        className="regular-text"
                    />
                    <p className="description">
                        {__('Set to 0 for unlimited.', 'divi-ai-pagebuilder')}
                    </p>
                </div>
            </SettingsCard>

            <SettingsCard title={__('Alerts', 'divi-ai-pagebuilder')}>
                <div className="divi-ai-field">
                    <label htmlFor="alert-threshold">
                        {__('Alert at usage threshold (%)', 'divi-ai-pagebuilder')}
                    </label>
                    <input
                        id="alert-threshold"
                        type="number"
                        min="0"
                        max="100"
                        value={settings.alert_threshold ?? 80}
                        onChange={(e) => onUpdate('alert_threshold', parseInt(e.target.value, 10))}
                        className="small-text"
                    />
                    <p className="description">
                        {__('Send alert when usage reaches this percentage.', 'divi-ai-pagebuilder')}
                    </p>
                </div>

                <div className="divi-ai-field">
                    <label htmlFor="alert-email">
                        {__('Alert email', 'divi-ai-pagebuilder')}
                    </label>
                    <input
                        id="alert-email"
                        type="email"
                        value={settings.alert_email ?? ''}
                        onChange={(e) => onUpdate('alert_email', e.target.value)}
                        className="regular-text"
                    />
                </div>
            </SettingsCard>
        </div>
    );
}
