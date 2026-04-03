import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { SelectControl, Button, PanelRow, __experimentalHStack as HStack } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

const TrafficTorchPanel = () => {
    const [selectedTool, setSelectedTool] = useState('seo-intent-tool');

    // Clean single list of all tools (in your preferred order)
    const allTools = [
        { label: '🎯 SEO Intent Tool', slug: 'seo-intent-tool', baseUrl: 'https://traffictorch.net/seo-intent-tool/' },
        { label: '🧬 SEO Entity Extractor Tool', slug: 'seo-entity-extractor-tool', baseUrl: 'https://traffictorch.net/seo-entity-extractor-tool/' },
        { label: '⚜️ Topical Authority Audit Tool', slug: 'topical-authority-audit-tool', baseUrl: 'https://traffictorch.net/topical-authority-audit-tool/' },
        { label: '📝 Keyword Research Tool', slug: 'keyword-research-tool', baseUrl: 'https://traffictorch.net/keyword-research-tool/' },
        { label: '🔍 AI Search Optimization Tool', slug: 'ai-search-optimization-tool', baseUrl: 'https://traffictorch.net/ai-search-optimization-tool/' },
        { label: '📍 Local SEO Tool', slug: 'local-seo-tool', baseUrl: 'https://traffictorch.net/local-seo-tool/' },
        { label: '⚙️ Schema Generator', slug: 'schema-generator', baseUrl: 'https://traffictorch.net/schema-generator/' },
        { label: '🎙️ AI Voice Search Tool', slug: 'ai-voice-search-tool', baseUrl: 'https://traffictorch.net/ai-voice-search-tool/' },
        { label: '🤖 AI Audit Tool', slug: 'ai-audit-tool', baseUrl: 'https://traffictorch.net/ai-audit-tool/' },
        { label: '🛒 Product SEO Tool', slug: 'product-seo-tool', baseUrl: 'https://traffictorch.net/product-seo-tool/' },
        { label: '⚡ Quit Risk Tool', slug: 'quit-risk-tool', baseUrl: 'https://traffictorch.net/quit-risk-tool/' },
        { label: '⚖️ SEO & UX Audit Tool', slug: 'seo-ux-tool', baseUrl: 'https://traffictorch.net/' },
        { label: '🗝️ Keyword Tool', slug: 'keyword-tool', baseUrl: 'https://traffictorch.net/keyword-tool/' },
        { label: '🆚 Keyword VS Tool', slug: 'keyword-vs-tool', baseUrl: 'https://traffictorch.net/keyword-vs-tool/' },
    ];

    const previewUrl = useSelect( ( select ) => {
        const editor = select( 'core/editor' );
        return editor.getEditedPostPreviewLink() || editor.getPermalink();
    }, [] );

    const launchTool = () => {
        const tool = allTools.find( t => t.slug === selectedTool );
        if ( !tool || !previewUrl ) {
            alert( __( 'Please save the post first to generate a preview or live URL.', 'traffictorch' ) );
            return;
        }

        let finalUrl = tool.baseUrl;
        const separator = finalUrl.includes('?') ? '&' : '?';
        finalUrl += `${separator}url=${encodeURIComponent( previewUrl )}`;

        if ( selectedTool === 'seo-ux-tool' ) {
            finalUrl += '#seo-ux-tool';
        }

        const newTab = window.open( finalUrl, '_blank' );
        if ( newTab ) {
            setTimeout( () => { try { newTab.focus(); } catch ( e ) {} }, 800 );
        }
    };

    const openHelpGuides = () => {
        window.open( 'https://traffictorch.net/ai-ux-seo-help-guides/', '_blank' );
    };

    return (
        <PluginDocumentSettingPanel
            name="traffictorch-panel"
            title={ __( '🚥 Traffic Torch AI GEO & SEO Audit Toolkit', 'traffictorch' ) }
            icon="dashicons-chart-bar"
        >
            <PanelRow>
                <SelectControl
                    label={ __( 'Select Tool', 'traffictorch' ) }
                    value={ selectedTool }
                    options={ allTools.map( tool => ({
                        label: tool.label,
                        value: tool.slug,
                    })) }
                    onChange={ setSelectedTool }
                    help="URL will be pre-filled where supported."
                />
            </PanelRow>
            
            { previewUrl && (
                <small style={{ display: 'block', marginTop: '16px', color: '#64748b', fontSize: '13px' }}>
                    URL ready: { previewUrl.substring(0, 65) }...
                </small>
            )}

            {/* Launch Button */}
            <HStack justify="flex-end" style={{ marginTop: '16px' }}>
                <Button
                    variant="primary"
                    onClick={ launchTool }
                    style={{ backgroundColor: '#10b981', color: '#ffffff', fontWeight: '600' }}
                >
                    { __( 'Launch Tool with Preview/Live URL →', 'traffictorch' ) }
                </Button>
            </HStack>

            {/* Help Guides Button - Moved to the bottom */}
            <HStack justify="flex-start" style={{ marginTop: '12px' }}>
                <Button
                    variant="secondary"
                    onClick={ openHelpGuides }
                    style={{ color: '#10b981', borderColor: '#10b981' }}
                >
                    📋 Help Guides
                </Button>
            </HStack>

        </PluginDocumentSettingPanel>
    );
};

registerPlugin( 'traffictorch', {
    render: TrafficTorchPanel,
} );