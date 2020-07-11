<?php
//-------------------------------------------------------------------
// エラーハンドラー(Whoops)の初期設定
//-------------------------------------------------------------------
return function():bool
{
    $whoops = new \Whoops\Run;
    if(config('whoops.debug'))
    {
        //----------------------------
        // デバッグ用のエラーハンドラー
        //----------------------------
        $whoops->pushHandler(new Apricot\Derivations\PrettyErrorHandlerWithLogger);
    }
    else
    {
        //----------------------------
        // 本番用のエラーハンドラー
        //----------------------------
        $whoops->pushHandler(function($exception, $inspector, $run)
        {
            // エラーログ出力
            Apricot\Log::critical($exception->getMessage(),[$exception->getFile(),$exception->getLine(), $exception->getTraceAsString()]);

            // ユーザ向けエラー画面の表示
            // TODO: ここは例外のループを抑止しなかればならない
            $controller = config('whoops.controller',null);
            $action = config('whoops.action',null);
            if (isset($controller)&&isset($action))
            {
                $instance = new $controller();
                $response = call_user_func_array(array($instance, $action), [$exception]);
            }
            return \Whoops\Handler\Handler::QUIT;
        });
    }

    $whoops->register();
    return true; // Must return true on success
};