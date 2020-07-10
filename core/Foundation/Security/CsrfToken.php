<?php
namespace Core\Foundation\Security;

use Core\Input;
use Core\Session;

/**
 * CSRF
 */
class CsrfToken
{
    /**
     * @var integer
     */
    private const CSRF_LENGTH = 40;

    /**
     * Session/Post key for CSRF
     */
    public const CSRF_KEY = '_token';

    /**
     * verify CSRF Token
     * @return bool Returns true on success
     */
    public static function verify():bool
    {
        $ret = true;

        // Verify CSRF token in case of POST method
        if (strtoupper($_SERVER['REQUEST_METHOD'])=='POST')
        {
            if (Input::get(self::CSRF_KEY,'A') != Session::get(self::CSRF_KEY,'B'))
            {
                \Core\Log::error('VerifyCsrf Error',[Input::get(self::CSRF_KEY),Session::get(self::CSRF_KEY)]);
                $ret = false;
            }
        }

        // Delete CSRF token of Input
        Input::remove(self::CSRF_KEY);

        // If the CSRF token is disposable, delete it from the session
        if (app('csrf.disposable',false))
        {
            Session::remove(self::CSRF_KEY);
        }

        return $ret;
    }

    /**
     * Generate new CSRF Token in Session
     * @return bool
     */
    public static function generate()
    {
        // Generate a CSRF token if it has not been generated
        if (!Session::has(self::CSRF_KEY) || empty(Session::get(self::CSRF_KEY)))
        {
            // Generate a new CSRF token for the next request
            Session::set(self::CSRF_KEY, str_random(self::CSRF_LENGTH));
        }
    }
}