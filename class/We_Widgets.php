<?php



if (! defined('ABSPATH')) {

    die();

}



use We_Cpt_Betting_Site as CptBettingSite;
use We_M_Betting_Site as BettingSite;
use We_Taxonomy as Taxonomy;
use Carbon_Fields\Block;
use Carbon_Fields\Field;

class We_Widgets
{
    public static string $latest_new_category_meta_key = 'we_widgets_latest_news_category';

    public static string $top_brands_title_meta_key = 'we_widgets_top_brands_title';

    public static string $top_bonuses_title_meta_key = 'we_widgets_top_bonuses_title';

    public static string $all_betting_sites_url_meta_key = 'we_widgets_all_betting_sites_url';



    public static string $latest_news_category;

    public static array $betting_sites;

    public static string $top_brands_title;

    public static string $top_bonuses_title;

    public static string $all_betting_sites_url;



    /**

     * @return void

     */

    public static function init(): void
    {

        self::$betting_sites         = BettingSite::getAll(array( 'limit' => 5 ));

        self::$top_brands_title      = get_option(self::$top_brands_title_meta_key, 'go to esports comparaison');

        self::$top_bonuses_title     = get_option(self::$top_bonuses_title_meta_key, 'go to esports comparaison');

        self::$all_betting_sites_url = get_option(self::$all_betting_sites_url_meta_key, home_url());

        self::$latest_news_category  = get_option(self::$latest_new_category_meta_key, 0);

    }



    /**

     * @param array $top_betting_sites

     *

     * @return false|string

     */

    public static function top_betting_sites_list(array $top_betting_sites): false|string
    {

        ob_start();

        ?>

<div class="card">

    <div class="card-header bg-white">

        <div class="py-3">

            <h2 class="fw-bold fs-6 text-uppercase mb-0">

                Top Betting Sites

            </h2>

        </div>

    </div>

    <div class="card-body">

        <ul class="list-group list-group-flush m-0 p-0">

            <?php foreach ($top_betting_sites as $betting_site): ?>

            <li class="list-group-item">

                <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-decoration-none text-black fs-6">

                    <?= $betting_site['post_title'] ?> Review

                </a>

            </li>

            <?php endforeach; ?>

        </ul>

    </div>

    <div class="card-footer text-center bg-white">

        <div class="py-3">

            <a href="<?= self::$all_betting_sites_url ?>"
                class="text-decoration-none fw-bold text-uppercase btn btn-outline-dark">

                Show More

            </a>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $betting_sites

     *

     * @return false|string

     */

    public static function top_brands(array $betting_sites): false|string
    {

        ob_start();

        ?>

<style>
.we-bs-raring-stars-container {

    width: 56px;

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-gray.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}



.we-bs-rating-stars {

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<div class="card mb-5">

    <div class="card-header bg-white">

        <div class="py-3">

            <h2 class="fw-bold fs-6 text-uppercase mb-0">

                Top Brands

            </h2>

        </div>

    </div>

    <div class="card-body">

        <div>

            <?php foreach ($betting_sites as $betting_site): ?>

            <div class="d-flex flex-row justify-content-between align-items-center py-3"
                style="border-bottom: 1px solid lightgray">

                <div class="px-2">

                    <div class="d-flex flex-row align-items-center">

                        <!-- Wrapping the image with a link to make it clickable -->
                        <a href="<?= get_permalink($betting_site['post_id']) ?>"
                            style="width: 75px; height: 50px; background-color: <?= $betting_site['_websf_logo_bg_color'] ?>"
                            class="d-flex flex-row justify-content-center align-items-center">

                            <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                                alt="<?= $betting_site['post_title'] ?>" class="img-fluid">

                        </a>

                        <div class="ms-3">
                            <!-- Post title -->
                            <h3 class="mb-0">
                                <?= $betting_site['post_title'] ?>
                            </h3>

                            <!-- Link under the title -->
                            <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-black">
                                <?= $betting_site['post_title'] ?> review
                            </a>
                        </div>

                    </div>

                </div>

                <div>

                    <div class="ps-3" style="border-left: 1px solid lightgray">

                        <span class="fw-bold fs-6">

                            <?= $betting_site['_websf_rat_overall'] ?>

                        </span> / 5

                    </div>

                    <div class="ps-3">

                        <div class="we-bs-raring-stars-container">

                            <div class="we-bs-rating-stars"
                                style=" width: <?= ($betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>

                        </div>

                    </div>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

    <div class="card-footer text-center bg-white">

        <div class="py-3">

            <a href="<?= self::$all_betting_sites_url ?>"
                class="text-decoration-none fw-bold text-uppercase btn btn-outline-dark">

                <?= self::$top_brands_title ?>

            </a>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $betting_sites

     *

     * @return false|string

     */

    public static function top_bonuses(array $betting_sites): false|string
    {

        ob_start();

        ?>

<style>
.we-bs-raring-stars-container {

    width: 56px;

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-gray.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}



.we-bs-rating-stars {

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<div class="card mb-5">

    <div class="card-header bg-white">

        <div class="py-3">

            <h2 class="fw-bold fs-6 text-uppercase mb-0">

                Top Bonuses

            </h2>

        </div>

    </div>

    <div class="card-body">

        <div>

            <?php foreach ($betting_sites as $betting_site): ?>

            <div class="d-flex flex-row justify-content-between align-items-center py-3"
                style="border-bottom: 1px solid lightgray">

                <div class="px-2">

                    <div class="d-flex flex-row align-items-center">

                        <!-- Image container with clickable link -->
                        <div style="width: 75px; min-width: 75px; height: 50px; background-color: <?= $betting_site['_websf_logo_bg_color'] ?>"
                            class="d-flex flex-row justify-content-center align-items-center">

                            <!-- Image wrapped in link -->
                            <a href="<?= get_permalink($betting_site['post_id']) ?>">
                                <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                                    alt="<?= $betting_site['post_title'] ?>" class="img-fluid">
                            </a>

                        </div>

                        <!-- Post title and bonus information -->
                        <div class="ms-3">

                            <h3 class="mb-0 text-uppercase fs-6">
                                <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-black">
                                    <?= $betting_site['post_title'] ?> bonus
                                </a>
                            </h3>

                            <div>
                                <?= $betting_site['_websf_featured_bonus'][0]['title'] ?>
                            </div>

                            <!-- Terms and Conditions, if available -->
                            <?php if (!empty($betting_site['_websf_tc_apply_18'])): ?>
                            <div class="text-black-50">
                                <?= $betting_site['_websf_tc_apply_18'] ?>
                            </div>
                            <?php endif; ?>

                        </div>

                    </div>

                </div>

                <div>

                    <div class="ps-3" style="border-left: 1px solid lightgray">

                        <span class="fw-bold fs-6">

                            <?= $betting_site['_websf_rat_overall'] ?>

                        </span> / 5

                    </div>

                    <div class="ps-3">

                        <div class="we-bs-raring-stars-container">

                            <div class="we-bs-rating-stars"
                                style=" width: <?= ($betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>

                        </div>

                    </div>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

    <div class="card-footer text-center bg-white">

        <div class="py-3">

            <a href="<?= self::$all_betting_sites_url ?>"
                class="text-decoration-none fw-bold text-uppercase btn btn-outline-dark">

                <?= self::$top_bonuses_title ?>

            </a>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @return false|string

     */

    public static function latest_news(): false|string
    {

        ob_start();

        $posts = get_posts(array(

            'numberposts' => 5,

            'category'    => self::$latest_news_category,

            'orderby'     => 'date',

            'order'       => 'DESC',

        ));

        ?>

<?php if (! empty($posts)): ?>

<div class="card mb-5">

    <div class="card-header bg-white">

        <div class="py-3">

            <h2 class="fw-bold fs-6 text-uppercase mb-0">

                Latest News

            </h2>

        </div>

    </div>

    <div class="card-body">

        <?php foreach ($posts as $post): ?>

        <div class="d-flex flex-row mb-5">

            <div style="max-width: 200px; max-height: 150px;">

                <img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full')[0] ?>"
                    alt="<?= $post->post_title ?>" class="img-fluid" style="object-fit: fill; height:100%; width:100%">

            </div>

            <div class="ms-3">

                <h3 class="fw-bold m-0 fs-6">

                    <a href="<?= get_permalink($post) ?>" class="text-decoration-none text-black">

                        <?= wp_trim_words($post->post_title, 9) ?>

                    </a>

                </h3>

                <div>

                    <?= wp_trim_words($post->post_excerpt, 15) ?>

                </div>

            </div>

        </div>

        <hr>

        <?php endforeach; ?>

    </div>

</div>

<?php endif; ?>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $betting_sites

     *

     * @return false|string

     */

    public static function top_brands_cards(array $betting_sites): false|string
    {

        ob_start()

        ?>

<style>
.we-bs-raring-stars-container {

    width: 56px;

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-gray.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}



.we-bs-rating-stars {

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<?php foreach ($betting_sites as $betting_site): ?>

<div class="col-12 col-sm-6 col-lg-4 col-xl-3">

    <?php if (! empty($betting_site['_websf_featured_bonus'])): ?>

    <?php

                    $bonus    = $betting_site['_websf_featured_bonus'][0];

        $category = get_term($bonus['category'], Taxonomy::$betting_site_category_slug);

        ?>

    <div class="card rounded-1 position-relative we-bs-bonus-review-card mt-4 w-100" style="width: 238px">

        <div class="d-flex flex-row justify-content-end align-items-center position-absolute end-0 p-2">

            <div class="we-bs-raring-stars-container">

                <div class="we-bs-rating-stars"
                    style=" width: <?= ($betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>

            </div>

        </div>

        <div class="card-body pt-3" style="background-color: whitesmoke">

            <div class="d-flex flex-column justify-content-center align-items-center my-4">

                <div class="d-flex justify-content-center align-items-center"
                    style="background-color: <?= $betting_site['_websf_logo_bg_color'] ?>; height: 116px; width: 116px; border-radius: 50%">

                    <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                        alt="<?= $betting_site['post_title'] ?>" class="img-fluid" loading="lazy">

                </div>

                <div class="pt-3 pb-2">

                    <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-black">

                        <?= $betting_site['post_title'] ?>

                    </a>

                </div>

                <div class="fw-bold fs-5 my-2 text-center">

                    <?= $bonus['title'] ?>

                </div>

                <a class="btn btn-primary text-uppercase fw-bold my-2 text-decoration-none WE_WIDGETS"
                    href="<?= $bonus['link'] ?>" target="_blank">

                    Get bonus

                </a>

                <?php if (! empty($betting_site['_websf_tc_apply_18'])): ?>

                <div class="my-2 text-black-50 fs-07rem">

                    <?= $betting_site['_websf_tc_apply_18']; ?>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <?php endif; ?>

</div>

<?php endforeach; ?>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $betting_sites

     *

     * @return false|string

     */

    public static function top_3_brands(array $betting_sites): false|string
    {

        ob_start()

        ?>

<style>
.we-bs-raring-stars-container {

    width: 56px;

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-gray.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}



.we-bs-rating-stars {

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<?php foreach ($betting_sites as $betting_site): ?>

<div class="col-12 col-sm-6 col-xl-4">

    <?php if (! empty($betting_site['_websf_featured_bonus'])): ?>

    <?php

                    $bonus    = $betting_site['_websf_featured_bonus'][0];

        $category = get_term($bonus['category'], Taxonomy::$betting_site_category_slug);

        ?>

    <div class="card rounded-1 position-relative we-bs-bonus-review-card my-4 w-100" style="width: 238px">

        <span style="background-color: whitesmoke;" 1234><?= $betting_site['_websf_featured_tag'] ?></span>
        <div class="d-flex flex-row justify-content-end align-items-center position-absolute end-0 p-2">

            <div class="we-bs-raring-stars-container">

                <div class="we-bs-rating-stars"
                    style=" width: <?= ($betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>

            </div>

        </div>

        <div class="card-body pt-3" style="background-color: whitesmoke">

            <div class="d-flex flex-column justify-content-center align-items-center my-4">

                <div class="d-flex justify-content-center align-items-center"
                    style="background-color: <?= $betting_site['_websf_logo_bg_color'] ?>; height: 116px; width: 116px; border-radius: 50%">

                    <a href="<?= get_permalink($betting_site['post_id']) ?>">
                        <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                            alt="<?= $betting_site['post_title'] ?>" class="img-fluid" loading="lazy">
                    </a>

                </div>

                <div class="pt-3 pb-2">

                    <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-black">

                        <?= $betting_site['post_title'] ?>

                    </a>

                </div>

                <div class="fw-bold fs-5 my-2 text-center">

                    <?= $bonus['title'] ?>

                </div>

                <a class="btn btn-primary text-uppercase fw-bold my-2 text-decoration-none" href="<?= $bonus['link'] ?>"
                    target="_blank">

                    Get bonus

                </a>

                <?php if (! empty($betting_site['_websf_tc_apply_18'])): ?>

                <div class="my-2 text-black-50 fs-07rem">

                    <?= $betting_site['_websf_tc_apply_18']; ?>

                </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <?php endif; ?>

</div>

<?php endforeach; ?>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $featured_betting_site

     *

     * @return false|string

     */

    public static function thin_card(array $featured_betting_site): false|string
    {

        ob_start();

        ?>

<style>
.we-bs-raring-stars-container {

    width: 56px;

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-gray.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}



.we-bs-rating-stars {

    height: 12px;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<?php

        $featured_bonus       = $featured_betting_site['_websf_featured_bonus'][0];

        $featured_category_id = $featured_bonus['category'];

        $category             = get_term($featured_category_id, Taxonomy::$betting_site_category_slug);

        ?>

<div class="card w-100 my-4">

    <div class="card-body">

        <div class="row">

            <div class="col-6 col-xl-3">

                <a href="<?= get_permalink($featured_betting_site['post_id']) ?>">
                    <div style="width: 137px; height: 100px; background-color: <?= $featured_betting_site['_websf_logo_bg_color'] ?>"
                        class="d-flex justify-content-center align-items-center">

                        <img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($featured_betting_site['post_id']), 'full')[0] ?>"
                            alt="<?= $featured_betting_site['post_title'] ?>" class="img-fluid">

                    </div>
                </a>

            </div>

            <div class="col-6 col-xl-3">

                <div class="d-flex flex-column justify-content-center">

                    <div class="py-1 text-uppercase fw-bold">

                        <span class="badge text-bg-warning"><?= $category->name ?> Bonus</span>

                    </div>

                    <div class="fw-bold fs-5 py-1 text-wrap" style="max-width: 200px" hamza>

                        <?= $featured_bonus['title'] ?>

                    </div>

                    <?php if (! empty($featured_betting_site['_websf_tc_apply_18'])): ?>

                    <div class="py-1 text-black-50">

                        <?= $featured_betting_site['_websf_tc_apply_18'] ?>

                    </div>

                    <?php endif; ?>

                </div>

            </div>

            <div class="col-6 col-xl-3">

                <div class="d-flex flex-row align-items-center h-100">

                    <div>

                        <span class="fw-bold">

                            <?= $featured_betting_site['_websf_rat_overall'] ?>

                        </span>

                        <span> / 5</span>

                    </div>

                    <div class="ms-2">

                        <div class="we-bs-raring-stars-container">

                            <div class="we-bs-rating-stars"
                                style=" width: <?= ($featured_betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-6 col-xl-3">

                <div class="d-flex flex-row align-items-center h-100 w-100">

                    <div class="d-grid g-1 w-100">

                        <a href="<?= $featured_bonus['link'] ?>"
                            class="fw-bold text-uppercase text-decoration-none btn btn-primary WE_WIDGETS2"
                            target="_blank">

                            Get bonus

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }

}
