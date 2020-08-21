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

        /**
         * @var \App\Services\SampleService $service
         */
        $service = Container::get('SampleService');
        $count = $service->getUserCount();
        $messages[] = "Number of registered users : {$count}";

        return render('stub',['title'=>$title,'messages'=>$messages]);
    }
}