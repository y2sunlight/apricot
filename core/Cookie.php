<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleCookie;

/**
 * Lang Class - SimpleCookie($_COOKIE) Wrapper
 *
 * @method static SimpleCookie getInstance()
 * @method static bool has(string $key)
 * @method static string get(string $key, string $default = null)
 * @method static bool set(string $key, string $value, int $expires_sec=0):bool
 * @method static bool forever(string $key, string $value)
 * @method static bool remove(string $key)
 */
class Cookie extends Singleton
{
    /**
     * Create SimpleCookie instance.
     * @return SimpleCookie
     */
    protected static function createInstance()
    {
        return new SimpleCookie();
    }
}
