<?php
//-------------------------------------------------------------------
// Autoloader registration
//-------------------------------------------------------------------
require dirname(__DIR__).'/vendor/autoload.php';

//-------------------------------------------------------------------
// Set the project and pulic path
//-------------------------------------------------------------------
$project_path = dirname(__DIR__);
$public_path = __DIR__;

//-------------------------------------------------------------------
// Initialize the application
//-------------------------------------------------------------------
$application = new Apricot\Application($project_path, $public_path);

// Start a Session
Apricot\Session::start();

// Setup the application
$application->setup(require_once config_dir('app.php'));

//-------------------------------------------------------------------
// Run the application
//-------------------------------------------------------------------
$application->run(require_once config_dir('routes.php'));
