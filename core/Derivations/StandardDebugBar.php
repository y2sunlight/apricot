<?php
namespace Core\Derivations;

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
     * Create custom StandardDebugBar instance.
     */
    public function __construct()
    {
        // Create StandardDebugBar
        $this->debugBar = new \DebugBar\StandardDebugBar();

        // Get JavascriptRenderer
        $base_url = config('debugbar.renderer.base_url');
        $base_path = config('debugbar.renderer.base_path');
        $this->renderer = $this->debugBar->getJavascriptRenderer($base_url, $base_path);
        $this->renderer->setEnableJqueryNoConflict(false);
    }

    /**
     * Renders the html to include needed assets
     * @return string
     */
    public function renderHead():string
    {
        if (config('debugbar.debug'))
        {
            return $this->renderer->renderHead();
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
