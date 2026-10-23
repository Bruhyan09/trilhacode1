<?php
require_once __DIR__ . '/config.php';
$pageId = $pageId ?? 'home';
$pageMeta = $PORTAL_PAGES[$pageId] ?? $PORTAL_PAGES['home'];
$fullTitle = ($pageMeta['title'] === 'Início' ? SITE_NAME : $pageMeta['title'] . ' — ' . SITE_NAME);
$description = $pageMeta['summary'] ?? SITE_TAGLINE;
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#1e1e1e">
  <meta name="description" content="<?= e($description) ?>">
  <title><?= e($fullTitle) ?></title>
  <link rel="icon" type="image/svg+xml" href="/assets/images/trilhacode-mark.svg">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body data-page-id="<?= e($pageId) ?>">
<div class="app-shell">
  <header class="mobile-topbar">
    <a class="brand brand-mobile" href="/index.php" aria-label="Trilha Code, início"><span class="brand-symbol" aria-hidden="true">&lt;_</span><span>trilha<span class="brand-light">code</span></span></a>
    <button class="icon-button menu-toggle" id="menuToggle" type="button" aria-expanded="false" aria-controls="sidebar" aria-label="Abrir navegação"><span></span><span></span><span></span></button>
  </header>
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
  <?php require __DIR__ . '/nav.php'; ?>
  <main class="main-content" id="mainContent" tabindex="-1">
    <a class="skip-link" href="#mainContent">Pular para o conteúdo</a>
    <div class="mobile-progress" aria-live="polite"><span id="mobileProgressLabel">Seu progresso</span><div class="progress-track"><span class="progress-fill" id="mobileProgressFill"></span></div><span id="mobileProgressValue">0%</span></div>
