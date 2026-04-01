# Setup Local

## Requisitos

- PHP 8.x
- MySQL ou MariaDB
- Servidor local (XAMPP recomendado para este projeto)

## Banco de dados

1. Crie o banco `bmmo`.
2. Importe o script `assets/sql/bmmo.sql`.
3. Verifique se existe pelo menos 1 registro de maestro na tabela `regency`.

## Configuração da aplicação

Edite `config/config.php` com os dados locais:

- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`

## Padrão de formatação

Este repositório usa `.editorconfig` na raiz para padronizar:

- `charset = utf-8`
- `end_of_line = lf`
- `insert_final_newline = true`
- `trim_trailing_whitespace = true`
- indentação com 4 espaços para `php/js/css/html`

## Execução

1. Inicie Apache e MySQL.
2. Acesse `http://localhost/bmmo/pages/index.php`.

## Rotas canônicas para smoke test

- Público:
  - `http://localhost/bmmo/pages/index.php`
  - `http://localhost/bmmo/pages/information/news/index.php`
  - `http://localhost/bmmo/pages/information/aboutTheBand/index.php`
- Login:
  - `http://localhost/bmmo/pages/login/admin/index.php`
  - `http://localhost/bmmo/pages/login/musician/index.php`
