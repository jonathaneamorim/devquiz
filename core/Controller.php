<?php

namespace core;

use app\classes\Uri;
use app\exceptions\ControllerNotExistsException;

// Precisamos capturar a URI da página 
// URI são os parâmetros depois da url ex: /curso/show/12
// Necessário uma classe especifica para trabalhar com a URI por fins de organização
class Controller {

    private $uri; // Variável local utilizada para guardar informação da URI atual
    private $controller; // Variável local utilizada para guardar informação da controller atual
    private $namespace; // Variável local utilizada para guardar informação do namespace atual
    
    // Variável local utilizada para mapear as pastas onde estarão localizadas as controllers do sistema, armazenado-as em lista
    private $folders = [
        'app\controllers\portal',
        'app\controllers\admin'
    ];

    public function __construct() {
        $this->uri = Uri::uri();
    }

    // Método que verifica se a página atual é a home, caso não seja executa o método controllerNotHome
    // Se a controller for a home ele executa o método controllerHome
    public function load() {
        if($this->isHome()) {
            return $this->controllerHome();
        }

        return $this->controllerNotHome();
    }

    // O método controllerHome primeiro verificará se existe a controller HomeController, caso ela não exista irá lançar uma exceção do tipo
    // ControllerNotExistsException (Criada manualmente). Caso a home controller exista, ele executará o método instantiateController
    private function controllerHome() {
        if(!$this->controllerExists('HomeController')) { // Se não existir a home controller, lança uma exceção do tipo ControllerNotExistsException
            throw new ControllerNotExistsException('Esse controller não existe!');
        }

        return $this->instantiateController(); // Se ela existe retorna a função instantiateController()
    }

    // Toda vez que a URI aberta não for a '/', sera chamado o método controllerNotHome
    // Método utilizado apenas para instanciar o controller
    private function controllerNotHome() {
        $controller = $this->getControllerNotHome();
        if(!$this->controllerExists($controller)) {
            throw new ControllerNotExistsException('Esse controller não existe!');
        }
        return $this->instantiateController();
        // Chamada a função die dump 
        // ucfirst: Transforma a primeira letra de uma string em UPPERCASE
        // ltrim: recebe 2 parâmetros, a string e um caractere para remover da string
        // dd(ucfirst(ltrim($this->uri, '/')).'Controller');
    }

    // Utilizado para a lógica do getController
    private function getControllerNotHome() {
        // O método nativo do php "substr_count" é usado para contar quantas vezes um caractere se repete em uma string 
        // Recebe até 4 parâmetros, sendo eles os mais comuns
        // O primeiro (haystack): O palheiro (a string)
        // A segunda (needle): A Agulha (o que deseja encontrar na string)
        // O condicional abaixo basicamente verifica se o caractere '/' se repete mais de uma vez na URI por exemplo (https://devclass.com.br/curso/show/12)
        if(substr_count($this->uri,'/') > 1) {
            /*  
            * A variável $explode está recebendo o valor de um array que passa por outras 2 funções.
            * A primeira é o array_filter que basicamente funciona como um foreach que recebe um array e uma função de callback (uma função definida a cada elemento)
            * se a função retornar true, o elemento é mantido no novo array resultado, caso contrário ele é descartado - Se ela retornar false (ou qualquer valor que seja avaliado como false em um contexto booleano, como 0, null, "", []), o elemento será excluído do novo array.
            * Se nenhum callback for fornecido, array_filter() removerá automaticamente todos os elementos do array que avaliam para false (ou seja, false, null, 0, "" (string vazia), e um array vazio []).
            * 
            * A segunda é o array_values que recebe um array como parâmetro, ela retorna todos os valores de um array, reindexando numericamente o novo array resultante.
            * A função retorna um novo array numericamente indexado (começando do índice 0) contendo todos os valores do array de entrada. As chaves originais do array de entrada são descartadas.
            * 
            * O construção list atribui o valor de um array para variáveis, nesse caso, como só existe um argumento, ele receberá o primeiro item do array
            * Nesse caso o explode serve para quebrar a string em um array de acordo com um caractere passado nesse caso por uma '/', ou seja 
            * Ele vai de '/curso/show/12' para $array = [curso,show,12] por exemplo
            * Então no exemplo abaixo, a variável $controller receberá o primeiro item da URI e é retornado o nome do item com a primeira letra maiuscula e concatenado com Controller
            */
            $explode = array_values(array_filter(explode('/', $this->uri)));
            list($controller) = $explode;
            return ucfirst($controller) . 'Controller';
        }

        // Caso o numéro de barras da URI seja menor ou igual a 1 ele vai apenas retornar o item com letra maiuscula concatenado com controller
        return ucfirst(ltrim($this->uri, '/')).'Controller';
    }

    // Função que verifica se a página atual verificando a variável local uri
    public function isHome() {
        return ($this->uri == '/'); // Retorna (true or false)
    }

    // Função utilizada para verificar se uma controller existe, recebendo o nome dela como parâmetro
    private function controllerExists($controller) {

        // Inicia declarando uma variável para teste como false
        $controllerExist = false;

        // percorrendo a lista de pastas
        foreach($this->folders as $folder) {
            // Verificando se existe a classe controller passada como parâmetro
            if(class_exists($folder.'\\'.$controller)) {
                // Se ela existir
                $controllerExist = true; // Define a variável de teste como true
                $this->namespace = $folder; // Define o namespace com o url do folder
                $this->controller = $controller; // Define a controller como a controller passada no parâmetro
            }
        }
        return $controllerExist; // Retorna o teste (true or false)
    }

    // Função utilizada para instanciar um novo controller
    private function instantiateController() {
        // O uso das duas barras se dá ao fato de formatação de string, se tiver apenas '\' o php pode acabar não considerando uma existencia de barra
        $controller = $this->namespace.'\\'.$this->controller;
        return new $controller();
    }
}