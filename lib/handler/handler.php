<?php

namespace handler;

use Exception;
use ErrorException;
use log\log;

class handler
{
    /**из https://github.com/illuminate/exception/blob/master/Handler.php
     */
    public function register()
    {
        $this->registerErrorHandler();
        $this->registerExceptionHandler();
    }

    /**
     * Register the PHP error handler.
     *
     * @return void
     */
    protected function registerErrorHandler()
    {
        set_error_handler(array($this, 'handleError'), E_ALL);
    }

    /**
     * Register the PHP exception handler.
     *
     * @return void
     */
    protected function registerExceptionHandler()
    {
        set_exception_handler(array($this, 'handleUncaughtException'));
    }
    /**
     * Register the PHP shutdown handler.
     *
     * @return void
     */
    /**
     * Handle a PHP error for the application.
     *
     * @param  int $level
     * @param  string $message
     * @param  string $file
     * @param  int $line
     * @param  array $context
     *
     * @throws \ErrorException
     */
    public function handleError($level, $message, $file = '', $line = 0, $context = array())
    {
        if (error_reporting() & $level) {
            throw new ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Handle an uncaught exception.
     *
     * @param  \Exception $exception
     */
    public function handleUncaughtException($e)
    {
        error_log($e->__toString());
        Log::error("handler:" . $e->__toString());
        echo 'FAQ временно недоступен';
    }

}