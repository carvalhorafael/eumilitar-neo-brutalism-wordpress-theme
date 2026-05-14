# Plano de Desenvolvimento do Tema WordPress EuMilitar

## Objetivo

Criar um tema WordPress para a EuMilitar que consuma o design system publicado como biblioteca, sem recriar tokens, componentes ou padrões visuais dentro do tema.

O tema deve funcionar como um consumer/adaptador WordPress do design system. A fonte de verdade continua sendo o repositório `eumilitar-design-system`.

Referências principais:

- Repositório do design system: https://github.com/carvalhorafael/eumilitar-design-system
- Documentação pública: https://eumilitar-design-system.vercel.app/
- Releases dos pacotes: https://github.com/carvalhorafael/eumilitar-design-system/releases

## Entendimento do design system

O design system já está estruturado como biblioteca distribuível em camadas:

- `@carvalhorafael/eumilitar-tokens`: fonte de verdade dos valores visuais, com CSS e JSON.
- `@carvalhorafael/eumilitar-css`: camada visual compartilhada e agnóstica de framework.
- `@carvalhorafael/eumilitar-web`: markup HTML canônico e comportamento progressivo para sites sem React.
- `@carvalhorafael/eumilitar-patterns`: contratos de blocos, anatomia, variantes, tokens e campos CMS.
- `@carvalhorafael/eumilitar-ui`: adapter React, não prioritário para este tema WordPress.

Para WordPress, o foco principal deve ser:

1. consumir `tokens`;
2. consumir `css`;
3. usar `web` como contrato de markup e JS progressivo;
4. usar `patterns` como contrato de composição e modelagem dos blocos.

O WordPress não deve virar fonte da verdade do design system. Elementor também não deve redefinir a linguagem visual; ele deve operar sobre a base carregada pelo tema.

## Stack de desenvolvimento recomendada

Stack inicial:

- WordPress local via `@wordpress/env`.
- Docker como runtime do WordPress, gerenciado pelo `wp-env`.
- Node/npm para instalar pacotes do design system e rodar o build.
- Vite para compilar CSS/JS do tema.
- PHP 8.3 no ambiente local.
- WordPress Coding Standards para lint PHP.
- Theme Check para validação de empacotamento do tema.
- Playwright ou smoke visual manual/automatizado quando houver páginas de referência.

Decisão: usar `@wordpress/env` em vez de um `docker-compose.yml` próprio no primeiro ciclo.

Motivo:

- é a ferramenta oficial do ecossistema WordPress para ambientes locais de temas e plugins;
- usa Docker por baixo;
- reduz a quantidade de infraestrutura mantida neste repositório;
- permite montar o tema atual diretamente dentro do WordPress local;
- facilita onboarding de outros agentes/desenvolvedores.

Um `docker-compose.yml` próprio só deve ser considerado se precisarmos de controle mais profundo sobre servidor web, banco, volumes, plugins pagos ou espelhamento de produção.

## Fluxo local esperado

Com Docker rodando:

```bash
npm install
npm run wp:start
npm run dev
```

URLs locais esperadas:

```txt
WordPress: http://localhost:8888
Admin:     http://localhost:8888/wp-admin
Login:     admin
Senha:     password
```

O WordPress local deve montar este repositório como tema. O Vite deve rodar em paralelo para compilar CSS/JS durante o desenvolvimento.

## Configuracao esperada do wp-env

Arquivo futuro: `.wp-env.json`

```json
{
  "core": null,
  "phpVersion": "8.3",
  "port": 8888,
  "themes": ["."],
  "plugins": ["elementor"],
  "config": {
    "WP_DEBUG": true,
    "WP_DEBUG_LOG": true,
    "SCRIPT_DEBUG": true
  }
}
```

Observações:

- `core: null` usa a versão estável atual do WordPress.
- `themes: ["."]` monta o tema atual.
- `elementor` deve ser usado para validar compatibilidade básica.
- Elementor Pro, se necessário, não deve ser versionado neste repositório.

## Pacotes do design system

O tema deve instalar os pacotes publicados via GitHub Packages.

Arquivo futuro: `.npmrc.example`

```ini
@carvalhorafael:registry=https://npm.pkg.github.com
//npm.pkg.github.com/:_authToken=SEU_TOKEN_GITHUB
```

Dependências esperadas:

```json
{
  "dependencies": {
    "@carvalhorafael/eumilitar-tokens": "^0.2.0",
    "@carvalhorafael/eumilitar-css": "^0.2.0",
    "@carvalhorafael/eumilitar-web": "^0.2.0",
    "@carvalhorafael/eumilitar-patterns": "^0.2.0"
  }
}
```

Por enquanto, não incluir `@carvalhorafael/eumilitar-ui`, porque o tema WordPress não deve depender do adapter React.

## Estrutura inicial do tema

Estrutura proposta:

```txt
eumilitar-neo-brutalism-wordpress-theme/
  style.css
  functions.php
  theme.json
  package.json
  .wp-env.json
  .npmrc.example
  vite.config.js
  inc/
    setup.php
    assets.php
    vite.php
    patterns.php
    elementor.php
    template-tags.php
  src/
    main.js
    editor.js
    styles/
      main.css
      theme.css
      editor.css
      elementor.css
  assets/
    dist/
  template-parts/
    layout/
    patterns/
      hero.php
      urgency.php
      faq.php
      capture.php
      benefits.php
      testimonials.php
      cta.php
  patterns/
    hero.php
    faq.php
    cta.php
    landing-page.php
  scripts/
    build-theme-zip.mjs
  docs/
    plano-desenvolvimento-tema.md
```

## Estrategia de build

O CSS principal deve importar o design system:

```css
@import "@carvalhorafael/eumilitar-tokens";
@import "@carvalhorafael/eumilitar-css";
@import "./styles/theme.css";
```

O JS principal deve inicializar apenas comportamentos progressivos:

```js
import { enhanceAccordion } from "@carvalhorafael/eumilitar-web";

enhanceAccordion(document);
```

Entradas previstas no Vite:

- `src/main.js`: frontend público.
- `src/editor.js`: editor do WordPress/Gutenberg.
- `src/styles/main.css`: CSS global do tema.
- `src/styles/editor.css`: CSS do editor.
- `src/styles/elementor.css`: ajustes mínimos de compatibilidade Elementor.

Saída de produção:

```txt
assets/dist/manifest.json
assets/dist/assets/*.css
assets/dist/assets/*.js
```

Em desenvolvimento, o WordPress pode carregar o Vite dev server. Em produção, o WordPress deve carregar arquivos compilados a partir do `manifest.json`.

## Carregamento de assets no WordPress

O tema deve centralizar o carregamento em `inc/assets.php` e `inc/vite.php`.

Hooks previstos:

- `wp_enqueue_scripts`: frontend público.
- `enqueue_block_editor_assets`: assets do editor.
- `after_setup_theme`: suporte de tema, menus, thumbnails, editor styles.

Regras:

- carregar a base do design system antes de ajustes do tema;
- versionar assets de produção por hash do Vite;
- em desenvolvimento, carregar o Vite client e entrada `src/main.js`;
- carregar CSS Elementor apenas se Elementor estiver ativo;
- evitar CSS inline como fonte de verdade de tokens.

## theme.json

O `theme.json` deve ser mínimo e subordinado ao design system.

Uso recomendado:

- configurar largura de conteúdo;
- habilitar recursos do editor;
- alinhar espaçamentos editoriais;
- expor presets apenas se forem derivados de `@carvalhorafael/eumilitar-tokens/json`.

O `theme.json` não deve recriar manualmente paleta, tipografia, sombras e raios como fonte paralela.

## Padrões e template parts

Blocos suportados pelo contrato atual de `@carvalhorafael/eumilitar-web`:

- `hero`
- `urgency`
- `faq`
- `capture`
- `benefits`
- `testimonials`
- `cta`

Estratégia:

- criar partials PHP em `template-parts/patterns/*.php`;
- cada partial recebe dados PHP e renderiza markup compatível com as classes `ds-*`;
- registrar block patterns em `patterns/*.php`;
- usar `@carvalhorafael/eumilitar-patterns` para orientar campos, variantes e anatomia;
- usar `@carvalhorafael/eumilitar-web` como contrato de markup e comportamento;
- não depender de Node em runtime no WordPress.

Classes base estáveis:

- `ds-hero`
- `ds-urgency`
- `ds-faq`
- `ds-capture`
- `ds-benefits`
- `ds-testimonials`
- `ds-cta`

## Blog e artigos

A camada editorial do blog deve seguir a hierarquia nativa de templates do WordPress para temas clássicos/híbridos.

Estrutura inicial:

- `home.php`: listagem de posts do blog, especialmente quando o WordPress usa front page estática e uma página separada para posts.
- `single.php`: post individual.
- `template-parts/content-excerpt.php`: card/teaser reutilizável da listagem.
- `template-parts/content-single.php`: conteúdo completo de um artigo.
- `archive.php`: arquivos gerais do WordPress.
- `category.php`: arquivo de categoria.
- `tag.php`: arquivo de tag.
- `search.php`: resultados de busca.
- `404.php`: página não encontrada com busca e retorno para artigos.
- `index.php`: fallback obrigatório do tema, não como template principal do blog.

Regras:

- preferir WordPress Loop, `get_template_part()`, `the_post_thumbnail()`, `the_excerpt()`, `wp_link_pages()` e APIs nativas de navegação/paginação;
- usar primitives do Design System quando existirem, como `.ds-button`, `.ds-badge` e `.ds-pagination`;
- não recriar tokens visuais no tema;
- quando faltar componente/pattern editorial no Design System, registrar o gap em `docs/design-system-gaps.md` com local de uso e decisão temporária.

Atributos estáveis para accordion:

- `data-accordion-root`
- `data-accordion-item`
- `data-accordion-trigger`
- `data-accordion-panel`

## Compatibilidade com Elementor

Elementor deve operar sobre a base do tema.

Regras:

- o tema carrega tokens e CSS global;
- templates Elementor devem usar classes `ds-*` sempre que possível;
- `src/styles/elementor.css` deve conter apenas compatibilidade e pequenos ajustes;
- Elementor não deve redefinir paleta, tipografia e componentes como fonte paralela;
- Elementor Pro, licenças e arquivos privados não devem ser commitados.

Validações futuras:

- página simples do tema sem Elementor;
- página Gutenberg com patterns;
- página Elementor usando classes do design system;
- comparação visual básica entre esses três cenários.

## Empacotamento público

O ZIP público do tema deve conter apenas o necessário para rodar em WordPress.

Incluir:

```txt
style.css
functions.php
theme.json
inc/
template-parts/
patterns/
assets/dist/
screenshot.png
README.md
```

Excluir:

```txt
node_modules/
src/
.wp-env.json
.npmrc
.env
vite.config.js
scripts/
docs/
package-lock.json
package.json
```

Observação: `package.json`, `src/`, `vite.config.js`, `scripts/` e `docs/` devem ficar no repositório de desenvolvimento, mas não precisam ir no ZIP público.

Comando futuro:

```bash
npm run theme:zip
```

Esse comando deve:

1. limpar build anterior;
2. rodar `npm run build`;
3. validar presença de `assets/dist/manifest.json`;
4. montar uma pasta temporária com allowlist de arquivos;
5. gerar `dist/eumilitar-neo-brutalism-wordpress-theme.zip`.

## Fase 1 - Fundação local

Objetivo: ter WordPress local rodando com o tema ativo e build básico funcionando.

Tarefas:

- [x] Criar arquivos mínimos do tema: `style.css`, `functions.php`, `index.php`.
- [x] Criar `package.json`.
- [x] Adicionar `@wordpress/env`.
- [x] Criar `.wp-env.json`.
- [x] Subir WordPress local em `localhost:8888`.
- [x] Ativar o tema no admin.
- [x] Adicionar Vite.
- [x] Criar `src/main.js` e `src/styles/main.css`.
- [x] Criar helpers `inc/assets.php` e `inc/vite.php`.
- [ ] Validar carregamento em modo dev.
- [x] Validar build de produção.

Critério de aceite:

- WordPress local abre em `http://localhost:8888`;
- tema aparece e pode ser ativado;
- CSS/JS do tema carregam no frontend;
- `npm run build` gera `assets/dist/manifest.json`.

Checkpoint atual:

- esqueleto do tema criado;
- integração Vite dev/prod criada;
- `.wp-env.json` criado com WordPress local, PHP 8.3 e Elementor;
- `npm install` passou depois da criação do `.npmrc` local com token do GitHub Packages;
- `npm run build` gerou `assets/dist/.vite/manifest.json`;
- `npm run theme:zip` gerou `dist/eumilitar-neo-brutalism-wordpress-theme.zip`;
- `npm run wp:start` ainda depende do Docker Desktop estar rodando; a tentativa atual falhou porque o Docker daemon não estava disponível em `~/.docker/run/docker.sock`.
- após o Docker ficar disponível, o tema foi ativado em `http://localhost:8888/` e a homepage passou a ser usada como smoke visual do consumer.
- `wp-env run cli wp theme list` confirmou `eumilitar-neo-brutalism-wordpress-theme` como tema ativo;
- `php -l` dentro do container não encontrou erros de sintaxe nos arquivos PHP do tema.

Nota de integração:

- a versão atual de `@carvalhorafael/eumilitar-css` estiliza layout dos patterns, mas `ds-button` e `ds-badge` ainda chegam como primitives estruturais;
- o tema contém uma ponte visual mínima para esses primitives em `src/styles/theme.css`, usando apenas tokens do design system;
- quando o design system passar a exportar estilos completos desses primitives no pacote CSS, essa ponte deve ser removida ou reduzida.

## Fase 2 - Consumo real do design system

Objetivo: provar que o tema consome a biblioteca publicada corretamente.

Tarefas:

- [x] Criar `.npmrc.example`.
- [x] Configurar autenticação local no GitHub Packages sem commitar token.
- [x] Instalar `@carvalhorafael/eumilitar-tokens`.
- [x] Instalar `@carvalhorafael/eumilitar-css`.
- [x] Instalar `@carvalhorafael/eumilitar-web`.
- [x] Instalar `@carvalhorafael/eumilitar-patterns`.
- [x] Importar tokens e CSS no CSS principal.
- [x] Inicializar `enhanceAccordion(document)`.
- [x] Criar uma página de smoke test no WordPress.

Critério de aceite:

- os tokens CSS estão disponíveis no frontend;
- classes `ds-*` recebem estilo esperado;
- accordion funciona com comportamento progressivo;
- o tema não contém cópia manual dos tokens.

Checkpoint atual:

- `front-page.php` renderiza Hero, FAQ e CTA com partials PHP;
- Playwright confirmou os blocos em `http://localhost:8888/`;
- screenshot salvo localmente em `eumilitar-theme-home.png`.

## Fase 3 - Primeiros padrões WordPress

Objetivo: transformar os primeiros contratos do design system em partes reutilizáveis do tema.

Escopo inicial:

- `hero`
- `faq`
- `cta`

Tarefas:

- [x] Criar `template-parts/patterns/hero.php`.
- [x] Criar `template-parts/patterns/faq.php`.
- [x] Criar `template-parts/patterns/cta.php`.
- [x] Criar helpers PHP para badge e CTA.
- [x] Registrar block patterns correspondentes em `patterns/`.
- [x] Garantir markup compatível com `@carvalhorafael/eumilitar-web`.
- [x] Criar página local com os três padrões.

Critério de aceite:

- os padrões renderizam no frontend;
- usam classes base estáveis (`ds-hero`, `ds-faq`, `ds-cta`);
- FAQ usa data attributes esperados pelo accordion;
- não há CSS novo recriando visual já existente no design system.

## Fase 4 - Biblioteca completa de padrões

Objetivo: expandir a cobertura dos blocos suportados.

Escopo:

- `urgency`
- `capture`
- `benefits`
- `testimonials`

Tarefas:

- [x] Criar partial para `urgency`.
- [x] Criar partial para `capture`.
- [x] Criar partial para `benefits`.
- [x] Criar partial para `testimonials`.
- [x] Registrar block patterns correspondentes.
- [x] Mapear campos CMS a partir de `@carvalhorafael/eumilitar-patterns`.
- [x] Documentar dados esperados por cada partial.

Critério de aceite:

- todos os blocos públicos do contrato `web` têm representação no tema;
- variações principais estão cobertas;
- estrutura dos campos segue a anatomia dos patterns.

Checkpoint atual:

- `front-page.php` renderiza os sete blocos do contrato público `@carvalhorafael/eumilitar-web`;
- partials PHP criados em `template-parts/patterns/` para `urgency`, `capture`, `benefits` e `testimonials`;
- block patterns criados em `patterns/` para os mesmos blocos;
- composição `patterns/landing-page.php` atualizada para incluir todos os blocos;
- Playwright confirmou a homepage completa em `http://localhost:8888/`;
- `npm run build` passou;
- `php -l` dentro do container passou para os arquivos PHP do tema.

## Fase 5 - Editor e Elementor

Objetivo: validar o uso do tema em Gutenberg e Elementor sem perder a base do design system.

Tarefas:

- [x] Criar `src/styles/editor.css`.
- [x] Configurar editor styles.
- [x] Criar `src/styles/elementor.css`.
- [x] Carregar CSS Elementor apenas quando necessário.
- [x] Instalar/ativar Elementor no ambiente local.
- [x] Criar página Elementor usando classes `ds-*`.
- [x] Comparar página Elementor com página de patterns nativos.

Critério de aceite:

- editor WordPress exibe base visual coerente;
- Elementor funciona sobre o tema;
- Elementor não redefine o sistema visual;
- ajustes Elementor ficam isolados.

Checkpoint atual:

- patterns `eumilitar/*` registrados explicitamente em PHP para compatibilidade com tema clássico/híbrido;
- `src/styles/editor.css` importa tokens, CSS compartilhado e a ponte visual do tema;
- página Gutenberg smoke criada em `http://localhost:8888/?page_id=8`;
- Elementor confirmado como plugin ativo no ambiente local;
- `src/styles/elementor.css` ajusta largura, título padrão e conflitos de link sem redefinir o design system;
- página Elementor smoke criada em `http://localhost:8888/?page_id=9`;
- documentação adicionada em `docs/editor-elementor.md`.

## Fase 6 - Qualidade e release

Objetivo: preparar o tema para distribuição pública.

Tarefas:

- [x] Adicionar WordPress Coding Standards.
- [x] Configurar PHPCS.
- [x] Adicionar Theme Check ao fluxo de validação.
- [x] Criar script `scripts/build-theme-zip.mjs`.
- [x] Criar allowlist de arquivos do ZIP.
- [x] Gerar pacote em `dist/`.
- [x] Testar instalação do ZIP em uma instância limpa.
- [x] Documentar processo de release no `README.md`.

Critério de aceite:

- `npm run build` passa;
- lint PHP passa;
- Theme Check não acusa problemas bloqueantes;
- ZIP instala em uma instalação WordPress limpa;
- tema funciona sem Node/npm em runtime.

Implementação:

- `composer.json` e `phpcs.xml.dist` definem PHPCS, WordPress Coding Standards e PHPCompatibilityWP;
- `npm run composer:install` instala as dependências PHP dentro do container `wp-env`;
- `npm run theme:check` executa Theme Check e bloqueia apenas problemas `REQUIRED`;
- `npm run theme:validate-zip` valida a allowlist do ZIP público;
- `npm run theme:test-install` instala o ZIP em uma cópia limpa da instância de testes;
- `npm run validate` concentra o fluxo de release local.

## Fase 7 - Widgets e areas editoriais editaveis

Objetivo: permitir que blog, artigos e rodape tenham areas editaveis pelo WordPress sem transformar o tema em uma biblioteca paralela de widgets.

Documento de referencia:

- `docs/widget-strategy.md`
- `docs/widget-implementation-plan.md`

Tarefas:

- [x] Criar `inc/widgets.php`.
- [x] Registrar `blog-sidebar`.
- [ ] Avaliar/registrar `single-post-sidebar` se a leitura do artigo justificar uma sidebar permanente.
- [x] Registrar `after-post-content`.
- [x] Registrar `site-footer`.
- [ ] Avaliar necessidade real de `front-page-aside`.
- [x] Renderizar sidebar nas listagens editoriais.
- [x] Renderizar area apos artigo antes dos comentarios.
- [x] Renderizar area opcional no rodape.
- [x] Criar styles para `.widget-area`, `.widget`, `.widget__title` e blocos nativos usados em widgets.
- [x] Criar patterns de composicao para sidebar/apos artigo quando fizer sentido.
- [x] Atualizar `docs/design-system-gaps.md` para todo adapter local sem equivalente no Design System.
- [x] Adicionar testes PHPUnit para areas registradas.
- [x] Adicionar smoke E2E desktop para blog com sidebar.
- [x] Adicionar smoke E2E mobile para blog com sidebar.

Critério de aceite:

- as areas aparecem no admin moderno de Widgets;
- as areas vazias nao geram markup visual quebrado;
- blog e artigo continuam responsivos em mobile;
- widgets nativos de busca, posts recentes, categorias e tags ficam coerentes com o Design System;
- qualquer componente local usado por falta de equivalente no Design System fica documentado em `docs/design-system-gaps.md`.

## Rotina de atualização do design system

Quando o design system publicar uma nova versão:

1. revisar releases/changelog;
2. atualizar versões no `package.json`;
3. rodar `npm install`;
4. rodar `npm run build`;
5. validar página de smoke test;
6. validar Gutenberg;
7. validar Elementor;
8. revisar mudanças visuais sensíveis;
9. publicar nova versão do tema apenas depois da validação.

Regra semver:

- `patch`: validar regressões visuais pontuais;
- `minor`: validar novos blocos, variantes e exports;
- `major`: revisar contratos de markup, tokens e CSS antes de atualizar.

## Decisões registradas

- O tema será um consumer externo do design system.
- O tema não deve recriar tokens, CSS base ou componentes visuais.
- O primeiro ambiente local será `@wordpress/env`.
- A compilação de assets será feita com Vite.
- O tema será inicialmente classic/hybrid, com PHP templates, `theme.json` mínimo e block patterns.
- Elementor será compatível, mas subordinado à base visual do tema.
- O ZIP público deve conter assets compilados e nenhum requisito de Node em runtime.
