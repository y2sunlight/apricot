<?php
namespace Apricot\Foundation;

/**
 * CallStatic
 */
abstract class CallStatic
{
    protected static abstract function getInstance();

    /**
     * Handles calls to instance,Statically.
     *
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
