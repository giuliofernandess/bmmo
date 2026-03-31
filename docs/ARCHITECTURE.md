# Arquitetura do Sistema BMMO

## Visao geral

O projeto segue arquitetura em camadas, sem framework, com separacao clara entre HTTP, regras de acesso e persistencia.

- `pages/`: rotas HTTP e telas.
- `includes/`: componentes reutilizaveis de interface e mensagens.
- `app/Auth/`: autenticacao e autorizacao por perfil.
- `app/Database/`: conexao MySQLi.
- `app/DAO/`: acesso a dados e operacoes SQL.
- `app/Models/`: entidades e contrato base (`EntityInterface`).
- `config/`: bootstrap global (constantes, conexao e instancias DAO).

## Estrutura de rotas canonicamente ativa

- `pages/admin`: painel e modulos do maestro.
- `pages/information`: rotas publicas (noticias e sobre).
- `pages/login`: autenticacao por perfil.
- `pages/musician`: painel e modulos do musico.
- `pages/index.php`: landing publica.
- `pages/logout.php`: encerramento de sessao.

## Avaliacao da estrutura de pastas

Estado atual: a estrutura esta adequada para o porte do projeto e para um fluxo sem framework, com separacao coerente por responsabilidade.

Pontos fortes:

- Rotas centralizadas em dominios canonicos (`admin`, `information`, `login`, `musician`).
- Camada de persistencia isolada em `app/DAO`.
- Componentes compartilhados separados em `includes`.
- Uploads centralizados e previsiveis em `uploads/*`.

Pontos de atencao para evolucao:

- Evitar recriar wrappers de rota quando o destino canonico ja existe.
- Manter todas as mutacoes HTTP em `actions/*` com validacao de permissao no proprio endpoint.
- Preservar convencoes de nomes para evitar regressao de caminhos em Linux.

## Fluxo de requisicao

1. A rota inclui `config/config.php`.
2. O bootstrap prepara constantes, conexao e DAOs.
3. Quando necessario, `Auth` valida sessao e perfil.
4. A rota executa leitura/escrita via DAO.
5. Feedback de operacao e trafegado por `$_SESSION` e renderizado por `includes`.

## Fluxo de autenticacao

- Login maestro: `pages/login/admin/index.php` -> `pages/login/admin/actions/login.php`.
- Login musico: `pages/login/musician/index.php` -> `pages/login/musician/actions/login.php`.
- Guards:
	- `Auth::requireRegency()`
	- `Auth::requireMusician()`

## Camada DAO

DAOs centrais:

- `NewsDAO`
- `PresentationsDAO`
- `MusiciansDAO`
- `MusicalScoresDAO`
- `BandGroupsDAO`
- `InstrumentsDAO`
- `RegencyDAO`

Contrato base em `app/Models/EntityInterface.php` (quando aplicavel):

- `create(array $data): mixed`
- `edit(array $data): bool`
- `delete(int $id): bool`
- `getAll(...$filters): array`

## Regras arquiteturais

- SQL somente na camada DAO.
- Prepared statements em operacoes de banco.
- Regras de autorizacao na camada `Auth` e no fluxo HTTP.
- Exclusoes e mutacoes destrutivas devem usar `POST` (form), nao ancora `GET`.
- Leitura de `$_POST`/`$_GET`/`$_FILES` deve usar guardas (`??`, `isset`, `is_array`) antes de iterar/acessar indices.
- Nomes de metodos em `camelCase`.
- Novas rotas apenas na arvore canonica de `pages`.

## Uploads e arquivos

Diretorios de uploads:

- `uploads/musical-scores`
- `uploads/musicians-images`
- `uploads/news-images`

Recomendacao para ambiente produtivo: reforcar validacao MIME, nomes unicos de arquivo e politicas de permissao.
