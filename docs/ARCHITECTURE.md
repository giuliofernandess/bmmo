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

## Uploads e arquivos

Diretórios de uploads:

- `uploads/musical-scores`
- `uploads/musicians-images`
- `uploads/news-images`
