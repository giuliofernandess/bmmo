# Documentacao do Banco de Dados

## Visao geral

Banco: `bmmo`

Script fonte:
- `assets/sql/bmmo.sql`

Motor e collation (no dump atual):
- InnoDB
- utf8mb4 / utf8mb4_general_ci

## Tabelas

### 1. band_groups
Finalidade: grupos da banda.

Campos:
- `group_id` int PK
- `group_name` varchar(50) NOT NULL

Relacionamentos:
- Referenciada por `musicians.band_group`
- Referenciada por `musical_scores_groups.group_id`
- Referenciada por `presentations_groups.group_id`

### 2. instruments
Finalidade: catalogo de instrumentos.

Campos:
- `instrument_id` int PK
- `instrument_name` varchar(50) NOT NULL

Relacionamentos:
- Referenciada por `musicians.instrument`
- Referenciada por `musical_scores_instruments.instrument_id`

### 3. musical_scores
Finalidade: cadastro principal de musicas/partituras.

Campos:
- `music_id` int PK AUTO_INCREMENT
- `music_name` varchar(100) NOT NULL
- `music_genre` varchar(100) NOT NULL

Relacionamentos:
- 1:N com `musical_scores_groups`
- 1:N com `musical_scores_instruments`
- Referenciada por `presentations_songs.song_id`

### 4. musical_scores_groups
Finalidade: vinculo N:N entre partituras e grupos.

Campos:
- `music_id` int FK -> `musical_scores.music_id`
- `group_id` int FK -> `band_groups.group_id`

Chave:
- PK composta (`music_id`, `group_id`)

### 5. musical_scores_instruments
Finalidade: arquivo de partitura por musica e instrumento.

Campos:
- `music_id` int FK -> `musical_scores.music_id`
- `instrument_id` int FK -> `instruments.instrument_id`
- `file` tinytext NOT NULL

Chave:
- PK composta (`music_id`, `instrument_id`)

### 6. musicians
Finalidade: cadastro de musicos.

Campos:
- `musician_id` int PK AUTO_INCREMENT
- `musician_name` varchar(255) NOT NULL
- `musician_login` varchar(50) NOT NULL
- `date_of_birth` date NOT NULL
- `instrument` int FK -> `instruments.instrument_id`
- `band_group` int FK -> `band_groups.group_id`
- `musician_contact` varchar(50) NULL
- `responsible_name` varchar(255) NULL
- `responsible_contact` varchar(50) NULL
- `neighborhood` varchar(50) NOT NULL
- `institution` varchar(255) NULL
- `password` varchar(255) NOT NULL
- `profile_image` tinytext NULL

Observacao:
- O dump atual nao define indice UNIQUE para `musician_login`.

### 7. news
Finalidade: noticias publicas.

Campos:
- `news_id` int PK AUTO_INCREMENT
- `news_title` varchar(255) NOT NULL
- `news_subtitle` varchar(255) NOT NULL
- `news_image` varchar(255) NOT NULL
- `news_description` text NOT NULL
- `publication_date` date NOT NULL
- `publication_hour` time NOT NULL

### 8. presentations
Finalidade: eventos/apresentacoes da banda.

Campos:
- `presentation_id` int PK AUTO_INCREMENT
- `presentation_name` varchar(200) NOT NULL
- `presentation_date` date NOT NULL
- `presentation_hour` time NOT NULL
- `local_of_presentation` varchar(200) NOT NULL

Relacionamentos:
- 1:N com `presentations_groups`
- 1:N com `presentations_songs`

### 9. presentations_groups
Finalidade: vinculo N:N entre apresentacoes e grupos.

Campos:
- `presentation_id` int FK -> `presentations.presentation_id`
- `group_id` int FK -> `band_groups.group_id`

Chave:
- PK composta (`presentation_id`, `group_id`)

### 10. presentations_songs
Finalidade: vinculo N:N entre apresentacoes e musicas.

Campos:
- `presentation_id` int FK -> `presentations.presentation_id`
- `song_id` int FK -> `musical_scores.music_id`

Chave:
- PK composta (`presentation_id`, `song_id`)

### 11. regency
Finalidade: credenciais do maestro/regente.

Campos:
- `regency_login` varchar(50) PK
- `password` varchar(255) NOT NULL

## Mapa de relacionamentos (resumo)

- `musicians.instrument` -> `instruments.instrument_id`
- `musicians.band_group` -> `band_groups.group_id`
- `musical_scores_groups.music_id` -> `musical_scores.music_id`
- `musical_scores_groups.group_id` -> `band_groups.group_id`
- `musical_scores_instruments.music_id` -> `musical_scores.music_id`
- `musical_scores_instruments.instrument_id` -> `instruments.instrument_id`
- `presentations_groups.presentation_id` -> `presentations.presentation_id`
- `presentations_groups.group_id` -> `band_groups.group_id`
- `presentations_songs.presentation_id` -> `presentations.presentation_id`
- `presentations_songs.song_id` -> `musical_scores.music_id`

## Mapeamento para DAOs

- `BandGroupsDAO` -> `band_groups`
- `InstrumentsDAO` -> `instruments`
- `MusicalScoresDAO` -> `musical_scores`, `musical_scores_groups`, `musical_scores_instruments`
- `MusiciansDAO` -> `musicians` (+ joins com `band_groups` e `instruments`)
- `NewsDAO` -> `news`
- `PresentationsDAO` -> `presentations`, `presentations_groups`, `presentations_songs`
- `RegencyDAO` -> `regency`
