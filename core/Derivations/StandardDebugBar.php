<?php
namespace Apricot\Derivations;

use DebugBar\DataCollector\DataCollectorInterface;

/**
 * StandardDebugBar - Inclusion of \DebugBar\StandardDebugBar Class
 */
Class StandardDebugBar
{
    /**
     * DebugBar
     * @var \DebugBar\StandardDebugBar
     */
    protected $debugBar;

    /**
     * JavascriptRenderer
     * @var \DebugBar\JavascriptRenderer
     */
    protected $renderer;

    /**
     * Whether to create assets to be automatically rendered
     * @var boolean
     */
    protected $autoAssets;

    /**
     * Directory of automatically generated resources
     * @var string
     */
    protected $autoAssetsDir;

    /**
     * Automatically generated resource base directory
     */
    protected const ASSET_BASE = 'var/debugbar';

    /**
     * Name of automatically generated css
     */
    protected const ASSET_CSS = 'debugbar.css';

    /**
     * Name of automatically generated js
     */
    protected const ASSET_JS = 'debugbar.js';

    /**
     * Name of automatically generated vendor directory
     */
    protected const ASSET_VENDOR = 'vendor';

    /**
     * Create custom StandardDebugBar instance.
     */
    public function __construct()
    {
        // Create StandardDebugBar
        $this->debugBar = new \DebugBar\StandardDebugBar();

        // Get JavascriptRenderer
        $this->autoAssets = config('debugbar.renderer.auto_assets', false);
        if ($this->autoAssets)
        {
            $this->renderer = $this->debugBar->getJavascriptRenderer();
            $this->renderer->setIncludeVendors(false);

            // Create assets to be automatically rendered
            $this->createAssets();
        }
        else
        {
            $base_url = config('debugbar.renderer.base_url');
            $base_path = config('debugbar.renderer.base_path');
            $this->renderer = $this->debugBar->getJavascriptRenderer($base_url, $base_path);
        }
        $this->renderer->setEnableJqueryNoConflict(false);
    }

    /**
     * Create assets to be automatically rendered
     * @return string
     */
    protected function createAssets()
    {
        $this->autoAssetsDir = public_dir(self::ASSET_BASE);
        if (!file_exists($this->autoAssetsDir))
        {
            @mkdir($this->autoAssetsDir, null, true);
        }

        // Create assets file
        $css_file = add_path($this->autoAssetsDir, self::ASSET_CSS);
        $js_file = add_path($this->autoAssetsDir, self::ASSET_JS);
        $vendor_base = add_path(self::ASSET_BASE, self::ASSET_VENDOR);

        if (!file_exists($css_file) || !file_exists($js_file) || !file_exists($vendor_base))
        {
            // Create css and js
            list($cssCollection, $jsCollection) = $this->renderer->getAsseticCollection();
            file_put_contents($css_file, $cssCollection->dump());
            file_put_contents($js_file, $jsCollection->dump());

            // Create vendor directory
            if (!file_exists($vendor_base))
            {
                $src_dir = $this->renderer->getBasePath() . "/vendor";
                $dst_dir = public_dir($vendor_base);
                recursive_copy($src_dir, $dst_dir);
            }
        }
    }

    /**
     * Renders the html to include needed assets
     * @return string
     */
    public function renderHead():string
    {
        if (config('debugbar.debug'))
        {
            if ($this->autoAssets)
            {
                $css_file = url(add_path(self::ASSET_BASE, self::ASSET_CSS));
                $js_file = url(add_path(self::ASSET_BASE, self::ASSET_JS));
                $vendor_base = url(add_path(self::ASSET_BASE, self::ASSET_VENDOR));

                $html = <<<EOT
<link rel="stylesheet" type="text/css" href="{$vendor_base}/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="{$vendor_base}/highlightjs/styles/github.css">
<link rel="stylesheet" type="text/css" href="{$css_file}">
<script type="text/javascript" src="{$vendor_base}/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="{$vendor_base}/highlightjs/highlight.pack.js"></script>
<script type="text/javascript" src="{$js_file}"></script>
EOT;
                return $html;
            }
            else
            {
                return $this->renderer->renderHead();
            }
        }
        return '';
    }

    /**
     * Returns the code needed to display the debug bar
     * @return string
     */
    public function render():string
    {
        if (config('debugbar.debug'))
        {
            $initialize  = config('debugbar.renderer.initialize', true);
            $stacked_data = config('debugbar.renderer.stacked_data', true);
            return $this->renderer->render($initialize, $stacked_data);
        }
        return '';
    }

    /**
     * Get Data Collector
     * @param string $name
     * @return DataCollectorInterface
     */
    public function getCollector(string $name="messages"): DataCollectorInterface
    {
        return $this->debugBar->getCollector($name);
    }
}
