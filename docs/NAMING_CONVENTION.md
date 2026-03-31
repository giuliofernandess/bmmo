# Convenção Final de Nomenclatura

Este documento define o padrão oficial de nomes para pastas, arquivos e rotas do projeto BMMO.

## Objetivo

Padronizar o projeto para:
- reduzir inconsistências de caminho
- evitar erros em ambientes Linux (case-sensitive)
- facilitar manutenção e navegação no código

## Regra Geral

Use nomes descritivos, estáveis e consistentes.

## Padrão por tipo

### 1. Pastas de rotas (pages)

Use `lowercase` para domínios principais:
- `pages/admin`
- `pages/information`
- `pages/login`
- `pages/musician`

Dentro de cada domínio, use `camelCase` apenas quando o nome tiver mais de uma palavra:
- `musicalScores`
- `aboutTheBand`
- `registerMusician`

Evite PascalCase e variações antigas com hífen para módulos de rota.

### 2. Arquivos de entrada de página

Use `index.php` como entrypoint de cada módulo.

Exemplos:
- `pages/admin/index.php`
- `pages/login/admin/index.php`
- `pages/musician/profile/index.php`

### 3. Ações HTTP (POST/GET de mutação)

Centralize em pasta `actions` com nomes verbais curtos em `lowercase`:
- `create.php`
- `edit.php`
- `delete.php`
- `login.php`

Formato recomendado:
- `pages/<dominio>/<modulo>/actions/<acao>.php`

### 4. Includes reutilizáveis

Em `includes/`, use `camelCase` para nomes compostos:
- `basicHead.php`
- `firstHeader.php`
- `secondHeader.php`
- `successToast.php`

### 5. Camada app

Mantenha padrão atual por responsabilidade:
- `app/DAO`: classes em PascalCase terminando com `DAO` (ex.: `MusiciansDAO.php`)
- `app/Models`: entidades em PascalCase (ex.: `MusicalScore.php`)
- `app/Auth`: classes em PascalCase (ex.: `Auth.php`)
- `app/Database`: classes em PascalCase (ex.: `Database.php`)

### 6. Assets

Mantenha:
- pastas em `lowercase`
- arquivos CSS/JS em `camelCase` quando compostos

Exemplos:
- `assets/css/aboutTheBand.css`
- `assets/js/showForm.js`

## Regras de compatibilidade e migração

1. Novas features devem nascer apenas na árvore canônica (`admin`, `information`, `login`, `musician`).
2. Não criar novos caminhos legados (`AdmSession`, `MusicianSession`, `Information`, `Login`).
3. Se houver necessidade temporária de compatibilidade, usar wrappers curtos e planejar remoção.

## Rotas canônicas finais

- Público:
  - `pages/index.php`
  - `pages/information/news/index.php`
  - `pages/information/news/expanded.php`
  - `pages/information/aboutTheBand/index.php`
- Login:
  - `pages/login/admin/index.php`
  - `pages/login/admin/actions/login.php`
  - `pages/login/musician/index.php`
  - `pages/login/musician/actions/login.php`
- Maestro:
  - `pages/admin/index.php`
  - módulos em `pages/admin/*`
- Músico:
  - `pages/musician/index.php`
  - módulos em `pages/musician/*`

## Checklist para novos arquivos

Antes de criar um arquivo/pasta novo, valide:
1. Está dentro do domínio canônico correto?
2. O nome segue o padrão (`lowercase` ou `camelCase` conforme regra)?
3. É entrypoint `index.php` ou ação em `actions/<acao>.php`?
4. O caminho funciona em Linux sem depender de case-insensitive?

## Padronizacao de editor (.editorconfig)

O arquivo `.editorconfig` e recomendado e, na pratica do projeto, deve ser mantido.

Motivos:

- evita diffs ruidosos (indentacao, newline final e espacos sobrando)
- reduz conflito entre VS Code, IDEs JetBrains e editores de terminal
- preserva consistencia entre PHP, CSS, JS e HTML

Diretriz:

- nao remover `.editorconfig`
- ao criar novos tipos de arquivo, incluir regra especifica quando necessario
