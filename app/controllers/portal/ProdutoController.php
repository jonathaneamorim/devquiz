<?php

namespace app\controllers\portal;

use app\controllers\ContainerController;

class ProdutoController extends ContainerController{
    public function index() {

    }

    public function create() {

    }

    public function store() {

    }

    public function show() {
        // dentro do método view, pegar na pasta portal o arquivo cursos.html
        $this->view([
            'title' => 'Produto',
        ],'portal.produto');
    }

    public function edit($id) {
        
    }
}