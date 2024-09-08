jQuery.noConflict()(function ($) {

    const $listContainer = $('#we-bs-list-container');
    const $filterContainers = $('.we-bs-filter-container');
    const $spinner = $('#filter-spinner');

    if (!$listContainer || !$filterContainers) {
        return;
    }

    const $categoryFilter = $('input[name="filter-category"]');
    const $sortFilter = $('input[name="filter-rating"]');
    const $bonusFeaturesFilter = $('input[name^="feature"]');
    const $bonusTypeFilter = $('input[name="filter-bonus-type"]');
    const $cryptoFilter = $('input[name="filter-crypto"]');

    const $filters = [$categoryFilter, $sortFilter, $bonusFeaturesFilter, $bonusTypeFilter, $cryptoFilter];

    const defaultFiltersData = defaultFilterData();

    const filtersData = {
        category: defaultFiltersData['cat_term_id'] || 0,
        sort: 'top',
        bonusFeatures: [],
        bonusType: 'all',
        isCrypto: defaultFiltersData['is_crypto'] || 0,
        cryptoCurrency: defaultFiltersData['crypto'] || 0,
        limit: defaultFiltersData['limit'] || 0
    }

    $filterContainers.on('click', onFilterContainerClick);

    $.each($filters, function (index, $filter) {
        $filter.on('click', onFilterClick);
    });

    function onFilterContainerClick() {
        const self = this;
        $.each($filterContainers, function (containerIndex, container) {
            if (self !== container && $(container).hasClass('filter-open')) {
                toggleFilterMenu($(container));
            }
        });

        toggleFilterMenu($(this));
    }

    function toggleFilterMenu($filter) {
        const $filterMenu = $('+div', $filter);
        const $filterIcon = $('img[alt="categories filter icon"]', $filter);
        const $dropdownArrowIcon = $('img[alt="dropdown arrow icon"]', $filter);
        const $closeIcon = $('img[alt="close icon"]', $filter);
        const width = $filter.width();
        $filter.toggleClass('filter-open text-bg-dark border-bottom-0 rounded-bottom-0');
        $filterIcon.toggleClass('invert-color');
        $dropdownArrowIcon.toggleClass('d-none');
        $closeIcon.toggleClass('d-none invert-color');
        $filterMenu.toggleClass('d-none');
        $filterMenu.width(width);
    }

    function onFilterClick() {
        switch (this.name) {
            case 'filter-category':
                if (filtersData.category !== this.value) {
                    filtersData.category = this.value;
                    filter();
                }
                return;
            case 'filter-rating':
                if (filtersData.sort !== this.value) {
                    filtersData.sort = this.value;
                    filter();
                }
                return;
            case 'filter-bonus-type':
                if (filtersData.bonusType !== this.value) {
                    filtersData.bonusType = this.value;
                    filter();
                }
                return;
            case 'filter-crypto':
                if (filtersData.cryptoCurrency !== this.value) {
                    filtersData.cryptoCurrency = this.value;
                    filter();
                }
                return;
        }

        if (this.name.startsWith('feature')) {
            if (this.checked) {
                if (!filtersData.bonusFeatures.includes(this.value)) {
                    filtersData.bonusFeatures.push(this.value);
                    return filter();
                }
            } else {
                if (filtersData.bonusFeatures.includes(this.value)) {
                    filtersData.bonusFeatures.splice(filtersData.bonusFeatures.indexOf(this.value), 1);
                    return filter();
                }
            }
        }
    }

    function filter() {
        closeFiltersMenu();
        toggleSpinner();

        const {action, ajaxUrl, nonce} = wpLocalize();
        const requestBody = {
            _ajax_nonce: nonce,
            action,
            data: filtersData
        }

        jQuery.post(ajaxUrl, requestBody)
            .done(function (response) {
                if (response.length) {
                    $listContainer.html(response);
                }
                toggleSpinner();
            })
            .fail(function (error) {
                toggleSpinner();
                console.log(error);
            })
    }

    function toggleSpinner() {
        $listContainer.toggleClass('d-none');
        $spinner.toggleClass('d-none');
    }

    function closeFiltersMenu() {
        $.each($filterContainers, function (containerIndex, container) {
            if ($(container).hasClass('filter-open')) {
                toggleFilterMenu($(container));
            }
        });
    }

    function wpLocalize() {
        const action = window.weBsArchiveFilterObject.action;
        const ajaxUrl = window.weBsArchiveFilterObject.ajaxUrl;
        const nonce = window.weBsArchiveFilterObject.nonce;
        return {action, ajaxUrl, nonce}
    }

    function defaultFilterData() {
        let data = {};
        const textData = $('#we-bs-list-data').text();
        try {
            data = JSON.parse(textData);
        } catch (err) {
            console.log(err);
        }
        return data;
    }
});