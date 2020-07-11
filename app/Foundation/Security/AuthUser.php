<?php
namespace App\Foundation\Security;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\Security\Authentication;
use App\Models\User;

/**
 * User Authentication
 *
 * @method static Authentication getInstance();
 * @method static bool authenticate(string $account, string $password, bool $remenber=false) Authenticate user (Login)
 * @method static void remember() Remember user (Auto Login)
 * @method static bool check() Returns whether the user has been authenticated
 * @method static bool verify() Verify whether user is authenticated
 * @method static void forget() Forget user's session and cookie
 * @method static object getUser() Get authenticated user
 * @method static string getPathAfterLogin() Get path after login
 */
class AuthUser extends Singleton
{
    /**
     * Create user authentication instance.
     * @return \Apricot\Foundation\Security\Authentication
     */
    protected static function createInstance()
    {
        return new Authentication(new User());
    }
}
