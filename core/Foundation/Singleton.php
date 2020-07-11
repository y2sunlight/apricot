<?php
namespace Apricot\Foundation;

/**
 * Singleton
 */
abstract class Singleton extends CallStatic
{
    protected static abstract function createInstance();

    /**
     * Get instance.
     * @return object
     */
    public static function getInstance()
    {
        static $instance = null;
        if (!$instance)
        {
            $instance = static::createInstance();
        }
        return $instance;
    }
}
