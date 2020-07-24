<?php
namespace Apricot;

use Apricot\Foundation\CallStatic;

/**
 * Flash Class - SimpleFlash Wrapper
 *
 * @method static SimpleFlash getInstance() Gets the SimpleFlash instance.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static mixed get(string $key, mixed $default = null) Gets the flash data specified by the key.
 * @method static void set(string $key, mixed $vale) Sets flash data.
 * @method static void remove(string $key) Removes the flash data specified by the key.
 * @method static void clear() Clears all flash data.
 */
class Flash extends CallStatic
{
    /**
     * Gets the Flash instance.
     *
     * @return Flash
     */
    public static function getInstance()
    {
        return Session::flash();
    }
}
