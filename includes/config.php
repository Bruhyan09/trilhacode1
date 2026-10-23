<?php
/** Configuração comum do portal Trilha Code. */
declare(strict_types=1);

const SITE_NAME = 'Trilha Code';
const SITE_TAGLINE = 'Aprenda fazendo. Publique com confiança.';

/** Rotas humanas e editáveis. Os arquivos continuam organizados por trilha. */
$PORTAL_PAGES = [
    'home' => ['title' => 'Início', 'href' => '/index.php', 'summary' => 'Escolha uma trilha e acompanhe seu progresso.'],
    'php-index' => ['title' => 'PHP · visão geral', 'href' => '/php/index.php', 'summary' => 'Backend, requisições HTTP, páginas dinâmicas e boas práticas PHP.'],
    'php-utilidade' => ['title' => 'PHP · utilidade', 'href' => '/php/utilidade.php', 'summary' => 'Quando escolher PHP e o que resolve no servidor.'],
    'php-como-funciona' => ['title' => 'PHP · funcionamento', 'href' => '/php/como-funciona.php', 'summary' => 'Request, resposta, superglobais, validação e escaping.'],
    'php-onde-usar' => ['title' => 'PHP · mercado', 'href' => '/php/onde-usar.php', 'summary' => 'CMS, e-commerce, portais, APIs e sistemas internos.'],
    'css-index' => ['title' => 'CSS · visão geral', 'href' => '/css/index.php', 'summary' => 'Layout, cascata, responsividade e design system.'],
    'css-utilidade' => ['title' => 'CSS · utilidade', 'href' => '/css/utilidade.php', 'summary' => 'Como criar interfaces claras, consistentes e responsivas.'],
    'css-como-funciona' => ['title' => 'CSS · funcionamento', 'href' => '/css/como-funciona.php', 'summary' => 'Cascata, especificidade, box model, flex e grid.'],
    'css-onde-usar' => ['title' => 'CSS · mercado', 'href' => '/css/onde-usar.php', 'summary' => 'Produtos web, componentes, acessibilidade e performance.'],
    'javascript-index' => ['title' => 'JavaScript · visão geral', 'href' => '/javascript/index.php', 'summary' => 'Interatividade, DOM, eventos e chamadas assíncronas.'],
    'javascript-utilidade' => ['title' => 'JavaScript · utilidade', 'href' => '/javascript/utilidade.php', 'summary' => 'O que JavaScript faz no navegador e no servidor.'],
    'javascript-como-funciona' => ['title' => 'JavaScript · funcionamento', 'href' => '/javascript/como-funciona.php', 'summary' => 'DOM, escopo, eventos, promises, async e await.'],
    'javascript-onde-usar' => ['title' => 'JavaScript · mercado', 'href' => '/javascript/onde-usar.php', 'summary' => 'Interfaces web, ferramentas, dashboards e aplicações.'],
    'vscode-instalacao' => ['title' => 'VS Code · instalação', 'href' => '/vscode/instalacao.php', 'summary' => 'Instale o editor e escolha extensões úteis.'],
    'vscode-estrutura' => ['title' => 'VS Code · estrutura', 'href' => '/vscode/estrutura-projeto.php', 'summary' => 'Organize páginas, includes, assets e dados.'],
    'vscode-servidor' => ['title' => 'VS Code · servidor local', 'href' => '/vscode/servidor-local.php', 'summary' => 'Teste e depure PHP localmente.'],
    'deploy-render' => ['title' => 'Deploy · Render', 'href' => '/deploy/render.php', 'summary' => 'Publique PHP com Docker, configure PORT e valide o serviço.'],
    'projetos-index' => ['title' => 'Projetos · catálogo', 'href' => '/projetos/index.php', 'summary' => 'Baixe projetos práticos de CRUD e autenticação.'],
    'projeto-crud' => ['title' => 'Projeto · CRUD', 'href' => '/projetos/projeto-crud.php', 'summary' => 'Criar, listar, editar e excluir registros com PHP.'],
    'projeto-login' => ['title' => 'Projeto · login', 'href' => '/projetos/projeto-login.php', 'summary' => 'Cadastro, senha com hash, sessões e CSRF.'],
    'mercado-index' => ['title' => 'Mercado de trabalho', 'href' => '/mercado/index.php', 'summary' => 'Construa portfólio, descreva decisões e prepare-se para entrevistas.'],
];

$NAV_GROUPS = [
    'Comece' => ['home'],
    'Tecnologias' => ['php-index', 'css-index', 'javascript-index'],
    'Ferramentas' => ['vscode-instalacao', 'vscode-estrutura', 'vscode-servidor', 'deploy-render'],
    'Prática e carreira' => ['projetos-index', 'mercado-index'],
];

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function pageHref(string $id): string
{
    global $PORTAL_PAGES;
    return $PORTAL_PAGES[$id]['href'] ?? '/index.php';
}

function pageTitle(string $id): string
{
    global $PORTAL_PAGES;
    return $PORTAL_PAGES[$id]['title'] ?? SITE_NAME;
}

function pageLink(string $id, ?string $label = null, string $class = ''): string
{
    $text = $label ?? pageTitle($id);
    return '<a' . ($class !== '' ? ' class="' . e($class) . '"' : '') . ' href="' . e(pageHref($id)) . '">' . e($text) . '</a>';
}
