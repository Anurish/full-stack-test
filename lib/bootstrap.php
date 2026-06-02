<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$GLOBALS['app_config'] = require __DIR__ . '/../config/config.php';

function app_config(string $key, mixed $default = null): mixed
{
    $config = $GLOBALS['app_config'] ?? [];
    return $config[$key] ?? $default;
}

function db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = app_config('db', []);

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $cfg['host'] ?? 'localhost',
        $cfg['name'] ?? '',
        $cfg['charset'] ?? 'utf8mb4'
    );

    $pdo = new PDO($dsn, $cfg['user'] ?? 'root', $cfg['pass'] ?? '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    return $pdo;
}

function h(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function base_url(string $path = ''): string
{
    $base = trim((string) app_config('base_url', '/full-stack-test'), '/');
    $path = ltrim($path, '/');

    $url = '/' . $base;

    if ($path === '') {
        return $url;
    }

    return $url . '/' . $path;
}

function asset(string $path): string
{
    return base_url($path);
}

function redirect(string $path): never
{
    header('Location: ' . base_url($path));
    exit;
}

function flash_set(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function flash_get(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function ensure_upload_dir(string $dir): string
{
    $absolute = __DIR__ . '/../assets/' . trim($dir, '/');

    if (!is_dir($absolute)) {
        mkdir($absolute, 0775, true);
    }

    return $absolute;
}

function upload_file(
    array $file,
    string $subdir = 'uploads',
    array $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']
): ?string {
    if (empty($file['name']) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        throw new RuntimeException('File upload failed.');
    }

    $ext = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExtensions, true)) {
        throw new RuntimeException('Invalid file type.');
    }

    $dir = ensure_upload_dir($subdir);
    $safeName = uniqid('upload_', true) . '.' . $ext;
    $target = $dir . '/' . $safeName;

    if (!move_uploaded_file((string) $file['tmp_name'], $target)) {
        throw new RuntimeException('Unable to save uploaded file.');
    }

    return 'assets/' . trim($subdir, '/') . '/' . $safeName;
}

function get_tabs_with_slides(bool $onlyActive = true): array
{
    $pdo = db();

    $tabSql = 'SELECT * FROM tabs';
    if ($onlyActive) {
        $tabSql .= ' WHERE status = 1';
    }
    $tabSql .= ' ORDER BY sort_order ASC, id ASC';

    $tabs = $pdo->query($tabSql)->fetchAll();

    $slideSql = 'SELECT * FROM slides WHERE tab_id = :tab_id';
    if ($onlyActive) {
        $slideSql .= ' AND status = 1';
    }
    $slideSql .= ' ORDER BY sort_order ASC, id ASC';

    $slideStmt = $pdo->prepare($slideSql);

    foreach ($tabs as &$tab) {
        $slideStmt->execute(['tab_id' => $tab['id']]);
        $tab['slides'] = $slideStmt->fetchAll();
    }
    unset($tab);

    return $tabs;
}

function get_tab_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM tabs WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $tab = $stmt->fetch();

    return $tab ?: null;
}

function get_slide_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM slides WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    $slide = $stmt->fetch();

    return $slide ?: null;
}

function current_page(string $needle): bool
{
    return str_contains($_SERVER['REQUEST_URI'] ?? '', $needle);
}

function checked(bool $value): string
{
    return $value ? 'checked' : '';
}

function selected(mixed $left, mixed $right): string
{
    return (string) $left === (string) $right ? 'selected' : '';
}