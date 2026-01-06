/**
 * Progress Bar Component
 *
 * @package DiviAI
 */

import classnames from 'classnames';

export default function ProgressBar({ value = 0, label, className }) {
    const clampedValue = Math.min(100, Math.max(0, value));

    return (
        <div className={classnames('divi-ai-progress', className)}>
            <div className="divi-ai-progress__bar">
                <div
                    className={classnames('divi-ai-progress__fill', {
                        'is-warning': clampedValue >= 70 && clampedValue < 90,
                        'is-danger': clampedValue >= 90,
                    })}
                    style={{ width: `${clampedValue}%` }}
                />
            </div>
            {label && (
                <div className="divi-ai-progress__label">
                    <span>{label}</span>
                    <span>{clampedValue}%</span>
                </div>
            )}
        </div>
    );
}
