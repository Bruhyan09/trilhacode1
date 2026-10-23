    <footer class="site-footer"><span>Trilha Code · prática que vira projeto</span><a href="/mercado/index.php">Próximo passo: mercado de trabalho <span aria-hidden="true">↗</span></a></footer>
  </main>
</div>
<div class="feedback-fab-wrap"><button class="feedback-fab" id="feedbackToggle" type="button" aria-expanded="false" aria-controls="feedbackPanel"><span aria-hidden="true">✳</span> Deixe um feedback</button></div>
<section class="feedback-panel" id="feedbackPanel" hidden aria-labelledby="feedbackTitle">
  <div class="feedback-panel-head"><div><span class="eyebrow">AJUDE A MELHORAR</span><h2 id="feedbackTitle">Como foi estudar por aqui?</h2></div><button class="icon-button close-feedback" id="feedbackClose" type="button" aria-label="Fechar feedback">×</button></div>
  <form id="feedbackForm"><label for="feedbackName">Seu nome <span class="muted">(opcional)</span></label><input id="feedbackName" maxlength="48" placeholder="Como podemos chamar você?"><label for="feedbackText">Seu comentário</label><textarea id="feedbackText" maxlength="400" required placeholder="O que funcionou bem? O que faltou para avançar?"></textarea><button class="button button-primary button-full" type="submit">Salvar neste dispositivo</button><p class="form-note">Seu comentário fica só neste navegador e não é enviado a um servidor.</p></form>
  <div class="feedback-list" id="feedbackList" aria-live="polite"></div>
</section>
<div class="toast-region" id="toastRegion" aria-live="polite" aria-atomic="true"></div>
<?php
$searchIndex = [];
foreach ($PORTAL_PAGES as $id => $page) {
    $lesson = $LESSONS[$id] ?? [];
    $sectionText = implode(' ', array_map(static fn($section) => $section['body'] ?? '', $lesson['sections'] ?? []));
    $content = strip_tags($sectionText . ' ' . ($lesson['code']['source'] ?? ''));
    $searchIndex[] = ['id'=>$id, 'title'=>$page['title'], 'href'=>$page['href'], 'summary'=>$page['summary'], 'content'=>$content];
}
?>
<script>window.portalSearchIndex = <?= json_encode($searchIndex, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;</script>
<script src="/assets/js/main.js" defer></script>
</body>
</html>
