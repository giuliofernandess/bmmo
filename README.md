# 🎵 Sistema BMMO

![Status](https://img.shields.io/badge/status-demo%20project-blue)
![License](https://img.shields.io/badge/license-All%20Rights%20Reserved-red)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-yellow)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4)
![MySQL](https://img.shields.io/badge/MySQL-database-lightgrey)

## 📌 Descrição

O **Sistema BMMO** é uma plataforma web desenvolvida com o objetivo de **melhorar a comunicação e organização** entre o maestro e os membros da **Banda de Música Municipal de Ocara**, além de oferecer um portal informativo para o público em geral.

Este projeto foi desenvolvido com foco **educacional e demonstrativo**, servindo como parte de portfólio para avaliação técnica.

---

## 🎯 Objetivo

Facilitar:
- A gestão de músicos e repertórios pelo maestro
- O acesso dos músicos às suas partituras
- A divulgação de informações e notícias para fãs e comunidade

---

## 👥 Tipos de Usuário e Funcionalidades

### 👤 Fãs
- Acesso ao portal de notícias
- Página institucional (Sobre)

### 🎺 Músicos
- Perfil individual do músico
- Visualização do repertório das próximas apresentações
- Acesso às partituras conforme:
  - Grupo
  - Instrumento
  - Voz

### 🎼 Maestro (Administrador)
- Cadastro, edição e listagem de músicos
- Criação e gerenciamento de repertórios
- Upload e atualização de partituras por grupo, instrumento e voz
- Criação e gerenciamento de notícias
- Validação de cadastro com regra para responsável em casos de menor de idade

---

## 🛠️ Tecnologias Utilizadas

- **HTML5**
- **CSS3**
- **JavaScript (ES6)**
- **PHP**
- **MySQL**

---

## 🧱 Arquitetura (Resumo)

O projeto adota uma arquitetura em camadas simples, sem framework:

- `pages/`: telas e validadores HTTP
- `includes/`: componentes reutilizáveis de interface
- `app/Auth/`: autenticação e autorização
- `app/Database/`: conexão com banco
- `app/DAO/`: acesso a dados
- `app/Models/`: entidades de domínio
- `config/`: bootstrap global

---

## ⚙️ Configuração Local

1. Configure Apache e MySQL (XAMPP recomendado neste projeto).
2. Crie o banco `bmmo`.
3. Importe o script SQL em `assets/sql/bmmo.sql`.
4. Ajuste credenciais em `config/config.php`.
5. Acesse `http://localhost/bmmo/pages/index.php`.

Documentação detalhada: [docs/SETUP_LOCAL.md](docs/SETUP_LOCAL.md)

---

## 🧾 Documentação Técnica

- Arquitetura: [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md)
- Módulos: [docs/MODULES.md](docs/MODULES.md)
- Banco de dados: [docs/DATABASE.md](docs/DATABASE.md)
- Convenção de nomenclatura: [docs/NAMING_CONVENTION.md](docs/NAMING_CONVENTION.md)
- Padrão de comentários: [docs/COMMENT_PATTERN.md](docs/COMMENT_PATTERN.md)
- Setup local: [docs/SETUP_LOCAL.md](docs/SETUP_LOCAL.md)
- Formatação e EditorConfig: [.editorconfig](.editorconfig)

---

## 📄 Licença

Este projeto **não é open source**.

O código-fonte está disponível **exclusivamente para fins de avaliação técnica por recrutadores**.

➡️ Consulte o arquivo [`LICENSE.txt`](./LICENSE.txt) para mais detalhes.

---

## ⚠️ Aviso

Não é permitida a cópia, modificação, redistribuição ou uso comercial deste projeto, no todo ou em parte, sem autorização prévia do autor.

---

## 🔐 Segurança

- Não publique credenciais reais no repositório.
- Use usuários e senhas de teste apenas em ambiente local.
- Revise permissões de upload e validações de entrada antes de uso em produção.
- Evite mutações por GET; priorize ações destrutivas via POST.
- O botão voltar do header secundário aplica validação para não retornar a rotas de mutação.
