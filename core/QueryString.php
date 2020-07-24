<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleInput;

/**
 * QueryString Class - SimpleInput Wrapper($_GET only)
 *
 * @method static SimpleInput getInstance() Gets the SimpleInput instance.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static string get(string $key, string $default = null) Gets the query string specified by the key.
 * @method static array all() Gets all query strings.
 * @method static array only(array|mixed $keys) Gets a subset of query strings for the specified keys only.
 * @method static array except(array|mixed $keys) Gets a subset of query string except specified keys.
 * @method static set(string $key, string $vale) Sets a query string.
 * @method static remove(string $key) Removes the query string specified by the key.
 */
class QueryString extends Singleton
{
    /**
     * Creates the SimpleInput instance.
     *
     * @return SimpleInput
     */
    protected static function createInstance()
    {
        return new SimpleInput($_GET);
    }
}
