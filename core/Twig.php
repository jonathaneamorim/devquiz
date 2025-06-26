<?php

namespace core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\String\StringExtension;
use Twig\TwigFunction;

class Twig {
    private $twig;
    private $functions = [];

    public function loadTwig() {
        $this->twig = new Environment($this->loadViews(), [
            'debug' => true, // Mostrar erros durante o desenvolvimento
            // 'cache' => '/cache', // Se quiser trabalhar com cash habilitar
            'auto_reload' => true, // Recarrega templates automaticamente se eles mudarem
        ]);

        return $this->twig;
    }

    private function loadViews() {
        // __DIR__ . '/../app/views' é um caminho mais robusto, pois é relativo ao arquivo atual
        return new FilesystemLoader(__DIR__ . '/../app/views');
    }

    public function loadExtensions() {
        $this->twig->addExtension(new StringExtension());
    }

    private function functionsToView($name, \Closure  $callback) {
        return new TwigFunction($name, $callback);
    }

    public function loadFunctions() {
        require '../app/functions/twig.php';
        
        /*
            O trecho $key=>$value em um foreach significa: "Para cada elemento do array $this->functions, atribui a chave à variável $key e o valor correspondente à variável $value".
            No seu caso específico, está percorrendo um array de funções do Twig onde $key é o nome/identificador da função e $value é o objeto TwigFunction que será adicionado ao ambiente Twig.
        */
        foreach ($this->functions as $key=>$value) {
            $this->twig->addFunction($this->functions[$key]);
        }
    }
}