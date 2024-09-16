<?php

if (! defined('ABSPATH')) {
    die();
}

use We_Cpt_Betting_Site as CptBettingSite;
use We_M_Betting_Site as BettingSite;
use We_Taxonomy as Taxonomy;
use We_Widgets as Widgets;
use Carbon_Fields\Block;
use Carbon_Fields\Field;

class We_Blocks
{
    public static string $blocks_category = 'we-blocks';
    public static string $blocks_category_icon = 'plugins';

    public static array $top_betting_sites;

    /**
     * @return void
     */
    public static function init(): void
    {
        self::$top_betting_sites = We_M_Betting_Site::getAll(array());
    }

    /**
     * @return void
     */
    public static function register(): void
    {
        self::init();
        self::register_above_the_fold();
        self::register_featured_cards();
        self::register_latest_articles();
        self::register_offers_and_promos();
        self::register_top_betting_sites();
        self::register_latest_reviews();

        self::register_container();
        self::register_container_with_sidebar();
        self::register_content_row();
        self::register_content_section();
        self::register_heading();
        self::register_paragraph();
        self::register_list();

        self::register_thin_card();
        self::register_top_three_cards();

        //		self::register_footer_menu();
        //		self::register_footer_posts_menu();
        //		self::register_footer_reviews_menu();
    }

    /**
     * @return void
     */
    public static function enqueue_block_editor_assets(): void
    {
        wp_register_style(
            'we-bs-block-editor',
            WE_PLUGIN_URL . '/assets/css/block-editor-style.css',
            array(),
            microtime()
        );
        wp_enqueue_style('we-bs-block-editor');
    }

    /**
     * @return void
     */
    public static function register_above_the_fold(): void
    {

        Block::make(__('Above The Fold'))
             ->add_tab(__('Heading'), array(
                 Field::make('text', 'title', __('Title')),
                 Field::make('text', 'subtitle', __('Subtitle')),
                 Field::make('image', 'image', __('Image')),
                 Field::make('textarea', 'content', __('Text Content')),
                 Field::make('color', 'text-color', __('Text Color')),
                 Field::make('color', 'background-color', __('Background Color'))
             ))
             ->add_tab(__('Links'), array(
                 Field::make('color', 'links-color', __('Links Text Color')),
                 Field::make('color', 'links-bg-color', __('Links Background Color')),
                 Field::make('complex', 'links', __('Link'))
                      ->set_layout('tabbed-vertical')
                      ->add_fields(array(
                          Field::make('text', 'link-title', __('Title')),
                          Field::make('text', 'link-url', __('Url')),
                          Field::make('image', 'link-image', __('Image')),
                      ))
             ))
             ->set_description(__('A block used as an above the fold section.'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('align-full-width')
             ->set_keywords([ __('header'), __('above the fold'), __('landing') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>

<section style="background-color: <?= $fields['background-color'] ?>;" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h1 class="text-uppercase fw-bold fs-5" style="color: <?= $fields['text-color'] ?>">
                    <?= esc_html($fields['title']) ?>
                </h1>
                <h2 class="text-uppercase fw-bold fs-4" style="color: <?= $fields['text-color'] ?>">
                    <?= esc_html($fields['subtitle']) ?>
                </h2>
                <div style="color: <?= $fields['text-color'] ?>; font-size: 1rem">
                    <?php echo apply_filters('the_content', $fields['content']); ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 text-md-center">
                <img src="<?= wp_get_attachment_image_src($fields['image'], 'full')[0] ?>" alt="" class="img-fluid"
                    width="523" height="398">
            </div>
        </div>
    </div>
</section>
<?php
                 $links = $fields['links'];
                 if (! empty($links)):
                     ?>
<section style="margin-top: -47px">
    <div class="container">
        <div class="row row-cols-auto justify-content-center g-2 gx-xl-0">
            <?php
                                 $links_count = count($links);
                     $link_index  = 0;
                     ?>
            <?php foreach ($links as $link): ?>
            <?php
                         $rounded_class = $link_index == 0 ? 'rounded-start-1'
                             : ($link_index == $links_count - 1 ? 'rounded-end-1' : 0);
                ?>
            <div class="col-12 col-sm-6 col-xl-3">
                <div class="h-100 d-flex flex-row px-4 py-3 justify-content-center align-items-center <?= $rounded_class ?>"
                    style="background-color: <?= $fields['links-bg-color'] ?>">
                    <h3 class="fw-bold fs-6 text-uppercase m-0">
                        <a href="<?= $link['link-url'] ?>" class="text-decoration-none"
                            style="color: <?= $fields['links-color'] ?>">
                            <?= $link['link-title'] ?>
                        </a>
                    </h3>
                    <img src="<?= wp_get_attachment_image_src($link['link-image'], 'full')[0] ?>"
                        alt="<?= $link['link-title'] ?>" class="img-fluid ms-2" width="63" height="74">
                </div>
            </div>
            <?php $link_index++; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_featured_cards(): void
    {
        Block::make(__('Featured Cards'))
             ->add_fields(array(
                 Field::make('text', 'title', __('Section Title')),
                 Field::make('complex', 'cards', __('Featured Card'))
                      ->set_layout('tabbed-vertical')
                      ->add_fields(array(
                          Field::make('text', 'card-title', __('Card Title')),
                          Field::make('image', 'card-image', __('Card Image')),
                          Field::make('complex', 'card-links', __('Card Links'))
                               ->set_layout('tabbed-vertical')
                               ->add_fields(array(
                                   Field::make('text', 'link-title', __('Link Title')),
                                   Field::make('text', 'link-url', __('Link Url'))
                               ))
                      ))
             ))
             ->set_description(__('Cards that display featured contents with links'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('editor-table')
             ->set_keywords([ __('cards'), __('featured') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold text-uppercase fs-4">
                    <?= $fields['title'] ?>
                </h2>
            </div>
        </div>
        <?php
                         $cards = $fields['cards'];
                 if (! empty($cards)):

                     ?>

        <div class="swiper">
            <div class="swiper-wrapper">
                <!-- <div class="row"> -->
                <swiper-container class="games_swiper" autoplay-delay="500" speed="2000" loop="true" space-between="20">
                    <?php foreach ($cards as $card): ?>
                    <swiper-slide>

                        <div class="card w-100 mb-4">
                            <?php

                 $links = $card['card-links'];
                        $list_style_image = WE_PLUGIN_URL . '/assets/icons/arrow-triangle-darkblue.svg';

                        if (!empty($links)): ?>
                            <a href="<?= $links[0]['link-url'] ?>">
                                <?php endif; ?>
                                <img src="<?= wp_get_attachment_image_src($card['card-image'], 'full')[0] ?>"
                                    alt="<?= $card['card-title'] ?>" class="img-fluid card-img-top">
                                <?php if (!empty($links)): ?>
                            </a>
                            <?php endif; ?>

                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="fw-bold text-uppercase fs-5">
                                        <?= $card['card-title'] ?>
                                    </h3>
                                </div>
                                <?php
        $links = $card['card-links'];
                        $list_style_image = WE_PLUGIN_URL . '/assets/icons/arrow-triangle-darkblue.svg';
                        if (!empty($links)):
                            ?>
                                <style>
                                ul.we-feature-card-list {
                                    list-style-image: url("<?= $list_style_image ?>");
                                }
                                </style>
                                <ul class="we-feature-card-list">
                                    <?php foreach ($links as $link): ?>
                                    <li>
                                        <a href="<?= $link['link-url'] ?>"
                                            class="text-decoration-none text-capitalize text-black">
                                            <?= $link['link-title'] ?>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </div>

                    </swiper-slide>
                    <?php endforeach; ?>
                </swiper-container>
            </div>
        </div>
    </div>
    <?php endif; ?>
    </div>
</section>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_latest_articles(): void
    {
        Block::make(__('Latest Articles'))
             ->add_fields(array(
                 Field::make('text', 'title', __('Section Title')),
                 Field::make('textarea', 'description', __('Section Description')),
                 Field::make('text', 'link-title', __('Related Page link text')),
                 Field::make('text', 'link-url', __('Related Page link url')),
                 Field::make('association', 'category', __('Articles Category'))
                      ->set_types(array(
                          array(
                              'type'     => 'term',
                              'taxonomy' => 'category'
                          )
                      ))
                      ->set_min(1)
                      ->set_max(1)
             ))
             ->set_description(__('Cards that display latest articles from a category'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('format-aside')
             ->set_keywords([ __('cards'), __('articles'), __('news'), __('blog') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $title       = $fields['title'] ?: '';
                 $link_url    = $fields['link-url'] ?: '';
                 $link_title  = $fields['link-title'] ?: '';
                 $category    = $fields['category'] ?: '';
                 $description = $fields['description'] ?: '';
                 $posts       = array();
                 if (! empty($category)) {
                     $posts = get_posts(array(
                         'numberposts' => 12,
                         'category'    => $category[0]['id'],
                         'orderby'     => 'date',
                         'order'       => 'DESC',
                         'post_type'   => 'post'
                     ));
                 }
                 ?>
<section class="py-5 my-5 bg-dark">
    <div class="container">
        <div class="row row-cols-auto">
            <?php if (! empty($title)): ?>
            <div class="col">
                <h2 class="fw-bold text-uppercase fs-4 text-bg-dark">
                    <?= $title ?>
                </h2>
            </div>
            <?php endif; ?>
            <?php if (! empty($link_title) && ! empty($link_url)): ?>
            <div class="col">
                <a href="<?= $link_url ?>"
                    class="btn btn-outline-light fw-bold text-uppercase fs-6 text-decoration-none">
                    <?= $link_title ?>
                </a>
            </div>
            <?php endif; ?>
        </div>
        <?php if (! empty($description)): ?>
        <div class="row my-3">
            <div class="col-12">
                <div class="text-bg-dark" style="font-size: 1rem">
                    <?= apply_filters('the_content', $description) ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if (! empty($posts)): ?>


        <div class="swiper">


            <!-- Swiper main container -->
            <div class="swiper-wrapper">

                <swiper-container class="mySwiper" autoplay-delay="1000" speed="2000" loop="true" space-between="10">

                    <!-- Swiper wrapper -->
                    <?php foreach ($posts as $post): ?>
                    <swiper-slide>


                        <!-- Each post as a swiper-slide -->
                        <div class=" card rounded-1 border-black w-100 mb-4">
                            <a href="<?= get_permalink($post) ?>">
                                <div class="position-relative">



                                    <img src="<?= wp_get_attachment_image_src(get_post_thumbnail_id($post), 'full')[0] ?>"
                                        alt="<?= $post->post_title ?>" class="img-fluid card-img-top">
                                    <div class="position-absolute bottom-0 text-bg-dark px-2 fs-08rem">
                                        <?= get_the_date("", $post); ?>
                                    </div>
                                </div>
                            </a>
                            <div class="card-body" style="height:200px;">
                                <div class="card-title">
                                    <h3 class="fw-bold fs-5">
                                        <a href="<?= get_permalink($post) ?>" class="text-decoration-none text-black">
                                            <?= wp_trim_words($post->post_title, 10) ?>
                                        </a>
                                    </h3>
                                </div>
                                <div class="card-text">
                                    <p>
                                        <?= wp_trim_words($post->post_excerpt, 15) ?>
                                    </p>
                                    <a href="<?php the_permalink($post); ?>"
                                        style="text-decoration:none; color:black; ">Read
                                        More</a>
                                </div>
                            </div>
                        </div>


                    </swiper-slide>
                    <?php endforeach; ?>

                </swiper-container>
            </div>
        </div>



        <?php endif; ?>
    </div>
</section>

<?php
             });
    }

    /**
     * @return void
     */
    public static function register_offers_and_promos(): void
    {
        Block::make(__('Featured betting sites'))
             ->add_fields(array(
                 Field::make('text', 'title', __('Section Title')),
                 Field::make('textarea', 'description', __('Section Description')),
             ))
             ->set_description(__('Featured Betting Sites Cards'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('star-filled')
             ->set_keywords([ __('cards'), __('featured'), __('Betting site') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $title         = $fields['title'] ?: '';
                 $description   = $fields['description'] ?: '';
                 $betting_sites = array_slice(self::$top_betting_sites, 0, 4);
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
<section class="my-5">
    <div class="container">
        <?php if (! empty($title)): ?>
        <div class="row">
            <div class="col-12">
                <h2 class="text-uppercase fw-bold"><?= $title ?></h2>
            </div>
        </div>
        <?php endif; ?>
        <?php if (! empty($description)): ?>
        <div class="row mb-3">
            <div class="col-12">
                <div style="font-size: 1rem">
                    <?= apply_filters('the_content', $description) ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php if (! empty($betting_sites)): ?>
        <div class="row">
            <?php foreach ($betting_sites as $betting_site): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <?php if (! empty($betting_site['_websf_featured_bonus'])): ?>
                <?php
                                             $bonus    = $betting_site['_websf_featured_bonus'][0];
                    $category = get_term($bonus['category'], Taxonomy::$betting_site_category_slug);
                    ?>
                <div class="card rounded-1 position-relative we-bs-bonus-review-card mt-4 w-100" style="width: 238px">
                    <span style="background-color: whitesmoke;" abcd>     
                        <?= $betting_site['_websf_featured_tag'] ?></span>
                    <div class="d-flex flex-row justify-content-end align-items-center position-absolute end-0 p-2">
                        <div class="we-bs-raring-stars-container">
                            <div class="we-bs-rating-stars"
                                style=" width: <?= ($betting_site['_websf_rat_overall'] / 5) * 100 ?>%;"></div>
                        </div>
                    </div>
                    <div class="card-body pt-3" style="background-color: whitesmoke">
                        <div class="d-flex flex-column justify-content-center align-items-center my-4">

                            <!-- Make the image clickable -->
                            <a href="<?= get_permalink($betting_site['post_id']) ?>" style="display: block;">
                                <div class="d-flex justify-content-center align-items-center"
                                    style="background-color: <?= $betting_site['_websf_logo_bg_color'] ?>; height: 116px; width: 116px; border-radius: 50%">
                                    <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                                        alt="<?= $betting_site['post_title'] ?>" class="img-fluid" loading="lazy">
                                </div>
                            </a>

                            <!-- Post title below the image -->
                            <div class="pt-3 pb-2">
                                <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-black">
                                    <?= $betting_site['post_title'] ?>
                                </a>
                            </div>

                            <!-- Bonus title -->
                            <div class="fw-bold fs-5 my-2 text-center">
                                <?= $bonus['title'] ?>
                            </div>

                            <!-- Bonus button -->
                            <a class="btn btn-primary text-uppercase fw-bold my-2 text-decoration-none WE_BLOCKS"
                                href="<?= $bonus['link'] ?>" target="_blank">
                                Get bonus
                            </a>

                            <!-- Terms and conditions -->
                            <?php if (!empty($betting_site['_websf_tc_apply_18'])): ?>
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
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_top_betting_sites(): void
    {
        Block::make(__('Top Betting Sites'))
             ->add_fields(array(
                 Field::make('text', 'title', __('Section Title')),
                 Field::make('text', 'link-title', __('Link Title')),
                 Field::make('text', 'link-url', __('Link Url')),
                 Field::make('text', 'count', __('Betting Sites Count')),
             ))
             ->set_description(__('Display top betting sites'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('editor-ol')
             ->set_keywords([ __('top'), __('betting sites') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $count = 5;
                 if (! empty($fields['count']) && is_numeric($fields['count'])) {
                     $count = (int) $fields['count'];
                 }
                 ?>
<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-uppercase fs-4 fw-bold">
                    <?= $fields['title'] ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= We_View_Betting_Site_Card::list_filter(array(
                                     'filters' => 'categories,sort,bonus-types,bonus-features'
                                 )); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?= We_View_Betting_Site_Card::list(array( 'limit' => $count )) ?>
            </div>
            <div class="col-12">
                <div class="d-grid my-3">
                    <a href="<?= $fields['link-url'] ?>"
                        class="btn btn-outline-dark text-decoration-none text-uppercase fs-6 fw-bold">
                        <?= $fields['link-title'] ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_latest_reviews(): void
    {
        Block::make(__('Top betting sites reviews'))
             ->add_fields(array(
                 Field::make('text', 'title', __('Section Title')),
             ))
             ->set_description(__('Cards that display latest reviews'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('align-left')
             ->set_keywords([ __('cards'), __('reviews') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<section class="my-5 py-5 bg-dark">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="fw-bold text-uppercase fs-4 text-bg-dark">
                    <?= $fields['title'] ?>
                </h2>
            </div>
        </div>
        <?php
                         $betting_sites = array_slice(self::$top_betting_sites, 0, 4);
                 if (! empty($betting_sites)):
                     ?>
        <div class="row">
            <?php foreach ($betting_sites as $betting_site): ?>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="card w-100 mb-4 border-black aaa">
                    <a href="<?= get_permalink($betting_site['post_id']) ?>" class="text-decoration-none text-black">
                        <div style="background-color: <?= $betting_site['_websf_logo_bg_color'] ?>; height: 150px;"
                            class="d-flex flex-row justify-content-center align-items-center">
                            <img src="<?= wp_get_attachment_image_src($betting_site['_thumbnail_id'], 'full')[0] ?>"
                                alt="<?= $betting_site['post_title'] ?>" class="img-fluid card-img-top">
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="fw-bold fs-5">
                                    <?= wp_trim_words($betting_site['post_title'], 10) ?>
                                </h3>
                            </div>
                            <div class="card-text">
                                <p>
                                    <?= wp_trim_words($betting_site['_websf_rev_intro'], 15) ?>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_container_with_sidebar(): void
    {
        Block::make(__('Container with sidebar'))
             ->set_description(__('A Block container with a sidebar'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('table-col-before')
             ->set_keywords([ __('container'), __('win esports'), __('sidebar') ])
             ->set_inner_blocks(true)
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $betting_sites = array_slice(self::$top_betting_sites, 0, 5);
                 ?>
<section class="my-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8">
                <?= $inner_blocks ?>
            </div>
            <div class="col-12 col-lg-4">
                <div class="row">
                    <div class="col-12">
                        <?= Widgets::top_brands($betting_sites) ?>
                    </div>
                    <div class="col-12">
                        <?= Widgets::latest_news() ?>
                    </div>
                    <div class="col-12 mb-5">
                        <?= Widgets::top_betting_sites_list(array_slice(self::$top_betting_sites, 0, 20)) ?>
                    </div>
                    <div class="col-12">
                        <?= Widgets::top_bonuses($betting_sites) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_container(): void
    {
        Block::make(__('Container'))
             ->set_description(__('Container'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('grid-view')
             ->set_keywords([ __('container') ])
             ->set_inner_blocks(true)
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<div class="container-fluid p-0 mt-4">
    <?= $inner_blocks ?>
</div>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_content_row(): void
    {
        Block::make(__('Row'))
             ->set_description(__('Row'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('minus')
             ->set_keywords([ __('row') ])
             ->set_inner_blocks(true)
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<div class="row">
    <?= $inner_blocks ?>
</div>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_content_section(): void
    {
        Block::make(__('Content Wrapper'))
             ->set_description(__('A content wrapper'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('align-none')
             ->set_keywords([ __('content wrapper'), __('section') ])
             ->set_inner_blocks(true)
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<div class="row">
    <div class="col-12">
        <?= $inner_blocks ?>
    </div>
</div>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_heading(): void
    {
        Block::make(__('Heading'))
             ->add_fields(array(
                 Field::make('select', 'tag', __('Heading Tag'))
                      ->add_options(array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' )),
                 Field::make('textarea', 'content', __('Content'))
             ))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('heading')
             ->set_keywords([ __('heading'), __('h') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $tag   = 'h2';
                 $class = 'mt-4 mb-2 text-uppercase fw-bold ';
                 if (isset($fields['tag']) && is_numeric($fields['tag'])) {
                     $tag   = 'h' . ($fields['tag'] + 1);
                     $class .= 'fs-' . (min($fields['tag'] + 3, 6));
                 }
                 $content = '';
                 if (! empty($fields['content'])) {
                     $content = $fields['content'];
                 }
                 ?>
<<?= $tag ?> class="<?= $class ?>">
    <?= $content ?>
</<?= $tag ?>>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_paragraph(): void
    {
        Block::make(__('Paragraph'))
             ->add_fields(array(
                 Field::make('textarea', 'content', __('Content'))
             ))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('editor-paragraph')
             ->set_keywords([ __('paragraph'), __('content') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $content = '';
                 if (! empty($fields['content'])) {
                     $content = $fields['content'];
                 }
                 ?>
<p style="font-size: 1rem" class="my-2">
    <?= $content ?>
</p>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_list(): void
    {
        Block::make(__('List'))
             ->add_fields(array(
                 Field::make('checkbox', 'type', __('Ordered'))
                      ->set_option_value('yes'),
                 Field::make('complex', 'list', __('List'))
                      ->add_fields(array(
                          Field::make('text', 'title', __('Item title')),
                          Field::make('textarea', 'content', __('Item content'))
                      ))
                      ->set_layout('tabbed-vertical')
             ))
             ->set_description(__('A list of items, ordered or unordered'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('editor-ul')
             ->set_keywords([ __('ul'), __('li'), __('unordered'), __('ordered'), __('list') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $list_tag = 'ul';
                 if (! empty($fields['type'])) {
                     $list_tag = 'ol';
                 }
                 ?>
<?php if (! empty($fields['list'])): ?>
<<?= $list_tag ?> class="my-2">
    <?php foreach ($fields['list'] as $item): ?>
    <li style="font-size: 1rem" class="py-2">
        <?php if (! empty($item['title'])): ?>
        <div class="fw-bold">
            <?= $item['title'] ?>
        </div>
        <?php endif; ?>
        <?= $item['content'] ?>
    </li>
    <?php endforeach; ?>
</<?= $list_tag ?>>
<?php endif; ?>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_thin_card(): void
    {
        Block::make(__('Thin betting site card'))
             ->add_fields(array(
                 Field::make('text', 'index', __('Betting site index (1 -> 5)'))
             ))
             ->set_description(__('A thin card that display a top betting site'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('button')
             ->set_keywords([ __('thin'), __('top'), __('card'), __('betting site') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 $index        = 0;
                 $betting_site = array();
                 if (! empty($fields['index']) && is_numeric($fields['index'])) {
                     $index = max(0, $fields['index'] - 1);
                 }
                 if (! empty(self::$top_betting_sites) && count(self::$top_betting_sites) >= ($index + 1)) {
                     $betting_site = self::$top_betting_sites[ $index ];
                 }
                 ?>
<?= Widgets::thin_card($betting_site) ?>
<?php
             });
    }

    /**
     * @return void
     */
    public static function register_top_three_cards(): void
    {
        Block::make(__('Top three Betting Sites Cards'))
             ->set_category(self::$blocks_category, __('Win Esports Blocks'), self::$blocks_category_icon)
             ->set_icon('format-gallery')
             ->set_keywords([ __('thin'), __('top'), __('card'), __('betting site') ])
             ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
                 ?>
<?php if (! empty(self::$top_betting_sites)): ?>
<?= Widgets::top_3_brands(array_slice(self::$top_betting_sites, 0, 3)) ?>
<?php endif; ?>
<?php
             });
    }
}
