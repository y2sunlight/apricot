<?php
//-------------------------------------------------------------------
// オートローダーの登録
//-------------------------------------------------------------------
require dirname(__DIR__).'/vendor/autoload.php';

//-------------------------------------------------------------------
// パスの設定
//-------------------------------------------------------------------
$project_path = dirname(__DIR__);
$public_path = __DIR__;

//-------------------------------------------------------------------
// アプリケーション初期化
//-------------------------------------------------------------------
$application = new Apricot\Application($project_path, $public_path);

// セッション開始
Apricot\Session::start();

// アプリケーションセットアップ
$application->setup(require_once config_dir('app.php'));

//-------------------------------------------------------------------
// アクションの実行
//-------------------------------------------------------------------
$application->run(require_once config_dir('routes.php'));
