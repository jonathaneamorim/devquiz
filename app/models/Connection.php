<?php

namespace app\models;

use app\classes\Bind;
use PDO;
use PDOException;

class Connection {
    public static function connect() {
        $config = Bind::get('config');
        $config->database = (object) $config->database;
        $db = $config->database;
       /*
       * Definindo a conexão com banco de dados
       * First attribute = connection info
       * Second attribute = username
       * Third attribute = password
       */

        try {
            $dsn = "mysql:host={$db->host};dbname={$db->dbname};charset={$db->charset}";
            $pdo = new PDO(
                $dsn,
                $db->username,
                $db->password,
                $db->options
            );
            /*
            * Configurações recomendadas para o PDO:
            * Acima essas configurações são passadas no parâmetro $db->options
            *
            * - PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            *   Define que erros com a conexão ou execução de queries devem lançar exceções.
            *
            * - PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            *   Define o modo padrão de recuperação de dados como objetos (ex: $user->name).
            *   Caso prefira arrays associativos, use PDO::FETCH_ASSOC (ex: $user['name']).
            *
            * - Exemplos de uso:
            *   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            *   $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            */

            return $pdo;

        } catch (PDOException $e) {
            // Realizar tratamento de erros
            throw new \Exception("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }
}
