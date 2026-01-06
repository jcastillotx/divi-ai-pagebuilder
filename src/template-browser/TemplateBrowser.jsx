/**
 * Template Browser Component
 *
 * @package DiviAI
 */

import { useState, useEffect, useCallback } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import { Spinner, Button } from '@wordpress/components';
import { getTemplates, transformTemplate } from '../services/api';

export default function TemplateBrowser({ onSelect, onClose }) {
    const [templates, setTemplates] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedTemplate, setSelectedTemplate] = useState(null);
    const [category, setCategory] = useState('');
    const [search, setSearch] = useState('');
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);

    const categories = [
        { label: __('All Templates', 'divi-ai-pagebuilder'), value: '' },
        { label: __('Full Pages', 'divi-ai-pagebuilder'), value: 'full-pages' },
        { label: __('Hero Sections', 'divi-ai-pagebuilder'), value: 'sections/hero' },
        { label: __('Features', 'divi-ai-pagebuilder'), value: 'sections/features' },
        { label: __('Testimonials', 'divi-ai-pagebuilder'), value: 'sections/testimonials' },
        { label: __('Pricing', 'divi-ai-pagebuilder'), value: 'sections/pricing' },
        { label: __('CTA', 'divi-ai-pagebuilder'), value: 'sections/cta' },
        { label: __('Headers', 'divi-ai-pagebuilder'), value: 'headers' },
        { label: __('Footers', 'divi-ai-pagebuilder'), value: 'footers' },
    ];

    const loadTemplates = useCallback(async () => {
        setLoading(true);
        try {
            const result = await getTemplates({ category, search, page, per_page: 12 });
            setTemplates(result.templates || []);
            setTotalPages(result.total_pages || 1);
        } catch (error) {
            console.error('Failed to load templates:', error);
        } finally {
            setLoading(false);
        }
    }, [category, search, page]);

    useEffect(() => {
        loadTemplates();
    }, [loadTemplates]);

    const handleSearch = useCallback((e) => {
        e.preventDefault();
        setPage(1);
        loadTemplates();
    }, [loadTemplates]);

    const handleInsert = useCallback(async () => {
        if (!selectedTemplate) return;

        try {
            const tokens = window.diviAIWizard?.userTokens || {};
            const transformed = await transformTemplate(selectedTemplate.template_id, tokens);

            if (onSelect) {
                onSelect(transformed);
            }
        } catch (error) {
            console.error('Failed to transform template:', error);
        }
    }, [selectedTemplate, onSelect]);

    return (
        <div className="divi-ai-template-browser">
            <div className="divi-ai-template-browser__header">
                <h2>{__('Template Library', 'divi-ai-pagebuilder')}</h2>
                {onClose && (
                    <Button
                        className="divi-ai-template-browser__close"
                        onClick={onClose}
                        icon="no-alt"
                    />
                )}
            </div>

            <div className="divi-ai-template-browser__body">
                <aside className="divi-ai-template-browser__sidebar">
                    <h3>{__('Categories', 'divi-ai-pagebuilder')}</h3>
                    <ul className="divi-ai-template-browser__categories">
                        {categories.map((cat) => (
                            <li key={cat.value}>
                                <button
                                    type="button"
                                    className={category === cat.value ? 'is-active' : ''}
                                    onClick={() => {
                                        setCategory(cat.value);
                                        setPage(1);
                                    }}
                                >
                                    {cat.label}
                                </button>
                            </li>
                        ))}
                    </ul>

                    <div className="divi-ai-template-browser__search">
                        <form onSubmit={handleSearch}>
                            <input
                                type="text"
                                placeholder={__('Search templates...', 'divi-ai-pagebuilder')}
                                value={search}
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <Button type="submit" variant="secondary">
                                {__('Search', 'divi-ai-pagebuilder')}
                            </Button>
                        </form>
                    </div>
                </aside>

                <main className="divi-ai-template-browser__main">
                    {loading ? (
                        <div className="divi-ai-template-browser__loading">
                            <Spinner />
                        </div>
                    ) : templates.length === 0 ? (
                        <div className="divi-ai-template-browser__empty">
                            <p>{__('No templates found.', 'divi-ai-pagebuilder')}</p>
                        </div>
                    ) : (
                        <>
                            <div className="divi-ai-template-browser__grid">
                                {templates.map((template) => (
                                    <button
                                        key={template.template_id}
                                        type="button"
                                        className={`divi-ai-template-browser__card ${selectedTemplate?.template_id === template.template_id ? 'is-selected' : ''}`}
                                        onClick={() => setSelectedTemplate(template)}
                                    >
                                        <div className="divi-ai-template-browser__preview">
                                            {template.preview_url ? (
                                                <img src={template.preview_url} alt={template.name} />
                                            ) : (
                                                <div className="divi-ai-template-browser__placeholder" />
                                            )}
                                        </div>
                                        <div className="divi-ai-template-browser__info">
                                            <h4>{template.name}</h4>
                                            <span>{template.category}</span>
                                        </div>
                                    </button>
                                ))}
                            </div>

                            {totalPages > 1 && (
                                <div className="divi-ai-template-browser__pagination">
                                    <Button
                                        variant="secondary"
                                        disabled={page <= 1}
                                        onClick={() => setPage(page - 1)}
                                    >
                                        {__('Previous', 'divi-ai-pagebuilder')}
                                    </Button>
                                    <span>{page} / {totalPages}</span>
                                    <Button
                                        variant="secondary"
                                        disabled={page >= totalPages}
                                        onClick={() => setPage(page + 1)}
                                    >
                                        {__('Next', 'divi-ai-pagebuilder')}
                                    </Button>
                                </div>
                            )}
                        </>
                    )}
                </main>
            </div>

            <div className="divi-ai-template-browser__footer">
                {selectedTemplate && (
                    <div className="divi-ai-template-browser__selected">
                        <strong>{__('Selected:', 'divi-ai-pagebuilder')}</strong> {selectedTemplate.name}
                    </div>
                )}
                <Button
                    variant="primary"
                    disabled={!selectedTemplate}
                    onClick={handleInsert}
                >
                    {__('Insert Template', 'divi-ai-pagebuilder')}
                </Button>
            </div>
        </div>
    );
}
