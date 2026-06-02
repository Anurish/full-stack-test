<?php
require_once __DIR__ . '/lib/bootstrap.php';
$tabs = get_tabs_with_slides(true);
require_once __DIR__ . '/lib/layout-top.php';
?>
<div class="page-shell">
    <div class="container-fluid container-xl">
        <div class="section-heading">
            <h1>DelphianLogic in Action</h1>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo</p>
        </div>

        <?php if (empty($tabs)): ?>
            <div class="alert alert-warning mb-0">No active tabs or slides found. Please import <code>database.sql</code> and add records through the admin panel.</div>
        <?php else: ?>
            <div class="desktop-shell">
                <div class="tab-column">
                    <?php foreach ($tabs as $i => $tab): ?>
                        <button type="button" class="tab-button<?= $i === 0 ? ' is-active' : ''; ?>" data-tab-target="<?= (int) $tab['id']; ?>">
                            <img class="tab-icon" src="<?= h(asset($tab['icon'])); ?>" alt="<?= h($tab['title']); ?>">
                            <span class="tab-title"><?= h($tab['title']); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

             <div class="content-column">
    <span class="content-arrow"></span>
                    <?php foreach ($tabs as $i => $tab): ?>
                        <div class="tab-panel<?= $i === 0 ? ' is-active' : ''; ?>" data-tab-panel="<?= (int) $tab['id']; ?>">
                            <div class="slider-stage">
                                <div class="content-slider">
                                    <?php foreach ($tab['slides'] as $j => $slide): ?>
                                        <div class="slide-card<?= $j === 0 ? ' is-active' : ''; ?>">
                                            <div class="slide-card-inner">
                                                <div class="slide-badge"><?= h($slide['badge_text']); ?></div>
                                                <h2 class="slide-title"><?= h($slide['title']); ?></h2>
                                                <a class="slide-cta" href="<?= h($slide['button_link']); ?>"><?= h($slide['button_text']); ?></a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="slider-controls">
                                    <button type="button" class="control-btn" data-prev aria-label="Previous slide">‹</button>
                                    <div class="slider-dots" data-dots></div>
                                    <button type="button" class="control-btn" data-next aria-label="Next slide">›</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="image-column">
                    <?php foreach ($tabs as $i => $tab): ?>
                        <div class="image-panel<?= $i === 0 ? ' is-active' : ''; ?>" data-image-panel="<?= (int) $tab['id']; ?>">
                            <div class="image-slider">
                                <?php foreach ($tab['slides'] as $j => $slide): ?>
                                    <div class="image-slide<?= $j === 0 ? ' is-active' : ''; ?>">
                                        <img src="<?= h(asset($slide['image'])); ?>" alt="<?= h($slide['title']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mobile-shell">
                <div class="accordion" id="tabsAccordion">
                    <?php foreach ($tabs as $i => $tab): ?>
                        <?php $collapseId = 'collapseTab' . (int) $tab['id']; ?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?= (int) $tab['id']; ?>">
                                <button class="accordion-button<?= $i === 0 ? '' : ' collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= h($collapseId); ?>" aria-expanded="<?= $i === 0 ? 'true' : 'false'; ?>" aria-controls="<?= h($collapseId); ?>">
                                    <img class="tab-icon" src="<?= h(asset($tab['icon'])); ?>" alt="<?= h($tab['title']); ?>">
                                    <span class="tab-title"><?= h($tab['title']); ?></span>
                                    <span class="accordion-plus" aria-hidden="true"></span>
                                </button>
                            </h2>
                            <div id="<?= h($collapseId); ?>" class="accordion-collapse collapse<?= $i === 0 ? ' show' : ''; ?>" data-bs-parent="#tabsAccordion" data-mobile-panel="<?= (int) $tab['id']; ?>">
                                <div class="accordion-body">
                                    <div class="mobile-slider">
                                        <?php foreach ($tab['slides'] as $j => $slide): ?>
                                            <div class="mobile-slide<?= $j === 0 ? ' is-active' : ''; ?>" style="background-image:url('<?= h(asset($slide['image'])); ?>');">
                                                <div class="mobile-slide-inner">
                                                    <div class="slide-badge"><?= h($slide['badge_text']); ?></div>
                                                    <h2 class="slide-title"><?= h($slide['title']); ?></h2>
                                                    <a class="slide-cta" href="<?= h($slide['button_link']); ?>"><?= h($slide['button_text']); ?></a>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                        <div class="slider-controls">
                                            <button type="button" class="control-btn" data-prev aria-label="Previous slide">‹</button>
                                            <div class="slider-dots" data-dots></div>
                                            <button type="button" class="control-btn" data-next aria-label="Next slide">›</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php require_once __DIR__ . '/lib/layout-bottom.php'; ?>
