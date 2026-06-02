<?php
require_once __DIR__ . '/../lib/bootstrap.php';

$entity = $_GET['entity'] ?? '';
$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0 || !in_array($entity, ['tab', 'slide'], true)) {
    flash_set('error', 'Invalid delete request.');
    redirect('admin/index.php');
}

try {
    if ($entity === 'tab') {
        $stmt = db()->prepare('DELETE FROM tabs WHERE id = :id');
    } else {
        $stmt = db()->prepare('DELETE FROM slides WHERE id = :id');
    }

    $stmt->execute(['id' => $id]);
    flash_set('success', ucfirst($entity) . ' deleted successfully.');
} catch (Throwable $e) {
    flash_set('error', 'Unable to delete record: ' . $e->getMessage());
}

redirect('admin/index.php');
