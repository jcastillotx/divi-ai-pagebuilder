/**
 * Settings Tabs Component
 *
 * @package DiviAI
 */

import classnames from 'classnames';

export default function SettingsTabs({ tabs, activeTab, onTabChange }) {
    return (
        <nav className="divi-ai-settings__tabs">
            {tabs.map((tab) => (
                <button
                    key={tab.id}
                    type="button"
                    className={classnames('divi-ai-settings__tab', {
                        'is-active': activeTab === tab.id,
                    })}
                    onClick={() => onTabChange(tab.id)}
                    aria-selected={activeTab === tab.id}
                    role="tab"
                >
                    {tab.label}
                </button>
            ))}
        </nav>
    );
}
