<?php
//-------------------------------------------------------------------
// Autoloader registration
//-------------------------------------------------------------------
require dirname(__DIR__).'/vendor/autoload.php';

//-------------------------------------------------------------------
// Sets the project and pulic path
//-------------------------------------------------------------------
$project_path = dirname(__DIR__);
$public_path = __DIR__;

//-------------------------------------------------------------------
// Initializes the application
//-------------------------------------------------------------------
$application = new Apricot\Application($project_path, $public_path);

// Starts a Session
Apricot\Session::start();

// Setups the application
$application->setup(require_once config_dir('app.php'));

//-------------------------------------------------------------------
// Runs the application
//-------------------------------------------------------------------
$application->run(require_once config_dir('routes.php'));
