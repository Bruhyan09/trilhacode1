<?php
declare(strict_types=1);

ini_set('session.use_strict_mode', '1');
session_start();

const DATA_FILE = __DIR__ . '/../var/tasks.json';

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verifyCsrf(): void
{
    $sent = (string)($_POST['csrf'] ?? '');
    if (!hash_equals(csrfToken(), $sent)) {
        http_response_code(403);
        exit('Formulário expirado. Volte e tente novamente.');
    }
}

function loadTasks(): array
{
    if (!is_file(DATA_FILE)) return [];
    $decoded = json_decode((string)file_get_contents(DATA_FILE), true);
    return is_array($decoded) ? $decoded : [];
}

function saveTasks(array $tasks): void
{
    $directory = dirname(DATA_FILE);
    if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
        throw new RuntimeException('Não foi possível criar a pasta de dados.');
    }
    $json = json_encode(array_values($tasks), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    if (file_put_contents(DATA_FILE, $json . PHP_EOL, LOCK_EX) === false) {
        throw new RuntimeException('Não foi possível salvar os dados.');
    }
}

function redirectHome(): never
{
    header('Location: /', true, 303);
    exit;
}
