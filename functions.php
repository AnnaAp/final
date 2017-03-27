<?php
use log\log;

function setErrors($msg)
{
    $_SESSION['error'][] = $msg;
}

function getErrors()
{
    return isset($_SESSION['error']) ? $_SESSION['error'] : [];
}

function clearErrors()
{
    unset($_SESSION['error']);
}

function libAutoload($classNameWithNameSpace)
{
    $pathToFile = __DIR__ . '/lib' . str_replace('\\', DIRECTORY_SEPARATOR, '\\' . $classNameWithNameSpace) . '.php';
    if (file_exists($pathToFile)) {
        include $pathToFile;
    }
}





