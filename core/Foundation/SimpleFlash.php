<?php
namespace Apricot\Foundation;

use Apricot\Debug;

/**
 * Simple Flash Class
 */
class SimpleFlash
{
    /**
     * @var array flash data
     */
    private $flash;

    /**
     * @var string Session key for Flash
     */
    private const FLASH_KEY = '_flash';

    /**
     * Creates flash data.
     */
    public function __construct()
    {
        $this->flash = array_key_exists(self::FLASH_KEY, $_SESSION) ? $_SESSION[self::FLASH_KEY] : array();
        Debug::debug($this);
        unset($_SESSION[self::FLASH_KEY]);
    }

    /**
     * Checks if the given key is present.
     *
     * @param string $key
     * @return boolean
     */
     public function has(string $key):bool
    {
        return array_key_exists($key, $this->flash);
    }

    /**
     * Gets the flash data specified by the key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key))
        {
            return $this->flash[$key];
        }
        else
        {
            return $default;
        }
    }

    /**
     * Sets flash data.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        $_SESSION[self::FLASH_KEY][$key] = $value;
        $this->flash[self::FLASH_KEY] = $value;
    }

    /**
     * Removes the flash data specified by the key.
     *
     * @param string $key
     */
    public function remove(string $key)
    {
        if ($this->has($key))
        {
            unset($_SESSION[self::FLASH_KEY][$key]);
            unset($this->flash[$key]);
        }
    }

    /**
     * Clears all flash data.
     */
    public function clear()
    {
        unset($_SESSION[self::FLASH_KEY]);
        $this->flash = array();
    }
}
