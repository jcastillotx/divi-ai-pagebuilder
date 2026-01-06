/**
 * Notice Component
 *
 * @package DiviAI
 */

import classnames from 'classnames';

export default function Notice({ type = 'info', message, onDismiss }) {
    return (
        <div
            className={classnames('notice', {
                'notice-success': type === 'success',
                'notice-error': type === 'error',
                'notice-warning': type === 'warning',
                'notice-info': type === 'info',
                'is-dismissible': !!onDismiss,
            })}
        >
            <p>{message}</p>
            {onDismiss && (
                <button
                    type="button"
                    className="notice-dismiss"
                    onClick={onDismiss}
                    aria-label="Dismiss"
                >
                    <span className="screen-reader-text">Dismiss this notice.</span>
                </button>
            )}
        </div>
    );
}
