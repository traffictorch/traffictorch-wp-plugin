<?php
/**
 * Plugin Name:       Traffic Torch AI GEO and SEO Tools
 * Plugin URI:        https://traffictorch.net
 * Description:       Adds a clean Traffic Torch AI, GEO & SEO audit toolkit panel in the Gutenberg editor sidebar. One-click launch with automatic preview/live URL pre-fill. 
 * Version:           1.0.0
 * Requires at least: 6.5
 * Tested up to:      6.9
 * Requires PHP:      8.0
 * Author:            Ylia Callan
 * Author URI:        https://traffictorch.net
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       traffic-torch-ai-geo-and-seo-tools
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}



// Plugin activation redirect to intro page
function traffictorch_activate_redirect() {
    if ( get_option( 'traffictorch_just_activated' ) ) {
        delete_option( 'traffictorch_just_activated' );
        wp_safe_redirect( admin_url( 'admin.php?page=traffictorch' ) );
        exit;
    }
}
add_action( 'admin_init', 'traffictorch_activate_redirect' );

function traffictorch_set_activation_flag() {
    add_option( 'traffictorch_just_activated', true );
}
register_activation_hook( __FILE__, 'traffictorch_set_activation_flag' );

// Enqueue the Gutenberg editor panel (latest 2026 best practice)
function traffictorch_enqueue_editor_assets() {
    wp_enqueue_script(
        'traffictorch-editor',
        plugins_url( 'build/index.js', __FILE__ ),
        array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'build/index.js' ),
        true
    );

    wp_localize_script(
        'traffictorch-editor',
        'traffictorchWpData',
        array(
            'baseUrl' => 'https://traffictorch.net',
        )
    );
}
add_action( 'enqueue_block_editor_assets', 'traffictorch_enqueue_editor_assets' );

// Admin menu with working tab links
function traffictorch_admin_menu() {
    // Main menu item (defaults to Welcome)
    add_menu_page(
        'Traffic Torch',
        'Traffic Torch',
        'manage_options',
        'traffictorch',
        'traffictorch_main_page',
        'dashicons-chart-bar',
        80
    );

    // Submenu items - using ?tab= parameter instead of #
    add_submenu_page( 'traffictorch', 'All Tools',          'All Tools',          'manage_options', 'traffictorch&tab=tools',    '__return_null' );
    add_submenu_page( 'traffictorch', 'Help Guides',       'Help Guides',       'manage_options', 'traffictorch&tab=help',     '__return_null' );
    add_submenu_page( 'traffictorch', 'Recommended Plugins', 'Plugins',         'manage_options', 'traffictorch&tab=plugins',  '__return_null' );
    add_submenu_page( 'traffictorch', 'Support',           'Support',           'manage_options', 'traffictorch&tab=support',  '__return_null' );
    add_submenu_page( 'traffictorch', 'Pro Traffic',       'Pro Traffic',       'manage_options', 'traffictorch&tab=pro',      '__return_null' );
}
add_action( 'admin_menu', 'traffictorch_admin_menu' );

// Main tabbed admin page (Welcome + all sections)
function traffictorch_main_page() {
    $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : 'welcome';
    ?>
    <div class="wrap traffictorch-admin-page" style="max-width: 1100px; margin: 20px auto;">

        <h1 style="color: #10b981; display: flex; align-items: center; gap: 12px;">
            🚥 Traffic Torch AI GEO and SEO Tools
        </h1>
        <p style="font-size: 16px; color: #475569; max-width: 800px;">
            Instant 360° SEO, UX & AI analysis for WordPress posts and pages.
        </p>

        <!-- Tab Navigation -->
        <h2 class="nav-tab-wrapper" style="margin-bottom: 30px;">
            <a href="?page=traffictorch&tab=welcome" class="nav-tab <?php echo $active_tab === 'welcome' ? 'nav-tab-active' : ''; ?>">Welcome</a>
            <a href="?page=traffictorch&tab=tools" class="nav-tab <?php echo $active_tab === 'tools' ? 'nav-tab-active' : ''; ?>">All Tools</a>
            <a href="?page=traffictorch&tab=help" class="nav-tab <?php echo $active_tab === 'help' ? 'nav-tab-active' : ''; ?>">Help Guides</a>
            <a href="?page=traffictorch&tab=plugins" class="nav-tab <?php echo $active_tab === 'plugins' ? 'nav-tab-active' : ''; ?>">Recommended Plugins</a>
            <a href="?page=traffictorch&tab=pro" class="nav-tab <?php echo $active_tab === 'pro' ? 'nav-tab-active' : ''; ?>">Pro Traffic</a>
            <a href="?page=traffictorch&tab=support" class="nav-tab <?php echo $active_tab === 'support' ? 'nav-tab-active' : ''; ?>">Support</a>
        </h2>

        <?php if ( $active_tab === 'welcome' ) : ?>
            <!-- Welcome Tab -->
            <div style="background: #f8fafc; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0;">
                <h2 style="color: #1e2937;">Welcome to Traffic Torch AI GEO and SEO Audit Toolkit</h2>
                <p style="font-size: 16px; color: #475569; line-height: 1.7; max-width: 800px;">
                    This plugin brings the power of Traffic Torch directly into your WordPress workflow.
                    Many of our tools recommend trusted Wordpress plugins to improve SEO for failed metrics in just a few clicks. 
                    Get instant access to AI, GEO, and SEO tools, plus helpful educational resources.
                </p>
                <div style="margin: 30px 0; padding: 20px; background: #fff; border-radius: 10px; border: 1px solid #e2e8f0;">
                    <h3 style="color: #1e2937; margin-top: 0;">How to Use the Plugin</h3>
                    <ul style="color: #475569; line-height: 1.8;">
                        <li><strong>In the Editor:</strong> While editing any Post or Page, look for the <strong>“🚥 Traffic Torch AI GEO & SEO Audit Toolkit”</strong> panel in the right sidebar. Select a tool and click Launch and it will automatically use the current preview or live URL. Click the <strong>📋 Help Guides</strong> button in the widget for practical tutorials and deep-dive explanations.</li>
                    </ul>
                </div>
                <h3 style="color: #1e2937;">What’s Inside the Traffic Torch Plugin</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px;">
                    <div style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong>🧰 All Tools</strong><br>
                        <span style="color: #64748b; font-size: 14px;">Educational overviews of SEO, AI, UX & Keyword tools in today’s 2026 search landscape.</span>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong>📋 Help Guides</strong><br>
                        <span style="color: #64748b; font-size: 14px;">Practical tutorials covering topical authority, semantic entities, voice search, schema, quit risk, AI detection, and more.</span>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong>🌐 Recommended Plugins</strong><br>
                        <span style="color: #64748b; font-size: 14px;">Curated lightweight plugins that close common gaps identified by Traffic Torch.</span>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong>🚥 Pro Traffic</strong><br>
                        <span style="color: #64748b; font-size: 14px;">25 audits/day, advanced modules, AI fixes, predictive insights & priority support.</span>
                    </div>
                    <div style="background: #fff; padding: 20px; border-radius: 10px; border: 1px solid #e2e8f0;">
                        <strong>💬 Support</strong><br>
                        <span style="color: #64748b; font-size: 14px;">GitHub for bugs & feature requests + direct contact.</span>
                    </div>
                </div>
                <p style="margin-top: 30px; color: #475569;">
                    All analysis happens in your browser and secure Cloudflare proxy.
                </p>
            </div>
            <?php endif; ?>
            
<?php if ( $active_tab === 'tools' ) : ?>
    <!-- Tools Tab - Educational + Cards -->

    <div id="tools-page">

        <!-- ====================== SEO TOOLS ====================== -->
        <h2 style="color: #1e2937; margin-bottom: 12px;">SEO Tools</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 28px;">
            In 2026, modern SEO has moved far beyond traditional keyword matching. Search engines and AI systems now heavily reward deep topical authority, semantic entity understanding, precise alignment with searcher intent, strong local and geo signals, and properly implemented structured data. 
            Building comprehensive topic clusters with clear E-E-A-T signals has become essential for visibility across Google, Bing, Perplexity, and emerging AI overviews. Traffic Torch SEO tools analyse these critical layers and deliver actionable insights you can apply directly while editing posts and pages in WordPress.
            Traffic Torch SEO tools analyse these elements and deliver clear insights you can apply directly in the WordPress editor and admin dashboard.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">⚜️ Topical Authority Tool</h3>
                <p style="color: #475569; margin: 0;">Detects main topics, subtopics, content gaps and suggests intelligent expansions to build stronger topical authority.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🧬 SEO Entity Tool</h3>
                <p style="color: #475569; margin: 0;">Extracts semantic entities, runs audits and provides targeted fixes to improve relevance and E-E-A-T signals.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🎯 SEO Intent Tool</h3>
                <p style="color: #475569; margin: 0;">Matches content to searcher intent and audits E-E-A-T alignment with practical improvement suggestions.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">📍 Local SEO Tool</h3>
                <p style="color: #475569; margin: 0;">Audits on-page local signals including NAP consistency, schema and map optimization opportunities.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🛒 Product SEO Tool</h3>
                <p style="color: #475569; margin: 0;">Reviews product pages for eCommerce-specific signals and optimization opportunities.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">⚙️ Schema Generator Tool</h3>
                <p style="color: #475569; margin: 0;">Detects opportunities and generates clean JSON-LD markup for 18+ schema types.</p>
            </div>
        </div>

        <p style="margin: 10px 0 50px;">
            <a href="https://traffictorch.net/ai-seo-ux-tools/" target="_blank" style="color: #10b981; text-decoration: underline; font-weight: 500;">
                Explore all SEO Tools on Traffic Torch →
            </a>
        </p>

        <!-- ====================== AI TOOLS ====================== -->
        <h2 style="color: #1e2937; margin-bottom: 12px;">AI Tools</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 28px;">
            AI-powered search engines (Perplexity, Grok, Gemini, ChatGPT Search) and voice assistants are fundamentally reshaping how people discover and consume information. 
            Traditional blue-link results are increasingly supplemented or replaced by AI-generated answers and conversational interfaces. 
            These tools help you optimize content for Generative Engine Optimization (GEO), improve citation chances in AI overviews, enhance voice search readiness, and ensure your material remains natural, human-first, and trustworthy across both traditional and AI-driven discovery channels.
            </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🔍 GEO Audit Tool</h3>
                <p style="color: #475569; margin: 0;">Optimizes content for AI search engines including Perplexity, Grok, Gemini and ChatGPT Search.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🤖 AI Content Tool</h3>
                <p style="color: #475569; margin: 0;">Detects AI-generated patterns and provides guidance to humanise content while maintaining quality.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🎙️ AI Voice Search Tool</h3>
                <p style="color: #475569; margin: 0;">Performs 360° audits optimized specifically for voice search and conversational queries.</p>
            </div>
        </div>

        <p style="margin: 10px 0 50px;">
            <a href="https://traffictorch.net/ai-seo-ux-tools/#ai-tools" target="_blank" style="color: #10b981; text-decoration: underline; font-weight: 500;">
                Explore all AI Tools on Traffic Torch →
            </a>
        </p>

        <!-- ====================== UX TOOLS ====================== -->
        <h2 style="color: #1e2937; margin-bottom: 12px;">UX Tools</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 28px;">
            User experience signals, including bounce rate, dwell time, scroll depth, interaction quality, and quit risk, have become direct ranking factors in the current landscape. 
            Search engines increasingly interpret strong engagement metrics as proof of helpful, well-designed content that satisfies real user needs. 
            Poor UX not only hurts conversions but also sends negative behavioural signals that can limit visibility. Traffic Torch UX tools quickly identify friction points and provide practical fixes to reduce quit risk, improve dwell time, and create experiences that keep visitors engaged longer.
            These tools quickly identify friction points and suggest practical on-page optimizations.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">⚡ Quit Risk Tool</h3>
                <p style="color: #475569; margin: 0;">Identifies UX friction points and predicts bounce risk with actionable optimization recommendations.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">⚖️ SEO UX Tool</h3>
                <p style="color: #475569; margin: 0;">Combines quick SEO health checks with user experience analysis for a true 360° view.</p>
            </div>
        </div>

        <p style="margin: 10px 0 50px;">
            <a href="https://traffictorch.net/ai-seo-ux-tools/#ux-tools" target="_blank" style="color: #10b981; text-decoration: underline; font-weight: 500;">
                Explore all UX Tools on Traffic Torch →
            </a>
        </p>

        <!-- ====================== KEYWORD TOOLS ====================== -->
        <h2 style="color: #1e2937; margin-bottom: 12px;">Keyword Tools</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 28px;">
            In today’s landscape, effective keyword strategy has evolved well beyond raw search volume. Search engines now prioritise intelligent placement, competitive gap analysis, and tight alignment with actual searcher intent and micro-intents. 
            Topical depth and semantic relevance often outweigh traditional volume metrics. These tools help you research high-opportunity terms, optimize natural placement across titles, headings, content, images, and schema, and uncover strategic advantages your competitors may be missing, all while supporting broader topical authority goals.
            These tools help you research smarter, optimize placement, and uncover opportunities your competitors miss.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">📝 Keyword Research Tool</h3>
                <p style="color: #475569; margin: 0;">High-impact keyword research and intelligent generator focused on opportunity and intent.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🗝️ Keyword Placement Tool</h3>
                <p style="color: #475569; margin: 0;">Audits on-page keyword placement and suggests density and positioning improvements.</p>
            </div>
            <div style="background: #fff; padding: 22px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 10px 0; color: #1e2937;">🆚 Keyword VS Tool</h3>
                <p style="color: #475569; margin: 0;">Competitive keyword gap analysis with clear strategies to outperform competitors.</p>
            </div>
        </div>

        <p style="margin: 10px 0 50px;">
            <a href="https://traffictorch.net/ai-seo-ux-tools/" target="_blank" style="color: #10b981; text-decoration: underline; font-weight: 500;">
                Explore all Keyword Tools on Traffic Torch →
            </a>
        </p>

    </div>
    <?php endif; ?>

<?php if ( $active_tab === 'help' ) : ?>
    <!-- Help Guides Tab - Educational Cards -->
    <div id="help-guides-page">

        <h2 style="color: #1e2937; margin-bottom: 8px;">AI, UX & SEO Help Guides</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 40px;">
            Practical, up-to-date tutorials that go beyond basic advice. Each guide delivers deep-dive diagnostics, high-impact fixes, instant 360° health scoring, and modern search insights. 
            If you're optimizing for Google, AI engines, voice search, or local pack results. These resources help you understand exactly what matters and how to improve fast.
        </p>

        <!-- Help Guides Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 22px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">📚 Topical Authority Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Complete guide to topical authority: what it is, how search engines & AI apps test it, why subtopic depth beats keywords, and how we audit gaps to help you build stronger authority across Google, Bing & Perplexity.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🧬 Semantic Entity Optimization Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">How to boost modern SEO, local/geo visibility, and answer engine results. Discover how Traffic Torch’s Entity Extractor audits your page across six key semantic layers and the highest-ROI optimizations you can apply today.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🎙️ AI Voice Search Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Complete guide to optimizing for voice search: conversational keywords, featured snippets, schema markup and AI assistant ranking strategies. Plus the 5 critical modules Traffic Torch uses to evaluate voice search readiness.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">⚙️ Schema Markup Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Complete help guide to schema markup: Organization, Article/BlogPosting, LocalBusiness, FAQPage, HowTo, Review, JobPosting, Course & more. Learn what each type is, when to use it, and why it boosts rich results, CTR & traffic.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">📊 The Ultimate SEO & UX Audit Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Get a complete breakdown of how Traffic Torch delivers your instant 360° SEO + UX health score. Explore each of the 8 core modules and why they matter in 2026.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">⚡ User Experience Help Guide: Slash Quit Risk</h3>
                <p style="color: #475569; line-height: 1.6;">Learn what each module measures, how the Quit Risk Tool calculates scores, why it matters for modern SEO + UX, and the fastest fixes that keep visitors longer.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">📍 Local SEO Mastery Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Discover how search engines rank local listings. Covers NAP consistency, local keywords, schema, maps & more, perfect for local businesses.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🎯 Mastering SEO Intent Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">How search engines measures search intent alignment, E-E-A-T signals, content depth, readability and schema, with highest-impact fixes for better rankings.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🛒 Product SEO Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Complete guide to boosting rankings and sales on ecommerce pages. Learn what each module measures and the fastest fixes that turn product pages into traffic magnets.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🔑 SEO Keyword Optimization Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Strategic keyword placement in titles, headings, content, images, anchors and URLs. Understand what each factor means and how to improve rankings.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🤖 Ultimate AI Search Optimization Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">Jump into how AI engines analyze pages across 8 critical metrics to improve visibility in AI-generated overviews and tools like Google’s Search Generative Experience.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🔍 How to Detect AI-Generated Content Help Guide</h3>
                <p style="color: #475569; line-height: 1.6;">The 5 key metrics Traffic Torch uses (Perplexity, Burstiness, Repetition, Sentence Length & Vocabulary) and how to improve your human score.</p>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🏆 Ultimate Guide to Beating Competitors in On-Page SEO 2026</h3>
                <p style="color: #475569; line-height: 1.6;">Deep dive into Traffic Torch Keyword VS Tool scoring logic, testing methods, and practical fixes to outperform competitors across all on-page signals.</p>
            </div>

        </div>

        <p style="margin-top: 50px; text-align: center;">
            <a href="https://traffictorch.net/ai-ux-seo-help-guides/" target="_blank" style="color: #10b981; text-decoration: underline; font-weight: 600; font-size: 16px;">
                Read All Help Guides on Traffic Torch →
            </a>
        </p>

    </div>
    <?php endif; ?>

        <?php if ( $active_tab === 'plugins' ) : ?>
            <!-- Recommended Plugins Tab -->
            <div id="plugins-page">

                <h2 style="color: #1e2937; margin-bottom: 8px;">Traffic Torch Recommended Plugins</h2>
                <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 30px;">
                    These highly-rated plugins complement Traffic Torch audits by closing common gaps in on-page SEO, performance, local signals, accessibility, and technical health. 
                    They help turn audit insights into real improvements without adding bloat. Perfect for achieving stronger 360° SEO results.
                </p>

                <!-- Quick Links Menu - 2 Columns -->
                <h3 style="color: #1e2937; margin-bottom: 16px;">Quick Links Menu</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px; margin-bottom: 40px;">

                    <a href="#seo-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        🔍 SEO Plugins
                    </a>
                    <a href="#performance-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        ⚡ Performance
                    </a>
                    <a href="#local-seo-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        📍 Local SEO
                    </a>
                    <a href="#accessibility-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        ♿ Accessibility
                    </a>
                    <a href="#image-optimization" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        🖼️ Image Optimization
                    </a>
                    <a href="#video-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        🎥 Video Plugins
                    </a>
                    <a href="#pwa-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        📱 Progressive Web Apps
                    </a>
                    <a href="#author-freshness" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        👤 Author & Freshness
                    </a>
                    <a href="#product-seo-plugins" style="display: block; padding: 14px 18px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; text-decoration: none; color: #1e2937; font-weight: 500;">
                        🛒 Product SEO
                    </a>

                </div>

        <!-- SEO Plugins -->
        <h3 id="seo-plugins" style="color: #1e2937; margin: 40px 0 16px;">SEO Plugins</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🔍 Yoast SEO</h4>
                <p style="color: #475569; line-height: 1.6;">Real-time title/meta editor, keyword placement guidance, SERP preview, and readability analysis. Helps balance keywords with natural language for better CTR.</p>
                <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📊 Rank Math</h4>
                <p style="color: #475569; line-height: 1.6;">Advanced title optimisation, multiple focus keywords, bulk editing, and dynamic variables. Strong for large sites and accurate previews.</p>
                <a href="https://wordpress.org/plugins/seo-by-rank-math/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📈 All in One SEO (AIOSEO)</h4>
                <p style="color: #475569; line-height: 1.6;">TruSEO scoring, smart patterns, unlimited keywords, and automatic recommendations. Excellent for beginners and WooCommerce users.</p>
                <a href="https://wordpress.org/plugins/all-in-one-seo-pack/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">⚡ SEOPress</h4>
                <p style="color: #475569; line-height: 1.6;">Lightweight with strong local/NAP schema support and clean JSON-LD output. Great for developers wanting control without bloat.</p>
                <a href="https://wordpress.org/plugins/wp-seopress/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🔒 Really Simple SSL</h4>
                <p style="color: #475569; line-height: 1.6;">Forces HTTPS, fixes mixed content automatically, and includes HSTS preload support. Essential for security and SEO signals.</p>
                <a href="https://wordpress.org/plugins/really-simple-ssl/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
        </div>

        <!-- Performance Plugins -->
        <h3 id="performance-plugins" style="color: #1e2937; margin: 40px 0 16px;">Performance Plugins</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">⚡ Autoptimize</h4>
                <p style="color: #475569; line-height: 1.6;">Minifies HTML/CSS/JS, combines files, and defers non-critical resources. Excellent first step for improving Core Web Vitals and overall page speed.</p>
                <a href="https://wordpress.org/plugins/autoptimize/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🚀 Perfmatters</h4>
                <p style="color: #475569; line-height: 1.6;">Removes unnecessary scripts, emojis, and bloat. Highly effective for cleaning up bloated themes and improving load times.</p>
                <a href="https://wordpress.org/plugins/perfmatters/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🧹 Asset CleanUp</h4>
                <p style="color: #475569; line-height: 1.6;">Disable unused CSS/JS per page or post. Dramatically reduces bloat on complex or theme-heavy sites.</p>
                <a href="https://wordpress.org/plugins/wp-asset-clean-up/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🔤 OMGF (Host Google Fonts Locally)</h4>
                <p style="color: #475569; line-height: 1.6;">Hosts Google Fonts locally with proper preload and font-display: swap. Eliminates external font requests and prevents FOUT.</p>
                <a href="https://wordpress.org/plugins/host-webfonts-local/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>

        <!-- Local SEO Plugins -->
        <h3 id="local-seo-plugins" style="color: #1e2937; margin: 40px 0 16px;">Local SEO Plugins</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🗺️ WP Go Maps</h4>
                <p style="color: #475569; line-height: 1.6;">Easy Google Maps embedding with markers, directions, and custom visuals. Strengthens local visual signals and user trust — important for local pack rankings.</p>
                <a href="https://wordpress.org/plugins/wp-google-maps/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🗺️ MapPress Maps</h4>
                <p style="color: #475569; line-height: 1.6;">Lightweight Google & Leaflet maps with pins, categories, and styling options. Simple way to add location visuals that support local SEO signals.</p>
                <a href="https://wordpress.org/plugins/mappress-google-maps-for-wordpress/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📍 GeoDirectory</h4>
                <p style="color: #475569; line-height: 1.6;">Full-featured location directory with maps, listings, and advanced local schema. Ideal for directory-style local SEO or multi-location businesses.</p>
                <a href="https://wordpress.org/plugins/geodirectory/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🗺️ Maps Widget for Google Maps</h4>
                <p style="color: #475569; line-height: 1.6;">Quick thumbnail maps with markers for sidebars, footers, or widgets. Easy way to boost local visual trust signals across your site.</p>
                <a href="https://wordpress.org/plugins/maps-widget-for-google-maps/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>

        <!-- Accessibility Plugins -->
        <h3 id="accessibility-plugins" style="color: #1e2937; margin: 40px 0 16px;">Accessibility Plugins</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">♿ WP Accessibility</h4>
                <p style="color: #475569; line-height: 1.6;">Automatically adds missing form labels, improves contrast checking, and adds proper landmark roles. Fixes many common accessibility issues that impact both users and SEO signals.</p>
                <a href="https://wordpress.org/plugins/wp-accessibility/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">♿ One Click Accessibility</h4>
                <p style="color: #475569; line-height: 1.6;">Adds skip-to-content link, removes title attributes, improves keyboard navigation, and includes basic contrast checks. Lightweight and effective for quick accessibility wins.</p>
                <a href="https://wordpress.org/plugins/one-click-accessibility/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">♿ Accessibility Widget</h4>
                <p style="color: #475569; line-height: 1.6;">Provides a floating accessibility toolbar with font size adjustment, contrast modes, and dyslexia-friendly options. Improves user experience for visitors with disabilities.</p>
                <a href="https://wordpress.org/plugins/accessibility-widget/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>

        <!-- Image Optimization -->
        <h3 id="image-optimization" style="color: #1e2937; margin: 40px 0 16px;">Image Optimization</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🖼️ Smush</h4>
                <p style="color: #475569; line-height: 1.6;">Bulk image compression, lazy loading, and intelligent alt text suggestions. One of the most popular solutions for improving Core Web Vitals and overall page speed.</p>
                <a href="https://wordpress.org/plugins/wp-smushit/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📸 EWWW Image Optimizer</h4>
                <p style="color: #475569; line-height: 1.6;">Server-side optimisation with WebP conversion, bulk processing, and excellent quality control. Great for sites with many legacy images.</p>
                <a href="https://wordpress.org/plugins/ewww-image-optimizer/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🖼️ Imagify</h4>
                <p style="color: #475569; line-height: 1.6;">Smart AI-driven compression with automatic WebP/AVIF conversion and alt text suggestions. Clean interface and strong integration with the media library.</p>
                <a href="https://wordpress.org/plugins/imagify-image-optimizer/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>

        <!-- Progressive Web Apps -->
        <h3 id="pwa-plugins" style="color: #1e2937; margin: 40px 0 16px;">Progressive Web Apps (PWA)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📱 PWA for WP</h4>
                <p style="color: #475569; line-height: 1.6;">Complete PWA setup with advanced caching and offline fallback pages.</p>
                <a href="https://wordpress.org/plugins/pwa-for-wp/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📱 Super Progressive Web Apps</h4>
                <p style="color: #475569; line-height: 1.6;">Adds manifest.json, theme colours, and installable app features with splash screen support.</p>
                <a href="https://wordpress.org/plugins/super-progressive-web-apps/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
        </div>

        <!-- Author & Freshness Signals -->
        <h3 id="author-freshness" style="color: #1e2937; margin: 40px 0 16px;">Author & Freshness Signals</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">👤 PublishPress Authors</h4>
                <p style="color: #475569; line-height: 1.6;">Adds bylines, co-authors, guest authors, and rich author boxes with social links and bios. Strongly improves E-E-A-T signals that Traffic Torch audits for topical authority and trust.</p>
                <a href="https://wordpress.org/plugins/publishpress-authors/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">👤 Simple Author Box</h4>
                <p style="color: #475569; line-height: 1.6;">Lightweight and responsive author/guest author box with gravatar, bio, and social icons. Easy way to display visible bylines and boost E-E-A-T signals.</p>
                <a href="https://wordpress.org/plugins/simple-author-box/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📅 Post Updated Date</h4>
                <p style="color: #475569; line-height: 1.6;">Displays the last modified date on posts and pages. Helps signal content freshness to search engines and readers — a key factor in modern ranking algorithms.</p>
                <a href="https://wordpress.org/plugins/post-updated-date/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">📅 Display Last Modified Date</h4>
                <p style="color: #475569; line-height: 1.6;">Clean display of last updated timestamp with flexible placement options. Reinforces content freshness signals that Traffic Torch evaluates in its audits.</p>
                <a href="https://wordpress.org/plugins/display-last-modified-date/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>
        
                <!-- Video Plugins -->
        <h3 id="video-plugins" style="color: #1e2937; margin: 40px 0 16px;">Video Plugins</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">
        
          <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">▶️ WP YouTube Lyte</h4>
                <p style="color: #475569; line-height: 1.6;">Lightweight YouTube embedding with lazy loading and privacy mode. Greatly improves page speed and Core Web Vitals while reducing third-party tracking.</p>
                <a href="https://wordpress.org/plugins/wp-youtube-lyte/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🎥 EmbedPress</h4>
                <p style="color: #475569; line-height: 1.6;">Advanced video embedding with caption support, lazy loading, and schema markup for YouTube, Vimeo, and more. Improves video SEO and accessibility signals.</p>
                <a href="https://wordpress.org/plugins/embedpress/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🎞️ Video Embed & Thumbnail Generator</h4>
                <p style="color: #475569; line-height: 1.6;">Generates thumbnails and lazy loading for self-hosted and embedded videos. Helps with Core Web Vitals and better video user experience.</p>
                <a href="https://wordpress.org/plugins/video-embed-thumbnail-generator/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">⏳ Lazy Load – Optimize Images & Videos</h4>
                <p style="color: #475569; line-height: 1.6;">Enables lazy loading for both images and videos. Reduces initial page weight and improves performance scores in Traffic Torch audits.</p>
                <a href="https://wordpress.org/plugins/rocket-lazy-load/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>

        </div>
        
                <!-- Product SEO -->
        <h3 id="product-seo-plugins" style="color: #1e2937; margin: 40px 0 16px;">Product SEO Plugins (WooCommerce)</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 22px; margin-bottom: 50px;">
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🛒 WooCommerce</h4>
                <p style="color: #475569; line-height: 1.6;">Core plugin for variant management, structured data, and product page optimisation. Essential foundation for ecommerce SEO signals.</p>
                <a href="https://wordpress.org/plugins/woocommerce/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
            <div style="background: #fff; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h4 style="margin: 0 0 10px 0; color: #1e2937;">🎨 Variation Swatches for WooCommerce</h4>
                <p style="color: #475569; line-height: 1.6;">Turns dropdowns into visual selectors (colors, sizes). Improves UX and conversion signals on product pages.</p>
                <a href="https://wordpress.org/plugins/variation-swatches-for-woocommerce/" target="_blank" style="color: #10b981; text-decoration: underline;">View on WordPress.org →</a>
            </div>
        </div>

    </div>
    <?php endif; ?>

<?php if ( $active_tab === 'pro' ) : ?>
    <!-- Pro Traffic Tab - Educational & Benefit-Focused -->
    <div id="pro-page">

        <h2 style="color: #1e2937; margin-bottom: 12px;">Pro Traffic</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 30px;">
            The free version of Traffic Torch gives you instant access to powerful AI, GEO and SEO tools with generous daily limits suitable for occasional use. 
            <strong>Traffic Torch Pro</strong> is designed for serious users, freelancers, agencies, content teams and local businesses who need higher volume and deeper insights to scale their GEO, SEO and UX efforts efficiently.
        </p>

        <div style="background: #f8fafc; padding: 28px; border-radius: 12px; border: 1px solid #e2e8f0; margin-bottom: 40px;">
            <h3 style="color: #1e2937; margin-top: 0;">What Pro Unlocks</h3>
            <ul style="color: #475569; line-height: 1.7; padding-left: 20px;">
                <li><strong>25 Full 360° AI-Powered Audits Per Day</strong>, No more 24-hour waits after hitting free limits (resets at midnight UTC).</li>
                <li>Access to all advanced modules including Local SEO, SEO Intent (E-E-A-T), Product SEO, Quit Risk Tool, Keyword Competition, AI Search Optimiser and AI Content Detector.</li>
                <li>Competitive gap analysis with side-by-side comparisons against top-ranking pages and clear outranking strategies.</li>
                <li>Predictive insights: estimated ranking improvements, bounce rate forecasts and traffic potential.</li>
                <li>In-depth educational breakdowns for every score. “Why it matters”, “How to improve”, common mistakes and linked help guides.</li>
                <li>Priority support with faster response times.</li>
            </ul>
            <p style="margin: 20px 0 0; font-size: 15px; color: #334155;">
                <strong>Pricing:</strong> USD $48 per year (less than 15 cents per day).
            </p>
        </div>

        <p style="color: #475569; line-height: 1.65; max-width: 860px; margin-bottom: 30px;">
            Pro is ideal if you regularly audit multiple pages, competitors, or client sites. All analysis remains 100% client-side in your browser. No data is stored or sent to any servers.
        </p>

        <div style="text-align: center; margin: 40px 0;">
            <a href="https://traffictorch.net/pro/" 
               target="_blank" 
               class="button button-primary" 
               style="background:#10b981; border:none; padding: 14px 32px; font-size: 17px; text-decoration: none;">
                Upgrade to Pro – $48/year →
            </a>
        </div>

        <p style="text-align: center; color: #64748b; font-size: 14px;">
            Secure payment via Stripe • Cancel anytime 
        </p>

    </div>
    <?php endif; ?>

<?php if ( $active_tab === 'support' ) : ?>
    <!-- Support Tab - Helpful & Professional -->
    <div id="support-page">

        <h2 style="color: #1e2937; margin-bottom: 12px;">Support & Feedback</h2>
        <p style="color: #475569; line-height: 1.65; max-width: 820px; margin-bottom: 30px;">
            We’re here to help you get the most out of Traffic Torch. Whether you have questions about the editor panel, the tools, installation, or want to suggest improvements, feel free to reach out.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px;">

            <!-- GitHub Card -->
            <div style="background: #fff; padding: 26px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">🐙 GitHub Repository</h3>
                <p style="color: #475569; line-height: 1.6;">
                    Report bugs, request new features, or view the source code. 
                    The repository is public and we welcome community contributions and feedback.
                </p>
                <p style="margin-top: 16px;">
                    <a href="https://github.com/traffictorch/traffictorch-wp-plugin" 
                       target="_blank" 
                       style="color: #10b981; text-decoration: underline; font-weight: 500;">
                        Visit GitHub Repository →
                    </a>
                </p>
            </div>

            <!-- Contact Card -->
            <div style="background: #fff; padding: 26px; border-radius: 10px; border: 1px solid #e2e8f0;">
                <h3 style="margin: 0 0 12px 0; color: #1e2937;">📬 Contact Traffic Torch</h3>
                <p style="color: #475569; line-height: 1.6;">
                    For general questions, support requests, or partnership inquiries, reach out directly through the official contact form. 
                    We aim to respond within 48 hours during weekdays.
                </p>
                <p style="margin-top: 16px;">
                    <a href="https://traffictorch.net/contact/" 
                       target="_blank" 
                       style="color: #10b981; text-decoration: underline; font-weight: 500;">
                        Go to Contact Page →
                    </a>
                </p>
            </div>

        </div>

        <div style="background: #f8fafc; padding: 24px; border-radius: 10px; border: 1px solid #e2e8f0;">
            <h3 style="color: #1e2937; margin-top: 0;">Quick Tips</h3>
            <ul style="color: #475569; line-height: 1.7;">
                <li>Always save your post/page draft first so the editor panel can grab the correct preview URL.</li>
                <li>The plugin works best in the Block Editor (Gutenberg). Classic Editor is not supported.</li>
                <li>All tool analysis happens in your browser via a secure Cloudflare proxy, no data is stored from your WordPress site.</li>
                <li>Found a bug or have a feature idea? Open an issue on GitHub, it helps everyone.</li>
            </ul>
        </div>

    </div>
<?php endif; ?>
    </div>

    <style>
        .traffictorch-admin-page .nav-tab-wrapper { border-bottom: 1px solid #e2e8f0; }
        .traffictorch-admin-page .nav-tab { font-size: 15px; padding: 12px 20px; }
        @media (prefers-color-scheme: dark) {
            .traffictorch-admin-page { color: #e2e8f0; }
            .traffictorch-admin-page h2, h3 { color: #cbd5e1; }
        }
    </style>
    <?php
}
