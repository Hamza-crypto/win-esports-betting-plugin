jQuery.noConflict()(function ($) {

    const $listContainer = $('#we-bs-list-container');

    if ($listContainer) {
        $listContainer.on('click', function (e) {
            const $btn = $(e.target);
            if (!$btn) {
                return;
            }
            const targetId = $btn.attr('data-toggle');
            if (!targetId) {
                return;
            }
            if ($btn.text().trim().length) {
                const previousBtnText = $btn.text().trim().toLowerCase();
                const newBtnText = previousBtnText === 'show more' ? 'show less' : 'show more';
                $btn.text(newBtnText);
            }
            $(`#${targetId}`).toggleClass('d-none');
        });
    }
});