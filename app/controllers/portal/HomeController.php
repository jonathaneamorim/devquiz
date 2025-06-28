<?php

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\Quiz;

class HomeController extends ContainerController{
    public function index(){
        if($this->isLogged()) {
            header('Location: /quiz');
            exit;
        } else {
            header('Location: /auth/login');
            exit;
        }
    }
}