(function ($) {
    'use strict';

    const tabStates = {};

    function clampIndex(index, total) {
        if (total <= 0) {
            return 0;
        }
        return ((index % total) + total) % total;
    }

    function buildDots($container, total, activeIndex, clickHandler) {
        $container.empty();
        for (let i = 0; i < total; i++) {
            const $dot = $('<button type="button" class="slider-dot" aria-label="Go to slide"></button>');
            if (i === activeIndex) {
                $dot.addClass('is-active');
            }
            $dot.on('click', function () {
                clickHandler(i);
            });
            $container.append($dot);
        }
    }

    function updateDesktopTab(tabId, index) {
        const state = tabStates[tabId];
        if (!state) {
            return;
        }

        const total = state.total;
        const active = clampIndex(index, total);

        state.index = active;

        state.$desktopPanel.find('.slide-card').removeClass('is-active').eq(active).addClass('is-active');
        state.$desktopImagePanel.find('.image-slide').removeClass('is-active').eq(active).addClass('is-active');
        state.$desktopPanel.find('.slider-dot').removeClass('is-active').eq(active).addClass('is-active');
    }

    function updateMobileTab(tabId, index) {
        const state = tabStates[tabId];
        if (!state) {
            return;
        }

        const total = state.total;
        const active = clampIndex(index, total);

        state.mobileIndex = active;
        state.$mobilePanel.find('.mobile-slide').removeClass('is-active').eq(active).addClass('is-active');
        state.$mobilePanel.find('.slider-dot').removeClass('is-active').eq(active).addClass('is-active');
    }

    function bindDesktopTab(tabId) {
        const state = tabStates[tabId];
        if (!state) {
            return;
        }

        updateDesktopTab(tabId, 0);

        state.$desktopPanel.find('[data-prev]').off('click').on('click', function () {
            updateDesktopTab(tabId, state.index - 1);
        });

        state.$desktopPanel.find('[data-next]').off('click').on('click', function () {
            updateDesktopTab(tabId, state.index + 1);
        });

        buildDots(state.$desktopPanel.find('[data-dots]'), state.total, 0, function (dotIndex) {
            updateDesktopTab(tabId, dotIndex);
        });
    }

    function bindMobileTab(tabId) {
        const state = tabStates[tabId];
        if (!state) {
            return;
        }

        updateMobileTab(tabId, 0);

        state.$mobilePanel.find('[data-prev]').off('click').on('click', function () {
            updateMobileTab(tabId, state.mobileIndex - 1);
        });

        state.$mobilePanel.find('[data-next]').off('click').on('click', function () {
            updateMobileTab(tabId, state.mobileIndex + 1);
        });

        buildDots(state.$mobilePanel.find('[data-dots]'), state.total, 0, function (dotIndex) {
            updateMobileTab(tabId, dotIndex);
        });
    }


    function moveContentArrow(tabId) {
    const $activeTab = $('.tab-button[data-tab-target="' + tabId + '"]');
    const $contentColumn = $('.content-column');
    const $arrow = $('.content-arrow');

    if (!$activeTab.length || !$contentColumn.length || !$arrow.length) {
        return;
    }

    const tabOffset = $activeTab.offset();
    const columnOffset = $contentColumn.offset();

    const top = tabOffset.top - columnOffset.top + ($activeTab.outerHeight() / 2) - 18;

    $arrow.css('top', top + 'px');
}

   function activateTab(tabId) {
    $('.tab-button').removeClass('is-active');
    $('.tab-button[data-tab-target="' + tabId + '"]').addClass('is-active');

    $('.tab-panel').removeClass('is-active');
    $('.image-panel').removeClass('is-active');

    const state = tabStates[tabId];
    if (!state) {
        return;
    }

    state.$desktopPanel.addClass('is-active');
    state.$desktopImagePanel.addClass('is-active');
    updateDesktopTab(tabId, 0);

    moveContentArrow(tabId);
}

    function initTabSystem() {
        $('[data-tab-target]').each(function () {
            const tabId = String($(this).data('tab-target'));
            const $desktopPanel = $('[data-tab-panel="' + tabId + '"]');
            const $desktopImagePanel = $('[data-image-panel="' + tabId + '"]');
            const $mobilePanel = $('[data-mobile-panel="' + tabId + '"]');
            const total = $desktopPanel.find('.slide-card').length || $mobilePanel.find('.mobile-slide').length;

            tabStates[tabId] = {
                total: total,
                index: 0,
                mobileIndex: 0,
                $desktopPanel: $desktopPanel,
                $desktopImagePanel: $desktopImagePanel,
                $mobilePanel: $mobilePanel
            };

            bindDesktopTab(tabId);
            bindMobileTab(tabId);
        });

        $('[data-tab-target]').on('click', function () {
            activateTab(String($(this).data('tab-target')));
        });

        const firstTab = $('[data-tab-target]').first().data('tab-target');
        if (firstTab !== undefined) {
            activateTab(String(firstTab));
            moveContentArrow(String(firstTab));
        }

        const accordion = document.getElementById('tabsAccordion');
        if (accordion) {
            accordion.addEventListener('shown.bs.collapse', function (event) {
                const target = event.target;
                const tabId = target.getAttribute('data-mobile-panel');
                if (tabId && tabStates[tabId]) {
                    updateMobileTab(tabId, 0);
                }
            });
        }
    }

    function initAdminActions() {
        $('.js-confirm-delete').on('click', function (event) {
            if (!confirm('Delete this record? This action cannot be undone.')) {
                event.preventDefault();
            }
        });
    }

    $(function () {
        initTabSystem();
        initAdminActions();

        $(window).on('resize', function () {
    const activeTab = $('.tab-button.is-active').data('tab-target');
    if (activeTab !== undefined) {
        moveContentArrow(String(activeTab));
    }
});
    });

})(jQuery);
