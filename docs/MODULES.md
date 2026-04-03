# Módulos Funcionais

## Autenticação

### Rotas
- `pages/login/admin/index.php`
- `pages/login/admin/actions/login.php`
- `pages/login/musician/index.php`
- `pages/login/musician/actions/login.php`
- `pages/logout.php`

### Regras centrais
- `Auth::regencyLogin()`
- `Auth::musicianLogin()`
- `Auth::requireRegency()`
- `Auth::requireMusician()`
- `Auth::logout()`

## Notícias

### Público
- `pages/information/news/index.php`
- `pages/information/news/expanded.php`

### Admin
- `pages/admin/news/index.php`
- `pages/admin/news/actions/create.php`
- `pages/admin/news/actions/edit.php`
- `pages/admin/news/actions/delete.php`

### Persistência
- `NewsDAO`

## Músicos

### Admin
- `pages/admin/musicians/index.php`
- `pages/admin/registerMusician/index.php`
- `pages/admin/musicians/musicianProfile/index.php`
- `pages/admin/musicians/musicianProfile/edit/index.php`
- `pages/admin/musicians/actions/create.php`
- `pages/admin/musicians/actions/edit.php`
- `pages/admin/musicians/actions/delete.php`

### Músico autenticado
- `pages/musician/profile/index.php`
- `pages/musician/profile/edit/index.php`
- `pages/musician/profile/actions/edit.php`

### Persistência
- `MusiciansDAO`

## Partituras

### Admin
- `pages/admin/musicalScores/index.php`
- `pages/admin/musicalScores/edit/index.php`
- `pages/admin/musicalScores/actions/create.php`
- `pages/admin/musicalScores/actions/edit.php`
- `pages/admin/musicalScores/actions/delete.php`
- `pages/admin/musicalScores/actions/deleteinstrument.php`

### Músico autenticado
- `pages/musician/musicalScores/index.php`

### Persistência
- `MusicalScoresDAO`

## Apresentações

### Admin
- `pages/admin/presentations/index.php`
- `pages/admin/presentations/actions/create.php`
- `pages/admin/presentations/actions/edit.php`
- `pages/admin/presentations/actions/delete.php`

### Músico autenticado
- `pages/musician/presentations/index.php`

### Persistência
- `PresentationsDAO`

## Informações institucionais

- `pages/information/aboutTheBand/index.php`

## Dashboard por perfil

- Maestro: `pages/admin/index.php`
- Músico: `pages/musician/index.php`
