<?php

namespace app\controllers\portal;
use app\controllers\ContainerController;

class CursoController extends ContainerController{
    public function index(){
        dd('index');
    }

    public function create() {
    }

    public function store() {

    }

    public function show($request) {

        // $curso = new app\models\portal\Cursos;
        // $cursoEncontrado = $curso->find('slug', $request->parameter);

        // dentro do método view, pegar na pasta portal o arquivo cursos.html
        $this->view([
            'title' => 'Curso',
            'curso' => $cursoEncontrado
        ],'portal.curso');
    }

    public function edit($id) {
        
    }
}