<?php
namespace App\Foundation\Security;

use Apricot\Foundation\Singleton;
use Apricot\Foundation\Security\Authentication;
use App\Models\User;

/**
 * User Authentication
 *
 * @method static Authentication getInstance() Gets the AuthUser instance.
 * @method static bool authenticate(string $account, string $password, bool $remenber=false) Authenticates the user.
 * @method static void remember() Remembers the user.
 * @method static bool check() Returns whether the user has been authenticated.
 * @method static bool verify() Verifys whether the user is authenticated.
 * @method static void forget() Forgets the user's session and cookie.
 * @method static object getUser() Gets the authenticated user.
 * @method static string getPathAfterLogin() Gets the path after logging in.
 */
class AuthUser extends Singleton
{
    /**
     * Creates the user authentication instance.
     *
     * @return \Apricot\Foundation\Security\Authentication
     */
    protected static function createInstance()
    {
        return new Authentication(new User());
    }
}
