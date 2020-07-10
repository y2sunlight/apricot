<?php
namespace Core;

use Core\Foundation\Singleton;
use Core\Derivations\StandardDebugBar;

/**
 * DebugBar Class - StandardDebugBar Wrapper
 *
 * @method static SimpleDebugBar getInstance()
 * @method static string renderHead()
 * @method static mixed render()
 * @method static \DataCollector\DataCollectorInterface getCollector(string $name="messages")
 */
class DebugBar extends Singleton
{
    /**
     * Create SimpleDebugBar instance.
     * @return \Core\Derivations\SimpleDebugBar;
     */
    protected static function createInstance()
    {
        return new StandardDebugBar();
    }
}