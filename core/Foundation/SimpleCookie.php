<?php
namespace Apricot\Foundation;

/**
 * Simple Cookie Class - $_COOKIE Wrapper
 */
class SimpleCookie
{
    /**
     * @var array Cookie data
     */
    private $cookie = null;

    /**
     * @var int Validity time of the cookie that represents 'FOREVER'
     */
    private const FOREVER = 365*24*60*60;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cookie = !empty($_COOKIE) ? $_COOKIE : array();
    }

    /**
     * Checks if the given key is present.
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $this->cookie);
    }

    /**
     * Gets the cookie data specified by the key.
     *
     * @param string $key
     * @param string $default
     * @return string|null
     */
    public function get(string $key, string $default = null)
    {
        if ($this->has($key))
        {
            return $this->cookie[$key];
        }
        else
        {
            return $default;
        }
    }

    /**
     * Sets cookie data.
     *
     * @param string $key
     * @param string $value
     * @param int $expires_sec (not time()*60*60, but 60*60 )
     * @return bool return true if successfuly
     */
    public function set(string $key, string $value=null, int $expires_sec=0):bool
    {
        if($this->sendCookie($key, $value, $expires_sec))
        {
            $this->cookie[$key] = $value;
            return true;
        }
        return false;
    }

    /**
     * Sets cookie data forever.
     *
     * @param string $key
     * @param string $value
     * @return bool return true if successfuly
     */
    public function forever(string $key, string $value):bool
    {
        return $this->set($key, $value, config('cookie.forever',self::FOREVER));
    }

    /**
     * Removes the cookie data specified by the key.
     *
     * @param string $key
     */
    public function remove(string $key)
    {
        if ($this->has($key))
        {
            unset($this->cookie[$key]);
            $this->sendCookie($key, '', -3600);
        }
    }

    /**
     * Sends the cookie data.
     *
     * @param string $key
     * @param string $value
     * @param int $expires_sec (not time()*60*60, but 60*60 )
     * @return bool return true if successfuly
     */
    private function sendCookie(string $key, string $value, int $expires_sec=0):bool
    {
        $expires = ($expires_sec==0) ? 0 : time() + $expires_sec;
        $path = config('cookie.path','');
        $domain = config('cookie.domain','');
        $secure = config('cookie.secure',FALSE);
        $httponly = config('cookie.httponly',FALSE);

        return setcookie($key, $value, $expires, $path, $domain, $secure, $httponly);
    }
}
