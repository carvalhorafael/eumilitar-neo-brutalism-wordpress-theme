# Editor e Elementor

Este documento registra como validar e usar o tema no Gutenberg e no Elementor sem transformar o WordPress em fonte paralela do design system.

## Gutenberg

Os padrões do tema são registrados explicitamente em PHP para funcionarem em tema clássico/híbrido.

Categoria:

- `EuMilitar`

Padrões disponíveis:

- `eumilitar/hero`
- `eumilitar/urgency`
- `eumilitar/benefits`
- `eumilitar/testimonials`
- `eumilitar/capture`
- `eumilitar/faq`
- `eumilitar/cta`
- `eumilitar/landing-page`

Validação por WP-CLI:

```bash
npx wp-env run cli wp eval '$patterns = WP_Block_Patterns_Registry::get_instance()->get_all_registered(); $names = array_column($patterns, "name"); foreach (["eumilitar/hero","eumilitar/urgency","eumilitar/benefits","eumilitar/testimonials","eumilitar/capture","eumilitar/faq","eumilitar/cta","eumilitar/landing-page"] as $slug) { echo $slug . ":" . (in_array($slug, $names, true) ? "registered" : "missing") . "\n"; }'
```

Smoke page criada em desenvolvimento:

- `http://localhost:8888/?page_id=8`

Essa página usa o pattern `eumilitar/landing-page` e valida o fluxo de renderização de página criada via Gutenberg.

## Editor styles

O arquivo `src/styles/editor.css` importa:

- `@carvalhorafael/eumilitar-tokens`
- `@carvalhorafael/eumilitar-css`
- `src/styles/theme.css`

Isso garante que os patterns no editor usem a mesma base visual do frontend, incluindo a ponte temporária para `ds-button`, `ds-badge` e campos de formulário.

Regra:

- ajustes editoriais devem ficar em `src/styles/editor.css`;
- não duplicar tokens;
- não criar uma segunda linguagem visual para Gutenberg.

## Elementor

Elementor está instalado e ativo no ambiente local via `wp-env`.

Validação:

```bash
npx wp-env run cli wp plugin list
```

Smoke page criada em desenvolvimento:

- `http://localhost:8888/?page_id=9`

Essa página usa metadados do Elementor e um widget HTML com classes `ds-*`, validando que a base visual do tema também funciona no fluxo Elementor.

## Widgets EuMilitar no Elementor

Plano de trabalho: `docs/elementor-builder-plan.md`.

O tema registra uma categoria `EuMilitar` no Elementor para concentrar widgets controlados pelo Design System.

Fase 1:

- `Hero EuMilitar`;
- `CTA EuMilitar`;
- `FAQ EuMilitar`.

Fase 2:

- `Cursos EuMilitar`;
- `Card de Curso EuMilitar`;
- `Aprovados EuMilitar`;
- `Por Que Escolher EuMilitar`;
- `Barra de Confiança EuMilitar`.

Fase 3:

- `Benefícios EuMilitar`;
- `Urgência EuMilitar`.

Esses widgets devem ser usados como ponto de partida para homes, landings de cursos e paginas de venda. Eles expõem campos de conteúdo e variantes aprovadas, mas não devem abrir controles livres de cor, tipografia, sombra, raio ou espaçamento.

Regra:

- Elementor monta a página;
- widgets EuMilitar definem as seções principais;
- o Design System continua sendo a fonte visual;
- partials `template-parts/patterns/*` continuam sendo o contrato de markup.

## CSS Elementor

O arquivo `src/styles/elementor.css` deve conter apenas compatibilidade mínima:

- liberar largura de páginas Elementor;
- esconder o título padrão da página quando Elementor controla a composição;
- preservar `ds-button` sem sobrescrever cor por regras genéricas de links;
- garantir `box-sizing` consistente nos blocos `ds-*`.

Regra:

- Elementor compõe layout;
- o design system continua definindo linguagem visual;
- não configurar Elementor como fonte paralela de cores, tipografia, sombras ou componentes.

## Login local

- Admin: http://localhost:8888/wp-admin
- Usuário: `admin`
- Senha: `password`

Essas credenciais são apenas do ambiente local `wp-env`.
