<?php
use log\log;

class FaqController
{
    private $model = null;
    private $twig = null;

    function __construct($db)
    {
        include 'model/Faq.php';
        $this->model = new Faq($db);
        $this->twig = include 'lib/twig.php';
    }

    public function getIndex($params)
    {
        $topics = $this->model->listTopicAll();
        $faq = array();
        foreach ($topics as $topic) {
            $faq[$topic["name"]] = $this->model->listTop($topic["id"]);
        }
        echo $this->twig->render('faq/index.php', ['topics' => $topics, 'faq' => $faq]);

    }

    /**
     * Форма добавление
     * @param $params array
     * @return mixed
     */
    public function getAdd()
    {
        $topics = $this->model->listTopicAll();
        echo $this->twig->render('faq/add.php', ['topics' => $topics]);
    }

    /**
     * Добавление
     * @param $params array
     * @return mixed
     */
    public function postAdd($params, $post)
    {
        if (!empty($post['description']) && (!empty($post['topic_id']))
            && (!empty($post['author'])) && (!empty($post['email']))
        ) {
            $isOk = $this->model->add([
                'description' => $post['description'],
                'topic_id' => $post['topic_id'],
                'author' => $post['author'],
                'email' => $post['email'],
            ]);
            if ($isOk) {
                Log::info(sprintf("добавление вопроса %s в тему(%s) ", $post['description'], $post['topic_id']));
            }

        }

        header('Location:?/faq/index'); //neto
    }

    public function getWaiting()
    {
        if (isset($_SESSION['login'])) {
            $faqs = $this->model->waitList();
            echo $this->twig->render('faq/waiting.php', ['faqs' => $faqs, 'session' => $_SESSION]);
        } else {
            header('Location:?/admin/signin');
        }
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
                Log::info(sprintf("%s удаление вопроса (%s) ", $_SESSION['login'], $params['id']));
            }
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function getChange($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $isDelete = $this->model->stChange($params['id']);

            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    /**
     * Форма редактирование данных
     * @param $id
     */
    public function getUpdate($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $data = $this->model->find($params['id']);
            echo $this->twig->render('faq/update.php', ['data' => $data, 'HTTP_REFERER' => $_SERVER['HTTP_REFERER']]);
        }
    }

    /**
     * Изменение данных о
     * @param $id
     * description`,`author`,`email`,`status`,a.content
     */
    public function postUpdate($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $updateParam = [];
            $updateAns = '';
            if (isset($post['description'])) {
                $updateParam['description'] = $post['description'];
            }
            if (isset($post['author'])) {
                $updateParam['author'] = $post['author'];
            }
            if (isset($post['email'])) {
                $updateParam['email'] = $post['email'];
            }
            if (isset($post['content'])) {
                $updateAns = $post['content'];
            }
            $isOk = $this->model->update($params['id'], $updateParam, $updateAns);
            if ($isOk) {
                Log::info(sprintf("%s изменение вопроса '%s' (%s) ", $_SESSION['login'], $post['description'], $params['id']));
            }
        }
        header('Location:' . $post['HTTP_REFERER']);
    }

    public function getMove($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $data = $this->model->find($params['id']);
            $topics = $this->model->listTopicAll();
            echo $this->twig->render('faq/move.php', ['data' => $data, 'topics' => $topics, 'params' => $params, 'HTTP_REFERER' => $_SERVER['HTTP_REFERER']]);
        }
    }

    public function postMove($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id']) && isset($post['topic_id']) && isset($post['old_id'])) {
            if ($post['topic_id'] != $post['old_id']) {
                $isOk = $this->model->move($params['id'], $post['topic_id']);
                if ($isOk) {
                    Log::info(sprintf("%s перемещение вопроса (%s)из темы (%s) в тему (%s) ", $_SESSION['login'], $params['id'], $post['old_id'], $post['topic_id']));
                }
            }
        }
        header('Location:' . $post['HTTP_REFERER']);
    }

    public function getList($params)
    {
        if (isset($_SESSION['login'])) {
            $topics = $this->model->listTopicAll(); //список тем
            $data = $this->model->listTopic($params['id']); //вопросы по теме

            echo $this->twig->render('faq/list.php', ['data' => $data, 'topics' => $topics, 'params' => $params, 'session' => $_SESSION]);
        } else {
            header('Location:?/admin/signin');
        }

    }

    public function postList($params, $post)
    {
        if (isset($post['topic_id'])) {
            header('Location:?/faq/list/id/' . $post['topic_id']);
        } else {
            header('Location:?/faq/list/id/0');
        }
    }

    public function getList_($params)
    {
        if (isset($_SESSION['login'])) {
            $data = $this->model->listTopic($params['id']);
            echo $this->twig->render('faq/list.php', ['data' => $data, 'params' => $params, 'session' => $_SESSION]);
        } else {
            header('Location:?/admin/signin');
        }

    }

    public function getAnswer($params)
    {
        //  var_dump($_SERVER);
        if (isset($params['id']) && is_numeric($params['id'])) {
            $data = $this->model->find($params['id']);
            echo $this->twig->render('faq/answer.php', ['data' => $data, 'HTTP_REFERER' => $_SERVER['HTTP_REFERER']]);
        }
    }

    public function postAnswer($params, $post)
    {
        if (isset($params['id']) && is_numeric($params['id']) &&
            isset($post['content']) && isset($post['status']) && is_numeric($post['status'])
        ) {
            $isOk = $this->model->addAns([
                'id' => $params['id'],
                'content' => $post['content'],
                'status' => $post['status'],
            ]);
            if ($isOk) {
                Log::info(sprintf("%s добавление ответа на вопрос (%s) ", $_SESSION['login'], $params['id']));
            }
        }
        header('Location:' . $post['HTTP_REFERER']);
    }

}