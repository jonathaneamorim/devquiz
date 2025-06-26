# Nexus-PHP-MVC
Este projeto foi desenvolvido com o objetivo de servir como base para aplicações PHP que seguem o padrão MVC, facilitando um desenvolvimento mais rápido, organizado e consistente.

## Estrutura 
```plaintext
Nexus-PHP-MVC  
├── config.php  
├── bootstrap.php  
├── composer.json  
├── app/  
│   ├── classes/  
│   │   ├── Bind.php  
│   │   └── Uri.php  
│   ├── controllers/  
│   │   └── ContainerController.php  
│   ├── exceptions/  
│   ├── functions/  
│   │   ├── helpers.php  
│   │   └── twig.php  
│   ├── models/  
│   │   ├── Connection.php  
│   │   └── Model.php  
│   ├── traits/  
│   │   └── TView.php  
│   └── views/  
├── core/  
│   ├── Controller.php  
│   ├── Method.php  
│   ├── Parameter.php  
│   └── Twig.php  
└── public/  
    ├── assets/  
    └── index.php  
```

## Rodar a aplicação (running)
Sempre que uma aplicação é iniciada ou hospedada em um servidor, o servidor web procura automaticamente pelo arquivo index.php dentro da pasta public, localizada na raiz do projeto. Esse arquivo é considerado o entry point (ponto de entrada) da aplicação.

Em ambientes de desenvolvimento local, precisamos simular o *entry point* da aplicação utilizando o servidor embutido do PHP. Para isso, execute o seguinte comando no terminal, na raiz do projeto:
```bash
php -S localhost:8080 -t public
```
- `php`: 
Inicia o interpretador do PHP via linha de comando.

- `-S localhost:8080`:
Ativa o servidor embutido do PHP e o disponibiliza em localhost na porta 8080.
Você pode trocar a porta por outra disponível, como 8000 ou 3000, se preferir.

- `-t public`: 
Define a pasta public como a raiz do servidor (document root).
É nela que o servidor buscará o arquivo index.php, que serve como ponto de entrada da aplicação (entry point).

## Requisitos e Configuração do Banco de Dados MySQL
Para rodar a aplicação, é necessário ter um servidor MySQL instalado e configurado corretamente, além de ferramentas para gerenciar os bancos de dados.

### 1. Requisitos

- **MySQL Server**  
  O servidor de banco de dados MySQL deve estar instalado e em execução na sua máquina local ou em um servidor acessível.

- **Aplicativos gráficos para gerenciamento de banco de dados** (opcionais, mas recomendados)  
  Exemplos populares:
  - [DBeaver](https://dbeaver.io/)  
  - [MySQL Workbench](https://www.mysql.com/products/workbench/)  

Essas ferramentas facilitam a criação, alteração e consulta aos bancos de dados por meio de interface visual.

---

### 2. Configuração inicial do MySQL
Após instalar o MySQL Server, é importante definir uma senha para o usuário `root` da sua instância local do banco. Em algumas distribuições, o MySQL pode ser instalado sem senha para o `root`, o que pode dificultar a conexão via aplicativos gráficos.

Siga os passos abaixo para definir ou alterar a senha do usuário `root`:

1. **Acesse o MySQL pelo terminal** (caso já tenha uma senha, informe-a; caso contrário, pressione Enter):

   ```bash
   sudo mysql -u root -p
   ```

2. **Altere a senha do usuário** `root` para usar o plugin de autenticação nativo do MySQL e defina uma nova senha:
    ```sql
    ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '{new_password}';
    ```

3. **Atualize os privilégios** para que as alterações tenham efeito imediato:
    ```sql
    FLUSH PRIVILEGES;
    ```

4. **Saia** do MySQL:
    ```sql
    EXIT;
    ```

### 3. Instalar a extensão PHP para conexão com MySQL
Para que o PHP possa se comunicar com o banco MySQL, é necessário instalar a extensão php-mysqlnd (MySQL Native Driver). Em distribuições baseadas em Fedora, Red Hat ou CentOS, execute:
```bash
sudo dnf install php-mysqlnd
```
- Para outras distribuições, utilize o gerenciador de pacotes correspondente (ex: apt para Debian/Ubuntu).

Após a instalação, reinicie o servidor web (Apache, Nginx ou o servidor embutido PHP) para que a extensão seja carregada corretamente.

## Gerenciador de pacotes Composer
O **Composer** é o gerenciador de dependências padrão para projetos em PHP — similar ao que o **NPM** é para o Node.js, ou o **Maven** e **Gradle** são para projetos Java.

Ele utiliza um arquivo chamado `composer.json` para definir e gerenciar as dependências do projeto. A partir desse arquivo, o Composer baixa automaticamente todas as bibliotecas necessárias.

### Principais comandos

- Para instalar as dependências definidas no `composer.json`:
  ```bash
  composer install
  ```
- É possível adicionar novas bibliotecas ao seu projeto utilizando o comando:
    ```bash
    sudo composer require
    ```
    Ao executá-lo sem argumentos, será exibido um prompt interativo, onde você pode pesquisar o nome da dependência desejada (por exemplo, twig/twig, symfony/var-dumper, etc.).
    Também é possível passar diretamente o nome do pacote, por exemplo:
    ```bash
    composer require twig/twig
    ```
    Isso adicionará a dependência ao arquivo composer.json e instalará automaticamente os arquivos na pasta vendor/.

- Para otimizar o autoload (útil em ambiente de produção):
  ```bash
  composer dump-autoload -o
  ```
    - O comando acima recria o autoloader de classes do projeto de forma otimizada, organizando melhor os arquivos.

### Pasta Vendor
Após a execução dos comandos do Composer, uma pasta chamada `vendor/` será criada automaticamente.
Nela ficarão armazenadas todas as bibliotecas instaladas e o autoloader gerado.
Essa pasta é equivalente à `node_modules` no Node.js e não deve ser editada manualmente.
- A pasta vendor normalmente é adicionada ao .gitignore e não enviada ao repositório.

Documentação oficial: 
[Documentação composer](https://getcomposer.org/doc/00-intro.md)

## Autoload
- Documentation: [autoload](https://www.php.net/manual/en/language.oop5.autoload.php)

## Futuras feats
- Pasta de documentação
---
- Resolver problema de URL com barra no final `http://localhost:3000/cursos/show/`
---
Criar um arquivo dockerfile para instalar dependencias
FROM php:8.2-apache
- Instala PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql
- Copia os arquivos do seu projeto
COPY . /var/www/html