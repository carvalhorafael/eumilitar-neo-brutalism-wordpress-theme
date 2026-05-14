# Plano de implementacao de widgets

Este plano transforma a estrategia de `docs/widget-strategy.md` em uma sequencia de trabalho executavel para o tema EuMilitar.

## Objetivo

Criar areas editaveis de widgets para blog, artigos e rodape usando as APIs nativas do WordPress e mantendo o tema como consumer do Design System.

Resultado esperado:

- o admin moderno de Widgets deve listar as areas registradas pelo tema;
- o blog deve aceitar uma sidebar editorial com blocos nativos;
- artigos devem poder receber uma area editorial apos o conteudo;
- o rodape deve ter uma area opcional editavel;
- todo adapter local sem equivalente no Design System deve continuar documentado em `docs/design-system-gaps.md`.

## Referencias tecnicas

- WordPress `register_sidebar()`: registrar areas no hook `widgets_init`, com IDs explicitos e wrappers de markup.
- WordPress `dynamic_sidebar()`: renderizar uma area por ID e retornar `false` quando nao houver widgets.
- WordPress `is_active_sidebar()`: evitar markup vazio em areas sem widgets.
- Gutenberg Widgets Block Editor: areas registradas pelo tema podem receber blocos e widgets tradicionais no editor moderno.

## Escopo inicial

Implementar agora:

- `blog-sidebar`;
- `after-post-content`;
- `site-footer`;
- estilos base para widgets e blocos nativos comuns;
- testes PHPUnit e E2E proporcionais.

Planejar, mas deixar desligado ate haver necessidade real:

- `single-post-sidebar`;
- `front-page-aside`;
- widgets PHP customizados com `WP_Widget`.

Motivo: `blog-sidebar` resolve a necessidade principal da listagem, `after-post-content` adiciona conversao sem prejudicar leitura, e `site-footer` e uma extensao natural de area editavel. Sidebar permanente em artigo pode comprimir a experiencia de leitura e deve ser validada depois.

## Onda 1 - Infraestrutura de areas

Arquivos previstos:

- `functions.php`;
- `inc/widgets.php`;
- `tests/php/ThemeSetupTest.php` ou novo `tests/php/WidgetAreasTest.php`.

Tarefas:

- [x] Criar `inc/widgets.php`.
- [x] Incluir `inc/widgets.php` em `functions.php`.
- [x] Criar `eumilitar_register_widget_areas()` no hook `widgets_init`.
- [x] Registrar `blog-sidebar`.
- [x] Registrar `after-post-content`.
- [x] Registrar `site-footer`.
- [x] Usar `show_in_rest => true` nas areas.
- [x] Definir wrappers estaveis:
  - `before_sidebar`: `<aside id="%1$s" class="widget-area %2$s">` ou container equivalente por area.
  - `after_sidebar`: `</aside>`.
  - `before_widget`: `<section id="%1$s" class="widget %2$s">`.
  - `after_widget`: `</section>`.
  - `before_title`: `<h2 class="widget__title">`.
  - `after_title`: `</h2>`.
- [x] Criar helper `eumilitar_render_widget_area( $id, $args = array() )`.
- [x] Fazer o helper retornar cedo quando `is_active_sidebar( $id )` for falso.

Critérios de aceite:

- `wp_registered_sidebars()` contem os IDs esperados.
- Cada area tem `show_in_rest` ativo.
- Areas vazias nao imprimem markup.
- Teste PHP cobre IDs, nomes e wrappers principais.

Validacao:

```bash
npm run test:php
```

## Onda 2 - Sidebar do blog

Arquivos previstos:

- `home.php`;
- `archive.php`;
- `category.php`;
- `tag.php`;
- `search.php`;
- `src/styles/theme.css`;
- `tests/e2e/front-end.spec.js`.

Tarefas:

- [x] Criar layout editorial com duas colunas quando `blog-sidebar` estiver ativa.
- [x] Manter layout atual de uma coluna quando a sidebar estiver vazia.
- [x] Renderizar `blog-sidebar` em:
  - `home.php`;
  - `archive.php`;
  - `category.php`;
  - `tag.php`;
  - `search.php`.
- [x] Adicionar classes de layout, por exemplo:
  - `.site-main--with-sidebar`;
  - `.content-sidebar-layout`;
  - `.content-sidebar-layout__main`;
  - `.content-sidebar-layout__sidebar`.
- [x] Garantir empilhamento mobile com conteudo principal antes da sidebar.
- [x] Estilizar widgets nativos provaveis:
  - `.wp-block-search`;
  - `.wp-block-latest-posts`;
  - `.wp-block-categories`;
  - `.wp-block-tag-cloud`.

Critérios de aceite:

- Listagens editoriais continuam iguais quando `blog-sidebar` esta vazia.
- Com widgets ativos, desktop mostra conteudo + sidebar.
- Mobile empilha sem overflow horizontal.
- Busca, recentes, categorias e tags ficam visualmente coerentes com tokens/primitives do DS.

Validacao:

```bash
npm run build
npm run test:e2e
```

## Onda 3 - Seed local e smoke visual

Arquivos previstos:

- `scripts/seed-blog-content.php`;
- `tests/e2e/front-end.spec.js`.

Tarefas:

- [x] Avaliar se o seed deve popular `sidebars_widgets` para `blog-sidebar`.
- [x] Se sim, criar conteudo idempotente com blocos nativos:
  - Search;
  - Latest Posts;
  - Categories;
  - Tag Cloud;
  - Group/Button ou HTML simples para CTA compacto.
- [x] Garantir cleanup/isolamento nos testes E2E para nao depender de estado manual do admin.
- [x] Adicionar smoke E2E para sidebar em desktop.
- [ ] Adicionar smoke E2E para empilhamento mobile.
- [ ] Rodar axe na pagina de blog com sidebar ativa.

Critérios de aceite:

- `npm run seed:blog` produz uma sidebar previsivel no ambiente local.
- Teste E2E consegue montar ou validar a sidebar sem depender de cliques no admin.
- Nao ha violacoes axe novas na pagina testada.

Validacao:

```bash
npm run seed:blog
npm run test:e2e
```

## Onda 4 - Area apos artigo

Arquivos previstos:

- `single.php` ou `template-parts/content-single.php`;
- `src/styles/theme.css`;
- `tests/e2e/front-end.spec.js`.

Tarefas:

- [x] Renderizar `after-post-content` apos o conteudo do artigo e antes de comentarios.
- [x] Manter comentarios funcionando como hoje.
- [x] Criar estilo de faixa/bloco horizontal para widgets nessa area.
- [ ] Garantir que um pattern/CTA com classes `ds-*` funcione bem nessa posicao.
- [x] Adicionar smoke E2E para artigo com area apos conteudo ativa.

Critérios de aceite:

- Artigo sem widgets fica visualmente igual ao estado atual.
- Artigo com area ativa exibe widgets antes de comentarios.
- Nao ha regressao na lista de comentarios, formulario ou navegacao de artigo.

Validacao:

```bash
npm run test:php
npm run test:e2e
```

## Onda 5 - Rodape editavel

Arquivos previstos:

- `footer.php`;
- `src/styles/theme.css`;
- `tests/e2e/front-end.spec.js`.

Tarefas:

- [x] Renderizar `site-footer` dentro do rodape existente.
- [x] Preservar conteudo institucional atual do footer, se houver.
- [x] Criar grid responsivo para blocos no rodape.
- [x] Estilizar blocos de navegacao/listas no contexto do footer.
- [ ] Adicionar teste simples para footer com area ativa.

Critérios de aceite:

- Rodape vazio continua sem espaco quebrado.
- Rodape com widgets aceita navegacao, texto e categorias.
- Contraste e foco continuam coerentes com o Design System.

Validacao:

```bash
npm run build
npm run test:e2e
```

## Onda 6 - Patterns de composicao

Arquivos previstos:

- `patterns/sidebar-blog.php`;
- `patterns/after-post-cta.php`;
- `inc/patterns.php`;
- `docs/design-system-gaps.md`.

Tarefas:

- [ ] Criar pattern `eumilitar/sidebar-blog` se o editor de Widgets aceitar bem a composicao.
- [ ] Criar pattern `eumilitar/after-post-cta`.
- [ ] Reutilizar `ds-cta`, `ds-capture`, `.ds-card`, `.ds-button` e `.ds-badge` quando possivel.
- [ ] Evitar criar markup que pareca novo componente oficial do DS sem registrar gap.
- [ ] Atualizar a lista de patterns em testes de registro, se aplicavel.

Critérios de aceite:

- Patterns aparecem na categoria `EuMilitar`.
- Patterns funcionam como ponto de partida, nao como dependencia obrigatoria da sidebar.
- Gaps continuam registrados quando houver adapter local.

Validacao:

```bash
npm run test:php
npm run test:e2e
```

## Onda 7 - Hardening e release readiness

Arquivos previstos:

- `docs/widget-strategy.md`;
- `docs/design-system-gaps.md`;
- `docs/plano-desenvolvimento-tema.md`;
- `README.md`;
- arquivos de build/zip, se a allowlist exigir ajuste.

Tarefas:

- [x] Marcar progresso da Fase 7 em `docs/plano-desenvolvimento-tema.md`.
- [x] Atualizar `docs/widget-strategy.md` com decisoes finais tomadas durante implementacao.
- [ ] Revisar `docs/design-system-gaps.md` para remover duplicidade ou registrar novos gaps descobertos.
- [x] Confirmar que novos arquivos entram no ZIP publico quando necessario.
- [ ] Rodar validacao completa.

Critérios de aceite:

- `npm run validate` passa.
- ZIP publico inclui `inc/widgets.php`, templates alterados e assets compilados.
- Documentacao reflete exatamente o que foi implementado.

Validacao:

```bash
npm run validate
```

## Decisoes adiadas

### `single-post-sidebar`

Implementar apenas se os testes visuais mostrarem que uma sidebar permanente melhora o artigo sem comprimir demais a leitura. Enquanto isso, priorizar `after-post-content`.

### `front-page-aside`

Implementar apenas se houver necessidade editorial frequente na homepage. A homepage atual ja e composta por patterns controlados do Design System.

### Widgets PHP customizados

Evitar no primeiro ciclo. Criar `WP_Widget` somente se um caso real exigir configuracao propria que blocos, patterns ou template parts nao resolvam bem.

## Ordem de PRs sugerida

1. Infraestrutura + `blog-sidebar` sem seed.
2. CSS + E2E para sidebar do blog.
3. Seed local de widgets e patterns de composicao.
4. `after-post-content`.
5. `site-footer`.
6. Documentacao final + `npm run validate`.
