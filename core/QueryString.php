<?php
namespace Core;

use Core\Foundation\Singleton;
use Core\Foundation\SimpleInput;

/**
 * QueryString Class - SimpleInput Wrapper($_GET only)
 *
 * @method static SimpleInput getInstance()
 * @method static bool has(string $key)
 * @method static string get(string $key, string $default = null)
 * @method static array all()
 * @method static array only(array|mixed $keys)
 * @method static array except(array|mixed $keys)
 * @method static set(string $key, string $vale)
 * @method static remove(string $key)
 */
class QueryString extends Singleton
{
    /**
     * Create SimpleInput instance.
     * @return SimpleInput
     */
    protected static function createInstance()
    {
        return new SimpleInput($_GET);
    }
}
