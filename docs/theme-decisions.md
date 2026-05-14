# Decisões do tema

Este documento registra decisões de escopo do tema WordPress para evitar que escolhas intencionais pareçam pendências acidentais.

## Custom header e custom background

Status: não implementar por enquanto.

O tema não deve habilitar `custom-header` nem `custom-background` nesta etapa.

Motivos:

- o tema é um consumer/adaptador do EuMilitar Design System;
- cores, superfícies, contraste e hierarquia visual devem vir dos tokens e componentes do Design System;
- imagem de header ou fundo livre pelo admin pode quebrar consistência visual, contraste e legibilidade;
- o suporte atual a `custom-logo` já cobre a personalização de marca que faz sentido para o tema;
- implementar esses recursos apenas para reduzir recomendações do Theme Check adicionaria flexibilidade sem necessidade real.

Reavaliação futura:

- considerar variações controladas pelo Design System, como tema claro/escuro ou variação de campanha;
- evitar opções livres de imagem/fundo enquanto não houver contrato visual definido no Design System.
