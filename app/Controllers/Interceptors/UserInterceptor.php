<?php
namespace App\Controllers\Interceptors;

use Core\Input;
use App\Foundation\Controller;
use App\Foundation\ValidatorErrorBag;

/**
 * ユーザインターセプタ―
 */
class UserInterceptor
{
    /**
     * ユーザレコード挿入
     * @return void|\Core\Foundation\Response return Response if failed
     */
    public function insert(Controller $controller)
    {
        $inputs = Input::all();

        // Validation
        $v =(new \Valitron\Validator($inputs))
        ->rule('required', ['account','password'])
        ->rule('alphaNum','account')
        ->rule('unique','account','user','id')
        ->rule('ascii','password')
        ->rule('equals','password','password_confirmation')
        ->rule('email', 'email')
        ->labels(inputLabels('messages.user.create'));

        if(!$v->validate())
        {
            $errorBag = new ValidatorErrorBag($v->errors());
            return redirect(back())->withInputs()->withErrors($errorBag);
        }

        // Remove unnecessary inputs
        Input::remove('password_confirmation');
    }

    /**
     * ユーザレコード更新
     * @param int $id
     * @return void|\Core\Foundation\Response return Response if failed
     */
    public function update(Controller $controller, int $id)
    {
        $inputs = Input::all();

        // Validation
        $v =(new \Valitron\Validator($inputs))
        ->rule('ascii','password')
        ->rule('equals','password','password_confirmation')
        ->rule('email', 'email')
        ->labels(inputLabels('messages.user.create'));

        if(!$v->validate())
        {
            $errorBag = new ValidatorErrorBag($v->errors());
            return redirect(back())->withInputs()->withErrors($errorBag);
        }

        // Remove unnecessary inputs
        Input::remove('password_confirmation');
    }
}
