<?php


class Logger {

    public static function write($message) {
        $logFile = 'pos.log';
        $logMessage = "[" . date('Y-m-d H:i:s') . "]" . PHP_EOL . $message . PHP_EOL . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    public static function dump($var) {
        $logFile = 'pos.log';
        $logMessage = "[" . date('Y-m-d H:i:s') . "]" . PHP_EOL . print_r($var, true) . PHP_EOL . PHP_EOL;
        file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

}