# EuMilitar Neo Brutalism WordPress Theme

Tema WordPress consumer do EuMilitar Design System.

## Desenvolvimento local

Requisitos:

- Docker
- Node.js
- npm
- token do GitHub Packages para instalar os pacotes `@carvalhorafael/*`

Configure o registry local copiando `.npmrc.example` para `.npmrc` e substituindo o token. Sem esse arquivo, o npm tentara buscar os pacotes `@carvalhorafael/*` no registry publico e a instalacao falhara.

```bash
npm install
npm run wp:start
npm run composer:install
npm run seed:blog
npm run dev
```

WordPress local:

- URL: `http://localhost:8888`
- Admin: `http://localhost:8888/wp-admin`
- Usuario: `admin`
- Senha: `password`

Para recriar um cenário visual consistente de blog no ambiente local:

```bash
npm run seed:blog
```

Esse comando cria/atualiza posts, categorias, tags, comentários aprovados e configura a página de posts. Ele é idempotente e voltado apenas para desenvolvimento local.

## Build

```bash
npm run build
```

O build de produção é gerado em `assets/dist`.

## Validação

```bash
npm run validate
```

Esse comando roda build Vite, instala as dependências PHP no container, valida sintaxe PHP, executa PHPCS com WordPress Coding Standards, roda Theme Check contra o tema, gera o ZIP público, confere a allowlist do pacote e testa a instalação do ZIP em uma cópia limpa do WordPress de testes.

## Testes automatizados

```bash
npm test
```

Esse comando roda as camadas automatizadas do tema:

- `npm run test:static`: build, sintaxe PHP, PHPCS e Theme Check;
- `npm run test:php`: PHPUnit dentro do WordPress de testes do `wp-env`;
- `npm run test:e2e`: Playwright no front-end em desktop e mobile, smoke do editor em desktop, interação do accordion e verificação axe de acessibilidade.

Para gerar cobertura PHP informativa:

```bash
npm run test:php:coverage
```

Esse comando gera `coverage/php/clover.xml`, `coverage/php/html` e `coverage/php/summary.md`. O CI publica o HTML como artifact e comenta o resumo no PR sem bloquear por percentual.

Para rodar apenas os testes E2E pela primeira vez na máquina, instale os navegadores do Playwright:

```bash
npx playwright install chromium
```

## Pacote do tema

```bash
npm run theme:zip
```

O ZIP público é gerado em `dist/` e inclui apenas arquivos necessários para instalar o tema no WordPress.

Para release, use o ZIP gerado em `dist/eumilitar-neo-brutalism-wordpress-theme.zip`. O pacote não inclui `node_modules`, `vendor`, fontes Vite, scripts de desenvolvimento, documentação interna ou arquivos de configuração local.

## Editor e Elementor

Os patterns do tema ficam disponíveis na categoria `EuMilitar` do editor de blocos.

Notas de uso e validação estão em `docs/editor-elementor.md`.
