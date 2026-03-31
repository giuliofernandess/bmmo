# Setup Local

## Requisitos

- PHP 8.x
- MySQL ou MariaDB
- Servidor local (XAMPP recomendado para este projeto)

## Banco de dados

1. Crie o banco `bmmo`.
2. Importe o script `assets/sql/bmmo.sql`.
3. Verifique se existe pelo menos 1 registro de maestro na tabela `regency`.

## Configuracao da aplicacao

Edite `config/config.php` com os dados locais:

- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`

## Padrao de formatacao

Este repositorio usa `.editorconfig` na raiz para padronizar:

- `charset = utf-8`
- `end_of_line = lf`
- `insert_final_newline = true`
- `trim_trailing_whitespace = true`
- indentacao com 4 espacos para `php/js/css/html`

Recomendacao:

1. Mantenha suporte a EditorConfig habilitado no editor.
2. Nao remova o arquivo `.editorconfig` do repositorio.

## Execucao

1. Inicie Apache e MySQL.
2. Acesse `http://localhost/bmmo/pages/index.php`.

## Rotas canônicas para smoke test

- Publico:
	- `http://localhost/bmmo/pages/index.php`
	- `http://localhost/bmmo/pages/information/news/index.php`
	- `http://localhost/bmmo/pages/information/aboutTheBand/index.php`
- Login:
	- `http://localhost/bmmo/pages/login/admin/index.php`
	- `http://localhost/bmmo/pages/login/musician/index.php`

## Observacao sobre warning pdo_mysql no terminal

O projeto usa MySQLi. O warning de `pdo_mysql` pode aparecer no PHP CLI quando a extensao nao esta instalada na versao de PHP usada no terminal.

Esse warning nao bloqueia o `php -l`, mas vale corrigir no ambiente para reduzir ruido no output.
