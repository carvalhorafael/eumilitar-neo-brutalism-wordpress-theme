# Plano Elementor e Design System

Este documento registra a estrategia para permitir que o time de marketing construa homes e paginas de venda no Elementor sem criar uma linguagem visual paralela ao EuMilitar Design System.

## Objetivo

Usar o Elementor como camada de composicao comercial, mantendo o tema como consumer/adaptador do Design System.

O time deve conseguir montar paginas avulsas com flexibilidade editorial, mas usando estruturas, variantes e controles aprovados pelo Design System.

## Principios

- Elementor compoe paginas; o Design System define a linguagem visual.
- Widgets EuMilitar devem priorizar conteudo, ordem e variantes controladas.
- Evitar controles livres de cor, tipografia, sombra, raio e espacamento quando isso criar uma fonte visual paralela.
- Reutilizar partials, classes `ds-*`, tokens e JS progressivo ja consumidos pelo tema.
- Criar widgets customizados apenas para estruturas que o time realmente usa em landing pages.

## Estrategia recomendada

### Camada 1 - Base do tema

O tema continua carregando tokens, CSS, scripts progressivos e compatibilidade Elementor.

Responsabilidades:

- garantir que paginas Elementor usem a mesma base visual do frontend;
- preservar classes `ds-*` dentro do canvas do Elementor;
- evitar que estilos genericos do Elementor quebrem botoes, formularios, navbar, cards e accordions do Design System.

### Camada 2 - Categoria EuMilitar no Elementor

Registrar uma categoria propria chamada `EuMilitar`.

Essa categoria deve concentrar widgets oficiais do tema para landing pages e paginas de venda.

### Camada 3 - Widgets controlados

Widgets devem expor campos comerciais e editoriais:

- textos;
- links;
- imagens, quando o pattern suportar;
- listas/repetidores;
- variantes aprovadas.

Widgets nao devem expor liberdade visual total por padrao.

## Fase 1

Status: implementada inicialmente.

Escopo:

- categoria Elementor `EuMilitar`;
- widget `Hero EuMilitar`;
- widget `CTA EuMilitar`;
- widget `FAQ EuMilitar`;
- renderizacao reaproveitando `template-parts/patterns/hero.php`, `cta.php` e `faq.php`;
- controles apenas para conteudo e variantes previstas.

Critérios de aceite:

- Elementor ativo mostra a categoria `EuMilitar`;
- os tres widgets aparecem nessa categoria;
- os widgets renderizam markup `ds-*` igual aos partials do tema;
- o FAQ preserva `data-accordion-*` para o JS progressivo;
- o tema continua funcionando sem Elementor ativo.

## Fases seguintes

### Fase 2 - Widgets comerciais

Status: implementada inicialmente.

Widgets:

- `Cursos EuMilitar`;
- `Card de Curso EuMilitar`;
- `Aprovados EuMilitar`;
- `Por Que Escolher EuMilitar`;
- `Barra de Confiança EuMilitar`.

Origem do escopo: pagina publica `https://lp.eumilitar.com/`, analisada em 2026-05-14.

Decisoes:

- cursos usam cards editaveis com informacoes comerciais, informacoes do concurso e lista de inclusos;
- listas longas nos cards usam campos de texto por linha para manter o painel do Elementor simples;
- os filtros da landing atual nao entram como comportamento interativo nesta fase;
- prova social entra como grade ou faixa horizontal de imagens, nao como carrossel JS;
- captura/lead fica fora desta fase porque a landing analisada esta orientada a compra direta.

### Fase 3 - Templates de pagina

Status: ajustada.

Decisao: nao criar templates completos de pagina nesta etapa. O time de marketing deve continuar montando as paginas livremente com widgets.

Widgets adicionados:

- `Benefícios EuMilitar`;
- `Urgência EuMilitar`.

Motivo:

- `Benefícios EuMilitar` cobre secoes intermediarias de argumentacao, como "o que voce vai receber", "como funciona", "modulos" e "diferenciais";
- `Urgência EuMilitar` cobre condicoes especiais, prazos, lotes, bonus temporarios e chamadas de conversao por tempo limitado.

Ficaram fora:

- templates longos de pagina;
- captura/lead;
- carrossel JS customizado;
- filtros interativos de cursos.

### Fase 4 - Governanca visual

Definir regras de uso para o time:

- preferir widgets EuMilitar para secoes principais;
- usar widgets genericos apenas para conteudo editorial simples;
- nao criar botoes, cards e formularios desalinhados quando existir equivalente EuMilitar;
- registrar novos gaps em `docs/design-system-gaps.md` antes de criar adapters locais permanentes.

## Decisao tecnica

Os widgets Elementor devem viver inicialmente no tema, porque este repositorio e o consumer WordPress oficial do Design System.

Extrair para plugin separado so deve ser reavaliado se:

- os widgets precisarem ser usados por outro tema;
- o ciclo de release dos widgets precisar ser independente;
- a quantidade de widgets crescer a ponto de virar produto proprio.
