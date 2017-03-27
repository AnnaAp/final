<?php


class Faq
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
            'INSERT INTO `problems` (`topic_id`,`description`,`status`,`author`,`email`,`time_create`)
              VALUES (:topic_id,:description,0,:author,:email,NOW())');

        $sth->bindValue(':topic_id', $params['topic_id'], PDO::PARAM_INT);
//        $sth->bindValue(':status', $params['status'], PDO::PARAM_INT);
        $sth->bindValue(':description', $params['description'], PDO::PARAM_STR);
        $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
        $sth->bindValue(':email', $params['email'], PDO::PARAM_STR);

        return $sth->execute();
    }


    public function addAns($params)
    {
        try {
            //$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $sth = $this->db->prepare(
                'INSERT INTO `answers` (`problem_id`,`content`,`time_create`)
                VALUES (:problem_id,:content,NOW())');
            $sth->bindValue(':problem_id', $params['id'], PDO::PARAM_INT);
            $sth->bindValue(':content', $params['content'], PDO::PARAM_STR);
            $sth->execute();

            $sth = $this->db->prepare('UPDATE `problems` SET status =:status WHERE id= :id');
            $sth->bindValue(':id', $params['id'], PDO::PARAM_INT);
            $sth->bindValue(':status', $params['status'], PDO::PARAM_INT);
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

    public function listTopicAll()
    {
        $sth = $this->db->prepare('SELECT `id` ,`name` FROM `topics` ORDER BY id');
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    public function listTop($id)
    {
        $sth = $this->db->prepare('
        SELECT p.topic_id,p.description,a.content
           FROM `problems` p, `answers` a
           WHERE
           p.topic_id =:id AND
           p.status =1 AND
           a.problem_id = p.id
           ORDER BY p.id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    //вопросы по теме
    public function listTopic($id)
    {
        $sth = $this->db->prepare('
        SELECT p.topic_id,p.id,p.description,p.status,p.time_create,t.name
           FROM `problems` p ,`topics` t
           WHERE
           p.topic_id =:id AND
           t.id =:id
           ORDER BY p.id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    public function waitList()
    {
        $sth = $this->db->prepare('SELECT p.id ,t.name ,p.description,p.author,p.time_create  FROM problems p,topics t
                                  WHERE p.status =0 AND p.topic_id =t.id
                                  ORDER BY p.time_create');
        if ($sth->execute()) {
            return $sth->fetchAll();
        }
        return false;
    }

    /**
     * Удаление
     * @param $id int
     * @return mixed
     */
    public function delete($id)
    {
        try {
            $this->db->beginTransaction();
            $sth = $this->db->prepare('DELETE FROM `answers` WHERE `problem_id` =:id');
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();

            $sth = $this->db->prepare('DELETE FROM `problems` WHERE id=:id');
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

    public function stChange($id)
    {
        $sth = $this->db->prepare('UPDATE `problems` SET status = CASE status WHEN 1 THEN 2
                                    WHEN 2 THEN 1 ELSE status END WHERE id =:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        return $sth->execute();
    }

    function move($id, $new_id)
    {
        $sth = $this->db->prepare('UPDATE `problems` SET topic_id =:new_id  WHERE id =:id');
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->bindValue(':new_id', $new_id, PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * //     * Получение одной
     * //     * @param $id int
     * //     * @return array
     * //     */
    public function find($id)
    {
        $sth = $this->db->prepare('SELECT p.id,`description`,`author`,`email`,`status`,`topic_id`,a.content
                                  FROM `problems` p LEFT JOIN answers a ON p.id=a.problem_id
                                  WHERE p.id=:id');

        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param $id int
     * @param $params array
     * @return mixed
     */
    public function update($id, $params, $ans = null)
    {
        $result = false;
        if (count($params) > 0) {
            $update = [];
            foreach ($params as $param => $value) {
                $update[] = $param . '`=:' . $param;
            }
            $sth = $this->db->prepare('UPDATE `problems` SET `' . implode(', `', $update) . ' WHERE `id`=:id');

            if (isset($params['description'])) {
                $sth->bindValue(':description', $params['description'], PDO::PARAM_STR);
            }
            if (isset($params['author'])) {
                $sth->bindValue(':author', $params['author'], PDO::PARAM_STR);
            }
            if (isset($params['email'])) {
                $sth->bindValue(':email', $params['email'], PDO::PARAM_STR);
            }
            $sth->bindValue(':id', $id, PDO::PARAM_INT);

            $result = $sth->execute();
        }
        if (empty($ans)) {
            return $result;
        } else {
            $sth = $this->db->prepare('UPDATE `answers` SET content =:content WHERE `problem_id`=:id');
            $sth->bindValue(':content', $ans, PDO::PARAM_STR);
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            return $sth->execute();
        }
    }

}
