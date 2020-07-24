<?php
namespace App\Controllers;

use Apricot\Input;
use Apricot\Foundation\ErrorBag;
use App\Foundation\Security\AuthUser;
use App\Foundation\Controller;
use App\Foundation\ValidatorErrorBag;

/**
 * Authentication Controller
 */
class AuthController extends Controller
{
    /**
     * Create a Authentication controller.
     */
    public function __construct()
    {
        // Register the interceptor
        $this->intercept('login', function(Controller $controller)
        {
            $inputs = Input::all();

            // Validation
            $v =(new \Valitron\Validator($inputs))
            ->rule('required', 'account')
            ->rule('alphaNum','account')
            ->rule('ascii','password')
            ->labels(inputLabels('auth.login'));

            if(!$v->validate())
            {
                $errorBag = new ValidatorErrorBag($v->errors());
                return redirect(back())->withInputs()->withErrors($errorBag);
            }
        });
    }

    /**
     * Shows the login form.
     *
     * @return \Apricot\Foundation\Response
     */
    public function showForm()
    {
        if (AuthUser::check())
        {
            // Top page display if authenticated
            return redirect(route(''));
        }

        if (AuthUser::remember())
        {
            // Top page display if automatic authentication is possible
            return redirect(route(''));
        }

        return render('login');
    }

    /**
     * Login (user authentication)
     *
     * @return \Apricot\Foundation\Response
     */
    public function login()
    {
        $inputs = Input::all();

        if (!AuthUser::authenticate($inputs['account'], $inputs['password'], !empty($inputs['remember'])))
        {
            // If the user cannot be found
            $errorBag = new ErrorBag([__('auth.login.error.no_account')]);
            return redirect(back())->withInputs()->withErrors($errorBag);
        }

        // When login is successful
        return redirect(AuthUser::getPathAfterLogin());
    }

    /**
     * Logout
     *
     * @return \Apricot\Foundation\Response
     */
    public function logout()
    {
        // Destroy the session
        AuthUser::forget();

        // Show the login form
        return redirect(route("login"));
    }
}