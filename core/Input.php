<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleInput;

/**
 * Input Class - SimpleInput Wrapper($_POST or $_GET depending on the method)
 *
 * @method static SimpleInput getInstance() Gets the SimpleInput instance.
 * @method static bool has(string $key) Checks if the given key is present.
 * @method static string get(string $key, string $default = null) Gets the input data specified by the key.
 * @method static array all() Gets all input data.
 * @method static array only(array|mixed $keys) Gets a subset of inputs for the specified keys only.
 * @method static array except(array|mixed $keys) Gets a subset of inputs except specified keys.
 * @method static set(string $key, string $vale=null) Sets input data.
 * @method static remove(string $key) Removes the input data specified by the key.
 */
class Input extends Singleton
{
    /**
     * Creates the SimpleInput instance.
     *
     * @return SimpleInput
     */
    protected static function createInstance()
    {
        $inputs = self::getRawData();
        return new SimpleInput($inputs);
    }

    /**
     * Gets raw input data depending on the method.
     *
     * @return array
     */
    public static function getRawData()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) =='POST' ? $_POST : $_GET;
    }
}
