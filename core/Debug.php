<?php
namespace Apricot;

use Apricot\Foundation\CallStatic;

/**
 * Debug Class - LoggerInterface Wrapper
 *
 * @method static \Psr\Log\LoggerInterface getInstance()
 * @method static void debug($message, array $context = array())
 * @method static void info($message, array $context = array())
 * @method static void notice($message, array $context = array())
 * @method static void warning($message, array $context = array())
 * @method static void error($message, array $context = array())
 * @method static void critical($message, array $context = array())
 * @method static void alert($message, array $context = array())
 * @method static void emergency($message, array $context = array())
 * @method static void log($level, $message, array $context = array())
 */
class Debug extends CallStatic
{
    /**
     * Create Debug instance.
     * @return \Psr\Log\LoggerInterface
     */
    public static function getInstance()
    {
        // DebugBarの作成
        return DebugBar::getCollector('messages');
    }
}