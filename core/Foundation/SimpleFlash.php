<?php
namespace Core\Foundation;

use Core\Debug;

/**
 * Very Simple Flash Class
 */
class SimpleFlash
{
    /*
     * Flash Data
     */
    private $flash;

    /*
     * Flash Session key
     */
    private const FLASH = '_flash';

    /**
     * Create Flash
     */
    public function __construct()
    {
        $this->flash = array_key_exists(self::FLASH,$_SESSION) ? $_SESSION[self::FLASH] : array();
        Debug::debug($this);
        unset($_SESSION[self::FLASH]);
    }

    /**
     * Checks if a key is present
     * @param string $key
     * @return boolean
     */
     public function has(string $key):bool
    {
        return array_key_exists($key, $this->flash);
    }

    /**
     * Get flash data
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
     * Set flash data
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        $_SESSION[self::FLASH][$key] = $value;
        $this->flash[self::FLASH] = $value;
    }

    /**
     * Remove flash data
     * @param array|mixed $keys array or arguments list
     */
    public function remove(string $key)
    {
        if ($this->has($key))
        {
            unset($_SESSION[self::FLASH][$key]);
            unset($this->flash[$key]);
        }
    }

    /**
     * Clear flash data
     */
    public function clear()
    {
        unset($_SESSION[self::FLASH]);
        $this->flash = array();
    }
}
