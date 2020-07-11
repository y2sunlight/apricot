<?php
namespace Apricot\Foundation;

/**
 * CallStatic
 */
abstract class CallStatic
{
    protected static abstract function getInstance();

    /**
     * Handle calls to Instance,Statically.
     * @param  string  $method
     * @param  array   $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        $instance = static::getInstance();
        return $instance->$method(...$args);
    }
}
