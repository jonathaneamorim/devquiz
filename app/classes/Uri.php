<?php 

namespace app\classes;

class Uri {
    // Método somente para pegar a URI da página
    public static function uri() {
        // Utilizar uma função padrão do PHP para capturar URI do servidor
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}