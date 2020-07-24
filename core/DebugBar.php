<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Derivations\StandardDebugBar;

/**
 * DebugBar Class - StandardDebugBar Wrapper
 *
 * @method static SimpleDebugBar getInstance() Gets the SimpleDebugBar instance.
 * @method static string renderHead() Renders the html to include needed assets.
 * @method static mixed render() Returns the code needed to display the debug bar.
 * @method static \DataCollector\DataCollectorInterface getCollector(string $name="messages") Gets data Collector.
 */
class DebugBar extends Singleton
{
    /**
     * Creates StandardDebugBar instance.
     *
     * @return \Apricot\Derivations\SimpleDebugBar;
     */
    protected static function createInstance()
    {
        return new StandardDebugBar();
    }
}