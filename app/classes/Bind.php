<?php

namespace app\classes;

// Vínculo
// O Bind é um arquivo que cria uma lista que poderá ser acessada globalmente. Essa lista salvará informações que poderão ser utilizadas em todo o sistema
// como conexão com o banco e arquivos de configuração (config.php), obs: o arquivo config.php está sendo setado no bind no arquivo bootstrap.php
class Bind {
    private static $bind = [];

    public static function set($name, $value) {
        if(!isset(static::$bind[$name])) {
            static::$bind[$name] = $value;
        }
    }

    public static function get($name) {
        if (!isset(static::$bind[$name])) {
            throw new \Exception("Esse índice não existe no bind: {$name}");
        }
        
        return (object) static::$bind[$name];
    }
}