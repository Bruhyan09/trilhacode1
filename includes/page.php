<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/lessons.php';

function renderPage(string $id): void
{
    global $PORTAL_PAGES, $LESSONS;
    $pageId = $id;
    $lesson = $LESSONS[$id] ?? null;
    if ($lesson === null) {
        http_response_code(404);
        $lesson = ['title'=>'Página não encontrada','eyebrow'=>'404','lead'=>'Este conteúdo não está disponível.','sections'=>[['title'=>'Volte à trilha','body'=>'<p>Use a navegação para escolher outro módulo.</p>']]];
    }
    require __DIR__ . '/header.php';
    if ($id === 'home') {
        renderHome($lesson);
    } else {
        renderLesson($id, $lesson);
    }
    require __DIR__ . '/footer.php';
}

function renderHome(array $lesson): void
{
    global $PORTAL_PAGES;
    ?>
    <section class="home-hero reveal">
      <div class="hero-copy"><span class="eyebrow"><span class="live-dot"></span> TRILHA DE DESENVOLVIMENTO WEB · NÍVEL INTERMEDIÁRIO</span>
        <h1>Do primeiro <span class="text-gradient">endpoint</span><br>ao deploy.</h1>
        <p>Aprenda a conectar PHP, CSS e JavaScript em projetos que fazem sentido no mercado — uma prática de cada vez.</p>
        <div class="hero-actions"><a class="button button-primary" href="/php/index.php">Começar pela trilha <span aria-hidden="true">→</span></a><a class="button button-quiet" href="/projetos/index.php">Ver projetos <span aria-hidden="true">↗</span></a></div>
        <div class="hero-proof"><span class="proof-mark">⌘</span><span>Conteúdo organizado para estudar, testar e publicar.</span></div>
      </div>
      <div class="hero-terminal" aria-label="Visão ilustrativa das tecnologias"><div class="terminal-bar"><span class="terminal-dot red"></span><span class="terminal-dot yellow"></span><span class="terminal-dot green"></span><span class="terminal-title">app.php</span><span class="terminal-status">● pronto</span></div><div class="terminal-code"><div><i>01</i><span><b class="syntax-purple">&lt;?php</b></span></div><div><i>02</i><span><b class="syntax-blue">$dados</b> = <b class="syntax-yellow">buscarDados</b>();</span></div><div><i>03</i><span><b class="syntax-muted">// estrutura com PHP</b></span></div><div><i>04</i><span><b class="syntax-purple">?&gt;</b></span></div><div><i>05</i><span class="syntax-green">&lt;main class="app"&gt;</span></div><div><i>06</i><span>&nbsp;&nbsp;&lt;button <b class="syntax-blue">data-action</b>&gt;</span></div><div><i>07</i><span>&nbsp;&nbsp;&nbsp;&nbsp;Continuar aprendendo</span></div><div><i>08</i><span>&nbsp;&nbsp;&lt;/button&gt;</span></div><div><i>09</i><span class="syntax-green">&lt;/main&gt;</span></div><div class="terminal-cursor-line"><i>10</i><span class="cursor-block"></span></div></div><div class="terminal-footer"><span>PHP + HTML</span><span>CSS · JavaScript</span><span>Render-ready</span></div></div>
    </section>
    <div class="home-meta-row"><div class="meta-item"><span class="meta-number">03</span><span>tecnologias conectadas</span></div><div class="meta-divider"></div><div class="meta-item"><span class="meta-number">02</span><span>projetos práticos para baixar</span></div><div class="meta-divider"></div><div class="meta-item"><span class="meta-number">∞</span><span>seu ritmo, salvo neste dispositivo</span></div></div>
    <section class="content-section reveal"><div class="section-heading"><div><span class="eyebrow">TRILHAS DE APRENDIZADO</span><h2>Construa repertório, <span class="muted">não só sintaxe.</span></h2></div><p>Comece pelo que acontece no servidor; depois dê forma e comportamento à interface.</p></div>
      <div class="track-list">
        <a class="track-card php-track" href="/php/index.php"><span class="track-index">01 / BACKEND</span><span class="track-logo php-mark">php</span><span class="track-main"><strong>PHP</strong><span>Receba dados, processe regras e entregue respostas seguras.</span><small>4 módulos · inclui quiz</small></span><span class="track-arrow">↗</span></a>
        <a class="track-card css-track" href="/css/index.php"><span class="track-index">02 / INTERFACE</span><span class="track-logo css-mark">#</span><span class="track-main"><strong>CSS</strong><span>Crie layouts responsivos e transforme requisitos em sistemas visuais.</span><small>4 módulos · inclui laboratório</small></span><span class="track-arrow">↗</span></a>
        <a class="track-card js-track" href="/javascript/index.php"><span class="track-index">03 / INTERAÇÃO</span><span class="track-logo js-mark">JS</span><span class="track-main"><strong>JavaScript</strong><span>Conecte ações do usuário à interface sem perder controle do estado.</span><small>4 módulos · inclui laboratório</small></span><span class="track-arrow">↗</span></a>
      </div>
    </section>
    <section class="content-section workflow-section reveal"><div class="section-heading"><div><span class="eyebrow">DO EDITOR À WEB</span><h2>Seu fluxo de trabalho, <span class="muted">de ponta a ponta.</span></h2></div></div><div class="workflow-steps"><a href="/vscode/instalacao.php"><span>01</span><strong>Prepare</strong><p>VS Code, extensões e pastas com propósito.</p></a><a href="/projetos/index.php"><span>02</span><strong>Construa</strong><p>Combine estrutura, estilo, interação e regras.</p></a><a href="/deploy/render.php"><span>03</span><strong>Publique</strong><p>Docker, Render, validação e próximos passos.</p></a></div></section>
    <section class="home-bottom-callout reveal"><div><span class="eyebrow">APRENDIZADO ATIVO</span><h2>Não deixe a aba aberta. <span class="muted">Deixe seu próximo projeto.</span></h2><p>Seu avanço fica salvo neste navegador. Retome de onde parou e transforme cada módulo em uma pequena entrega.</p></div><a href="/projetos/index.php" class="button button-primary">Explorar projetos <span aria-hidden="true">→</span></a></section>
    <?php
}

function renderLesson(string $id, array $lesson): void
{
    $sections = $lesson['sections'] ?? [];
    ?>
    <nav class="breadcrumbs" aria-label="Você está aqui"><a href="/index.php">Início</a><span aria-hidden="true">/</span><span><?= e($lesson['crumb'] ?? $lesson['eyebrow']) ?></span></nav>
    <header class="lesson-header reveal"><div class="lesson-heading-copy"><span class="eyebrow"><span class="eyebrow-line"></span><?= e($lesson['eyebrow']) ?></span><h1><?= e($lesson['title']) ?></h1><p class="lesson-lead"><?= e($lesson['lead']) ?></p><div class="lesson-meta"><span>◷ <?= e($lesson['time'] ?? '6 min de leitura') ?></span><span>·</span><span><?= e($lesson['level'] ?? 'Conceito + prática') ?></span><span class="lesson-visited" hidden>✓ Visitado</span></div></div>
      <?php if (!empty($lesson['badge'])): ?><div class="lesson-badge"><span><?= e($lesson['badge']) ?></span><small>NA PRÁTICA</small></div><?php endif; ?>
    </header>
    <div class="lesson-layout"><article class="lesson-body">
      <?php foreach ($sections as $index => $section): ?>
      <section class="lesson-section reveal" id="sec-<?= $index + 1 ?>"><div class="section-number"><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></div><div class="section-content"><h2><?= e($section['title']) ?></h2><div class="prose"><?= $section['body'] ?></div></div></section>
      <?php endforeach; ?>
      <?php if (!empty($lesson['code'])): $code = $lesson['code']; $codeId = 'code-' . $id; ?>
      <section class="code-panel reveal"><div class="code-panel-head"><div><span class="code-language"><span class="language-dot <?= e($code['class'] ?? '') ?>"></span><?= e($code['language']) ?></span><span class="code-filename"><?= e($code['filename'] ?? 'exemplo') ?></span></div><button class="copy-button" type="button" data-copy-target="<?= e($codeId) ?>"><span aria-hidden="true">▢</span> Copiar</button></div><pre><code id="<?= e($codeId) ?>" class="code-content"><?= e($code['source']) ?></code></pre></section>
      <?php if (!empty($code['note'])): ?><p class="code-note"><span aria-hidden="true">i</span> <?= e($code['note']) ?></p><?php endif; ?>
      <?php endif; ?>
      <?php if (!empty($lesson['lab'])): $labId = 'lab-' . $id; ?>
      <section class="lab-panel reveal" data-lab="<?= e($labId) ?>"><div class="lab-heading"><div><span class="eyebrow">PLAYGROUND LOCAL</span><h2>Teste uma ideia</h2><p><?= e($lesson['lab']['hint'] ?? 'Edite o exemplo e veja o resultado sem sair desta página.') ?></p></div><span class="lab-icon">⌘</span></div><label class="visually-hidden" for="<?= e($labId) ?>-editor">Código de demonstração</label><textarea id="<?= e($labId) ?>-editor" class="code-editor" spellcheck="false" autocapitalize="off" autocomplete="off"><?= e($lesson['lab']['source']) ?></textarea><div class="lab-toolbar"><span><i class="live-dot"></i> Executa isolado neste navegador</span><button class="button button-primary button-small" type="button" data-run-lab="<?= e($labId) ?>">Executar <span aria-hidden="true">▶</span></button></div><iframe class="lab-output" id="<?= e($labId) ?>-output" title="Pré-visualização do exemplo interativo" sandbox="allow-scripts"></iframe><p class="lab-note">Este playground não envia o código a nenhum servidor. Não cole senhas ou dados pessoais.</p></section>
      <?php endif; ?>
      <?php if (!empty($lesson['quiz'])): ?>
      <section class="quiz-panel reveal" data-quiz="<?= e($id) ?>"><div class="quiz-heading"><span class="quiz-mark">?</span><div><span class="eyebrow">CHECAGEM RÁPIDA</span><h2>Você consegue explicar?</h2><p>Responda e receba retorno imediato. Seu resultado fica só neste navegador.</p></div></div>
        <?php foreach ($lesson['quiz'] as $qIndex => $question): ?>
        <fieldset class="quiz-question" data-quiz-question data-answer="<?= (int)$question['answer'] ?>" data-explanation="<?= e($question['explanation']) ?>"><legend><span class="question-number">0<?= $qIndex + 1 ?></span><?= e($question['question']) ?></legend><div class="quiz-options"><?php foreach ($question['options'] as $optIndex => $option): ?><label class="quiz-option"><input type="radio" name="<?= e($id) ?>-q<?= $qIndex ?>" value="<?= $optIndex ?>"><span class="custom-radio"></span><span><?= e($option) ?></span></label><?php endforeach; ?></div><p class="question-feedback" aria-live="polite"></p></fieldset>
        <?php endforeach; ?>
        <div class="quiz-bottom"><button type="button" class="button button-primary" data-quiz-submit>Corrigir minhas respostas <span aria-hidden="true">→</span></button><span class="quiz-score" aria-live="polite"></span></div>
      </section>
      <?php endif; ?>
      <div class="lesson-completion"><span class="completion-icon">✓</span><div><strong>Módulo percorrido</strong><p>Marcar esta página e avançar faz parte do seu progresso. Ele é salvo no navegador.</p></div></div>
      <div class="lesson-bottom-nav"><a href="/index.php"><span>←</span><div><small>VOLTAR AO INÍCIO</small><strong>Visão geral</strong></div></a><a href="/projetos/index.php"><div><small>PRÓXIMA PRÁTICA</small><strong>Levar ao projeto</strong></div><span>→</span></a></div>
    </article><aside class="lesson-aside"><div class="aside-sticky"><div class="aside-card"><span class="eyebrow">NESTA PÁGINA</span><?php foreach ($sections as $index => $section): ?><a href="#sec-<?= $index + 1 ?>"><span><?= str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) ?></span><?= e($section['title']) ?></a><?php endforeach; ?><div class="aside-rule"></div><span class="aside-next-label">SIGA NA TRILHA</span><?php foreach (($lesson['next'] ?? ['projetos-index']) as $nextId): ?><a class="aside-next" href="<?= e(pageHref($nextId)) ?>"><span>↗</span><?= e(pageTitle($nextId)) ?></a><?php endforeach; ?></div><div class="aside-tip"><span aria-hidden="true">✳</span><p><strong>Dica de estudo</strong><br>Tente explicar o conceito com suas palavras antes de seguir.</p></div></div></aside></div>
    <?php
}
?>