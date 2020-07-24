<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleSession;

/**
 * Session Class - SimpleSession Wrapper
 *
 * @method static SimpleSession getInstance() Gets the SimpleSession instance.
 * @method static void start() Starts session.
 * @method static bool isStarted() Checks if session has started.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static mixed get(string $key, mixed $default = null) Gets the session data specified by the key.
 * @method static void set(string $key, mixed $vale) Sets session data.
 * @method static void remove(string $key) Removes the session data specified by the key.
 * @method static void clear() Clears all session data.
 * @method static void destroy() Destroys all session data.
 * @method static \Apricot\Foundation\SimpleFlash flash() Gets the SimpleFlash instance.
 */
class Session extends Singleton
{
    /**
     * Creates the SimpleSession instance.
     *
     * @return SimpleSession
     */
    protected static function createInstance()
    {
        return new SimpleSession();
    }
}
