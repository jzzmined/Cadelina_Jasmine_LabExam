<?php
// includes/functions.php

if (!defined('FUNCTIONS_LOADED')) {
    define('FUNCTIONS_LOADED', true);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('USERS_FILE', __DIR__ . '/../data/users.json');

    function e(?string $v): string {
        return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
    }

    function clean(?string $v): string {
        return trim(strip_tags($v ?? ''));
    }

    function redirect(string $to): void {
        header("Location: $to");
        exit;
    }

    function load_users(): array {
        if (!file_exists(USERS_FILE)) return [];
        return json_decode(file_get_contents(USERS_FILE), true) ?: [];
    }

    function save_users(array $users): void {
        $dir = dirname(USERS_FILE);
        if (!is_dir($dir)) mkdir($dir, 0775, true);
        if (file_put_contents(USERS_FILE, json_encode($users, JSON_PRETTY_PRINT), LOCK_EX) === false) {
            throw new RuntimeException('Could not write users.json');
        }
    }

    function find_user(string $email): ?array {
        foreach (load_users() as $u) {
            if (strcasecmp($u['email'], $email) === 0) return $u;
        }
        return null;
    }

    function flash(string $type, string $msg): void {
        $_SESSION['flash'] = compact('type', 'msg');
    }

    function get_flash(): ?array {
        $f = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $f;
    }

    function csrf_token(): string {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    function csrf_ok(): bool {
        return isset($_POST['csrf'], $_SESSION['csrf'])
            && hash_equals($_SESSION['csrf'], $_POST['csrf']);
    }

    function validate_password(string $pw): ?string {
        if ($pw === '') return 'Password is required.';
        if (strlen($pw) < 8) return 'Password must be at least 8 characters.';
        if (!preg_match('/[A-Z]/', $pw) || !preg_match('/[a-z]/', $pw) || !preg_match('/\d/', $pw)) {
            return 'Password needs an uppercase letter, a lowercase letter, and a number.';
        }
        return null;
    }
}