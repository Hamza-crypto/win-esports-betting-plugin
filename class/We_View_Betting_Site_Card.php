<?php

if (! defined('ABSPATH')) {
    die();
}

use We_Cpt_Betting_Site_Meta_Keys as MetaKeys;
use We_View_Betting_Site_Card as BettingSiteViewCard;

class We_View_Betting_Site_Card
{
    /**
     * @param array $betting_site
     * @param int $index
     *
     * @return false|string
     */
    public static function logo(array $betting_site, int $index = 0): false|string
    {
        ob_start()
        ?>
<div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">
    <div class="py-4 text-center rounded-1 position-relative"
        style="background-color: <?= $betting_site[ '_' . MetaKeys::logo_bg_color_key() ]; ?>;">
        <?php
                if (! empty($betting_site['_thumbnail_id'])) {
                    $thumbnail = wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?? '';
                }
        if (!empty($thumbnail)):
    ?>
        <a href="<?= get_permalink($betting_site['post_id']) ?>" target="_blank">
            <img src="<?= $thumbnail ?>" alt="<?= $betting_site['post_title'] ?>" class="img-fluid" loading="lazy"
                width="172" height="46">
        </a>
        <?php endif; ?>
        <div class="badge rounded-start-3 text-bg-light position-absolute end-0 bottom-0">
            <?php if (! empty($betting_site[ '_' . MetaKeys::rating_overall_key() ])): ?>
            <?= $betting_site[ '_' . MetaKeys::rating_overall_key() ] . ' / 5' ?>
            <?php else: ?>
            _ / 5
            <?php endif; ?>
        </div>
        <?php if (! empty($index)): ?>
        <div class="badge rounded-1 text-bg-dark position-absolute start-0 top-0">
            <?= $index ?>
        </div>
        <?php endif; ?>
        <?php if (! empty($betting_site[ '_' . MetaKeys::is_exclusive_key() ])): ?>
        <div class="badge text-bg-warning text-uppercase position-absolute start-0 top-0 ">
            EXCLUSIVE
        </div>
        <?php endif; ?>
        <?php if (! empty($betting_site[ '_' . MetaKeys::is_hot_key() ])): ?>
        <div class="badge text-bg-danger text-uppercase position-absolute start-0 top-0 ">
            HOT OFFER
        </div>
        <?php endif; ?>
        <?php if (! empty($betting_site[ '_' . MetaKeys::is_recommended_key() ])): ?>
        <div class="badge text-bg-primary text-uppercase position-absolute start-0 top-0 ">
            RECOMMENDED
        </div>
        <?php endif; ?>
    </div>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_category_term_id
     *
     * @return false|string
     */
    public static function featured_bonus_reviews(array $betting_site, int $bs_category_term_id): false|string
    {
        $featured_bonus = array();
        if (! empty($betting_site[ '_' . MetaKeys::featured_bonus_key() ])) {
            $featured_bonus = $betting_site[ '_' . MetaKeys::featured_bonus_key() ][0];
        }
        ob_start();
        ?>
<div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-5">
    <div class="mt-2 mt-sm-0">
        <a href="<?= get_permalink($betting_site['post_id']) ?>" target="_blank" class="fw-bold text-black">
            <?= $betting_site['post_title'] . ' review' ?>
        </a>
    </div>
    <div>
        <?php if (! empty($featured_bonus) && ! empty($featured_bonus['features'])): ?>
        <ul style="list-style: none" class="p-0">
            <?php foreach ($featured_bonus['features'] as $feature): ?>
            <li>
                <img src="<?= WE_PLUGIN_URL . 'assets/icons/check-icon.svg' ?>" alt="Svg check icon">
                <span class="ms-2"><?= $feature ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_category_term_id
     *
     * @return false|string
     */
    public static function featured_bonus_title(array $betting_site, int $bs_category_term_id): false|string
    {
        $featured_bonus = array();
        if (! empty($betting_site[ '_' . MetaKeys::featured_bonus_key() ])) {
            $featured_bonus = $betting_site[ '_' . MetaKeys::featured_bonus_key() ][0];
        }
        ob_start();
        ?>
<div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
    <div class="text-uppercase fw-bold text-black-50" style="font-size: 11px;">
        <?= $betting_site['post_title'] . ' bonus' ?>
    </div>
    <div class="my-2 my-md-0 d-flex flex-row">
        <div style="line-height: 24px">
            <img src="<?= WE_PLUGIN_URL . 'assets/icons/review/review-icon-bonus.svg' ?>"
                alt="Icon of a gift, representing a bonus" width="20" height="20">
        </div>
        <div class="fw-bold fs-5 ms-2" style="line-height: 24px">
            <?= $featured_bonus['title'] ?? '-' ?>
        </div>
    </div>
    <?php $tc_apply = $betting_site[ '_' . MetaKeys::tc_apply_key() ] ?? '';
        if (! empty($tc_apply)): ?>
    <div class="mt-2">
        <small class="text-black-50"><?= $tc_apply ?></small>
    </div>
    <?php endif; ?>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_category_term_id
     *
     * @return false|string
     */
    public static function call_to_action(array $betting_site, int $bs_category_term_id): false|string
    {
        $featured_bonus = array();
        if (! empty($betting_site[ '_' . MetaKeys::featured_bonus_key() ])) {
            $featured_bonus = $betting_site[ '_' . MetaKeys::featured_bonus_key() ][0];
        }
        ob_start();
        ?>
<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2">
    <div class="d-grid">
        <a class="btn btn-outline-dark" style="border-style: dashed; text-decoration: none"
            href="<?= ! empty($featured_bonus['link']) ? $featured_bonus['link'] : '' ?>" target="_blank"
            data-value="<?= ! empty($featured_bonus) ? $featured_bonus['code'] : '' ?>">
            <span style="vertical-align: -webkit-baseline-middle;"><?= str_repeat('*  ', 6) ?></span>
        </a>
        <a class="btn btn-primary text-uppercase mt-2 border-0 fw-semibold text-decoration-none"
            href="<?= ! empty($featured_bonus['link']) ? $featured_bonus['link'] : '' ?>" target="_blank">
            <?= $betting_site[ '_' . MetaKeys::cta_label_key() ] ?? 'bet now' ?>
        </a>
    </div>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_index
     *
     * @return false|string
     */
    public static function payment_methods(array $betting_site, int $bs_index): false|string
    {
        ob_start();
        ?>
<?php
        $payment_methods = array();
        if (! empty($betting_site[ '_' . MetaKeys::payment_methods_key() ])) {
            $payment_methods = $betting_site[ '_' . MetaKeys::payment_methods_key() ];
        }
        if (! empty($payment_methods)): ?>
<div class="col pt-3">
    <div class="container-fluid" style="max-width: 200px;">
        <div class="text-uppercase text-black-50 fs-07rem" style="margin-left: -12px">
            PAYMENT METHODS
        </div>
        <div style="position: relative; width: 160px">
            <div class="row row-cols-3">
                <?php if (! empty($payment_methods[0]['icon'])): ?>
                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">
                    <img src="<?= wp_get_attachment_image_src($payment_methods[0]['icon'], 'full')[0] ?? '' ?>"
                        alt="icon of a payment method" style="width: auto; height: 28px" loading="lazy">
                </div>
                <?php endif; ?>
                <?php if (count($payment_methods) > 1): ?>
                <?php if (! empty($payment_methods[1]['icon'])): ?>
                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">
                    <img src="<?= wp_get_attachment_image_src($payment_methods[1]['icon'], 'full')[0] ?? '' ?>"
                        alt="icon of a payment method" style="width: auto; height: 28px">
                </div>
                <?php endif; ?>
                <?php if (count($payment_methods) > 2): ?>
                <?php if (! empty($payment_methods[2]['icon'])): ?>
                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">
                    <img src="<?= wp_get_attachment_image_src($payment_methods[2]['icon'], 'full')[0] ?>"
                        alt="icon of a payment method" style="width: auto; height: 28px">
                </div>
                <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php if (count($payment_methods) > 3): ?>
            <div class="d-none row row-cols-3" id="we-bs-x-pm-<?= $bs_index ?>">
                <?php for ($i = 3; $i < count($payment_methods); $i++): ?>
                <?php if (! empty($payment_methods[ $i ]['icon'])): ?>
                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1 mt-1">
                    <img src="<?= wp_get_attachment_image_src($payment_methods[ $i ]['icon'], 'full')[0] ?>"
                        alt="icon of a payment method" style="width: auto; height: 28px">
                </div>
                <?php endif; ?>
                <?php endfor; ?>
            </div>
            <div class="border border-1 d-flex flex-row justify-content-center align-items-center px-1"
                style="height: 53px; width: 15px;  border-color: var(--bs-border-color-translucent); cursor: pointer; position: absolute; top: 0; left: 100%"
                data-toggle="we-bs-x-pm-<?= $bs_index ?>">
                <img src="<?= WE_PLUGIN_URL . 'assets/icons/arrow-down-angular-green.svg' ?>"
                    alt="Arrow down / up, toggle payment methods" style="filter: brightness(0%)"
                    data-toggle="we-bs-x-pm-<?= $bs_index ?>">
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     *
     * @return false|string
     */
    public static function withdrawal(array $betting_site): false|string
    {
        $withdrawal = $betting_site[ '_' . MetaKeys::withdrawal_key() ] ?? '';
        ob_start();
        if (! empty($withdrawal)):
            ?>
<div class="col pt-3">
    <div class="text-uppercase text-black-50 fs-07rem">
        withdrawal
    </div>
    <div class="d-flex flex-row align-items-center border border-1 px-3"
        style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">
        <div style="width: 26px; height: 26px; background: color-mix(in srgb, #14e682 25%, transparent);"
            class="rounded-4 d-flex justify-content-center align-items-center">
            <span class="fw-bold" style="color: #14e682">$</span>
        </div>
        <div class="ms-2 fs-08rem"><?= $withdrawal ?></div>
    </div>
</div>
<?php
        endif;

        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     *
     * @return false|string
     */
    public static function apps(array $betting_site): false|string
    {
        ob_start();
        $android_available = $betting_site[ '_' . MetaKeys::android_available_key() ] ?? '';
        $ios_available     = $betting_site[ '_' . MetaKeys::ios_available_key() ] ?? '';
        if ($android_available || $ios_available):
            ?>
<div class="col pt-3">
    <div class="text-uppercase text-black-50 fs-07rem">
        apps
    </div>
    <div class="row">
        <div class="d-flex flex-row">
            <?php if ($android_available): ?>
            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                class="border border-1 d-flex justify-content-center align-items-center">
                <img src="<?= WE_PLUGIN_URL . 'assets/icons/icon-comp-android.svg' ?>" alt="Android icon" height="26"
                    width="26" loading="lazy">
            </div>
            <?php endif; ?>
            <?php if ($ios_available): ?>
            <div style="width: 53px; height: 53px; border-color: var(--bs-border-color-translucent);"
                class="border border-1 d-flex justify-content-center align-items-center ms-2">
                <img src="<?= WE_PLUGIN_URL . 'assets/icons/icon-comp-ios.svg' ?>" alt="iOS icon" height="24"
                    width="24">
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
        endif;

        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     *
     * @return false|string
     */
    public static function license(array $betting_site): false|string
    {
        ob_start();
        $license = $betting_site[ '_' . MetaKeys::license_key() ] ?? '';
        if (! empty($license)) :
            ?>
<div class="col pt-3">
    <div class="text-uppercase text-black-50 fs-07rem">
        license
    </div>
    <div class="border border-1 fs-08rem d-flex flex-row align-items-center"
        style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">
        <img src="<?= wp_get_attachment_image_src($license, 'full')[0] ?>"
            alt="<?= $betting_site['post_title'] . ' License' ?>" style="height: 40px; width: auto" loading="lazy">
    </div>
</div>
<?php
        endif;

        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     *
     * @return false|string
     */
    public static function award(array $betting_site): false|string
    {
        ob_start();
        $award = $betting_site[ '_' . MetaKeys::award_key() ] ?? '';
        if (! empty($award)):
            ?>
<div class="col pt-3">
    <div class="text-uppercase text-black-50 fs-07rem">
        award
    </div>
    <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
        style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">
        <?= $award ?>
    </div>
</div>
<?php
        endif;

        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_category_term_id
     * @param int $index
     *
     * @return false|string
     */
    public static function header(array $betting_site, int $bs_category_term_id, int $index = 0): false|string
    {
        ob_start();
        ?>
<div class="row">
    <?= self::logo($betting_site, $index); ?>
    <?= self::featured_bonus_reviews($betting_site, $bs_category_term_id); ?>
    <?= self::featured_bonus_title($betting_site, $bs_category_term_id); ?>
    <?= self::call_to_action($betting_site, $bs_category_term_id); ?>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_index
     *
     * @return false|string
     */
    public static function body(array $betting_site, int $bs_index): false|string
    {
        ob_start();
        ?>
<div id="we-bs-x-<?= $bs_index ?>" class="d-none row row-cols-auto mt-4">
    <?= self::payment_methods($betting_site, $bs_index); ?>
    <?= self::withdrawal($betting_site); ?>
    <?= self::apps($betting_site); ?>
    <?= self::license($betting_site); ?>
    <?= self::award($betting_site); ?>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_index
     *
     * @return false|string
     */
    public static function footer(array $betting_site, int $bs_index): false|string
    {
        ob_start();
        ?>
<div class="row">
    <div class="col-12 col-md-10">
        <div class="fs-063rem text-black-50">
            <?php
                    $play_conditions = $betting_site[ '_' . MetaKeys::play_terms_key() ] ?? '';
        if (! empty($play_conditions)): ?>
            <?= $play_conditions ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-12 col-md-2">
        <div class="d-flex flex-row justify-content-end">
            <span class="fs-07rem ms-auto text-capitalize" style="cursor: pointer"
                data-toggle="we-bs-x-<?= $bs_index ?>">
                Show More
            </span>
        </div>
    </div>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $betting_site
     * @param int $bs_index
     * @param int $bs_category_term_id
     *
     * @return false|string
     */
    public static function content(array $betting_site, int $bs_index, int $bs_category_term_id): false|string
    {
        ob_start();
        ?>
<div class="row we-bs-card mt-2">
    <div class="col-12">
        <div class="card rounded-1 p-3">
            <?= self::header($betting_site, $bs_category_term_id, $bs_index); ?>
            <?= self::body($betting_site, $bs_index); ?>
            <?= self::footer($betting_site, $bs_index); ?>
        </div>
    </div>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $args
     *
     * @return false|string
     */
    public static function list(array $args = array()): false|string
    {
        ob_start();
        ?>
<div class="container-fluid p-0 mt-4 d-none" id="filter-spinner">
    <div class="row py-4">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid p-0 mt-4" id="we-bs-list-container">
    <?= self::list_content($args) ?>
</div>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $args
     *
     * @return false|string
     */
    public static function list_content(array $args = array()): false|string
    {
        if (empty($args['cat_term_id'])) {
            $args['cat_term_id'] = 0;
        }

        $betting_sites = We_M_Betting_Site::getAll($args);
        $bs_index      = 1;
        ob_start();
        ?>
<div id="we-bs-list-data" class="d-none"><?= htmlspecialchars(json_encode($args)) ?></div>
<?php foreach ($betting_sites as $betting_site) :
    ?>
<?= BettingSiteViewCard::content($betting_site, $bs_index, + $args['cat_term_id']) ?>
<?php
    $bs_index++;
endforeach; ?>
<?php
        return ob_get_clean();
    }

    /**
     * @param array $args
     *
     * @return false|string
     */
    public static function list_filter(array $args = array()): false|string
    {
        ob_start();
        $filters = array();
        if (! empty($args['filters'])) {
            $filters = explode(",", $args['filters']);
            $filters = array_map(function ($filter) {
                return trim(strtolower($filter));
            }, $filters);
            $filters = array_values($filters);
        }
        $categories        = get_terms(
            array(
                'taxonomy'   => We_Taxonomy::$betting_site_category_slug,
                'hide_empty' => false
            )
        );
        $crypto_currencies = get_terms(
            array(
                'taxonomy'   => We_Taxonomy::$betting_site_crypto_currency_slug,
                'hide_empty' => false
            )
        );
        ?>
<div class="container-fluid px-0">
    <div class="row gx-lg-2">
        <!-- Filter by category -->
        <?php if (in_array('categories', $filters)): ?>
        <div class="col-12 col-lg-3 mb-2 mb-lg-0 position-relative">
            <div class="border border-1 border-dark rounded-1 p-3 we-bs-filter-container mt-2" style="cursor: pointer">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/filter-icon-product.svg' ?>"
                            alt="categories filter icon" loading="lazy">
                    </div>
                    <div class="fw-bold text-uppercase">
                        Category
                    </div>
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/dropdown-arrow-black.svg' ?>"
                            alt="dropdown arrow icon" loading="lazy">
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/icon-close.svg' ?>" alt="close icon"
                            class="d-none" loading="lazy">
                    </div>
                </div>
            </div>
            <?php if (! empty($categories) && ! is_wp_error($categories)): ?>
            <div class="border border-1 border-dark p-3 d-none position-absolute bg-white" style="z-index: 999">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-category" id="filter-category-all"
                        value="0" checked>
                    <label class="form-check-label" for="filter-category-all">
                        All Categories
                    </label>
                </div>
                <?php foreach ($categories as $category): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-category"
                        id="filter-category-<?= $category->name ?>" value="<?= $category->term_id ?>">
                    <label class="form-check-label" for="filter-category-<?= $category->name ?>">
                        <?= $category->name ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <!-- Filter by overall rating -->
        <?php if (in_array('sort', $filters)): ?>
        <div class="col-12 col-lg-3 mb-2 mb-lg-0 position-relative">
            <div class="border border-1 border-dark rounded-1 p-3 we-bs-filter-container mt-2" style="cursor: pointer">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/filter-icon-rating.svg' ?>"
                            alt="categories filter icon">
                    </div>
                    <div class="fw-bold text-uppercase">
                        Sort By
                    </div>
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/dropdown-arrow-black.svg' ?>"
                            alt="dropdown arrow icon">
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/icon-close.svg' ?>" alt="close icon"
                            class="d-none">
                    </div>
                </div>
            </div>
            <div class="border border-1 border-dark p-3 d-none position-absolute bg-white" style="z-index: 999">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-rating" id="filter-rating-top" value="top"
                        checked>
                    <label class="form-check-label" for="filter-rating-top">
                        Top Rated
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-rating" id="filter-rating-new"
                        value="new">
                    <label class="form-check-label" for="filter-rating-new">
                        Newly Added
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Filter by feature -->
        <?php if (in_array('bonus-features', $filters)): ?>
        <div class="col-12 col-lg-3 mb-2 mb-lg-0 position-relative">
            <div class="border border-1 border-dark rounded-1 p-3 we-bs-filter-container mt-2" style="cursor: pointer">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/filter-icon-features.svg' ?>"
                            alt="categories filter icon">
                    </div>
                    <div class="fw-bold text-uppercase">
                        Features
                    </div>
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/dropdown-arrow-black.svg' ?>"
                            alt="dropdown arrow icon">
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/icon-close.svg' ?>" alt="close icon"
                            class="d-none">
                    </div>
                </div>
            </div>
            <div class="border border-1 border-dark p-3 d-none position-absolute bg-white" style="z-index: 999">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="live-betting" id="feature-live-betting"
                        name="feature-live-betting">
                    <label class="form-check-label" for="feature-live-betting">
                        Live Betting
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="livestream" id="feature-livestream"
                        name="feature-livestream">
                    <label class="form-check-label" for="feature-livestream">
                        Livestream
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="high-betting-odds"
                        id="feature-high-betting-odds" name="feature-high-betting-odds">
                    <label class="form-check-label" for="feature-high-betting-odds">
                        High Betting Odds
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="live-chat" id="feature-live-chat"
                        name="feature-live-chat">
                    <label class="form-check-label" for="feature-live-chat">
                        Live Chat
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="phone-support" id="feature-phone-support"
                        name="feature-phone-support">
                    <label class="form-check-label" for="feature-phone-support">
                        Phone Support
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Filter by bonus type -->
        <?php if (in_array('bonus-types', $filters)): ?>
        <div class="col-12 col-lg-3 mb-2 mb-lg-0 position-relative">
            <div class="border border-1 border-dark rounded-1 p-3 we-bs-filter-container mt-2" style="cursor: pointer">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/filter-icon-bonus-type.svg' ?>"
                            alt="categories filter icon">
                    </div>
                    <div class="fw-bold text-uppercase">
                        Bonus Type
                    </div>
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/dropdown-arrow-black.svg' ?>"
                            alt="dropdown arrow icon">
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/icon-close.svg' ?>" alt="close icon"
                            class="d-none">
                    </div>
                </div>
            </div>
            <div class="border border-1 border-dark p-3 d-none position-absolute bg-white" style="z-index: 999">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-bonus-type" id="filter-bonus-type-all"
                        value="all" checked>
                    <label class="form-check-label" for="filter-bonus-type-all">
                        All Bonus Types
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-bonus-type"
                        id="filter-bonus-type-no-deposit-bonus" value="no-deposit-bonus">
                    <label class="form-check-label" for="filter-bonus-type-no-deposit-bonus">
                        No Deposit Bonus
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-bonus-type"
                        id="filter-bonus-type-free-bet" value="free-bet">
                    <label class="form-check-label" for="filter-bonus-type-free-bet">
                        Free Bet
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-bonus-type"
                        id="filter-bonus-type-deposit-bonus" value="deposit-bonus">
                    <label class="form-check-label" for="filter-bonus-type-deposit-bonus">
                        Deposit Bonus
                    </label>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <!-- Filter by cryptocurrency -->
        <?php if (in_array('crypto', $filters)): ?>
        <div class="col-12 col-lg-3 mb-2 mb-lg-0 position-relative">
            <div class="border border-1 border-dark rounded-1 p-3 we-bs-filter-container mt-2" style="cursor: pointer">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/filter-icon-product.svg' ?>"
                            alt="categories filter icon" loading="lazy">
                    </div>
                    <div class="fw-bold text-uppercase">
                        Crypto Currency
                    </div>
                    <div>
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/dropdown-arrow-black.svg' ?>"
                            alt="dropdown arrow icon" loading="lazy">
                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/filter/icon-close.svg' ?>" alt="close icon"
                            class="d-none" loading="lazy">
                    </div>
                </div>
            </div>
            <?php if (! empty($crypto_currencies) && ! is_wp_error($crypto_currencies)): ?>
            <div class="border border-1 border-dark p-3 d-none position-absolute bg-white" style="z-index: 999">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-crypto" id="filter-crypto-all" value="0"
                        checked>
                    <label class="form-check-label" for="filter-crypto-all">
                        All Crypto Currencies
                    </label>
                </div>
                <?php foreach ($crypto_currencies as $crypto_currency): ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter-crypto"
                        id="filter-crypto-<?= $crypto_currency->term_id ?>" value="<?= $crypto_currency->term_id ?>">
                    <label class="form-check-label" for="filter-crypto-<?= $crypto_currency->term_id ?>">
                        <?= $crypto_currency->name ?>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php
        return ob_get_clean();
    }
}