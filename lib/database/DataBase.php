<?php
namespace database;

use PDO as PDO;

class DataBase
{
    /**
     * Подключение к базе данных mysql
     * @param $host адрес
     * @param $dbname название базы
     * @param $user пользователь
     * @param $pass пароль
     */

    public static function connect($host, $dbname, $user, $pass)
    {
        $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
        $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8', $user, $pass, $opt);
        //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}
