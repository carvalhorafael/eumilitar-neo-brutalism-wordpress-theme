# Gaps do Design System

Este arquivo registra componentes ou padrões editoriais necessários no tema WordPress que ainda não foram encontrados nos pacotes `@carvalhorafael/eumilitar-*`.

O objetivo é manter rastreabilidade: primeiro o tema usa uma composição local mínima, depois o Design System pode receber o componente/padrão e estes pontos podem ser substituídos.

## Blog

### Card/teaser de artigo

- Status: gap identificado
- Locais de uso:
  - `template-parts/content-excerpt.php`
  - `src/styles/theme.css`
- Necessidade: card editorial para listagem de posts com thumbnail, metadados, título, excerpt e CTA.
- O que existe hoje no DS: primitive `.ds-card`, `.ds-button` e `.ds-badge`.
- Limite encontrado: `.ds-card` é apenas um primitive estrutural; não há componente/pattern editorial de artigo ou post teaser.
- Decisão temporária no tema: compor o card com `.ds-card`, `.ds-button`, `.ds-badge` e classes locais `post-card*`.

### Metadados editoriais de post

- Status: gap identificado
- Locais de uso:
  - `inc/template-tags.php`
  - `template-parts/content-excerpt.php`
  - `template-parts/content-single.php`
  - `src/styles/theme.css`
- Necessidade: padrão visual para data, autor e categorias de artigo.
- O que existe hoje no DS: `.ds-badge` e primitives textuais genéricos.
- Limite encontrado: não há componente específico para post meta/byline.
- Decisão temporária no tema: renderizar helper PHP `eumilitar_render_post_meta()` com classes locais `entry-meta*`.

### Template de artigo completo

- Status: gap identificado
- Locais de uso:
  - `single.php`
  - `template-parts/content-single.php`
  - `src/styles/theme.css`
- Necessidade: layout editorial de artigo com header, metadados, imagem destacada, corpo e navegação.
- O que existe hoje no DS: primitives de botão, badge e paginação.
- Limite encontrado: não há pattern de artigo completo no pacote de patterns.
- Decisão temporária no tema: criar estrutura WordPress nativa com classes locais `single-post-entry*` e usar primitives do DS quando disponíveis.

### Navegação entre artigos

- Status: gap identificado
- Locais de uso:
  - `template-parts/content-single.php`
  - `src/styles/theme.css`
- Necessidade: navegação anterior/próximo artigo.
- O que existe hoje no DS: `.ds-pagination` para paginação numérica.
- Limite encontrado: não há componente específico para previous/next editorial com título do post.
- Decisão temporária no tema: usar `previous_post_link()` e `next_post_link()` com classes locais `post-navigation*`.
