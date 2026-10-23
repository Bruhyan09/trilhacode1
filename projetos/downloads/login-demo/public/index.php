<?php
require_once __DIR__ . '/../src/bootstrap.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $action = (string)($_POST['action'] ?? '');
    $users = loadUsers();
    $email = mb_strtolower(trim((string)($_POST['email'] ?? '')));
    $password = (string)($_POST['password'] ?? '');

    if ($action === 'register') {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 180) {
            $message = 'Informe um e-mail válido.';
        } elseif (mb_strlen($password) < 10 || mb_strlen($password) > 200) {
            $message = 'Use uma senha de 10 a 200 caracteres (somente para este exercício).';
        } else {
            $exists = false;
            foreach ($users as $user) if (($user['email'] ?? '') === $email) $exists = true;
            if ($exists) $message = 'Não foi possível concluir o cadastro com esses dados.';
            else {
                $users[] = ['id' => bin2hex(random_bytes(8)), 'email' => $email, 'password_hash' => password_hash($password, PASSWORD_DEFAULT), 'created_at' => date(DATE_ATOM)];
                saveUsers($users);
                $user = end($users);
                session_regenerate_id(true);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['flash'] = 'Cadastro criado. Você entrou na demonstração.';
                redirectHome();
            }
        }
    } elseif ($action === 'login') {
        $matched = null;
        foreach ($users as $user) if (($user['email'] ?? '') === $email) $matched = $user;
        if ($matched && password_verify($password, (string)$matched['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $matched['id'];
            $_SESSION['flash'] = 'Sessão iniciada.';
            redirectHome();
        }
        $message = 'Não foi possível entrar com esses dados.';
    } elseif ($action === 'logout') {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'] ?? '', $params['secure'], $params['httponly']);
        }
        session_destroy();
        header('Location: /', true, 303);
        exit;
    } else {
        http_response_code(400);
        exit('Ação não reconhecida.');
    }
}

$flash = (string)($_SESSION['flash'] ?? '');
unset($_SESSION['flash']);
$user = null;
if (!empty($_SESSION['user_id'])) {
    foreach (loadUsers() as $candidate) if (($candidate['id'] ?? '') === $_SESSION['user_id']) $user = $candidate;
}
$token = csrfToken();
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login seguro · Projeto de estudo</title><link rel="stylesheet" href="/style.css"></head>
<body><main class="wrap"><a class="back" href="/">← Início da demonstração</a>
  <p class="eyebrow">PROJETO DE ESTUDO · SESSÕES PHP</p><h1>Identidade com cuidado.</h1><p class="lead">Cadastro e login com hash de senha, sessão e token CSRF.</p>
  <?php if ($flash !== ''): ?><p class="notice" role="status"><?= e($flash) ?></p><?php endif; ?>
  <?php if ($message !== ''): ?><p class="notice warning" role="alert"><?= e($message) ?></p><?php endif; ?>
  <?php if ($user): ?>
    <section class="account"><span class="avatar" aria-hidden="true">✓</span><div><small>SESSÃO ATIVA</small><h2>Olá, <?= e((string)$user['email']) ?></h2><p>Você entrou na área de demonstração.</p></div></section>
    <form method="post"><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="action" value="logout"><button class="primary" type="submit">Encerrar sessão</button></form>
  <?php else: ?>
    <div class="forms">
      <form class="panel" method="post"><h2>Entrar</h2><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="action" value="login"><label for="login-email">E-mail</label><input id="login-email" name="email" type="email" maxlength="180" autocomplete="email" required><label for="login-password">Senha</label><input id="login-password" name="password" type="password" autocomplete="current-password" required><button class="primary" type="submit">Entrar</button></form>
      <form class="panel" method="post"><h2>Criar cadastro</h2><input type="hidden" name="csrf" value="<?= e($token) ?>"><input type="hidden" name="action" value="register"><label for="register-email">E-mail</label><input id="register-email" name="email" type="email" maxlength="180" autocomplete="email" required><label for="register-password">Senha <small>(mínimo de 10 caracteres)</small></label><input id="register-password" name="password" type="password" minlength="10" maxlength="200" autocomplete="new-password" required><button class="primary" type="submit">Criar cadastro</button></form>
    </div>
  <?php endif; ?>
  <aside class="warning-box"><strong>Somente para estudo local.</strong> O armazenamento JSON não implementa limite de tentativas, recuperação de conta, auditoria nem proteção contra concorrência. Não use sua senha real nem publique esta demonstração sem revisão.</aside>
  <footer>Senhas são armazenadas com <code>password_hash</code>; jamais como texto puro.</footer>
</main></body></html>
