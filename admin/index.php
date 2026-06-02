<?php
require_once __DIR__ . '/../lib/bootstrap.php';

$tabCount = (int) db()->query('SELECT COUNT(*) FROM tabs')->fetchColumn();
$slideCount = (int) db()->query('SELECT COUNT(*) FROM slides')->fetchColumn();
$tabs = get_tabs_with_slides(false);
$flash = flash_get();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | <?= h(app_config('app_name')); ?></title>
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
            <h1 class="h3 mb-1" style="font-family:'Titillium Web', sans-serif;">WPoets Admin</h1>
            <div class="small-muted">Manage tabs and slides for the frontend section.</div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?= h(asset('index.php')); ?>" class="btn btn-outline-secondary">View Frontend</a>
            <a href="<?= h(asset('admin/tab-form.php')); ?>" class="btn btn-primary">Add Tab</a>
            <a href="<?= h(asset('admin/slide-form.php')); ?>" class="btn btn-primary">Add Slide</a>
        </div>
    </div>

    <?php if ($flash): ?>
        <div class="flash-wrap">
            <div class="flash-message flash-<?= h($flash['type']); ?>"><?= h($flash['message']); ?></div>
        </div>
    <?php endif; ?>

    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card admin-card">
                <div class="card-body">
                    <div class="text-uppercase small-muted mb-1">Tabs</div>
                    <div class="display-6 mb-0"><?= $tabCount; ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card admin-card">
                <div class="card-body">
                    <div class="text-uppercase small-muted mb-1">Slides</div>
                    <div class="display-6 mb-0"><?= $slideCount; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card admin-card mb-4">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <strong>Tabs</strong>
            <a href="<?= h(asset('admin/tab-form.php')); ?>" class="btn btn-sm btn-primary">Add New</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Icon</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($tabs as $tab): ?>
                        <tr>
                            <td><?= (int) $tab['id']; ?></td>
                            <td><?= h($tab['title']); ?></td>
                            <td><img src="<?= h(asset($tab['icon'])); ?>" alt="" style="width:40px;height:40px;object-fit:contain;"></td>
                            <td><?= (int) $tab['sort_order']; ?></td>
                            <td><span class="badge text-bg-<?= ((int)$tab['status'] === 1) ? 'success' : 'secondary'; ?>"><?= ((int)$tab['status'] === 1) ? 'Active' : 'Inactive'; ?></span></td>
                            <td class="text-end">
                                <a href="<?= h(asset('admin/tab-form.php?id=' . (int) $tab['id'])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?= h(asset('admin/delete.php?entity=tab&id=' . (int) $tab['id'])); ?>" class="btn btn-sm btn-outline-danger js-confirm-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($tabs)): ?>
                        <tr><td colspan="6" class="text-center py-4">No tabs found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card admin-card">
        <div class="card-header bg-white d-flex align-items-center justify-content-between">
            <strong>Slides</strong>
            <a href="<?= h(asset('admin/slide-form.php')); ?>" class="btn btn-sm btn-primary">Add New</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tab</th>
                            <th>Badge</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $stmt = db()->query('SELECT s.*, t.title AS tab_title FROM slides s INNER JOIN tabs t ON t.id = s.tab_id ORDER BY s.sort_order ASC, s.id ASC');
                        $slides = $stmt->fetchAll();
                    ?>
                    <?php foreach ($slides as $slide): ?>
                        <tr>
                            <td><?= (int) $slide['id']; ?></td>
                            <td><?= h($slide['tab_title']); ?></td>
                            <td><?= h($slide['badge_text']); ?></td>
                            <td><?= h($slide['title']); ?></td>
                            <td><img src="<?= h(asset($slide['image'])); ?>" alt="" style="width:54px;height:54px;object-fit:cover;border-radius:8px;"></td>
                            <td><?= (int) $slide['sort_order']; ?></td>
                            <td><span class="badge text-bg-<?= ((int)$slide['status'] === 1) ? 'success' : 'secondary'; ?>"><?= ((int)$slide['status'] === 1) ? 'Active' : 'Inactive'; ?></span></td>
                            <td class="text-end">
                                <a href="<?= h(asset('admin/slide-form.php?id=' . (int) $slide['id'])); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="<?= h(asset('admin/delete.php?entity=slide&id=' . (int) $slide['id'])); ?>" class="btn btn-sm btn-outline-danger js-confirm-delete">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($slides)): ?>
                        <tr><td colspan="8" class="text-center py-4">No slides found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= h(asset('assets/js/app.js')); ?>"></script>
</body>
</html>
