<?php
namespace Apricot\Derivations;

/**
 * PrettyErrorHandler With Logger
 */
class PrettyErrorHandlerWithLogger extends \Whoops\Handler\PrettyPageHandler
{
    /**
     * {@inheritDoc}
     * @see \Whoops\Handler\PrettyPageHandler::handle()
     */
    public function handle()
    {
        // エラーログ出力
        $exception = parent::getException();
        \Apricot\Log::critical($exception->getMessage(),[$exception->getFile(),$exception->getLine(), $exception->getTraceAsString()]);

        parent::handle();
    }
}