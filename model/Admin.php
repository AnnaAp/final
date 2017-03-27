<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.03.17
 * Time: 20:28
 */
class Admin
{
    private $db = null;

    function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Добавление
     * @param $params array
     * @return mixed
     */
    public function add($params)
    {
        $sth = $this->db->prepare(
            'INSERT INTO users (login,password) VALUES (:login,:password)');

        $sth->bindValue(':login', $params['login'], PDO::PARAM_STR);
        $sth->bindValue(':password', md5($params['password']), PDO::PARAM_STR);

        return $sth->execute();
    }

    public function find($id)
    {
        $sth = $this->db->prepare('SELECT `id`,`login` FROM `users` WHERE id=:id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * Удаление
     * @param $id int
     * @return mixed
     */
    public function delete($id)
    {
        $sth = $this->db->prepare('DELETE FROM `users` WHERE id=:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    public function listAll()
    {
        $sth = $this->db->prepare('SELECT `id` ,`login` FROM `users` ORDER BY id');
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    public function update($id, $params)
    {
        if (isset($params['password'])) {

            $sth = $this->db->prepare('UPDATE `users` SET `password` = :password WHERE `id`=:id');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->bindValue(':password', md5($params['password']), PDO::PARAM_STR);

            return $sth->execute();
        } else {
            return false;
        }
    }

    public function exists($login, $password)
    {
        $id = -1;
        $sth = $this->db->prepare('SELECT `id` FROM `users` WHERE `login`=:login AND (`password` =:password) ');
        $sth->bindValue(':login', $login, PDO::PARAM_STR);
        $sth->bindValue(':password', $password, PDO::PARAM_STR);
        $sth->execute();
        $res = $sth->fetchAll();
        if (count($res) == 1) {
            $id = $res[0]['id'];
        }
        return $id;
    }

    public function login($post)
    {
        $login = $post['login'];
        $psw = md5($post['password']);
        $id = $this->exists($login, $psw);
        if ((int)$id < 1) {
            setErrors('Пользователь ' . $login . ' с таким паролем не существует');
            return false;
        } else {
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
            return true;
        }
    }


}