# Padrao de Comentarios

Este documento define o padrao de comentarios adotado no codigo.

## Objetivo
Comentar apenas o que agrega contexto, sem descrever o obvio.

## Regras
- Use frases curtas, claras e diretas.
- Prefira comentarios em portugues tecnico simples.
- Evite comentarios redundantes sobre codigo autoexplicativo.
- Mantenha consistencia de estilo em todo o projeto.

## Onde comentar
- Blocos com multiplas etapas e estado intermediario.
- Regras de negocio sensiveis (autenticacao, autorizacao, seguranca).
- Decisoes tecnicas nao triviais.
- Tratamentos de excecao/fallback em runtime.

## Formato recomendado
- Comentario de linha para contexto rapido:
  - `// Mantem fallback para nao quebrar renderizacao em caso de dado invalido.`
- PHPDoc para metodos publicos:
  - descrever responsabilidade em 1 linha.
  - incluir detalhes extras somente quando necessario.

## Boas praticas
- Atualize comentario quando alterar regra.
- Remova comentario antigo que nao reflete o comportamento atual.
- Nao misture varios idiomas no mesmo arquivo.
- Nao comentar caminho/arquivo antigo que ja foi removido.
