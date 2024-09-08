<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_Taxonomy as Taxonomy;
use We_Shortcodes as Shortcodes;
use We_Utils as Utils;
use We_Widgets as Widgets;

?>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="fs-5 text-uppercase fw-bold">
                Import Betting Sites <br>
                <small class="text-black-50">Upload xls/xlsx file</small>
            </h2>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <input class="form-control" type="file" id="we-bs-input-file" disabled>
                    </div>
                    <button class="btn btn-primary" id="we-bs-import-btn" disabled>Upload</button>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card d-none" id="we-bs-upload-feedback">
                <div class="card-body">
                    <h4 class="fw-bold fs-6 text-uppercase">Uploading betting sites</h4>
                    <div class="d-flex flex-row align-items-center my-3">
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="ms-2 fs-6"
                             id="we-bs-upload-name"></div>
                    </div>
                    <div id="we-bs-upload-count"></div>
                    <div class="progress"
                         role="progressbar"
                         aria-label="Success striped example"
                         aria-valuenow="0"
                         aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped bg-success" id="we-bs-upload-progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h2 class="fs-5 text-uppercase fw-bold">
                Shortcode builder
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h3 class="fs-5 text-uppercase fw-bold text-black-50">
                Betting sites list
            </h3>
        </div>
    </div>
    <div class="row row-cols-auto">
        <div class="col-12">
            <div class="mb-3">
                <label for="we-bs-list-shortcode">Shortcode: </label>
                <input name="we-bs-list-shortcode"
                       type="text"
                       value="<?= '[' . Shortcodes::$betting_site_card_list . ']' ?>"
                       class="form-control"
                       id="we-bs-list-shortcode">
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <input type="checkbox" name="we-is-crypto" id="we-is-crypto" data-shortcode-param="is_crypto">
                <label for="we-is-crypto">Only Crypto Betting Sites</label>
            </div>
        </div>
        <div class="col-12">
            <div class="row row-cols-auto">
                <div class="col">
                    <div class="mb-3">
                        <label for="we-category">Category</label>
                        <select name="we-category" id="we-category" class="form-control"
                                data-shortcode-param="cat_term_id">
                            <option value="">== Select a category ==</option>
							<?php foreach (
								get_terms( array(
									'taxonomy'   => Taxonomy::$betting_site_category_slug,
									'hide_empty' => false
								) ) as $term
							) : ?>
                                <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="we-country">Country</label>
                        <select name="we-country" id="we-country" class="form-control"
                                data-shortcode-param="country_code">
                            <option value="">== Select a country ==</option>
							<?php foreach ( Utils::$countries as $key => $value ) : ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="we-crypto">Crypto Currency</label>
                        <select name="we-crypto" id="we-crypto" class="form-control" data-shortcode-param="crypto">
                            <option value="">== Select a crypto currency ==</option>
							<?php foreach (
								get_terms( array(
									'taxonomy'   => Taxonomy::$betting_site_crypto_currency_slug,
									'hide_empty' => false,
								) ) as $term
							) : ?>
                                <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label for="we-esport-game">ESport</label>
                        <select name="we-esport-game" id="we-esport-game" class="form-control"
                                data-shortcode-param="esport">
                            <option value="">== Select an ESport Game ==</option>
							<?php foreach (
								get_terms( array(
									'taxonomy'   => Taxonomy::$betting_site_esport_game_slug,
									'hide_empty' => false,
								) ) as $term
							) : ?>
                                <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="we-sport-game">Sport</label>
                        <select name="we-sport-game" id="we-sport-game" class="form-control"
                                data-shortcode-param="sport">
                            <option value="">== Select a Sport Game ==</option>
							<?php foreach (
								get_terms( array(
									'taxonomy'   => Taxonomy::$betting_site_sport_game_slug,
									'hide_empty' => false,
								) ) as $term
							) : ?>
                                <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="we-casino-game">Casino</label>
                        <select name="we-casino-game" id="we-casino-game" class="form-control"
                                data-shortcode-param="casino">
                            <option value="">== Select a Sport Game ==</option>
							<?php foreach (
								get_terms( array(
									'taxonomy'   => Taxonomy::$betting_site_casino_game_slug,
									'hide_empty' => false,
								) ) as $term
							) : ?>
                                <option value="<?= $term->term_id ?>"><?= $term->name ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row my-2">
        <div class="col-12">
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h3 class="fs-5 text-uppercase fw-bold text-black-50">
                Betting sites list filters
            </h3>
        </div>
    </div>
    <div class="row row-cols-auto">
        <div class="col-12">
            <div class="mb-3">
                <label for="we-bs-list-filter-shortcode">Shortcode: </label>
                <input name="we-bs-list-filter-shortcode"
                       type="text"
                       value="<?= '[' . Shortcodes::$betting_site_list_filter . ']' ?>"
                       class="form-control"
                       id="we-bs-list-filter-shortcode">
            </div>
        </div>
        <div class="col-12">
            <div>
                <div class="d-flex flex-row align-items-center">
                    <input class="form-check-input"
                           type="checkbox"
                           value="categories"
                           id="filter-categories"
                           name="filter-categories">
                    <label class="form-check-label" for="filter-categories">
                        Categories
                    </label>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <input class="form-check-input"
                           type="checkbox"
                           value="crypto"
                           id="filter-crypto"
                           name="filter-crypto">
                    <label class="form-check-label" for="filter-crypto">
                        Crypto currencies
                    </label>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <input class="form-check-input"
                           type="checkbox"
                           value="sort"
                           id="filter-sort"
                           name="filter-sort">
                    <label class="form-check-label" for="filter-sort">
                        Sorting
                    </label>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <input class="form-check-input"
                           type="checkbox"
                           value="bonus-types"
                           id="filter-bonus-types"
                           name="filter-bonus-types">
                    <label class="form-check-label" for="filter-bonus-types">
                        Bonus types
                    </label>
                </div>
                <div class="d-flex flex-row align-items-center">
                    <input class="form-check-input"
                           type="checkbox"
                           value="bonus-features"
                           id="filter-bonus-features"
                           name="filter-bonus-features">
                    <label class="form-check-label" for="filter-bonus-features">
                        Bonus features
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <h2 class="fw-bold text-uppercase">Widgets</h2>
            <form id="we-widgets-form">
                <div class="mb-3">
                    <label for="<?= Widgets::$latest_new_category_meta_key ?>"
                           class="form-label">
                        Latest news category
                    </label>
					<?php
					$post_categories        = get_terms( array( 'taxonomy' => 'category' ) );
					$selected_post_category = get_option( Widgets::$latest_new_category_meta_key, 0 );
					?>
                    <select name="<?= Widgets::$latest_new_category_meta_key ?>"
                            id="<?= Widgets::$latest_new_category_meta_key ?>"
                            class="form-control">
                        <option value="0" <?= empty( $selected_post_category ) ? 'selected' : '' ?>>
                            === Select Post Category ===
                        </option>
						<?php if ( ! empty( $post_categories ) && ! is_wp_error( $post_categories ) ): ?>
							<?php foreach ( $post_categories as $post_category ): ?>
                                <option value="<?= $post_category->term_id ?>"
									<?= $selected_post_category == $post_category->term_id ? 'selected' : 0 ?>>
									<?= $post_category->name ?>
                                </option>
							<?php endforeach; ?>
						<?php endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="<?= Widgets::$top_brands_title_meta_key ?>"
                           class="form-label">
                        Top brands Link Title
                    </label>
                    <input id="<?= Widgets::$top_brands_title_meta_key ?>"
                           name="<?= Widgets::$top_brands_title_meta_key ?>"
                           type="text"
                           class="form-control"
                           value="<?= get_option( Widgets::$top_brands_title_meta_key ) ?>">
                </div>
                <div class="mb-3">
                    <label for="<?= Widgets::$top_bonuses_title_meta_key ?>"
                           class="form-label">
                        Top Bonuses Link Title
                    </label>
                    <input id="<?= Widgets::$top_bonuses_title_meta_key ?>"
                           name="<?= Widgets::$top_bonuses_title_meta_key ?>"
                           type="text"
                           class="form-control"
                           value="<?= get_option( Widgets::$top_bonuses_title_meta_key ) ?>">
                </div>
                <div class="mb-3">
                    <label for="<?= Widgets::$all_betting_sites_url_meta_key ?>"
                           class="form-label">
                        All Betting Sites Page Url
                    </label>
                    <input id="<?= Widgets::$all_betting_sites_url_meta_key ?>"
                           name="<?= Widgets::$all_betting_sites_url_meta_key ?>"
                           type="text"
                           class="form-control"
                           value="<?= get_option( Widgets::$all_betting_sites_url_meta_key ) ?>">
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" id="we-widgets-form-submit-btn">
                        <span class="spinner-border spinner-border-sm"
                              aria-hidden="true"
                              id="we-widgets-form-submit-btn-spinner"
                              style="display: none"></span>
                        <span>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    (() => {
        const shortcodeParams = [];
        const inputShortcode = document.querySelector('#we-bs-list-shortcode');
        const checkboxIsCrypto = document.querySelector('[name="we-is-crypto"]');
        const selectFields = document.querySelectorAll('select');

        checkboxIsCrypto.addEventListener('change', function (e) {
            const control = e.target;
            const paramName = control.getAttribute('data-shortcode-param');
            const checked = e.target.checked;
            if (shortcodeParams.length) {
                let paramIndex = undefined;
                for (let i = 0; i < shortcodeParams.length; i++) {
                    const param = shortcodeParams[i];
                    if (param.split('=')[0] === paramName) {
                        paramIndex = i;
                        break;
                    }
                }
                if (paramIndex !== undefined) {
                    shortcodeParams.splice(paramIndex, 1);
                }
            }
            if (checked) {
                shortcodeParams.push(`${paramName}="yes"`);
            }
            updateShortcode();
        });

        selectFields.forEach(field => {
            field.addEventListener('change', function (e) {
                const control = e.target;
                const paramName = control.getAttribute('data-shortcode-param');
                const value = e.target.value;
                if (shortcodeParams.length) {
                    let paramIndex = undefined;
                    for (let i = 0; i < shortcodeParams.length; i++) {
                        const param = shortcodeParams[i];
                        if (param.split('=')[0] === paramName) {
                            paramIndex = i;
                            break;
                        }
                    }
                    if (paramIndex !== undefined) {
                        shortcodeParams.splice(paramIndex, 1);
                    }
                }
                if (value !== '')
                    shortcodeParams.push(`${paramName}="${value}"`);
                updateShortcode();
            }, false);
        })

        function buildShortcode() {
            if (shortcodeParams.length)
                return `[webs_list ${shortcodeParams.join(' ')}]`;
            return '[webs_list]';
        }

        function updateShortcode() {
            inputShortcode.value = buildShortcode();
        }
    })();

</script>
<script>
    jQuery.noConflict()(function ($) {
        const activeFilters = [];
        const $filterShortCode = $('input[name="we-bs-list-filter-shortcode"]');
        const $filters = $('input[name^="filter"]');

        let shortCodeName = $filterShortCode.val().replace('[', '');
        shortCodeName = shortCodeName.replace(']', '');

        $filters.on('click', updateShortCode);

        function updateShortCode() {
            if (this.checked && !activeFilters.includes(this.value)) {
                activeFilters.push(this.value);
            }
            if (!this.checked && activeFilters.includes(this.value)) {
                activeFilters.splice(activeFilters.indexOf(this.value), 1);
            }
            let filterArgs = '';
            if (activeFilters.length) {
                filterArgs = ` filters="${activeFilters.join(',')}"`;
            }
            $filterShortCode.val(`[${shortCodeName}${filterArgs}]`);
        }
    });
</script>