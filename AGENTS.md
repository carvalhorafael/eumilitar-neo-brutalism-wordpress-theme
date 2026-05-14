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

## Pull Requests e CI

Todo PR para `main` deve passar pelo workflow `CI`.

Rotina padrão:

1. criar branch de trabalho com prefixo `codex/`;
2. fazer commits pequenos e intencionais;
3. rodar validações locais quando a mudança tocar build, PHP, assets ou empacotamento;
4. fazer push da branch;
5. abrir PR para `main`;
6. aguardar o workflow `CI` passar antes do merge.

O workflow de CI roda em PRs para `main`, em pushes para `main` e manualmente via `workflow_dispatch`. Ele executa:

- `npm ci`;
- `npm run wp:start`;
- `npm run validate`;
- upload do ZIP gerado em `dist/eumilitar-neo-brutalism-wordpress-theme.zip` como artifact.

O repositório precisa do secret `EUMILITAR_PACKAGES_TOKEN` para instalar os pacotes privados/publicados do escopo `@carvalhorafael` no GitHub Packages. Esse token deve ter permissão mínima de leitura dos packages necessários. Nunca commitar `.npmrc` real ou tokens.

## Releases e tags

A decisão de criar uma nova release é humana. A automação começa quando uma tag `vX.Y.Z` é enviada ao GitHub.

Rotina padrão de release:

1. criar uma branch de release;
2. atualizar a versão em `package.json`;
3. atualizar `Version` em `style.css`;
4. atualizar `Stable tag` em `readme.txt`;
5. abrir PR e mergear em `main` após o CI passar;
6. sincronizar `main` local;
7. criar tag anotada no formato `vX.Y.Z`;
8. fazer push da tag.

Exemplo:

```bash
git checkout main
git pull --ff-only origin main
git tag -a v0.1.1 -m "Release v0.1.1"
git push origin v0.1.1
```

O workflow `Release` roda em tags `v*`. Ele valida que a tag `vX.Y.Z` bate com:

- `package.json` -> `version`;
- `style.css` -> `Version`;
- `readme.txt` -> `Stable tag`.

Depois disso, executa `npm run validate`, cria a GitHub Release e anexa o ZIP público do tema. Não criar releases manualmente sem tag correspondente.

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
