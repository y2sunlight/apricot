<?php
namespace Apricot;

use Apricot\Foundation\CallStatic;

/**
 * Debug Class - LoggerInterface Wrapper
 *
 * @method static \Psr\Log\LoggerInterface getInstance() Gets the LoggerInterface instance.
 * @method static void debug($message, array $context = array()) Detailed debug information.
 * @method static void info($message, array $context = array()) Interesting events.
 * @method static void notice($message, array $context = array()) Normal but significant events.
 * @method static void warning($message, array $context = array()) Exceptional occurrences that are not errors.
 * @method static void error($message, array $context = array()) Runtime errors that do not require immediate action but should typically be logged and monitored.
 * @method static void critical($message, array $context = array()) Critical conditions.
 * @method static void alert($message, array $context = array()) Action must be taken immediately.
 * @method static void emergency($message, array $context = array()) System is unusable.
 * @method static void log($level, $message, array $context = array()) Logs with an arbitrary level.
 */
class Debug extends CallStatic
{
    /**
     * Creates the Debug instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public static function getInstance()
    {
        return DebugBar::getCollector('messages');
    }
}