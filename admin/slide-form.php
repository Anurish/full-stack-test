<?php
require_once __DIR__ . '/../lib/bootstrap.php';

$id = (int) ($_GET['id'] ?? 0);
$slide = [
    'tab_id' => '',
    'badge_text' => '',
    'title' => '',
    'button_text' => 'Learn More',
    'button_link' => '#',
    'image' => '',
    'sort_order' => 0,
    'status' => 1,
];

if ($id > 0) {
    $existing = get_slide_by_id($id);
    if (!$existing) {
        flash_set('error', 'Slide not found.');
        redirect('admin/index.php');
    }
    $slide = $existing;
}

$tabs = db()->query('SELECT id, title FROM tabs ORDER BY sort_order ASC, id ASC')->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabId = (int) ($_POST['tab_id'] ?? 0);
    $badgeText = trim((string) ($_POST['badge_text'] ?? ''));
    $title = trim((string) ($_POST['title'] ?? ''));
    $buttonText = trim((string) ($_POST['button_text'] ?? 'Learn More'));
    $buttonLink = trim((string) ($_POST['button_link'] ?? '#'));
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $status = isset($_POST['status']) ? 1 : 0;

    if ($tabId <= 0 || $title === '' || $badgeText === '') {
        flash_set('error', 'Tab, badge text, and title are required.');
        redirect($id > 0 ? 'admin/slide-form.php?id=' . $id : 'admin/slide-form.php');
    }

    $imagePath = $slide['image'] ?? '';
    try {
        $uploadedImage = upload_file($_FILES['image'] ?? [], 'uploads');
        if ($uploadedImage) {
            $imagePath = $uploadedImage;
        }

        $pdo = db();

        if ($id > 0) {
            $stmt = $pdo->prepare('UPDATE slides SET tab_id = :tab_id, badge_text = :badge_text, title = :title, button_text = :button_text, button_link = :button_link, image = :image, sort_order = :sort_order, status = :status WHERE id = :id');
            $stmt->execute([
                'tab_id' => $tabId,
                'badge_text' => $badgeText,
                'title' => $title,
                'button_text' => $buttonText ?: 'Learn More',
                'button_link' => $buttonLink ?: '#',
                'image' => $imagePath,
                'sort_order' => $sortOrder,
                'status' => $status,
                'id' => $id,
            ]);
            flash_set('success', 'Slide updated successfully.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO slides (tab_id, badge_text, title, button_text, button_link, image, sort_order, status) VALUES (:tab_id, :badge_text, :title, :button_text, :button_link, :image, :sort_order, :status)');
            $stmt->execute([
                'tab_id' => $tabId,
                'badge_text' => $badgeText,
                'title' => $title,
                'button_text' => $buttonText ?: 'Learn More',
                'button_link' => $buttonLink ?: '#',
                'image' => $imagePath ?: 'assets/images/learning-1.svg',
                'sort_order' => $sortOrder,
                'status' => $status,
            ]);
            flash_set('success', 'Slide created successfully.');
        }

        redirect('admin/index.php');
    } catch (Throwable $e) {
        flash_set('error', 'Unable to save slide: ' . $e->getMessage());
        redirect($id > 0 ? 'admin/slide-form.php?id=' . $id : 'admin/slide-form.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $id > 0 ? 'Edit Slide' : 'Add Slide'; ?> | Admin</title>
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
            <h1 class="h3 mb-1" style="font-family:'Titillium Web', sans-serif;"><?= $id > 0 ? 'Edit Slide' : 'Add Slide'; ?></h1>
            <div class="small-muted">Create or update a slide shown in column 2 and column 3.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= h(asset('admin/index.php')); ?>" class="btn btn-outline-secondary">Back</a>
            <a href="<?= h(asset('index.php')); ?>" class="btn btn-outline-secondary">View Frontend</a>
        </div>
    </div>

    <div class="card admin-card">
        <div class="card-body p-4">
            <form method="post" enctype="multipart/form-data" class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Tab</label>
                    <select name="tab_id" class="form-select" required>
                        <option value="">Select tab</option>
                        <?php foreach ($tabs as $tab): ?>
                            <option value="<?= (int) $tab['id']; ?>" <?= selected($slide['tab_id'], $tab['id']); ?>><?= h($tab['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="<?= h($slide['sort_order']); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Badge Text</label>
                    <input type="text" name="badge_text" class="form-control" value="<?= h($slide['badge_text']); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Title</label>
                    <textarea name="title" class="form-control" rows="3" required><?= h($slide['title']); ?></textarea>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Button Text</label>
                    <input type="text" name="button_text" class="form-control" value="<?= h($slide['button_text']); ?>">
                </div>
                <div class="col-md-8">
                    <label class="form-label">Button Link</label>
                    <input type="text" name="button_link" class="form-control" value="<?= h($slide['button_link']); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept=".svg,.png,.jpg,.jpeg,.webp">
                    <div class="small-muted mt-2">Leave blank to keep the current image.</div>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="slideStatus" name="status" <?= checked((int) $slide['status'] === 1); ?>>
                        <label class="form-check-label" for="slideStatus">Active</label>
                    </div>
                </div>
                <?php if (!empty($slide['image'])): ?>
                    <div class="col-12">
                        <label class="form-label">Current Image</label><br>
                        <img src="<?= h(asset($slide['image'])); ?>" alt="" style="width:120px;height:120px;object-fit:cover;border-radius:12px;">
                    </div>
                <?php endif; ?>
                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><?= $id > 0 ? 'Update Slide' : 'Save Slide'; ?></button>
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
