/* Trilha Code — interações locais; nenhum dado de estudo é enviado ao servidor. */
(() => {
  'use strict';
  document.documentElement.classList.add('js-ready');
  const STORAGE = {
    progress: 'trilhacode:visited:v1',
    quiz: 'trilhacode:quiz:v1',
    feedback: 'trilhacode:feedback:v1',
    theme: 'trilhacode:theme:v1'
  };
  const read = (key, fallback) => {
    try { const value = JSON.parse(localStorage.getItem(key)); return value ?? fallback; }
    catch { return fallback; }
  };
  const write = (key, value) => {
    try { localStorage.setItem(key, JSON.stringify(value)); return true; }
    catch { toast('Não foi possível salvar. Verifique as permissões do navegador.', true); return false; }
  };

  function toast(message, error = false) {
    const region = document.querySelector('#toastRegion');
    if (!region) return;
    const item = document.createElement('div');
    item.className = `toast${error ? ' toast-error' : ''}`;
    item.textContent = message;
    region.append(item);
    window.setTimeout(() => item.remove(), 2700);
  }

  // Progresso: visita cada página uma vez; não é necessário criar uma conta.
  const currentPage = document.body.dataset.pageId;
  const pages = Array.isArray(window.portalSearchIndex) ? window.portalSearchIndex : [];
  const visited = new Set(read(STORAGE.progress, []));
  if (currentPage) visited.add(currentPage);
  write(STORAGE.progress, [...visited]);
  const percent = pages.length ? Math.round((visited.size / pages.length) * 100) : 0;
  const fill = document.querySelector('#progressFill');
  const value = document.querySelector('#progressValue');
  const bar = document.querySelector('#progressBar');
  const caption = document.querySelector('#progressCaption');
  const mobileFill = document.querySelector('#mobileProgressFill');
  const mobileValue = document.querySelector('#mobileProgressValue');
  if (fill) fill.style.width = `${percent}%`;
  if (value) value.textContent = `${percent}%`;
  if (bar) bar.setAttribute('aria-valuenow', String(percent));
  if (caption) caption.textContent = `${visited.size} de ${pages.length} páginas visitadas`;
  if (mobileFill) mobileFill.style.width = `${percent}%`;
  if (mobileValue) mobileValue.textContent = `${percent}%`;
  document.querySelectorAll('.nav-link').forEach((link) => {
    const linkId = pages.find((page) => page.href === link.getAttribute('href'))?.id;
    if (linkId && visited.has(linkId)) link.classList.add('is-visited');
  });
  const visitedBadge = document.querySelector('.lesson-visited');
  if (visitedBadge && currentPage && visited.has(currentPage)) visitedBadge.hidden = false;

  // Tema escuro é o padrão pedido; o botão opcional lembra a escolha neste dispositivo.
  const theme = read(STORAGE.theme, 'dark');
  if (theme === 'light') document.documentElement.dataset.theme = 'light';
  document.querySelector('#themeToggle')?.addEventListener('click', () => {
    const next = document.documentElement.dataset.theme === 'light' ? 'dark' : 'light';
    if (next === 'dark') delete document.documentElement.dataset.theme;
    else document.documentElement.dataset.theme = next;
    write(STORAGE.theme, next);
  });

  // Menu mobile fecha com seleção, Escape ou toque no fundo.
  const menuToggle = document.querySelector('#menuToggle');
  const backdrop = document.querySelector('#sidebarBackdrop');
  const closeMenu = () => {
    document.body.classList.remove('menu-open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    menuToggle?.setAttribute('aria-label', 'Abrir navegação');
  };
  menuToggle?.addEventListener('click', () => {
    const opened = document.body.classList.toggle('menu-open');
    menuToggle.setAttribute('aria-expanded', String(opened));
    menuToggle.setAttribute('aria-label', opened ? 'Fechar navegação' : 'Abrir navegação');
  });
  backdrop?.addEventListener('click', closeMenu);
  document.querySelectorAll('.nav-link').forEach((link) => link.addEventListener('click', closeMenu));
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') { closeMenu(); closeFeedback(); }
    if (event.key === '/' && !['INPUT', 'TEXTAREA'].includes(document.activeElement?.tagName)) {
      event.preventDefault(); document.querySelector('#contentSearch')?.focus();
    }
  });

  // Busca local no índice de páginas, com resultados escritos via textContent.
  const searchInput = document.querySelector('#contentSearch');
  const searchResults = document.querySelector('#searchResults');
  const showSearch = (query) => {
    if (!searchInput || !searchResults) return;
    const term = query.trim().toLocaleLowerCase('pt-BR');
    searchResults.replaceChildren();
    if (!term) { searchResults.hidden = true; return; }
    const found = pages.filter((page) => `${page.title} ${page.summary} ${page.content ?? ''}`.toLocaleLowerCase('pt-BR').includes(term)).slice(0, 7);
    if (!found.length) {
      const empty = document.createElement('div'); empty.className = 'search-empty'; empty.textContent = 'Nenhuma página encontrada. Tente PHP, CSS ou Render.'; searchResults.append(empty);
    } else {
      found.forEach((page) => {
        const link = document.createElement('a'); link.className = 'search-result'; link.href = page.href; link.setAttribute('role', 'option');
        const title = document.createElement('strong'); title.textContent = page.title;
        const summary = document.createElement('span'); summary.textContent = page.summary;
        link.append(title, summary); searchResults.append(link);
      });
    }
    searchResults.hidden = false;
  };
  searchInput?.addEventListener('input', () => showSearch(searchInput.value));
  searchInput?.addEventListener('focus', () => { if (searchInput.value.trim()) showSearch(searchInput.value); });
  document.addEventListener('click', (event) => {
    if (!event.target.closest('.search-box, .search-results')) searchResults && (searchResults.hidden = true);
  });

  // Copiar blocos preserva o conteúdo original, sem formatação adicional.
  document.querySelectorAll('[data-copy-target]').forEach((button) => {
    button.addEventListener('click', async () => {
      const code = document.getElementById(button.dataset.copyTarget)?.textContent ?? '';
      try {
        await navigator.clipboard.writeText(code);
        button.innerHTML = '<span aria-hidden="true">✓</span> Copiado';
        window.setTimeout(() => { button.innerHTML = '<span aria-hidden="true">▢</span> Copiar'; }, 1600);
      } catch {
        const selection = document.createElement('textarea'); selection.value = code; selection.setAttribute('readonly', '');
        selection.style.position = 'fixed'; selection.style.opacity = '0'; document.body.append(selection); selection.select();
        const ok = document.execCommand('copy'); selection.remove(); toast(ok ? 'Código copiado.' : 'Selecione e copie o código manualmente.', !ok);
      }
    });
  });

  // Playground só entrega código ao próprio iframe com sandbox="allow-scripts".
  const previewCsp = "default-src 'none'; script-src 'unsafe-inline'; style-src 'unsafe-inline'; img-src data:; connect-src 'none'; form-action 'none'; base-uri 'none'; object-src 'none'; frame-src 'none'";
  document.querySelectorAll('[data-run-lab]').forEach((button) => {
    button.addEventListener('click', () => {
      const id = button.dataset.runLab;
      const editor = document.getElementById(`${id}-editor`);
      const frame = document.getElementById(`${id}-output`);
      if (!editor || !frame) return;
      const source = editor.value;
      if (source.length > 18000) { toast('O exemplo é grande demais para a prévia.', true); return; }
      const documentHtml = `<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta http-equiv="Content-Security-Policy" content="${previewCsp}"><meta name="viewport" content="width=device-width,initial-scale=1"><style>body{margin:0;padding:14px;background:#0e1015;color:#f8fafc;font:14px system-ui;overflow-wrap:anywhere}button,input{font:inherit}</style></head><body>${source}</body></html>`;
      frame.srcdoc = documentHtml;
      toast('Prévia atualizada no navegador.');
    });
    const panel = button.closest('[data-lab]');
    const editor = panel?.querySelector('.code-editor');
    if (panel && editor) {
      const frame = panel.querySelector('.lab-output');
      const updateInitial = () => {
        if (!frame || editor.value.length > 18000) return;
        frame.srcdoc = `<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta http-equiv="Content-Security-Policy" content="${previewCsp}"><meta name="viewport" content="width=device-width,initial-scale=1"><style>body{margin:0;padding:14px;background:#0e1015;color:#f8fafc;font:14px system-ui;overflow-wrap:anywhere}button,input{font:inherit}</style></head><body>${editor.value}</body></html>`;
      };
      updateInitial();
    }
  });

  // Quizzes com correção imediata e melhor resultado salvo localmente.
  document.querySelectorAll('[data-quiz]').forEach((quiz) => {
    const key = `${STORAGE.quiz}:${quiz.dataset.quiz}`;
    const saved = read(key, null);
    const scoreLabel = quiz.querySelector('.quiz-score');
    if (saved && scoreLabel) scoreLabel.textContent = `Melhor resultado salvo: ${saved.score}/${saved.total}`;
    quiz.querySelector('[data-quiz-submit]')?.addEventListener('click', () => {
      const questions = [...quiz.querySelectorAll('[data-quiz-question]')];
      let score = 0; let answered = 0;
      questions.forEach((question) => {
        const selected = question.querySelector('input[type="radio"]:checked');
        const feedback = question.querySelector('.question-feedback');
        question.querySelectorAll('.quiz-option').forEach((option) => option.classList.remove('is-correct', 'is-wrong'));
        if (!selected) { feedback.textContent = 'Escolha uma opção para ver o retorno.'; feedback.className = 'question-feedback'; return; }
        answered += 1;
        const correct = Number(selected.value) === Number(question.dataset.answer);
        const selectedLabel = selected.closest('.quiz-option');
        if (correct) { score += 1; selectedLabel?.classList.add('is-correct'); }
        else { selectedLabel?.classList.add('is-wrong'); question.querySelector(`input[value="${question.dataset.answer}"]`)?.closest('.quiz-option')?.classList.add('is-correct'); }
        feedback.textContent = `${correct ? 'Correto.' : 'Ainda não.'} ${question.dataset.explanation}`;
        feedback.className = `question-feedback ${correct ? 'is-correct' : 'is-wrong'}`;
      });
      if (!answered) { toast('Escolha pelo menos uma resposta para corrigir.', true); return; }
      const best = read(key, { score: 0, total: questions.length });
      const nextBest = { score: Math.max(best.score ?? 0, score), total: questions.length };
      write(key, nextBest);
      if (scoreLabel) scoreLabel.textContent = `Resultado desta tentativa: ${score}/${questions.length} · melhor: ${nextBest.score}/${nextBest.total}`;
    });
  });

  // Feedback de baixo risco guardado apenas neste dispositivo. Renderização segura via textContent.
  const feedbackPanel = document.querySelector('#feedbackPanel');
  const feedbackToggle = document.querySelector('#feedbackToggle');
  const feedbackList = document.querySelector('#feedbackList');
  const closeFeedback = () => { if (feedbackPanel) feedbackPanel.hidden = true; feedbackToggle?.setAttribute('aria-expanded', 'false'); };
  const drawFeedback = () => {
    if (!feedbackList) return;
    const entries = read(STORAGE.feedback, []).slice().reverse();
    feedbackList.replaceChildren();
    entries.forEach((entry) => {
      const card = document.createElement('article'); card.className = 'feedback-entry';
      const author = document.createElement('strong'); author.textContent = entry.name || 'Estudante';
      const date = document.createElement('time'); date.dateTime = entry.date; date.textContent = new Date(entry.date).toLocaleDateString('pt-BR');
      const text = document.createElement('p'); text.textContent = entry.text;
      card.append(author, date, text); feedbackList.append(card);
    });
  };
  feedbackToggle?.addEventListener('click', () => {
    if (!feedbackPanel) return;
    feedbackPanel.hidden = !feedbackPanel.hidden;
    feedbackToggle.setAttribute('aria-expanded', String(!feedbackPanel.hidden));
    if (!feedbackPanel.hidden) { drawFeedback(); document.querySelector('#feedbackText')?.focus(); }
  });
  document.querySelector('#feedbackClose')?.addEventListener('click', closeFeedback);
  document.querySelector('#feedbackForm')?.addEventListener('submit', (event) => {
    event.preventDefault();
    const nameField = document.querySelector('#feedbackName');
    const textField = document.querySelector('#feedbackText');
    const text = textField?.value.trim() ?? '';
    if (!text) { textField?.focus(); return; }
    const entries = read(STORAGE.feedback, []);
    entries.push({ name: nameField?.value.trim().slice(0, 48) ?? '', text: text.slice(0, 400), date: new Date().toISOString() });
    if (!write(STORAGE.feedback, entries)) return;
    event.target.reset(); drawFeedback(); toast('Feedback salvo neste dispositivo.');
  });
  drawFeedback();

  // Entrada suave, sem esconder conteúdo quando JavaScript estiver desativado.
  if ('IntersectionObserver' in window && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    const observer = new IntersectionObserver((entries) => entries.forEach((entry) => {
      if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); }
    }), { threshold: .06 });
    document.querySelectorAll('.reveal').forEach((element) => observer.observe(element));
  } else document.querySelectorAll('.reveal').forEach((element) => element.classList.add('is-visible'));
})();
