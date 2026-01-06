/**
 * Settings Card Component
 *
 * @package DiviAI
 */

import classnames from 'classnames';

export default function SettingsCard({ title, children, actions, className }) {
    return (
        <div className={classnames('divi-ai-card', className)}>
            <div className="divi-ai-card__header">
                <h3 className="divi-ai-card__title">{title}</h3>
                {actions && (
                    <div className="divi-ai-card__actions">{actions}</div>
                )}
            </div>
            <div className="divi-ai-card__content">
                {children}
            </div>
        </div>
    );
}
