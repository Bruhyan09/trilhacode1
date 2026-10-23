<?php
declare(strict_types=1);

ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

const USERS_FILE = __DIR__ . '/../var/users.json';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}

function verifyCsrf(): void
{
    if (!hash_equals(csrfToken(), (string)($_POST['csrf'] ?? ''))) {
        http_response_code(403);
        exit('Formulário expirado. Volte e tente novamente.');
    }
}

function loadUsers(): array
{
    if (!is_file(USERS_FILE)) return [];
    $users = json_decode((string)file_get_contents(USERS_FILE), true);
    return is_array($users) ? $users : [];
}

function saveUsers(array $users): void
{
    $directory = dirname(USERS_FILE);
    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new RuntimeException('Não foi possível criar a pasta privada.');
    }
    $json = json_encode(array_values($users), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    if (file_put_contents(USERS_FILE, $json . PHP_EOL, LOCK_EX) === false) {
        throw new RuntimeException('Não foi possível salvar o cadastro.');
    }
}

function redirectHome(): never
{
    header('Location: /', true, 303);
    exit;
}
