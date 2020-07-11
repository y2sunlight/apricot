<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Derivations\StandardDebugBar;

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
     * @return \Apricot\Derivations\SimpleDebugBar;
     */
    protected static function createInstance()
    {
        return new StandardDebugBar();
    }
}