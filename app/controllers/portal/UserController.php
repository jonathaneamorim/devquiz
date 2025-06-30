<?php 

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\User;

class UserController extends ContainerController {

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        if(!$this->isLogged()) {
            header('Location: /auth/login');
            exit;
        }
        $session = $this->getSession();
        $isAdmin = $this->isAdmin($session['id']);
        
        $this->view([
            'title' => 'DevQuiz - Perfil',
            'logged' => true,
            'isAdmin' => $isAdmin
        ], 'portal.quiz');
    }
}