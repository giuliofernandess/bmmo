# Arquitetura do Sistema BMMO

## Visão geral

O projeto segue arquitetura em camadas, sem framework, com separação clara entre HTTP, regras de acesso e persistência.

- `pages/`: rotas HTTP e telas.
- `includes/`: componentes reutilizáveis de interface e mensagens.
- `app/Auth/`: autenticação e autorização por perfil.
- `app/Database/`: conexão MySQLi.
- `app/DAO/`: acesso a dados e operações SQL.
- `app/Models/`: entidades de domínio (`Musician`, `News`, `Presentation`, `MusicalScore`, etc.) e o contrato base `EntityInterface`.
- `config/`: bootstrap global (constantes, conexão e instâncias DAO).

## Estrutura de rotas canonicamente ativa

- `pages/admin`: painel e módulos do maestro.
- `pages/information`: rotas públicas (notícias e sobre).
- `pages/login`: autenticação por perfil.
- `pages/musician`: painel e módulos do músico.
- `pages/index.php`: landing pública.
- `pages/logout.php`: encerramento de sessão.

## Fluxo de requisição

1. A rota inclui `config/config.php`.
2. O bootstrap prepara constantes, conexão e DAOs.
3. Quando necessário, `Auth` valida sessão e perfil.
4. Em operações de escrita, a rota/action instancia um objeto de domínio (`new ...`), preenche via métodos `set...` e envia para o DAO.
5. A rota executa leitura/escrita via DAO.
6. Feedback de operação é trafegado por `$_SESSION` e renderizado por `includes`.

## Fluxo de autenticação

- Login maestro: `pages/login/admin/index.php` -> `pages/login/admin/actions/login.php`.
- Login músico: `pages/login/musician/index.php` -> `pages/login/musician/actions/login.php`.
- Guards:
  - `Auth::requireRegency()`
  - `Auth::requireMusician()`

## Regras de negócio (cadastro de músicos)

- Validação de idade no cadastro administrativo em `pages/admin/musicians/musicianProfile/actions/create.php`.
- Para cadastros de menores de idade, os campos de responsável devem ser informados.
- Falhas de validação retornam feedback via `$_SESSION['error']` e redirecionam para o formulário.

## Camada DAO

DAOs centrais:

- `NewsDAO`
- `PresentationsDAO`
- `MusiciansDAO`
- `MusicalScoresDAO`
- `BandGroupsDAO`
- `InstrumentsDAO`
- `RegencyDAO`

Contrato base em `app/Models/EntityInterface.php` (quando aplicável):

- `create(object $entity): mixed`
- `edit(object $entity): bool`
- `delete(int $id): bool`
- `getAll(array $filters = []): array`

### Contratos atuais de filtros (`getAll`)

Nem todos os DAOs usam o mesmo conjunto de filtros. Contratos vigentes:

- `MusiciansDAO::getAll(array $filters = [])`
  - `musician_name` (string)
  - `band_group` (int)
  - `instrument` (int)
- `MusicalScoresDAO::getAll(array $filters = [])`
  - `music_name` (string)
  - `band_group` (int)
  - `music_genre` (string)
- `NewsDAO::getAll(array $filters = [])`
  - sem filtros efetivos no estado atual (lista ordenada por publicação)
- `PresentationsDAO::getAll(array $filters = [])`
  - sem filtros efetivos no estado atual (lista cronológica)
- `BandGroupsDAO::getAll()`
  - sem parâmetros
- `InstrumentsDAO::getAll(bool $voiceOff = false, bool $musicalScore = false)`
  - filtros posicionais por flags

## Regras arquiteturais

- SQL somente na camada DAO.
- Prepared statements em operações de banco.
- Regras de autorização na camada `Auth` e no fluxo HTTP.
- Exclusões e mutações destrutivas devem usar `POST` (form), não âncora `GET`.
- Leitura de `$_POST`/`$_GET`/`$_FILES` deve usar guardas (`??`, `isset`, `is_array`) antes de iterar/acessar índices.
- Navegação por botão voltar no header secundário deve bloquear retorno para rotas de mutação (`actions/*`) e URLs com query string, usando fallback seguro por perfil.
- Métodos `delete` dos DAOs devem respeitar as regras de integridade referencial do banco e o comportamento de `ON DELETE CASCADE`.
- Nomes de métodos em `camelCase`.
- Novas rotas apenas na árvore canônica de `pages`.

## Estratégia de exclusão (DAO + banco)

- `MusicalScoresDAO::delete(int $musicId)` remove o registro principal em `musical_scores`.
- `PresentationsDAO::delete(int $presentationId)` remove o registro principal em `presentations`.
- Tabelas filhas com `ON DELETE CASCADE` removem vínculos automaticamente.
- Arquivos físicos (ex.: uploads de partituras) são tratados pela camada DAO após a operação de banco.

## Uploads e arquivos

Diretórios de uploads:

- `uploads/musical-scores`
- `uploads/musicians-images`
- `uploads/news-images`
