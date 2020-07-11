<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\SimpleInput;

/**
 * Input Class - SimpleInput Wrapper($_POST or $_GET depending on the method)
 *
 * @method static SimpleInput getInstance()
 * @method static bool has(string $key)
 * @method static string get(string $key, string $default = null)
 * @method static array all()
 * @method static array only(array|mixed $keys)
 * @method static array except(array|mixed $keys)
 * @method static set(string $key, string $vale)
 * @method static remove(string $key)
 */
class Input extends Singleton
{
    /**
     * Create SimpleInput instance.
     * @return SimpleInput
     */
    protected static function createInstance()
    {
        $inputs = self::getRawData();
        return new SimpleInput($inputs);
    }

    /**
     * Get raw input data depending on the method
     * @return array
     */
    public static function getRawData()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']) =='POST' ? $_POST : $_GET;
    }
}
