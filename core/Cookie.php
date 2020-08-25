<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleCookie;

/**
 * Lang Class - SimpleCookie($_COOKIE) Wrapper
 *
 * @method static SimpleCookie getInstance() Gets the SimpleCookie instance.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static string get(string $key, string $default = null) Gets the cookie data specified by the key.
 * @method static bool set(string $key, string $value=null, int $expires_sec=0):bool Sets cookie data.
 * @method static bool forever(string $key, string $value) Sets cookie data forever.
 * @method static bool remove(string $key) Removes the cookie data specified by the key.
 */
class Cookie extends Singleton
{
    /**
     * Creates the SimpleCookie instance.
     *
     * @return SimpleCookie
     */
    protected static function createInstance()
    {
        return new SimpleCookie();
    }
}
