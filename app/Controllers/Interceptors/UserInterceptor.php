<?php
namespace App\Controllers\Interceptors;

use Apricot\Input;
use App\Foundation\Controller;
use App\Foundation\ValidatorErrorBag;

/**
 * User Interceptor
 */
class UserInterceptor
{
    /**
     * Interceptor for insert method.
     *
     * @param Controller $controller
     * @return void|\Apricot\Foundation\Response return Response if failed
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

        // Removes unnecessary inputs
        Input::remove('password_confirmation');
    }

    /**
     * Interceptor for update method.
     *
     * @param Controller $controller
     * @param int $id
     * @return void|\Apricot\Foundation\Response return Response if failed
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

        // Removes unnecessary inputs
        Input::remove('password_confirmation');
    }
}
