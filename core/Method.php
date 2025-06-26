<?php

namespace core;

use app\classes\Uri;
use app\exceptions\MethodNotExistsException;

class Method {
    private $uri;

    public function __construct() {
        $this->uri = Uri::uri();
    }

    public function load($controller) {
        $method = $this->getMethod();
        // Verifica se o method (função de uma classe X existe)
        // Nesse caso verifica se o method existe na classe $controller
        if (!method_exists($controller, $method)) {
            throw new MethodNotExistsException("Esse método não existe: {$method}");
        }

        return $method;
    }

    private function getMethod() {
        if(substr_count($this->uri,'/') > 1) {
            list($controller, $method) = array_values(array_filter(explode('/', $this->uri)));
            return $method;
        }

        return 'index';
    }   
}