<?php

class Topic
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
        if (empty($params['name'])) {
            return false;
        }
        $sth = $this->db->prepare(
            'INSERT INTO `topics` (`name`) VALUES (:name)');
        $sth->bindValue(':name', $params['name'], PDO::PARAM_STR);
        return $sth->execute();
    }

    public function delete($id)
    {
        try {
            //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $sth = $this->db->prepare(
                'DELETE FROM `answers` WHERE `problem_id` IN(SELECT `id` FROM `problems` WHERE `topic_id` =:id)');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();

            $sth = $this->db->prepare('DELETE FROM `problems` WHERE `topic_id`=:id');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();

            $sth = $this->db->prepare('DELETE FROM `topics` WHERE id=:id');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->__toString());
            return false;
            //echo "Ошибка: " . $e->getMessage();
        }
    }

    /**
     * @param $id int
     * @param $params array
     * @return mixed
     */
    public function update($id, $params)
    {
        if (empty($params['name'])) {
            return false;
        }
        $sth = $this->db->prepare('UPDATE `topics` SET `name` = :name WHERE `id`=:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->bindValue(':name', $params['name'], PDO::PARAM_STR);

        return $sth->execute();
    }

    /**
     * Получение всех
     * @return array
     */
    public function listAll()
    {
        $sth = $this->db->prepare('SELECT t.id ,t.name,
        (SELECT count(p.id) FROM `problems` p WHERE p.topic_id =t.id ) qw_all,
        (SELECT count(p.id) FROM `problems` p WHERE p.topic_id =t.id AND p.status=1) qw_pb,
        (SELECT count(p.id) FROM `problems` p WHERE p.topic_id =t.id AND p.status=0) qq_wt
        FROM `topics` t ORDER BY t.id');

        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    /**
     * Получение одной
     * @param $id int
     * @return array
     */
    public function find($id)
    {
        $sth = $this->db->prepare('SELECT `id`,`name` FROM `topics` WHERE id=:id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

}