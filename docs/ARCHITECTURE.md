# Arquitetura do Sistema BMMO

## Visão geral

O projeto segue arquitetura em camadas, sem framework, com separação clara entre HTTP, regras de acesso e persistência.

- `pages/`: rotas HTTP e telas.
- `includes/`: componentes reutilizáveis de interface e mensagens.
- `app/Auth/`: autenticação e autorização por perfil.
- `app/Database/`: conexão MySQLi.
- `app/DAO/`: acesso a dados e operações SQL.
- `app/Models/`: entidades e contrato base (`EntityInterface`).
- `config/`: bootstrap global (constantes, conexão e instâncias DAO).

## Estrutura de rotas canonicamente ativa

- `pages/admin`: painel e módulos do maestro.
- `pages/information`: rotas públicas (notícias e sobre).
- `pages/login`: autenticação por perfil.
- `pages/musician`: painel e módulos do músico.
- `pages/index.php`: landing pública.
- `pages/logout.php`: encerramento de sessão.

## Avaliação da estrutura de pastas

Estado atual: a estrutura está adequada para o porte do projeto e para um fluxo sem framework, com separação coerente por responsabilidade.

Pontos fortes:

- Rotas centralizadas em domínios canônicos (`admin`, `information`, `login`, `musician`).
- Camada de persistência isolada em `app/DAO`.
- Componentes compartilhados separados em `includes`.
- Uploads centralizados e previsíveis em `uploads/*`.

Pontos de atenção para evolução:

- Evitar recriar wrappers de rota quando o destino canônico já existe.
- Manter todas as mutações HTTP em `actions/*` com validação de permissão no próprio endpoint.
- Preservar convenções de nomes para evitar regressão de caminhos em Linux.

## Fluxo de requisição

1. A rota inclui `config/config.php`.
2. O bootstrap prepara constantes, conexão e DAOs.
3. Quando necessário, `Auth` valida sessão e perfil.
4. A rota executa leitura/escrita via DAO.
5. Feedback de operação é trafegado por `$_SESSION` e renderizado por `includes`.

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

- `create(array $data): mixed`
- `edit(array $data): bool`
- `delete(int $id): bool`
- `getAll(...$filters): array`

## Regras arquiteturais

- SQL somente na camada DAO.
- Prepared statements em operações de banco.
- Regras de autorização na camada `Auth` e no fluxo HTTP.
- Exclusões e mutações destrutivas devem usar `POST` (form), não âncora `GET`.
- Leitura de `$_POST`/`$_GET`/`$_FILES` deve usar guardas (`??`, `isset`, `is_array`) antes de iterar/acessar índices.
- Navegação por botão voltar no header secundário deve bloquear retorno para rotas de mutação (`actions/*`) e URLs com query string, usando fallback seguro por perfil.
- Nomes de métodos em `camelCase`.
- Novas rotas apenas na árvore canônica de `pages`.

## Uploads e arquivos

Diretórios de uploads:

- `uploads/musical-scores`
- `uploads/musicians-images`
- `uploads/news-images`

Recomendação para ambiente produtivo: reforçar validação MIME, nomes únicos de arquivo e políticas de permissão.
