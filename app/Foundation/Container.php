<?php
namespace App\Foundation;

use Apricot\Foundation\Singleton;
use App\Provider;

/**
 * Container class for service
 *
 * @method static Container getInstance() Gets the Container instance.
 * @method static mixed get(string $id) Finds an entry of the container by its identifier and returns it.
 * @method static bool has(string $id) Returns true if the container can return an entry for the given identifier.
 */
class Container extends Singleton
{
    /**
     * Create Container instance.
     * @return \League\Container\Container
     */
    protected static function createInstance()
    {
        $container = new \League\Container\Container;
        $container->addServiceProvider(new Provider());
        return $container;
    }
}
