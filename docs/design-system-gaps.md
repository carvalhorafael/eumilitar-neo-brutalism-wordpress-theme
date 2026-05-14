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
- Decisão temporária no tema: compor o card com `.ds-card`, `.ds-button`, `.ds-badge` e classes locais `post-card*`, incluindo placeholder local quando não houver imagem destacada.

### Seção de artigos recentes / card compacto

- Status: gap identificado
- Locais de uso:
  - `front-page.php`
  - `template-parts/content-compact.php`
  - `src/styles/theme.css`
- Necessidade: pattern de homepage para listar 3 ou 4 artigos recentes com card editorial compacto.
- O que existe hoje no DS: primitive `.ds-card`, `.ds-button`, `.ds-badge` e o card editorial local criado para listagens completas.
- Limite encontrado: não há pattern de seção editorial recente nem variação compacta de article card para áreas de homepage.
- Decisão temporária no tema: criar seção local `home-recent-posts*` e card compacto `post-card-compact*`, mantendo metadados via helper WordPress e tokens/primitives do DS.

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

### Cabeçalho editorial de arquivo

- Status: gap identificado
- Locais de uso:
  - `home.php`
  - `archive.php`
  - `category.php`
  - `tag.php`
  - `search.php`
  - `src/styles/theme.css`
- Necessidade: cabeçalho padrão para páginas editoriais, com badge/contexto, título e descrição opcional.
- O que existe hoje no DS: `.ds-badge` e patterns de seções de landing, mas não um header editorial genérico para arquivos WordPress.
- Limite encontrado: não há componente/pattern para archive header, search header ou taxonomy header.
- Decisão temporária no tema: criar estrutura local `blog-header*` usando `.ds-badge` como primitive.

### Taxonomia editorial de artigo

- Status: gap identificado
- Locais de uso:
  - `inc/template-tags.php`
  - `template-parts/content-single.php`
  - `src/styles/theme.css`
- Necessidade: bloco de categorias e tags no rodapé do artigo completo.
- O que existe hoje no DS: primitives textuais e `.ds-badge`, mas não um componente de taxonomia editorial.
- Limite encontrado: não há pattern para topic/taxonomy footer de artigo.
- Decisão temporária no tema: renderizar helper PHP `eumilitar_render_post_taxonomy()` com classes locais `entry-taxonomy*`.

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

### Prose/rich text editorial

- Status: gap identificado
- Locais de uso:
  - `template-parts/content-single.php`
  - `src/styles/theme.css`
- Necessidade: estilos consistentes para conteúdo longo vindo do Gutenberg, incluindo headings, listas, blockquotes, imagens, legendas e espaçamento vertical.
- O que existe hoje no DS: tokens, primitives e patterns de landing/captura/prova social.
- Limite encontrado: não há componente/pattern de prose para corpo editorial de artigo.
- Decisão temporária no tema: estilizar `.single-post-entry__content` localmente usando tokens do DS.

### Search form editorial

- Status: gap identificado
- Locais de uso:
  - `search.php`
  - `404.php`
  - `src/styles/theme.css`
- Necessidade: formulário de busca alinhado ao Design System para arquivos editoriais, busca e estado 404.
- O que existe hoje no DS: primitives de input e button, mas o formulário padrão do WordPress vem com classes próprias (`search-form`, `search-field`, `search-submit`).
- Limite encontrado: não há adapter/pattern para o formulário de busca nativo do WordPress, e a saída pode variar entre classes e `role="search"`.
- Decisão temporária no tema: estilizar as classes nativas do WordPress e `form[role="search"]` com tokens do DS.

### Estado vazio editorial

- Status: gap identificado
- Locais de uso:
  - `inc/template-tags.php`
  - `home.php`
  - `archive.php`
  - `category.php`
  - `tag.php`
  - `search.php`
  - `src/styles/theme.css`
- Necessidade: padrão para páginas editoriais sem conteúdo, com título, descrição, CTA primário e busca opcional.
- O que existe hoje no DS: primitives de badge, button e input.
- Limite encontrado: não há componente/pattern de empty state editorial ou adapter para arquivos nativos do WordPress.
- Decisão temporária no tema: criar helper PHP `eumilitar_render_editorial_empty_state()` e classes locais `site-empty*`.

### Estado 404 editorial

- Status: gap identificado
- Locais de uso:
  - `404.php`
  - `src/styles/theme.css`
- Necessidade: página de erro editorial com badge, título, descrição, busca e CTA para voltar aos artigos.
- O que existe hoje no DS: primitives de badge, button e input.
- Limite encontrado: não há pattern específico para página 404/erro no Design System.
- Decisão temporária no tema: criar estrutura local `error-page*` e reutilizar o formulário nativo de busca estilizado.

### Comentários de artigo

- Status: gap identificado
- Locais de uso:
  - `comments.php`
  - `single.php`
  - `src/styles/theme.css`
- Necessidade: padrão visual para discussão editorial com lista de comentários, respostas, paginação e formulário nativo do WordPress.
- O que existe hoje no DS: primitives de card, button, badge e inputs.
- Limite encontrado: não há componente/pattern para comments thread nem adapter para `wp_list_comments()` e `comment_form()`.
- Decisão temporária no tema: implementar `comments.php` com funções nativas do WordPress e estilizar classes padrão de comentários com tokens/primitives do DS.

## Widgets e areas editaveis

### Sidebar editorial / area de widgets

- Status: gap identificado
- Locais de uso previstos:
  - `inc/widgets.php`
  - `home.php`
  - `archive.php`
  - `category.php`
  - `tag.php`
  - `search.php`
  - `single.php`
  - `footer.php`
  - `src/styles/theme.css`
- Necessidade: padrao visual para areas editaveis do WordPress, incluindo sidebar de blog, sidebar de artigo, area apos artigo e rodape.
- O que existe hoje no DS: primitives como `.ds-card`, `.ds-button`, `.ds-badge`, inputs, lista/divider e patterns de secoes maiores.
- Limite encontrado: nao ha componente/pattern especifico para sidebar editorial ou wrapper de widget WordPress.
- Decisão temporária no tema: registrar areas com APIs nativas do WordPress e criar adapters locais `.widget-area`, `.widget` e `.widget__title`, usando tokens/primitives do DS.

### Lista compacta de posts para widgets

- Status: gap identificado
- Locais de uso previstos:
  - `blog-sidebar`
  - `single-post-sidebar`
  - `src/styles/theme.css`
- Necessidade: lista compacta de artigos recentes/relacionados adequada para coluna estreita, com titulo, data e link.
- O que existe hoje no DS: card editorial local para listagens e primitives `.ds-card`, `.ds-badge` e `.ds-button`.
- Limite encontrado: nao ha componente/pattern de lista compacta editorial para sidebar.
- Decisão temporária no tema: usar inicialmente o bloco nativo Latest Posts estilizado como adapter local; se o contrato visual precisar de thumbnail/metadados especificos, criar template local e registrar a evolucao.

### Lista de categorias, tags e topicos

- Status: gap identificado
- Locais de uso previstos:
  - `blog-sidebar`
  - `single-post-sidebar`
  - `site-footer`
  - `src/styles/theme.css`
- Necessidade: exibicao coerente de categorias, tags e topicos editoriais como links escaneaveis em areas estreitas.
- O que existe hoje no DS: `.ds-badge`, list/divider e primitives textuais.
- Limite encontrado: nao ha componente editorial de taxonomy/link cloud para WordPress.
- Decisão temporária no tema: estilizar blocos nativos Categories e Tag Cloud com tokens do DS e avaliar se devem virar pattern no Design System.

### CTA compacto para sidebar

- Status: gap identificado
- Locais de uso previstos:
  - `blog-sidebar`
  - `single-post-sidebar`
  - `after-post-content`
  - `src/styles/theme.css`
- Necessidade: chamada curta de conversao em area estreita sem usar uma secao de landing completa.
- O que existe hoje no DS: pattern `cta` com variantes `light`, `brand-dark` e `urgent`.
- Limite encontrado: o `cta` atual e orientado a secao/faixa, nao a card compacto de sidebar.
- Decisão temporária no tema: compor CTA compacto com `.ds-card`, `.ds-badge` e `.ds-button`, mantendo o gap registrado ate o Design System fornecer variante compacta.

### Captura compacta para sidebar

- Status: gap identificado
- Locais de uso previstos:
  - `blog-sidebar`
  - `single-post-sidebar`
  - `after-post-content`
  - `src/styles/theme.css`
- Necessidade: formulario curto de captura em coluna estreita.
- O que existe hoje no DS: pattern `capture` e primitives de input/button.
- Limite encontrado: o pattern `capture` atual e mais adequado a secoes de pagina; falta variante compacta para widget/sidebar.
- Decisão temporária no tema: usar blocos/forms nativos quando houver integracao real e aplicar adapter local de largura estreita com tokens do DS.
