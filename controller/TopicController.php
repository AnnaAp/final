<?php
use log\log;

class TopicController
{
    private $model = null;
    private $twig = null;

    function __construct($db)
    {
        include 'model/Topic.php';
        $this->model = new Topic($db);
        $this->twig = include 'lib/twig.php';
    }

    public function getList($params)
    {
        if (isset($_SESSION['login'])) {
            $topics = $this->model->listAll();
            echo $this->twig->render('topic/list.php', ['topics' => $topics, 'session' => $_SESSION]);
        } else {
            header('Location:?/admin/signin');
        }
    }

    /**
     * Форма добавление
     * @return mixed
     */
    public function getAdd()
    {
        echo $this->twig->render('topic/add.php');
    }

    /**
     * Добавление
     * @param $params array
     * @return mixed
     */
    public function postAdd($params, $post)
    {
        $updateParam = [];

        if (!empty($post['name'])) {
            $isOk = $this->model->add([
                'name' => $post['name'],
            ]);
            if ($isOk) {
                Log::info(sprintf("%s добавление темы %s ", $_SESSION['login'], $post['name']));
            }
        }
        header('Location: ?/topic/list');
    }

    /**
     * Удаление
     * @param $id
     */
    public function getDelete($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $isOk = $this->model->delete($params['id']);
            if ($isOk) {
                Log::info(sprintf("%s удаление темы (%s) ", $_SESSION['login'], $params['id']));
            }
        }
        header('Location:?/topic/list');
    }
}