<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\Configuration;

/**
 * Config Class - Configuration Wrapper
 *
 * @method static Configuration getInstance();
 * @method static bool has(string $key)
 * @method static mixed get(string $key, $default = null)
 */
class Config extends Singleton
{
    /**
     * Create Translation instance.
     * @return Configuration
     */
    protected static function createInstance()
    {
        return new Configuration();
    }
}
