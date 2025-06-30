<?php

namespace app\models\portal;

use app\models\Model;
use app\classes\Bind;

class Quiz extends Model {
    
    protected $table = 'quiz';

    public function newQuiz($titulo, $descricao, $userId) {
        try {
            $connection = Bind::get('connection');
            $stmt = $connection->prepare("INSERT INTO $this->table (titulo, descricao, criadoPor, criadoEm) VALUES (:titulo, :descricao, :userId, NOW())");
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();
            return true;
        } catch(PDOException $e) {
            error_log('Erro ao inserir novo quiz: ', $e);
            return false;
        }
    }
    
}