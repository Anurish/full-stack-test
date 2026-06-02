<?php
require_once __DIR__ . '/../lib/bootstrap.php';

$id = (int) ($_GET['id'] ?? 0);
$tab = [
    'title' => '',
    'icon' => '',
    'sort_order' => 0,
    'status' => 1,
];

if ($id > 0) {
    $existing = get_tab_by_id($id);
    if (!$existing) {
        flash_set('error', 'Tab not found.');
        redirect('admin/index.php');
    }
    $tab = $existing;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($title === '') {
        flash_set('error', 'Tab title is required.');
        redirect($id > 0 ? 'admin/tab-form.php?id=' . $id : 'admin/tab-form.php');
    }

    $iconPath = $tab['icon'] ?? '';
    try {
        $uploadedIcon = upload_file($_FILES['icon'] ?? [], 'uploads');
        if ($uploadedIcon) {
            $iconPath = $uploadedIcon;
        }

        $pdo = db();

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE tabs SET title = :title, icon = :icon, sort_order = :sort_order, status = :status WHERE id = :id');
            $stmt->execute([
                'title' => $title,
                'icon' => $iconPath,
                'sort_order' => $sortOrder,
                'status' => $status,
                'id' => $id,
            ]);
            flash_set('success', 'Tab updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO tabs (title, icon, sort_order, status) VALUES (:title, :icon, :sort_order, :status)');
            $stmt->execute([
                'title' => $title,
                'icon' => $iconPath ?: 'assets/images/icon-learning.svg',
                'sort_order' => $sortOrder,
                'status' => $status,
            ]);
            flash_set('success', 'Tab created successfully.');
        }

        redirect('admin/index.php');
    } catch (Throwable $e) {
        flash_set('error', 'Unable to save tab: ' . $e->getMessage());
        redirect($id > 0 ? 'admin/tab-form.php?id=' . $id : 'admin/tab-form.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $id > 0 ? 'Edit Tab' : 'Add Tab'; ?> | Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&family=Titillium+Web:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= h(asset('assets/css/style.css')); ?>">
</head>
<body class="site-admin">
<div class="container py-4 py-lg-5">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1" style="font-family:'Titillium Web', sans-serif;"><?= $id > 0 ? 'Edit Tab' : 'Add Tab'; ?></h1>
            <div class="small-muted">Create or update a tab shown in the left column.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= h(asset('admin/index.php')); ?>" class="btn btn-outline-secondary">Back</a>
            <a href="<?= h(asset('index.php')); ?>" class="btn btn-outline-secondary">View Frontend</a>
        </div>
    </div>

    <div class="card admin-card">
        <div class="card-body p-4">
            <form method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= h($tab['title']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= h($tab['sort_order']); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Icon</label>
                    <input type="file" name="icon" class="form-control" accept=".svg,.png,.jpg,.jpeg,.webp">
                    <div class="small-muted mt-2">Leave blank to keep the current icon.</div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="status" name="status" <?= checked((int) $tab['status'] === 1); ?>>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
                <?php if (!empty($tab['icon'])): ?>
                    <div class="col-12">
                        <label class="form-label">Current Icon</label><br>
                        <img src="<?= h(asset($tab['icon'])); ?>" alt="" style="width:72px;height:72px;object-fit:contain;">
                    </div>
                <?php endif; ?>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= $id > 0 ? 'Update Tab' : 'Save Tab'; ?></button>
                    <a href="<?= h(asset('admin/index.php')); ?>" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= h(asset('assets/js/app.js')); ?>"></script>
</body>
</html>
