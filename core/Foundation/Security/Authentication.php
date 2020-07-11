<?php
namespace Apricot\Foundation\Security;

use Apricot\Cookie;
use Apricot\Session;

/**
 * Authentication
 */
class Authentication
{
    /**
     * @var integer
     */
    private const TOKEN_LENGTH = 64;

    /**
     * Session key for authenticated user
     */
    private const SESSION_KEY_AUTH = '_auth_';

    /**
     * Session key for path after login
     */
    private const SESSION_KEY_PATH_AFTER_LOGIN = '_path_after_login_';

    /**
     * Cookie key for remembered user
     */
    private const COOKIE_KEY_REMEMBER = '_remember_';

    /**
     * Authentication name
     * @var string
     */
    private $name;

    /**
     * Authentication interface
     * @var Authenticatable
     */
    private $auth;

    /**
     * Create authentication object
     * @param string $name
     */
    public function __construct(Authenticatable $auth)
    {
        $this->auth = $auth;
        $this->name = $this->auth->getAuthName();
    }

    /**
     * Authenticate user (Login)
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
            //Set user session
            $this->setUserSession($user, $remenber);
            return true;
        }
        return false;
    }

    /**
     * Remember user (Auto Login)
     * @return bool true if authenticated
     */
    public function remember()
    {
        if(Cookie::has($this->getRemenberCookieName()))
        {
            $user = $this->auth->rememberUser(Cookie::get($this->getRemenberCookieName()));
            if (($user!==false))
            {
                // Set user session
                $this->setUserSession($user, true);
                return true;
            }
        }
        return false;
    }

    /**
     * Returns whether the user has been authenticated
     * @return bool true if authenticated
     */
    public function check(): bool
    {
        return Session::has(self::SESSION_KEY_AUTH.$this->name);
    }

    /**
     * Verify whether user is authenticated
     * @return bool true if authenticated
     */
    public function verify(): bool
    {
        // When alraedy logged in
        if ($this->check())
        {
            $user = $this->getUser();

            // Retrieve login user info
            $new_user_info = $this->auth->retrieveUser($user);

            // The login user may have been deleted, but keep on login
            if ($new_user_info!==false)
            {
                $this->setUser($new_user_info);
            }
            return true;
        }

        // If not authenticated, remember the path after login
        $this->setPathAfterLogin($_SERVER['REQUEST_URI']);
        return false;
    }

    /**
     * Forget user's session and cookie
     */
    public function forget()
    {
        // Destroy session completely
        Session::destroy();

        // Remove user from cookie
        Cookie::remove($this->getRemenberCookieName());
    }

    /**
     * Get authenticated user
     * @return object
     */
    public function getUser()
    {
        return Session::get(self::SESSION_KEY_AUTH.$this->name);
    }

    /**
     * Get path after login
     * @return string
     */
    public function getPathAfterLogin() : string
    {
        return Session::get(self::SESSION_KEY_PATH_AFTER_LOGIN.$this->name, route(''));
    }

    /**
     * Set user session
     * @param object $user
     * @param bool $remenber
     */
    private function setUserSession(object $user, bool $remenber)
    {
        // Save user in session
        $this->setUser($user);

        if ($remenber)
        {
            $remenber_token = $this->getRemenberToken();

            // Save remenber_token to DB
            if ($this->auth->saveRemenberToken($user, $remenber_token))
            {
                // Save to cookie
                Cookie::set($this->getRemenberCookieName(), $remenber_token, app('auth.expires_sec'));
            }
        }
        else
        {
            // Remove from cookie
            Cookie::remove($this->getRemenberCookieName());
        }
    }

    /**
     * Get login user
     * @return object
     */
    private function setUser(object $user)
    {
        return Session::set(self::SESSION_KEY_AUTH.$this->name, $user);
    }

    /**
     * Set path after login
     * @param string $path
     */
    private function setPathAfterLogin(string $path)
    {
        return Session::set(self::SESSION_KEY_PATH_AFTER_LOGIN.$this->name, $path);
    }

    /**
     * Get remenber me cookie name
     * @return string
     */
    private function getRemenberCookieName():string
    {
        return self::COOKIE_KEY_REMEMBER.$this->name.'_'.sha1(env('APP_SECRET',self::class));
    }

    /**
     * Get remenber me token
     * @return string
     */
    private function getRemenberToken():string
    {
        return str_random(self::TOKEN_LENGTH);
    }
}