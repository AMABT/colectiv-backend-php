<?php

class LogService
{

    public static function info($message)
    {
        self::writeLog($message, 'info');
    }

    public static function debug($message)
    {
        self::writeLog($message, 'debug');
    }

    public static function error($message)
    {
        self::writeLog($message, 'error');
    }

    protected static function writeLog($message, $type)
    {
        file_put_contents(LOG_FOLDER . $type . '.txt', date('l jS F Y h:i:s') . ': ' . print_r($message, true) . "\n", FILE_APPEND);
    }
}