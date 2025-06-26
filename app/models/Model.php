<?php

namespace app\models;

use app\classes\Bind;

// Todos os models criados deverão ser estendidos de Model
// Aqui estarão itens que deverão ser utilizados em todos os arquivos model, ex: Conexão com o banco de dados para gerar tabelas
abstract class Model {

    protected $connection;

    public function __construct() {
        $this->connection = Bind::get('connection');
    }

    public function all() {
        $sql = "SELECT * FROM {$this->table}";
        $list = $this->connection->query($sql);
        $list->execute();

        return $list->fetchAll();
    }

}