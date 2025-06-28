<?php 

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\Quiz;

class QuizController extends ContainerController {
    public function index() {
        if(!$this->isLogged()) {
            header('Location: /auth/login');
            exit;
        }
        $quiz = new Quiz;
        $quizzes = $quiz->all();
        $session = $this->getSession();
        
        $this->view([
            'title' => 'DevQuiz - Quizzes',
            'logged' => true,
            'isAdmin' => isAdmin($session['id'])
        ], 'portal.quiz');
    }

    public function create() {
        if(!isAdmin($_SESSION['usuario']['id'])) {
            header('Location: /quiz');
            exit;
        }
        $this->view([
            'titulo' => 'DevQuiz - Novo',
            'logged' => true,
        ], 'portal.novoQuiz');
    }

    public function store() {
        
    }

    public function show() {
        $quiz = new Quiz;
        $quizzes = $quiz->all();
        header('Content-Type: application/json');
        echo json_encode($quizzes);
    }

    public function edit($id) {
        
    }
}