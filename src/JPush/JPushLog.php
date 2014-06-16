<?php
/**
 * Created by PhpStorm.
 * User: xiezefan
 * Date: 14-6-16
 * Time: 下午3:39
 */

namespace JPush;

use Monolog\Logger;

/**
 * Class JPushLog
 * @package JPush
 */
class JPushLog {
    const DEFAULT_UA_LOG_NAME = "JPush";

    private static $logHandlers;

    /**
     * Add log handlers to tailor logging for your use case. Default logging
     * is the Monolog default, a Monolog StreamHandler('php://stderr', static::DEBUG)
     * Use Monolog NullHandler to disable all logging.
     * @param $handlers
     */
    public static function setLogHandlers($handlers)
    {
        self::$logHandlers = $handlers;
    }

    /**
     * Get the current log handler array
     * @return mixed
     */
    public static function getLogHandlers()
    {
        return self::$logHandlers;
    }

    /**
     * Returns the logger for standard logging in the library
     * @return Logger
     */
    public static function getLogger()
    {
        if (!self::$logHandlers) {
            self::setLogHandlers(array());
        }
        return new Logger(self::DEFAULT_UA_LOG_NAME, self::$logHandlers);
    }

} 