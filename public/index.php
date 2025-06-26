<?php

require "../bootstrap.php";

use core\Controller;
use core\Method;
use core\Parameters;

// https://devclass.com.br/curso/show/12

// dd(app\classes\Uri::uri());

try {
    // Capturar primeiro slug (curso)
    $controller = new Controller;
    $controller = $controller->load();

    $method = new Method;
    $method =  $method->load($controller);

    $parameters = new Parameters;
    $parameters = $parameters->load($controller);

    $controller->$method($parameters);
}catch(Exception $e) {
    dd($e->getMessage());
}

// Capturar segundo slug (show)
// $method = new Method;
// $method = $method->getMethod();

// // Capturar parâmetros (12)
// $parameters = new Parameters;
// $parameters = $parameters->getParamenters();

// // Capturar /controller/metodo/parametro - /curso/show/12
// $controller->$method($parameters); 