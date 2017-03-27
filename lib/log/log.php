<?php
//из https://gist.github.com/fd0a32e9e4e9fbbf9584.git
namespace log;

use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;

class Log
{
    protected static $instance;

    static public function getLogger()
    {
        if (!self::$instance) {
            self::configureInstance();
        }
        return self::$instance;
    }

    protected static function configureInstance()
    {
        $logger = new Logger('monolog');
        $handlerI = new StreamHandler('logs/info.log', Logger::INFO, false);
        $handlerI->setFormatter(new LineFormatter("%level_name%:[%datetime%] %message% \n"));
        $logger->pushHandler($handlerI);
        //$logger->pushHandler(new StreamHandler('logs/info.log', Logger::INFO, false));
        $handlerE = new StreamHandler('logs/error.log', Logger::WARNING, false);
        $handlerE->setFormatter(new LineFormatter("%level_name%:[%datetime%] %message% \n"));
        $logger->pushHandler($handlerE);
        // $logger->pushHandler(new StreamHandler('logs/error.log', Logger::WARNING, false));

        self::$instance = $logger;
    }

    public static function debug($message, array $context = [])
    {
        self::getLogger()->addDebug($message, $context);
    }

    public static function info($message, array $context = [])
    {
        self::getLogger()->addInfo($message, $context);
    }

    public static function warning($message, array $context = [])
    {
        self::getLogger()->addWarning($message, $context);
    }

    public static function error($message, array $context = [])
    {
        self::getLogger()->addError($message, $context);
    }
}
