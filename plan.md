# Plano — Trilha Code

## Abordagem

Construir um portal navegável em PHP puro, HTML semântico, CSS e JavaScript, sem framework e sem banco de dados. Cada URL da árvore pedida será um arquivo PHP pequeno que define seu identificador e reaproveita `includes/config.php`, `includes/header.php`, `includes/nav.php`, `includes/footer.php` e uma view compartilhada. O conteúdo editorial e o índice de busca ficam em módulos PHP separados para evitar repetição. O JavaScript centralizado em `assets/js/main.js` salva progresso, quizzes e feedback no `localStorage`; também controla menu, cópia de código, busca e demonstrações executáveis em `iframe sandbox` com uma política CSP que bloqueia conexões externas. Código PHP será apresentado para cópia e explicado, nunca executado arbitrariamente no navegador.

Criar pacotes ZIP para download com dois projetos independentes: CRUD PHP que demonstra persistência local em arquivo JSON; login PHP com cadastro e sessão, hash de senha, token CSRF e instruções de execução. No portal, as demonstrações HTML/CSS/JavaScript terão editor e pré-visualização segura. Adicionar Dockerfile com Apache/PHP para o Render e um guia de deploy baseado na documentação oficial atual.

## Estrutura e responsabilidades

- `index.php`: página inicial, trilhas, progresso e chamadas para continuar o estudo.
- `includes/config.php`: dados do portal, páginas, rotas, helpers e metadados usados por busca e navegação.
- `includes/header.php`, `nav.php`, `footer.php`: moldura reutilizável, barra de progresso e navegação responsiva.
- `includes/page.php` e `includes/lessons.php`: apresentação reutilizável e conteúdo didático de cada página.
- `php/`, `css/`, `javascript/`: overview, utilidade, funcionamento e aplicações de mercado para cada tecnologia.
- `vscode/`: instalação, extensões, estrutura do projeto e servidor local.
- `deploy/render.php`: roteiro de publicação e validação no Render.
- `projetos/`: catálogo e páginas explicativas do CRUD e login; `projetos/downloads/`: arquivos compactados para baixar.
- `mercado/index.php`: competências, portfólio e preparação profissional.
- `assets/css/style.css`, `assets/js/main.js`, `assets/images/`: estilos, interações e recursos visuais.
- `Dockerfile`, `docker-entrypoint.sh`, `render.yaml`: ambiente de execução e configuração de deploy.
- `manus-routes.json`: lista de rotas de página servidas pelo portal.

## Design

**Direção escolhida:** minimalismo editorial de produto para desenvolvedores, com dark mode e realces de sintaxe.

- **Princípios:** leitura confortável; hierarquia nítida; conteúdo prático acima de decoração; controles com feedback imediato.
- **Cores:** base `#1e1e1e`, superfícies `#2d2d2d` e `#3a3a3a`; texto claro e azul `#3b82f6` com `#60a5fa` para foco e interação. O azul orienta ações e progresso sem competir com os exemplos de código.
- **Layout:** sidebar persistente em telas grandes; navegação recolhível em celular; coluna de leitura ampla e espaços laterais para progresso, busca e prática; cards em listas adaptáveis, sem excesso de grades.
- **Elementos de assinatura:** trilha vertical de módulos com estados visitados; barra de progresso azul global; blocos de código com etiquetas de linguagem e ação copiar.
- **Interação/animação:** transições curtas, foco de teclado visível, menu móvel acessível, progresso e feedback atualizados sem recarga, respeitando `prefers-reduced-motion`.
- **Tipografia:** Inter para interface e leitura, com system fallback; JetBrains Mono ou fonte monoespaçada de sistema para código. H1 conciso, títulos de seção claros e parágrafos com largura de leitura controlada.
- **Essência da marca:** uma trilha de prática web para quem já sabe HTML e quer construir aplicações úteis; personalidade direta, acolhedora e aplicada.
- **Voz:** títulos e instruções orientados a ação. Exemplos: “Do primeiro endpoint ao deploy” e “Escreva, teste, publique — uma etapa por vez.”
- **Logotipo:** wordmark “Trilha Code” acompanhado por um sinal próprio de terminal: dois chevrons e um cursor, em azul.
- **Cor de marca:** azul elétrico `#3b82f6`.

## Conteúdo e experiência

O conteúdo cobre PHP, CSS e JavaScript com utilidade, funcionamento, decisões técnicas, usos reais e boas práticas de nível intermediário. A trilha de VS Code vai da instalação à estrutura e servidor local. O guia de deploy percorre Git, Docker/Render, porta, publicação e verificação. O catálogo apresenta dois projetos baixáveis e explica o que cada um ensina. O portal oferece busca em tempo real, progresso local, quizzes com correção imediata e feedback local. A versão simplificada prioriza esses fluxos essenciais sem autenticação nem serviços externos.

## Render

A documentação oficial do Render indica usar Docker para PHP, ouvir em `0.0.0.0` na porta `PORT` (padrão `10000`) e configurar o Web Service para o Dockerfile. O `Dockerfile` instalará PHP/extensões mínimas e Apache; o script de entrada aplicará a porta de runtime. O guia instrui a criar um Web Service, escolher Docker, manter o Dockerfile na raiz, publicar, verificar `/` e ler logs se a checagem falhar. Este portal não precisa de dados persistidos no servidor. Fontes: https://render.com/docs/docker, https://render.com/docs/web-services e https://render.com/docs/deploy-php-laravel-docker.
