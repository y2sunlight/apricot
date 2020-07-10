<?php
namespace App\Controllers;

use Core\Input;
use Core\Foundation\ErrorBag;
use App\Foundation\Security\AuthUser;
use App\Foundation\Controller;
use App\Foundation\ValidatorErrorBag;

/**
 * Authコントローラ
 */
class AuthController extends Controller
{
    public function __construct()
    {
        // インターセプターの登録
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
     * ログインフォーム表示
     * @return \Core\Foundation\Response
     */
    public function showForm()
    {
        if (AuthUser::check())
        {
            // 認証済ならトップ画面表示
            return redirect(route(''));
        }

        if (AuthUser::remember())
        {
            // 自動認証できたらトップ画面表示
            return redirect(route(''));
        }

        return render('login');
    }

    /**
     * ログイン(ユーザ認証)
     * @return \Core\Foundation\Response
     */
    public function login()
    {
        $inputs = Input::all();

        if (!AuthUser::authenticate($inputs['account'], $inputs['password'], !empty($inputs['remember'])))
        {
            // ユーザが見つからない
            $errorBag = new ErrorBag([__('auth.login.error.no_account')]);
            return redirect(back())->withInputs()->withErrors($errorBag);
        }

        // ログイン成功
        return redirect(AuthUser::getPathAfterLogin());
    }

    /**
     * ログアウト
     * @return \Core\Foundation\Response
     */
    public function logout()
    {
        // セッションの破棄
        AuthUser::forget();

        // ログイン画面表示
        return redirect(route("login"));
    }
}