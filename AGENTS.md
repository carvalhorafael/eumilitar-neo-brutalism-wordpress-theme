# Instruções para agentes

## Contexto do projeto

Este repositório contém um tema WordPress consumer do EuMilitar Design System.

O tema deve consumir os pacotes publicados do design system:

- `@carvalhorafael/eumilitar-tokens`
- `@carvalhorafael/eumilitar-css`
- `@carvalhorafael/eumilitar-web`
- `@carvalhorafael/eumilitar-patterns`

Não recrie tokens, componentes ou padrões visuais do zero dentro do tema. O WordPress deve ser tratado como consumer/adaptador da biblioteca.

## Ambiente local WordPress

O ambiente local usa `@wordpress/env`, que roda WordPress via Docker.

Comandos principais:

```bash
npm install
npm run wp:start
npm run dev
```

URLs locais:

- Site: http://localhost:8888/
- Admin: http://localhost:8888/wp-admin
- Login: http://localhost:8888/wp-login.php

Credenciais locais padrão do `wp-env`:

- Usuário: `admin`
- Senha: `password`

Essas credenciais são apenas do ambiente local de desenvolvimento. Não usar como referência para produção, staging ou qualquer ambiente real.

## GitHub Packages

Para rodar `npm install`, o projeto precisa de um `.npmrc` local com token do GitHub Packages.

Use `.npmrc.example` como modelo:

```ini
@carvalhorafael:registry=https://npm.pkg.github.com
//npm.pkg.github.com/:_authToken=SEU_TOKEN_GITHUB
```

O arquivo `.npmrc` real não deve ser commitado.

## Fluxo de branches

Regra padrão:

- não desenvolver diretamente em `main`;
- criar uma branch de trabalho antes de alterar código;
- usar prefixo `codex/` para branches criadas por agentes;
- fazer commits pequenos e intencionais;
- fazer push da branch para `origin`;
- levar mudanças para `main` apenas via Pull Request.

Exemplo:

```bash
git checkout -b codex/fase-5-editor-elementor
```

Antes de começar uma nova tarefa, sempre verificar:

```bash
git status --short --branch
git branch -vv
```

Se o checkout estiver em `main`, criar uma branch antes de editar. Commits diretos em `main` só devem acontecer em situações explicitamente autorizadas pelo usuário ou em bootstrap inicial de repositório vazio.

## Validações úteis

Antes de considerar uma mudança pronta:

```bash
npm run build
npm run validate
npm run theme:zip
```

Para validar PHP dentro do container:

```bash
npx wp-env run cli bash -lc 'cd /var/www/html/wp-content/themes/eumilitar-neo-brutalism-wordpress-theme && find . -path "./dist" -prune -o -name "*.php" -print0 | xargs -0 -n1 php -l'
```

Se o container foi recriado ou o `vendor/` não existir, instalar as dependências PHP antes do lint:

```bash
npm run composer:install
```
