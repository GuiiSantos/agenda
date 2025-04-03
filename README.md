# Agenda Eletrônica

## Detalhes do Projeto

Este projeto foi desenvolvido para criar uma **Agenda Eletrônica** com funcionalidades de gerenciamento de usuários e atividades. Cada usuário pode criar e gerenciar suas próprias atividades, e o sistema oferece uma interface de fácil uso para visualização e manipulação dessas atividades em um calendário.

## Requisitos

- **PHP**: Versão 8.1 ou superior.
- **MySQL**: Versão 10 ou superior.
- **CodeIgniter**: Versão 4.
- **Bootstrap**: Utilizado para estilização e layout responsivo.
- **jQuery**: Usado para manipulação do DOM e execução de requisições AJAX.

## Funcionalidades

### Usuários
- Cada usuário tem um login e uma senha únicos.
- Cada usuário pode criar e gerenciar suas próprias atividades, e somente verá suas próprias atividades.

### Atividades
- Cada atividade possui os seguintes campos:
    - **ID**: Identificador único da atividade.
    - **Nome**: Nome da atividade.
    - **Descrição**: Descrição detalhada da atividade.
    - **Data e hora de início**: Quando a atividade começa.
    - **Data e hora de término**: Quando a atividade termina.
    - **Status**: Pode ser "pendente", "concluída" ou "cancelada".

## Funcionalidades Principais

- **Cadastro e login de usuário**: Permite que novos usuários se registrem e façam login.
- **CRUD de atividades**:
    - **Create**: Criar novas atividades.
    - **Read**: Exibir as atividades do usuário.
    - **Update**: Atualizar atividades existentes.
    - **Delete**: Excluir atividades.
- **Exibição das atividades em um calendário**: As atividades são exibidas em um calendário interativo, com diferentes cores para indicar o status (pendente, concluída, cancelada).

## Passo a Passo para Rodar o Projeto

### 1. Clonar o Projeto

No terminal, rode o comando abaixo para clonar o repositório:

```bash
git clone https://github.com/GuiiSantos/agenda.git
```

Depois, acesse a pasta do projeto:

```bash
cd agenda
```

### 2. Instalar o Composer

Se você ainda não tem o Composer instalado, baixe-o no [site oficial do Composer](https://getcomposer.org/).

### 3. Instalar as Dependências

Após instalar o Composer, no diretório do projeto, execute o comando abaixo para instalar as dependências do projeto:

```bash
composer install
```

### 4. Configurar o Banco de Dados

No arquivo `app/Config/Database.php`, configure as credenciais do banco de dados:

```php
'hostname' => '127.0.0.1',
'username' => 'usuario',
'password' => 'senha',
'database' => 'nome_do_banco',
'DBDriver' => 'MySQLi',
'DBPrefix' => '',
```

Alternativamente, configure as credenciais no arquivo `.env`:

```bash
database.default.hostname = localhost
database.default.database = nome_do_banco
database.default.username = usuario
database.default.password = senha
database.default.DBDriver = MySQLi
```

### 5. Rodar as Migrações

Execute as migrações para criar as tabelas necessárias no banco de dados:

```bash
php spark migrate
```

### 6. Rodar a Aplicação

Para rodar a aplicação localmente, utilize o comando abaixo:

```bash
php spark serve
```

Isso iniciará o servidor de desenvolvimento em [http://localhost:8080](http://localhost:8080).

### 7. Acessar o Sistema

Abra o navegador e vá para [http://localhost:8080](http://localhost:8080) para começar a usar a Agenda Eletrônica.

### 8. Uso da Aplicação

- **Cadastro de Usuário**: Na tela de login, clique em "Cadastrar" para criar uma nova conta.
- **Login de Usuário**: Após o cadastro, use seu login e senha para acessar a aplicação.
- **Gerenciamento de Atividades**: Após o login, você pode visualizar, criar, editar e excluir suas atividades na página principal.

## Arquitetura do Sistema

O sistema segue a arquitetura **MVC (Model-View-Controller)** utilizando o framework **CodeIgniter 4**.

- **Model**: Responsável pela interação com o banco de dados (tabelas de usuários e atividades).
- **Controller**: Gerencia a lógica de negócio e manipula as requisições feitas pelas views.
- **View**: Responsável pela interface com o usuário, apresentando as informações na tela.

## Observações

- O **calendário** exibe as atividades de cada usuário, com cores diferentes para os status das atividades (Pendente, Concluída, Cancelada).
- A aplicação utiliza **AJAX** para manipulação dinâmica das atividades, incluindo criação, edição, exclusão e visualização em tempo real.
