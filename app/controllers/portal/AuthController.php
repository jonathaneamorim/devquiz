<?php

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\User;

class AuthController extends ContainerController{

    private $user;

    public function __construct() {
        $this->user = new User();
    }

    public function index() {
        header('Location: /auth/login');
        exit;
    }

    public function register() {
        if($this->isLogged()) {
            header('Location: /quiz');
            exit;
        } 
        $this->view([
            'title' => 'DevQuiz - Cadastro',
            'logged' => false,
        ], 'portal.cadastro');
    }

    public function login() {
        if($this->isLogged()) {
            header('Location: /quiz');
            exit;
        } 
        $this->view([
            'title' => 'DevQuiz - Login',
            'logged' => false,
        ], 'portal.login');
    }

    public function autenticar() {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $userFound = $this->user->findByEmail($email);

        if ($userFound) {
            if(password_verify($senha, $userFound->senha)) {
                $_SESSION['usuario'] = [
                    'id' => $userFound->id,
                    'nome' => $userFound->nome,
                    'email' => $userFound->email,
                    'isAdmin' => $userFound->isAdmin
                ];

                http_response_code(200);
                echo 'Usuário Logado!';
                exit;
            } 

            http_response_code(401);
            echo 'Senha Incorreta!';
            exit;
        }

        http_response_code(404);
        echo 'Email de usuário não cadastrado!';
        exit;
    }

    public function logout() {
        session_destroy();
        header('Location: /auth/login');
        exit;
    }

    public function registrar() {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        User::findByEmail($email);

        $verifica = $this->user->findByEmail($email);
    
        if ($verifica) {
            http_response_code(400);
            echo 'Esse e-mail já está registrado!';
            exit;
        }
    
        $this->user->addNewUser($nome, $email, $senha);
        $user = $this->user->findByEmail($email);

        $_SESSION['usuario'] = [
            'id' => $user->id, 
            'nome' => $user->nome,
            'email' => $user->email
        ];
        http_response_code(201);
        echo 'Cadastro realizado com sucesso!';
        exit;
    }
}