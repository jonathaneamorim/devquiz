<?php 

namespace app\controllers;

use app\traits\TView;
use app\models\portal\User;

// Container onde serão guardados recursos base para todos os outros controllers
abstract class ContainerController {
    use TView;


    public function getSession() {
        return $_SESSION['usuario'];
    }

    public function isLogged() {
        return isset($_SESSION['usuario']);
    }

    public function isAdmin($id) {
        $user = new User();
        $userFound = $user->findById($id);
        return $userFound->isAdmin;
    }
}