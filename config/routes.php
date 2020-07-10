<?php
//-------------------------------------------------------------------
// Route Definition Callback
//-------------------------------------------------------------------
return function (FastRoute\RouteCollector $r)
{
    $base = Core\Application::getInstance()->getRouteBase();
    $r->addGroup($base, function (FastRoute\RouteCollector $r) use($base)
    {
        // Auth
        $r->get ('/login', 'AuthController@showForm');
        $r->post('/login', 'AuthController@login');
        $r->get ('/logout', 'AuthController@logout');

        // User
        $r->get ('/users', 'UserController@index');
        $r->get ('/user/create', 'UserController@create');
        $r->post('/user/insert', 'UserController@insert');
        $r->get ('/user/{id:\d+}/edit', 'UserController@edit');
        $r->post('/user/{id:\d+}/update', 'UserController@update');
        $r->post('/user/{id:\d+}/delete', 'UserController@delete');

        // Home
        $r->get ('/home', 'HomeController@index');
        $r->get('/', function() use($base){
            header("Location: " . $base.'/home');
        });

        // Stub
        $r->get('/stub[/{no:\d+}]', 'StubController@index');
    });
};