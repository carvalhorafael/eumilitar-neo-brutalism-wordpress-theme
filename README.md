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
npm run dev
```

WordPress local:

- URL: `http://localhost:8888`
- Admin: `http://localhost:8888/wp-admin`
- Usuario: `admin`
- Senha: `password`

## Build

```bash
npm run build
```

O build de produção é gerado em `assets/dist`.

## Pacote do tema

```bash
npm run theme:zip
```

O ZIP público é gerado em `dist/` e inclui apenas arquivos necessários para instalar o tema no WordPress.

## Editor e Elementor

Os patterns do tema ficam disponíveis na categoria `EuMilitar` do editor de blocos.

Notas de uso e validação estão em `docs/editor-elementor.md`.
