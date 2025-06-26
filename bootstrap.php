<?php 

require "vendor/autoload.php";

use app\classes\Bind;
use app\models\Connection;

// A variável config está recebendo o retorno do arquivo config.php
$config = require "config.php";

// O método set da classe bind 
// A variável config estará disponível em qualquer parte do sistema, devido a inserção no arquiov composer.json 
Bind::set('config', $config);
Bind::set('connection', Connection::connect());