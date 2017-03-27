<?php
use log\log;

class AdminController
{
    private $model = null;
    private $twig = null;

    function __construct($db)
    {
        include 'model/Admin.php';
        $this->model = new Admin($db);
        $this->twig = include 'lib/twig.php';
    }

    public function getSignin() //авторизация
    {
        echo $this->twig->render('admin/signin.php', ['errors' => getErrors()]);
        clearErrors();
    }

    public function postSignin($params, $post) //авторизация
    {
        if ($this->model->login($post)) {
            header('Location:?/topic/list');
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }

    }

    public function getLogout()
    {
        if (session_destroy()) {
            header('Location:?/faq/index');
        }
    }

    public function getList()
    {
        if (isset($_SESSION['login'])) {
            $data = $this->model->listAll();
            echo $this->twig->render('admin/list.php', ['data' => $data, 'session' => $_SESSION]);
        } else {
            header('Location:?/admin/signin');
        }

    }

    public function getUpdate($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $data = $this->model->find($params['id']);
            echo $this->twig->render('admin/update.php', ['data' => $data, 'HTTP_REFERER' => $_SERVER['HTTP_REFERER']]);
        }
    }

    public function postUpdate($params, $post)
    {
        //var_dump($post);
        if (isset($params['id']) && is_numeric($params['id']) && isset($post['password'])) {
            $isOk = $this->model->update($params['id'], ['password' => $post['password']]);
            if ($isOk) {
                Log::info(sprintf("%s изменение пароля администратора %s (%s) ", $_SESSION['login'], $post['login'], $params['id']));
            }
        }
        header('Location:' . $post['HTTP_REFERER']);
    }

    /**
     * Форма добавление
     * @return mixed
     */
    public function getAdd()
    {
        echo $this->twig->render('admin/add.php');
    }

    /**
     * Добавление
     * @param $params array
     * @return mixed
     */
    public function postAdd($params, $post)
    {

        if (isset($post['login']) && isset($post['password'])) {
            $isOk = $this->model->add([
                'login' => $post['login'],
                'password' => $post['password'],
            ]);
            if ($isOk) {
                Log::info(sprintf("%s добавление администратора %s ", $_SESSION['login'], $post['login']));
            }
        }
        header('Location: ?/admin/list');
    }

    public function getDelete($params)
    {
        if (isset($params['id']) && is_numeric($params['id'])) {
            $isOk = $this->model->delete($params['id']);
            if ($isOk) {
                Log::info(sprintf("%s удаление администратора (%s) ", $_SESSION['login'], $params['id']));
            }
        }
        header('Location:?/admin/list');
    }
}