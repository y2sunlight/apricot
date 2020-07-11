<?php
namespace App\Controllers;

use App\Foundation\Controller;
use App\Foundation\Security\AuthUser;

/**
 * ホームコントローラ
 */
class HomeController extends Controller
{
    /**
     * Home Page
     * @return \Apricot\Foundation\Response
     */
    public function index()
    {
        $message = __('messages.home.msg_hello', [':account'=>AuthUser::getUser()->account]);
        return render('home',['message'=>$message]);
    }
}