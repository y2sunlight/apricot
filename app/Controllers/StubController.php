<?php
namespace App\Controllers;

use App\Foundation\Container;
use App\Foundation\Controller;

/**
 * Stub Controller
 */
class StubController extends Controller
{
    /**
     * Index Page for this controller.
     *
     * @return \Apricot\Foundation\Response
     */
    public function index(int $no=null)
    {
        $title = "Stub {$no}";

        /*
         * Example for Container
         * @var \App\Models\User $user
         */
        $user = Container::get('user');
        $userCount = count($user->findAll());
        $messages[] = "Number of registered users : {$userCount}";

        return render('stub',['title'=>$title,'messages'=>$messages]);
    }
}