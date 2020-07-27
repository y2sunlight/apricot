<?php
namespace Apricot;

use Apricot\Foundation\Singleton;
use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;

/**
 * Log Class - Monolog\Logger Wrapper
 *
 * @method static Logger getInstance() Gets the Logger instance.
 * @method static void emergency(string $message, array $context = []) Action must be taken immediately.
 * @method static void alert(string $message, array $context = []) Runtime errors that do not require immediate action but should typically be logged and monitored.
 * @method static void critical(string $message, array $context = []) Critical conditions.
 * @method static void error(string $message, array $context = []) Exceptional occurrences that are not errors.
 * @method static void warning(string $message, array $context = []) Normal but significant events.
 * @method static void notice(string $message, array $context = []) Interesting events.
 * @method static void info(string $message, array $context = []) User logs in, SQL logs.
 * @method static void debug(string $message, array $context = []) Logs with an arbitrary level.
 * @method static void log($level, string $message, array $context = []) Logs with an arbitrary level.
 */
class Log extends Singleton
{
    /**
     * Creates the Logger instance.
     *
     * @return \Monolog\Logger
     */
    protected static function createInstance()
    {
        $log_name = config('monolog.name');
        $log_path = config('monolog.path');
        $log_level = config('monolog.level');
        $log_max_files = config('monolog.max_files',0);

        // Creates a log handler.
        // Log format setting:
        // * Allow line breaks in log
        // * Ignore if additional information is empty
        $log_file_name = "{$log_path}/{$log_name}.log";
        $stream = new RotatingFileHandler($log_file_name, $log_max_files, $log_level);
        $stream->setFormatter(new LineFormatter(null, null, true, true));

        // Creates a log channel.
        $instance = new Logger($log_name);
        $instance->pushHandler($stream);
        return $instance;
    }

    /**
     * Logs an exception.
     *
     * @param string $level 'debug','info','notice','warning','error','critical','alert' or 'emergency
     * @param \Exception $e
     */
    public static function exception(string $level, \Exception $e)
    {
        self::getInstance()->log($level, $e->getMessage(),[$e->getFile(), $e->getLine(), $e->getTraceAsString()]);
    }
}
