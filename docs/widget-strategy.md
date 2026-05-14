# Frente de widgets WordPress

Este documento mapeia a abordagem recomendada para widgets no tema EuMilitar e registra onde a implementacao deve continuar usando o Design System como fonte de verdade.

Plano executavel: `docs/widget-implementation-plan.md`.

## Decisao tecnica

O tema deve tratar widgets como areas editaveis por blocos, nao como uma colecao nova de widgets PHP proprietarios.

Modelo recomendado:

- registrar areas com `register_sidebar()` no hook `widgets_init`;
- renderizar areas com `is_active_sidebar()` e `dynamic_sidebar()`;
- habilitar a edicao via admin moderno de Widgets do WordPress, onde o usuario pode inserir blocos nativos e widgets legados;
- oferecer block patterns/composicoes orientadas pelo tema para acelerar montagem de sidebar, rodape e chamadas editoriais;
- criar `WP_Widget` customizado apenas se houver uma necessidade real de estado/configuracao que nao se resolva bem com blocos, patterns ou template parts.

Motivo:

- `register_sidebar()` e `dynamic_sidebar()` continuam sendo a API estavel para areas de widget em temas classicos/hibridos;
- o editor moderno de Widgets usa blocos dentro das areas registradas pelo tema;
- o tema permanece um consumer/adaptador do Design System, sem criar uma biblioteca paralela de componentes WordPress.

Referencias verificadas:

- WordPress Developer Reference: `register_sidebar()` registra a area e adiciona suporte a widgets ao tema.
- WordPress Developer Reference: `dynamic_sidebar()` renderiza os widgets atribuidos a uma area registrada.
- Gutenberg Widgets Block Editor: areas de widget/sidebars definidas pelo tema podem receber blocos e widgets tradicionais na interface de Widgets.

## Areas recomendadas

### `blog-sidebar`

- Nome sugerido no admin: `Barra lateral do blog`.
- Uso: `home.php`, `archive.php`, `category.php`, `tag.php` e `search.php`.
- Comportamento: aparecer ao lado da listagem em desktop e abaixo da listagem em mobile.
- Conteudo recomendado:
  - busca;
  - categorias principais;
  - posts recentes;
  - tags/topicos;
  - CTA curto para preparacao militar;
  - captura simples de lead, se houver integracao real.
- Prioridade: alta.

### `single-post-sidebar`

- Nome sugerido no admin: `Barra lateral do artigo`.
- Uso: `single.php`.
- Comportamento: opcional; se vazia, o artigo continua em layout de uma coluna.
- Conteudo recomendado:
  - artigos relacionados ou recentes;
  - categorias/tags do artigo;
  - CTA contextual;
  - bloco de captura;
  - sumario do artigo no futuro, se o conteudo longo justificar.
- Prioridade: media.

### `after-post-content`

- Nome sugerido no admin: `Apos o artigo`.
- Uso: abaixo de `template-parts/content-single.php`, antes de comentarios.
- Comportamento: faixa horizontal de conversao/editorial.
- Conteudo recomendado:
  - CTA do Design System;
  - captura de lead;
  - FAQ curto;
  - recomendacao de leitura.
- Prioridade: media.

### `site-footer`

- Nome sugerido no admin: `Rodape do site`.
- Uso: `footer.php`.
- Comportamento: grid responsivo de blocos no rodape.
- Conteudo recomendado:
  - navegacao curta;
  - texto institucional;
  - categorias;
  - links de suporte;
  - CTA secundario.
- Prioridade: baixa/media.

### `front-page-aside`

- Nome sugerido no admin: `Apoio da pagina inicial`.
- Uso: homepage, apenas se houver decisao de produto para area editavel.
- Comportamento: bloco/faixa dentro da homepage, nao uma sidebar permanente.
- Conteudo recomendado:
  - prova social compacta;
  - aviso de turma;
  - captura de lead;
  - link para artigos recentes.
- Prioridade: baixa. A homepage atual ja e composta por patterns do Design System, entao esta area so deve entrar se houver necessidade editorial frequente.

## Widgets/blocos recomendados

### Base WordPress nativa

Usar primeiro:

- Search;
- Latest Posts;
- Categories;
- Tag Cloud;
- Archives, se houver utilidade editorial;
- Navigation/Menu, quando for link list simples;
- Paragraph/Heading/List/Button/Image/Group para composicoes editoriais simples.

Evitar no primeiro ciclo:

- Calendar, Meta, RSS e widgets administrativos sem valor claro para o usuario final;
- widgets customizados para listas de posts antes de provar que os blocos nativos nao atendem;
- dependencia de plugin de widgets para algo que o tema pode oferecer com area + pattern.

### Composicoes do tema

Oferecer patterns para acelerar a montagem:

- `eumilitar/sidebar-blog`: busca + recentes + categorias + tags + CTA compacto;
- `eumilitar/after-post-cta`: bloco `ds-cta` horizontal para area apos artigo;
- `eumilitar/capture-compact`: formulario curto baseado em primitives do DS e adapter local de largura estreita.

Esses patterns devem reaproveitar classes e markup do Design System quando o contrato existir. Quando a largura estreita exigir ajuste local, usar classes locais do tema como adaptacao temporaria e registrar a lacuna em `docs/design-system-gaps.md`.

Ficaram deliberadamente fora do primeiro ciclo: `single-post-sidebar`, pattern especifico de sidebar de artigo e FAQ compacto. A decisao atual e manter a leitura do artigo limpa e usar `after-post-content` para conversao contextual.

## Forma de implementacao

### 1. Registro de areas

Criar `inc/widgets.php` e inclui-lo em `functions.php`.

Registrar as areas em `widgets_init`, com IDs estaveis:

- `blog-sidebar`;
- `after-post-content`;
- `site-footer`;
- `single-post-sidebar`, apenas se a leitura do artigo justificar uma sidebar permanente;
- `front-page-aside`, apenas se a decisao de produto confirmar a necessidade.

Usar wrappers semanticamente neutros e estilizaveis:

- `before_sidebar`: container da area;
- `after_sidebar`: fechamento da area;
- `before_widget`: `<section id="%1$s" class="widget %2$s">`;
- `after_widget`: `</section>`;
- `before_title`: `<h2 class="widget__title">`;
- `after_title`: `</h2>`.

Incluir `show_in_rest => true` para manter as areas visiveis no fluxo moderno de widgets/blocos.

### 2. Renderizacao nos templates

Criar um helper em `inc/widgets.php`, por exemplo `eumilitar_render_widget_area( $id, $args = array() )`, para centralizar:

- checagem com `is_active_sidebar()`;
- `aria-label`/heading quando necessario;
- classes locais de layout;
- fallback vazio sem markup sobrando.

Aplicar:

- `home.php`, `archive.php`, `category.php`, `tag.php`, `search.php`: layout `content + blog-sidebar`;
- `single.php`: layout de artigo com sidebar opcional ou area apos conteudo;
- `footer.php`: rodape com widget area opcional.

### 3. CSS

Adicionar estilos em `src/styles/theme.css` para:

- grid editorial com sidebar;
- empilhamento mobile;
- `.widget-area`, `.widget`, `.widget__title`;
- adaptadores para classes comuns de blocos dentro de widgets, como `.wp-block-search`, `.wp-block-latest-posts`, `.wp-block-categories`, `.wp-block-tag-cloud`;
- estados de foco e formularios usando tokens e primitives do Design System.

Nao recriar tokens. Usar `var(--...)` ja fornecido pelos pacotes.

### 4. Patterns e seed local

Registrar patterns em `patterns/` para composicoes de widget.

Atualizar `scripts/seed-blog-content.php` para popular as areas principais no ambiente local apenas se isso for necessario para smoke visual e testes E2E. O seed deve continuar idempotente.

### 5. Testes

Adicionar cobertura proporcional:

- PHPUnit: areas registradas com IDs esperados e argumentos principais.
- E2E: blog com sidebar em desktop/mobile, sem erro de console e sem quebra de acessibilidade basica.
- Static/build: validar que os novos arquivos entram no build e no ZIP quando aplicavel.

## Gaps do Design System

Ja confirmado no pacote instalado:

- existem primitives como `.ds-card`, `.ds-button`, `.ds-badge`, inputs e `.ds-pagination`;
- existem patterns de pagina/secoes: `hero`, `urgency`, `faq`, `capture`, `benefits`, `testimonials`, `cta`;
- existem componentes web como navbar, breadcrumbs, drawer, tabs, stat, status, list, divider e pagination;
- nao ha componente/pattern especifico para sidebar editorial, widget card, lista compacta de posts, lista de categorias/tags ou captura compacta para coluna estreita.

Todo componente local criado para essa frente deve ser registrado em `docs/design-system-gaps.md` com:

- status;
- locais de uso;
- necessidade;
- o que existe hoje no DS;
- limite encontrado;
- decisao temporaria no tema.

Gaps iniciais a acompanhar:

- area/sidebar editorial;
- wrapper visual de widget;
- lista compacta de posts;
- lista de categorias/tags/topicos;
- CTA compacto para sidebar;
- captura compacta para sidebar;
- bloco "apos artigo" para conversao/editorial.

## Ordem recomendada

1. Implementar `blog-sidebar` e layout de listagens.
2. Adicionar styles para blocos nativos mais provaveis: busca, recentes, categorias e tags.
3. Registrar gaps dos adapters locais usados.
4. Validar desktop/mobile com conteudo seedado.
5. Implementar `after-post-content` antes de `single-post-sidebar`, porque tende a converter melhor sem comprimir a leitura.
6. Avaliar `site-footer`.
7. So depois criar widgets customizados, se algum caso real nao couber em blocos/patterns.
