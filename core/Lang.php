<?php
namespace Core;

use Core\Foundation\Singleton;
use Core\Foundation\Translation;

/**
 * Lang Class - Translation Wrapper
 *
 * @method static Translation getInstance();
 * @method static bool has(string $key)
 * @method static string get(string $key, array $params = [])
 */
class Lang extends Singleton
{
    /**
     * Create Translation instance.
     * @return Translation
     */
    protected static function createInstance()
    {
        // cf.) $_SERVER['HTTP_ACCEPT_LANGUAGE'];
        $lang = env('APP_LANG','ja');
        return new Translation($lang);
    }
}
