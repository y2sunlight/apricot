<?php
namespace Apricot\Foundation;

/**
 * Very Simple Session Class - $_SESSION Wrapper
 */
class SimpleSession
{
    /**
     * Flash Data
     * @var SimpleFlash
     */
    private $flash = null;

    /**
     * Create Simple Session
     */
    public function __construct()
    {
        session_name(config('session.name'));

        // ini_set
        $ini_values = config('session.ini',[]);
        foreach($ini_values as $key=>$value)
        {
            if (isset($value))
            {
                try
                {
                    ini_set("session.{$key}", $value);
                    \Apricot\Debug::debug("ini_set(session.{$key})=".ini_get("session.{$key}"));
                }
                catch(\Throwable $e)
                {
                    \Apricot\Debug::error("ini_set(session)",[$key,$value]);
                };
            }
        }
    }

    /**
     * Session Start
     */
    public function start()
    {
        // Start Session
        session_start();
        $this->flash = new SimpleFlash();
    }

    /**
     * Checks if session has started
     * @return bool
     */
    public function isStarted():bool
    {
        return (array_key_exists(session_name(), $_COOKIE));
    }

    /**
     * Checks if a key is present
     * @param string $key
     * @return bool
     */
    public function has(string $key):bool
    {
        return array_key_exists($key, $_SESSION);
    }

    /**
     * Get session data
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if ($this->has($key))
        {
            return $_SESSION[$key];
        }
        else
        {
            return $default;
        }
    }

    /**
     * Set session data
     * @param string $key
     * @param mixed $value
     */
    public function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Remove session data
     * @param string $key
     */
    public function remove(string $key)
    {
        if ($this->has($key))
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Clear session data
     */
    public function clear()
    {
        $_SESSION = [];
    }

    /**
     * Destroy session data
     */
    public function destroy()
    {
        $this->clear();
        if($this->isStarted())
        {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() -24*60*60,
                $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    /**
     * Get flash data
     * @return \Apricot\Foundation\SimpleFlash
     */
    public function flash()
    {
        return $this->flash;
    }
}
