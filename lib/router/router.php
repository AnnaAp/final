<?php

namespace router;

use \exceptions\myException;

class router
{
    protected $dirController = '';
    protected $dirProject = '';
    protected $db = '';
    protected $routes = array();


    function __construct($db, $dirProject)
    {
        $this->db = $db;
        $this->dirController = 'controller/';
        $this->dirProject = $dirProject;

        $this->routes = array(
            // 'url' => 'контроллер/действие/
            '/' => 'Admin/signin',
            '/faq' => 'Faq/index' //neto - на работает??
        );

    }

    public function run()
    {
        $requestedUrl = $_SERVER["REQUEST_URI"];

        if (strpos($requestedUrl, '?') === false) {
            $requestedUrl = str_replace($this->dirProject, '', $requestedUrl);
            if (isset($this->routes[$requestedUrl])) { //есть маршрут?
                $route = $this->routes[$requestedUrl];
            } else {
                $route = $requestedUrl;
            }
        } else {
            $route = urldecode(substr(strstr($requestedUrl, '?'), 1));
        }

        $pathList = preg_split('/\//', $route, -1, PREG_SPLIT_NO_EMPTY);
        $controller = isset($pathList[0]) ? $pathList[0] : 'faq';
        $action = isset($pathList[1]) ? $pathList[1] : 'index';
        $pathList = array_slice($pathList, 2);
        $params = [];
        foreach ($pathList as $i => $value) {
            if ($i % 2 == 0 && isset($pathList[$i + 1])) {
                $params[$pathList[$i]] = $pathList[$i + 1];
            }
        }

        $controllerText = $controller . 'Controller';
        $controllerFile = $this->dirController . ucfirst($controllerText) . '.php';
//echo $controllerFile;
        if (is_file($controllerFile)) {
            include $controllerFile;
            if (class_exists($controllerText)) {
                $control = new $controllerText($this->db);
                $action = ($_SERVER['REQUEST_METHOD'] == 'POST' ? 'post' : 'get') . ucfirst($action);
                //echo 'action:'.$action;echo "<br/>";

                if (method_exists($control, $action)) {
                    $control->$action($params, $_POST);
                } else {
                    throw new myException("Ошибка маршрута -метод: " . $controllerText . '/' . $action);
                }
            } else {
                throw new myException("Ошибка маршрута -class: " . $controllerText);
            }
        } else {
            throw new myException("Ошибка маршрута -файл: " . $controllerFile);
        }

    }


}