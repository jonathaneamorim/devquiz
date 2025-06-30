# Get Started

O entry point da aplicação se inicia no arquivo index.php localizado dentro da pasta public. A partir dali, com uma simples estrutura inserida dentro de um try catch
```php
try {
    startSessionIfNotStarted();
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
```
é possivel visualizar o método de funcionamento do MVC, onde no fim de tudo ocorre uma chamada do método controller que chama o método e recebe um parâmetro `$controller->$method($parameters);`. 

No caso de algum erro ele é capturado no catch e exibido direto na página por meio de um Die Dump. 
Esse é um método de debug muito comum no PHP onde ele executa um `var_dump` e para todo o processo, evitando que o script continue rodando
- Evita que execute lógicas desnecessárias (inserções e redirecionamentos);
- Evita ocultar o resultado o `var_dump` dentro de um HTML maior.

```php
function dd($dump) {
    var_dump($dump);
    die();
}
```

Exemplo prático:
```php
$user = $this->user->findByEmail($email);
var_dump($user);
die();
```
Para saber o que há dentro de $user no momento, basta aplicar um var_dump e die().

O die() nesse caso, pausa a execução de todo o script que esteja rodando.