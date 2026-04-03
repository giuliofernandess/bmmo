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

## Padronizações operacionais (adotadas)

As regras abaixo entram no padrão oficial.

### 1. `data-*` explícito por domínio

Evite `data-id` genérico.

Exemplo:

```html
<div class="news-card-item" data-news-id="12" data-news-title="Concerto"></div>
```

### 2. Classes de estado para UI dinâmica

Use classes de estado em vez de `style.display` inline.

Exemplo:

```css
.is-hidden { display: none !important; }
.is-open { display: block; }
```

```js
form.classList.remove('is-hidden');
form.classList.add('is-open');
```

### 3. Validação centralizada de entrada

Centralize leitura/normalização de `$_POST` em helpers.

Exemplo:

```php
function postValue(string $key): ?string {
  if (!isset($_POST[$key]) || $_POST[$key] === '') {
    return null;
  }
  return trim($_POST[$key]);
}
```

### 4. Mensagens de feedback consistentes

Use padrão claro para sucesso/erro.

Exemplo:

```php
Message::set('success', 'Músico salvo com sucesso.');
Message::set('error', 'Erro ao salvar músico. Tente novamente.');
```

### 5. Redirecionamento padronizado

Defina `$redirect` uma vez e reutilize.

Exemplo:

```php
$redirect = BASE_URL . 'pages/admin/musicians/index.php';
header('Location: ' . $redirect);
exit;
```

### 6. Nomes de coleção e item de loop

Use coleção no plural e item no singular sem abreviações genéricas.

Exemplo:

```php
$musiciansList = $musiciansDAO->getAll();

foreach ($musiciansList as $musician) {
  // ...
}
```

Evite nomes como `$res`, `$rowItem`, `$inst` em páginas de domínio.

### 7. Nome de upload consistente

Prefixe por domínio para facilitar rastreio.

Exemplo:

```php
$newFileName = uniqid('musician_', true) . '.' . $extension;
```

### 8. IDs semânticos de formulário

Evite IDs genéricos como `iname`, `ibutton`.

Exemplo:

```html
<input id="musician-name" name="musician_name">
<input id="musician-submit" type="submit">
```

### 9. Filtros GET por domínio

Padronize nomes de filtro com contexto de entidade.

Exemplo:

```php
$_GET['musician_name']
$_GET['band_group']
$_GET['instrument_id']
```

### 10. Regra única para `null` e `empty`

Use a semântica certa para cada caso:
- `isset` para presença de chave
- `empty` apenas para coleção vazia ou ausência de itens processáveis
- `??` para valor opcional com fallback simples
- comparação explícita com `null` para valores opcionais hidratados

Exemplo recomendado:

```php
$login = isset($_SESSION['musician_login']) ? trim((string) $_SESSION['musician_login']) : null;

if ($login === null) {
  // trata ausência de sessão
}
```
