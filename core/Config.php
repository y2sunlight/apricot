<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\Configuration;

/**
 * Config Class - Configuration Wrapper
 *
 * @method static Configuration getInstance() Gets the Configuration instance.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static mixed get(string $key, $default = null) Gets the configuration value specified by the Dot-notation key.
 */
class Config extends Singleton
{
    /**
     * Creates the Configuration instance.
     *
     * @return Configuration
     */
    protected static function createInstance()
    {
        return new Configuration();
    }
}
