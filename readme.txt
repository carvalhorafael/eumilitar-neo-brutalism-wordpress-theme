=== EuMilitar Neo Brutalism WordPress Theme ===

Contributors: carvalhorafael
Requires at least: 6.5
Tested up to: 6.8
Requires PHP: 8.2
Stable tag: 0.3.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: education, custom-logo, block-patterns

Tema WordPress consumer do EuMilitar Design System.

== Description ==

EuMilitar Neo Brutalism WordPress Theme é um tema WordPress híbrido que consome os pacotes publicados do EuMilitar Design System para tokens, CSS compartilhado, markup canônico e contratos de patterns.

O tema é um consumer da biblioteca. O design system continua sendo a fonte da verdade visual.

== Development ==

Use o ambiente local com wp-env:

1. npm install
2. npm run wp:start
3. npm run composer:install
4. npm run dev

Para validar e gerar o pacote distribuível:

1. npm run validate
2. npm run theme:zip

== Changelog ==

= 0.3.0 =

* Atualização para as versões mais recentes disponíveis dos pacotes do EuMilitar Design System.

= 0.2.0 =

* Automação de CI para PRs e main.
* Automação de releases por tags versionadas.
* Validação de versão entre package.json, style.css e readme.txt.

= 0.1.0 =

* Fundação inicial do tema.
* Consumo dos pacotes do EuMilitar Design System.
* Patterns para Hero, Urgência, Benefícios, Depoimentos, Captação, FAQ e CTA.
* Compatibilidade inicial com Gutenberg e Elementor.
