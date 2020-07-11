<?php
namespace Apricot;

use Apricot\Foundation\CallStatic;

/**
 * Flash Class - SimpleFlash Wrapper
 *
 * @method static SimpleFlash getInstance()
 * @method static bool has(string $key)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static void set(string $key, mixed $vale)
 * @method static void remove(string $key)
 * @method static void clear()
 */
class Flash extends CallStatic
{
    /**
     * Get Flash instance.
     * @return Flash
     */
    public static function getInstance()
    {
        return Session::flash();
    }
}
