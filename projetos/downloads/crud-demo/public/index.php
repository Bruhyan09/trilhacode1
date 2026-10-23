<?php
require_once __DIR__ . '/../src/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $tasks = loadTasks();
    $action = (string)($_POST['action'] ?? '');
    try {
        if ($action === 'create') {
            $title = trim((string)($_POST['title'] ?? ''));
            if ($title === '' || mb_strlen($title) > 120) {
                throw new InvalidArgumentException('Informe um título de até 120 caracteres.');
            }
            $tasks[] = ['id' => bin2hex(random_bytes(8)), 'title' => $title, 'done' => false, 'created_at' => date(DATE_ATOM)];
            saveTasks($tasks);
            $_SESSION['flash'] = 'Tarefa criada.';
        } elseif (in_array($action, ['toggle', 'delete'], true)) {
            $id = (string)($_POST['id'] ?? '');
            $found = false;
            foreach ($tasks as $index => &$task) {
                if (($task['id'] ?? '') !== $id) continue;
                $found = true;
                if ($action === 'toggle') $task['done'] = !($task['done'] ?? false);
                else unset($tasks[$index]);
                break;
            }
            unset($task);
            if (!$found) throw new InvalidArgumentException('A tarefa não foi encontrada.');
            saveTasks($tasks);
            $_SESSION['flash'] = $action === 'toggle' ? 'Estado atualizado.' : 'Tarefa removida.';
        } else {
            http_response_code(400);
            exit('Ação não reconhecida.');
        }
    } catch (Throwable $error) {
        $_SESSION['flash'] = $error instanceof InvalidArgumentException ? $error->getMessage() : 'Não foi possível concluir a operação.';
    }
    redirectHome();
}

$tasks = loadTasks();
$flash = (string)($_SESSION['flash'] ?? '');
unset($_SESSION['flash']);
$token = csrfToken();
$completed = count(array_filter($tasks, static fn($task) => !empty($task['done'])));
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>CRUD de tarefas · Projeto de estudo</title><link rel="stylesheet" href="/style.css"></head>
<body><main class="wrap">
  <a class="back" href="/">← Início da demonstração</a>
  <p class="eyebrow">PROJETO DE ESTUDO · PHP</p><h1>Uma tarefa por vez.</h1><p class="lead">CRUD mínimo com validação no servidor, token CSRF e dados JSON locais.</p>
  <div class="summary"><strong><?= count($tasks) ?></strong> tarefa(s) <span>·</span> <strong><?= $completed ?></strong> concluída(s)</div>
  <?php if ($flash !== ''): ?><p class="notice" role="status"><?= e($flash) ?></p><?php endif; ?>
  <form class="create" method="post"><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="action" value="create"><label class="sr-only" for="title">Nova tarefa</label><input id="title" name="title" maxlength="120" required placeholder="Ex.: revisar a validação do formulário"><button type="submit">Adicionar tarefa</button></form>
  <section class="list" aria-label="Lista de tarefas">
    <?php if (!$tasks): ?><p class="empty">Ainda não há tarefas. Crie a primeira acima.</p><?php endif; ?>
    <?php foreach ($tasks as $task): ?>
      <article class="task<?= !empty($task['done']) ? ' done' : '' ?>"><div><strong><?= e((string)($task['title'] ?? '')) ?></strong><small><?= !empty($task['done']) ? 'Concluída' : 'Em andamento' ?></small></div>
        <form method="post"><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="id" value="<?= e((string)$task['id']) ?>"><input type="hidden" name="action" value="toggle"><button class="secondary" type="submit"><?= !empty($task['done']) ? 'Reabrir' : 'Concluir' ?></button></form>
        <form method="post" onsubmit="return confirm('Remover esta tarefa?')"><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="id" value="<?= e((string)$task['id']) ?>"><input type="hidden" name="action" value="delete"><button class="remove" type="submit" aria-label="Remover <?= e((string)$task['title']) ?>">Excluir</button></form>
      </article>
    <?php endforeach; ?>
  </section>
  <footer>Os dados deste exercício são gravados em <code>var/tasks.json</code> fora da pasta pública. Para uso real, avalie banco de dados e acesso concorrente.</footer>
</main></body></html>
