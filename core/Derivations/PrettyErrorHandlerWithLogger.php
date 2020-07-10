<?php
namespace Core\Derivations;

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
        \Core\Log::critical($exception->getMessage(),[$exception->getFile(),$exception->getLine(), $exception->getTraceAsString()]);

        parent::handle();
    }
}