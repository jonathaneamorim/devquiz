<?php

namespace app\controllers\portal;

use app\controllers\ContainerController;
use app\models\portal\User;

class AuthController extends ContainerController{

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
        $user = User::findByEmail($email);

        if ($user) {
            if(password_verify($senha, $user->senha)) {
                $_SESSION['usuario'] = [
                    'id' => $user->id,
                    'nome' => $user->nome,
                    'email' => $user->email,
                    'isAdmin' => $user->isAdmin
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
    
        $verifica = User::findByEmail($email);
    
        if ($verifica) {
            http_response_code(400);
            echo 'Esse e-mail já está registrado!';
            exit;
        }
    
        User::addNewUser($nome, $email, $senha);
        $user = User::findByEmail($email);

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