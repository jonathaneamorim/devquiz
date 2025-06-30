<?php

namespace app\models\portal;

use app\models\Model;
use app\classes\Bind;

class User extends Model {
    
    protected $table = 'usuario';

    // Why use self::$table: https://stackoverflow.com/questions/2350937/php-fatal-error-using-this-when-not-in-object-context
    public function findByEmail($email) {
        try {
            $connection = $this->connection;
            $stmt = $connection->prepare("SELECT * FROM $this->table WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log('Erro ao encontrar usuário por email: '. $e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $connection = Bind::get('connection');
            $stmt = $connection->prepare("SELECT * FROM $this->table WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            return $stmt->fetch();

        } catch(PDOException $e) {
            error_log('Erro em ao encontrar usuário: ' . $e->getMessage());
            return false;
        }
    }

    public static function addNewUser($nome, $email, $senha) {
        try {
            $connection = Bind::get('connection');
            $stmt = $connection->prepare("INSERT INTO $this->table (id, nome, email, senha) VALUES (UUID(), :nome, :email, :senha)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            
            $stmt->execute();
        } catch (PDOException $e) {
            // Exibe ou registra o erro
            echo "Erro ao inserir usuário: " . $e->getMessage();
        }
        
    }
    
}