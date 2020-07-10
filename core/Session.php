<?php
namespace Core;

use Core\Foundation\Singleton;
use Core\Foundation\SimpleSession;

/**
 * Session Class - SimpleSession Wrapper
 *
 * @method static SimpleSession getInstance()
 * @method static void start()
 * @method static bool has(string $key)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static void set(string $key, mixed $vale)
 * @method static void clear()
 * @method static void remove(string $key)
 * @method static void destroy()
 * @method static \Core\Foundation\SimpleFlash flash()
 */
class Session extends Singleton
{
    /**
     * Create SimpleSession instance.
     * @return SimpleSession
     */
    protected static function createInstance()
    {
        return new SimpleSession();
    }
}
