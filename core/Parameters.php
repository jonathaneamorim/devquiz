<?php

namespace core;

use app\classes\Uri;

class Parameters {

    private $uri;

    public function __construct() {
        $this->uri = Uri::uri();
    }

    public function load() {
        return $this->getParameter();
    }

    private function getParameter() {
        // Verifica se a URI possui mais de duas barras, pois se tiver, possuirá parametros EX: /curso/show/curso-php 
        if(substr_count($this->uri,'/') > 2) {
            $parameter = array_values(array_filter(explode('/', $this->uri)));
            return(object) [
                // filter_var: Método que filtra qualquer código malicioso passado dentro da URL - (Evita sql injection e entre outros)
                'parameter' => filter_var($parameter[2], FILTER_SANITIZE_STRING),
                'next' => filter_var($this->getNextParameter(2), FILTER_SANITIZE_STRING)
            ];
        }
    }

    private function getNextParameter($actual) {
        $parameter = array_values(array_filter(explode('/', $this->uri)));

        return $parameter[$actual+1] ?? $parameter[$actual];
    }
}