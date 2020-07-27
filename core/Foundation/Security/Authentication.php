<?php
namespace Apricot\Foundation\Security;

use Apricot\Cookie;
use Apricot\Session;

/**
 * Authentication Class
 */
class Authentication
{
    /**
     * @var int
     */
    private const TOKEN_LENGTH = 64;

    /**
     * @var string Session key prefix for an authenticated user
     */
    private const SESSION_KEY_AUTH = '_auth_';

    /**
     * @var string Session key prefix for the path after logging in
     */
    private const SESSION_KEY_PATH_AFTER_LOGIN = '_path_after_login_';

    /**
     * @var string Cookie key prefix for a remembered user
     */
    private const COOKIE_KEY_REMEMBER = '_remember_';

    /**
     * @var string Authentication name
     */
    private $name;

    /**
     * @var Authenticatable Authentication interface
     */
    private $auth;

    /**
     * Creates an authentication object.
     *
     * @param Authenticatable $auth
     */
    public function __construct(Authenticatable $auth)
    {
        $this->auth = $auth;
        $this->name = $this->auth->getAuthName();
    }

    /**
     * Authenticates the user.
     *
     * @param string $account
     * @param string $password
     * @param bool $remenber
     * @return bool true if authenticated
     */
    public function authenticate(string $account, string $password, bool $remenber=false): bool
    {
        $user = $this->auth->authenticateUser($account, $password, $remenber);
        if ($user!== false)
        {
            //Sets user session.
            $this->setUserSession($user, $remenber);
            return true;
        }
        return false;
    }

    /**
     * Remembers the user.
     *
     * @return bool true if authenticated
     */
    public function remember()
    {
        if(Cookie::has($this->getRemenberCookieName()))
        {
            $user = $this->auth->rememberUser(Cookie::get($this->getRemenberCookieName()));
            if (($user!==false))
            {
                // Sets user session.
                $this->setUserSession($user, true);
                return true;
            }
        }
        return false;
    }

    /**
     * Returns whether the user has been authenticated.
     *
     * @return bool true if authenticated
     */
    public function check(): bool
    {
        return Session::has(self::SESSION_KEY_AUTH.$this->name);
    }

    /**
     * Verifys whether the user is authenticated.
     *
     * @return bool true if authenticated
     */
    public function verify(): bool
    {
        // When alraedy logged in.
        if ($this->check())
        {
            $user = $this->getUser();

            // Retrieves login user information.
            $new_user_info = $this->auth->retrieveUser($user);

            // The logged-in user may have been deleted, but will continue to log in.
            if ($new_user_info!==false)
            {
                $this->setUser($new_user_info);
            }
            return true;
        }

        // If not authenticated, remembers the path after logging in.
        $this->setPathAfterLogin($_SERVER['REQUEST_URI']);
        return false;
    }

    /**
     * Forgets the user's session and cookie.
     */
    public function forget()
    {
        // Destroys session completely.
        Session::destroy();

        // Removes user from cookie.
        Cookie::remove($this->getRemenberCookieName());
    }

    /**
     * Gets the authenticated user.
     *
     * @return object
     */
    public function getUser()
    {
        return Session::get(self::SESSION_KEY_AUTH.$this->name);
    }

    /**
     * Gets the path after logging in.
     *
     * @return string
     */
    public function getPathAfterLogin() : string
    {
        return Session::get(self::SESSION_KEY_PATH_AFTER_LOGIN.$this->name, route(''));
    }

    /**
     * Sets the user session.
     *
     * @param object $user
     * @param bool $remenber
     */
    private function setUserSession(object $user, bool $remenber)
    {
        // Saves user in session.
        $this->setUser($user);

        if ($remenber)
        {
            $remenber_token = $this->getRemenberToken();

            // Saves remenber_token to DB.
            if ($this->auth->saveRemenberToken($user, $remenber_token))
            {
                // Saves to cookie.
                Cookie::set($this->getRemenberCookieName(), $remenber_token, app('auth.expires_sec'));
            }
        }
        else
        {
            // Removes from cookie.
            Cookie::remove($this->getRemenberCookieName());
        }
    }

    /**
     * Gets the login user
     * @return object
     */
    private function setUser(object $user)
    {
        return Session::set(self::SESSION_KEY_AUTH.$this->name, $user);
    }

    /**
     * Sets the path after logging in
     * @param string $path
     */
    private function setPathAfterLogin(string $path)
    {
        return Session::set(self::SESSION_KEY_PATH_AFTER_LOGIN.$this->name, $path);
    }

    /**
     * Gets the remenber_me cookie name
     * @return string
     */
    private function getRemenberCookieName():string
    {
        return self::COOKIE_KEY_REMEMBER.$this->name.'_'.sha1(env('APP_SECRET',self::class));
    }

    /**
     * Gets the remenber_me token
     * @return string
     */
    private function getRemenberToken():string
    {
        return str_random(self::TOKEN_LENGTH);
    }
}