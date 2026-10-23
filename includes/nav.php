<?php require_once __DIR__ . '/config.php'; ?>
<aside class="sidebar" id="sidebar" aria-label="Navegação principal">
  <div class="sidebar-inner">
    <a class="brand brand-desktop" href="/index.php" aria-label="Trilha Code, início"><span class="brand-symbol" aria-hidden="true">&lt;_</span><span>trilha<span class="brand-light">code</span></span></a>
    <div class="sidebar-caption">ESTUDE NO SEU RITMO</div>
    <label class="search-box" for="contentSearch"><span class="search-icon" aria-hidden="true">⌕</span><input id="contentSearch" type="search" placeholder="Buscar conteúdo…" autocomplete="off"><kbd>/</kbd></label>
    <div class="search-results" id="searchResults" hidden role="listbox" aria-label="Resultados da busca"></div>
    <nav class="side-nav">
      <?php foreach ($NAV_GROUPS as $group => $items): ?>
        <div class="nav-group"><p class="nav-heading"><?= e($group) ?></p>
          <?php foreach ($items as $id): $item = $PORTAL_PAGES[$id]; ?>
            <a class="nav-link<?= $pageId === $id ? ' is-active' : '' ?>" href="<?= e($item['href']) ?>"<?= $pageId === $id ? ' aria-current="page"' : '' ?>><span class="nav-dot" aria-hidden="true"></span><span><?= e($item['title']) ?></span><span class="visited-check" aria-hidden="true">✓</span></a>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    </nav>
    <div class="sidebar-progress">
      <div class="progress-meta"><span>TRILHA PERCORRIDA</span><strong id="progressValue">0%</strong></div>
      <div class="progress-track" role="progressbar" aria-label="Progresso do conteúdo" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" id="progressBar"><span class="progress-fill" id="progressFill"></span></div>
      <span class="progress-caption" id="progressCaption">Um passo de cada vez.</span>
    </div>
    <div class="sidebar-bottom"><span class="online-indicator"></span> Conteúdo disponível neste dispositivo <button id="themeToggle" class="theme-toggle" type="button" aria-label="Alternar tema de cores"><span aria-hidden="true">◐</span><span>Tema</span></button></div>
  </div>
</aside>
