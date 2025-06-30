<?php 

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\Quiz;

class QuizController extends ContainerController {

    private $quiz;

    public function __construct() {
        $this->quiz = new Quiz();
    }

    public function index() {
        if(!$this->isLogged()) {
            header('Location: /auth/login');
            exit;
        }
        $session = $this->getSession();
        $isAdmin = $this->isAdmin($session['id']);
        
        $this->view([
            'title' => 'DevQuiz - Quizzes',
            'logged' => true,
            'isAdmin' => $isAdmin
        ], 'portal.quiz');
    }

    public function new() {
        $session = $this->getSession();
        $isAdmin = $this->isAdmin($session['id']);
        if(!$isAdmin) {
            header('Location: /quiz');
            exit;
        }
        $this->view([
            'titulo' => 'DevQuiz - Novo',
            'logged' => true,
        ], 'portal.novoQuiz');
    }

    public function create() {
        try {
            $titulo = $_POST['titulo'];
            $descricao = $_POST['descricao'];
            $session = $this->getSession();
            $userId = $session['id'];

            if($this->quiz->newQuiz($titulo, $descricao, $userId)) {
                http_response_code(201);
                echo 'Quiz cadastrado com sucesso!';
                exit;
            } else {
                http_response_code(400);
                echo 'Erro ao cadastrar quiz';
                exit;
            }
        } catch(Exception $e) {
            error_log('Erro ao criar novo quiz: ', $e);
            http_response_code(400);
            echo 'Erro ao cadastrar quiz';
            exit;
        }
    }

    public function quizadminlist($userId) {
        
    }

    // Rota para o getQuizzes (Listagem de quizzes) /quiz/show
    public function show() {
        $quizzes = $this->quiz->all();
        header('Content-Type: application/json');
        echo json_encode($quizzes);
    }

    public function edit($id) {
        
    }
}