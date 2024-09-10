<?php



if (! defined('ABSPATH')) {

    die();

}



use We_M_Betting_Site as BettingSite;
use We_Cpt_Betting_Site_Meta_Keys as MetaKeys;
use We_Taxonomy as Taxonomy;
use We_Widgets as Widgets;

class We_View_Betting_Site
{
    public static array $categories;

    public static array $ratings;

    public static array $payment_methods;

    public static array $software_providers;

    public static array $all_bonus;

    public static string $logo_src;

    public static string $logo_bg_color;

    public static array $top_betting_sites;



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return void

     */

    public static function init(BettingSite $betting_site): void
    {

        self::$top_betting_sites  = We_M_Betting_Site::getAll(array());

        self::$logo_src           = get_the_post_thumbnail_url($betting_site->post);

        self::$logo_bg_color      = $betting_site->get_logo_bg_color();

        self::$ratings            = $betting_site->get_ratings();

        self::$categories         = $betting_site->get_categories();

        self::$payment_methods    = $betting_site->get_payment_methods();

        self::$software_providers = $betting_site->get_software_providers();

        self::$all_bonus          = array();

        foreach (self::$categories as $category) {

            $bonus = $betting_site->get_featured_bonus($category['id']);

            if (! empty($bonus)) {

                self::$all_bonus[] = $bonus;

            }

        }

    }



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function header(BettingSite $betting_site): false|string
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

    width: <?=(self::$ratings['overall'] / 5) * 100 ?>%;

    background-image: url("<?= WE_PLUGIN_URL . 'assets/icons/rating-star-golden.svg' ?>");

    background-repeat: repeat-x;

    background-size: contain;

}
</style>

<!-- Title & Subtitle -->

<div class="row">

    <div class="col-12">

        <h1 class="fs-3 text-uppercase mb-0" style="margin-top: -25px;">

            <?= $betting_site->get_review_title(); ?>

        </h1>

        <h2 class="fs-5 text-uppercase mt-0">

            <?= $betting_site->get_review_sub_title() ?>

        </h2>

    </div>

</div>

<!-- Betting Site Summary -->

<div class="row mt-4">

    <!-- Logo -->

    <div class="col-12 col-sm-4 col-md-3 col-lg-2 col-xl-2">

        <div class="py-4 text-center rounded-1 position-relative"
            style="background-color: <?= self::$logo_bg_color; ?>;">

            <img src="<?= self::$logo_src ?>" alt="<?= $betting_site->post->post_title ?>" class="img-fluid"
                loading="lazy">

        </div>

        <div class="d-grid mt-1">

            <div class="badge text-bg-dark rounded-pill py-2 fs-08rem">

                <div class="d-flex flex-row justify-content-center">

                    <div>

                        <span class="fw-bold"><?= self::$ratings['overall'] ?></span>

                        <span class="fw-normal">/ 5</span>

                    </div>

                    <div class="we-bs-raring-stars-container ms-1">

                        <div class="we-bs-rating-stars"></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Bonus Categories & Bonus Features -->

    <?php if (! empty(self::$all_bonus)): ?>

    <div class="col-12 col-sm-8 col-md-5 col-lg-4 col-xl-5">

        <!-- Bonus Categories -->

        <div class="row mt-4 mt-md-0">

            <div class="col-12">

                <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">

                    <?php $checked = true;

        foreach (self::$all_bonus as $bonus): ?>

                    <?php if (! empty($bonus['category'])): ?>

                    <input type="radio" class="btn-check webs-category-btn" name="webs-btn-category-name"
                        id="webs-btn-category-btn-<?= $bonus['category'][0]['id'] ?>" autocomplete="off"
                        data-target="webs-category-features-<?= $bonus['category'][0]['id'] ?>"
                        data-target-title="webs-category-title-<?= $bonus['category'][0]['id'] ?>"
                        data-target-cta="webs-bonus-cta-<?= $bonus['category'][0]['id'] ?>"
                        <?= $checked ? 'checked' : '' ?>>

                    <label class="btn btn-outline-dark" for="webs-btn-category-btn-<?= $bonus['category'][0]['id'] ?>">

                        <?php

                    $term = get_term($bonus['category'][0]['id'], $bonus['category'][0]['subtype']);

                        if (! empty($term) && $term instanceof WP_Term) :?>

                        <span class="fw-bold text-uppercase"><?= $term->name ?></span>

                        <?php endif;

                        $checked = false; ?>

                    </label>

                    <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

        <!-- Bonus Features -->

        <div class="row">

            <div class="col-12">

                <?php $show = true;

        foreach (self::$all_bonus as $bonus): ?>

                <?php if (! empty($bonus['features'])): ?>

                <ul class="<?= $show ? '' : 'd-none' ?> webs-category-features mt-3"
                    id="webs-category-features-<?= $bonus['category'][0]['id'] ?>">

                    <?php foreach ($bonus['features'] as $feature): ?>

                    <li class="fs-6"><?= $feature ?></li>

                    <?php endforeach; ?>

                </ul>

                <?php endif;

            $show = false; ?>

                <?php endforeach; ?>

            </div>

        </div>

    </div>

    <!-- Bonus title -->

    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">

        <div class="row">

            <div class="col-12">

                <?php $first = true;

        foreach (self::$all_bonus as $bonus): ?>

                <div class="webs-bonus-title <?= $first ? '' : 'd-none' ?>"
                    id="webs-category-title-<?= $bonus['category'][0]['id'] ?>">

                    <?php $term = get_term($bonus['category'][0]['id'], $bonus['category'][0]['subtype']); ?>

                    <div class="fw-bold fs-6 text-uppercase text-black-50">

                        <?= $betting_site->post->post_title . ' ' . $term->name . ' bonus' ?>

                    </div>

                    <h3 class="text-uppercase text-uppercase mt-3">

                        <?= $bonus['title'] ?>

                    </h3>

                </div>

                <?php $first = false; endforeach; ?>

            </div>

        </div>

    </div>

    <!-- Call to action -->

    <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-2">

        <?php $first = true;

        foreach (self::$all_bonus as $bonus): ?>

        <div class="d-grid <?= $first ? '' : 'd-none' ?> webs-bonus-cta"
            id="webs-bonus-cta-<?= $bonus['category'][0]['id'] ?>">

            <a class="btn btn-outline-dark" style="border-style: dashed; text-decoration: none"
                href="<?= ! empty($bonus['link']) ? $bonus['link'] : '' ?>" 
                data-value="<?= $bonus['code'] ?>">

                <span style="vertical-align: -webkit-baseline-middle;">

                    <?= str_repeat('*  ', 6) ?>

                </span>

            </a>

            <a class="btn btn-primary text-uppercase mt-2 border-0 fw-semibold text-decoration-none" 
                href="<?= ! empty($bonus['link']) ? $bonus['link'] : '' ?>">

                <?= $betting_site->get_cta_label() ?>

            </a>

        </div>

        <?php $first = false; endforeach; ?>

    </div>

    <script>
    (() => {

        const categoriesButtons = document.querySelectorAll('.webs-category-btn');

        const categoriesFeaturesSections = document.querySelectorAll('.webs-category-features');

        const categoriesBonusTitles = document.querySelectorAll('.webs-bonus-title');

        const categoriesBonusCtas = document.querySelectorAll('.webs-bonus-cta');

        if (!categoriesButtons || !categoriesFeaturesSections || !categoriesBonusTitles || !categoriesBonusCtas)

            return;

        categoriesButtons.forEach(btn => {

            btn.addEventListener('click', (e) => {

                const categoryFeaturesTarget = e.target.getAttribute('data-target');

                const categoryBonusTitle = e.target.getAttribute('data-target-title');

                const categoryBonusCta = e.target.getAttribute('data-target-cta');

                if (!categoryFeaturesTarget || !categoryBonusTitle || !categoryBonusCta)

                    return;



                categoriesFeaturesSections.forEach(section => {

                    if (!section.classList.contains('d-none'))

                        section.classList.add('d-none');

                });

                document.getElementById(categoryFeaturesTarget).classList.remove('d-none');



                categoriesBonusTitles.forEach(title => {

                    if (!title.classList.contains('d-none'))

                        title.classList.add('d-none');

                });

                document.getElementById(categoryBonusTitle).classList.remove('d-none');



                categoriesBonusCtas.forEach(cta => {

                    if (!cta.classList.contains('d-none'))

                        cta.classList.add('d-none');

                });

                document.getElementById(categoryBonusCta).classList.remove('d-none');



                categoriesButtons.forEach(button => {

                    button.removeAttribute('checked');

                });

                if (!e.target.hasAttribute('checked'))

                    e.target.setAttribute('checked', '');

            });

        });

    })();
    </script>

    <?php endif; ?>

</div>

<?php

        return ob_get_clean();



    }



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function summary(BettingSite $betting_site): false|string
    {

        ob_start();

        ?>

<style>
.nav.nav-tabs .nav-item .nav-link:hover,

.nav.nav-tabs .nav-item .nav-link {

    color: white;

}



.nav.nav-tabs .nav-item .nav-link.active:hover,

.nav.nav-tabs .nav-item .nav-link.active {

    color: black;

}



#webs-info .fs-07rem {

    font-weight: bold;

}
</style>

<div class="row mt-5">

    <div class="col-12">

        <?php $payment_methods = self::$payment_methods; ?>

        <ul class="nav nav-tabs ps-0 bg-primary" id="summaryTab" role="tablist">

            <li class="nav-item" role="presentation">

                <button class="nav-link active fw-bold text-uppercase fs-6" id="details-tab" data-bs-toggle="tab"
                    data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane"
                    aria-selected="true">

                    Details

                </button>

            </li>

            <?php if (! empty($payment_methods)): ?>

            <li class="nav-item" role="presentation">

                <button class="nav-link fw-bold text-uppercase fs-6" id="payments-tab" data-bs-toggle="tab"
                    data-bs-target="#payments-tab-pane" type="button" role="tab" aria-controls="payments-tab-pane"
                    aria-selected="false">

                    Payment Methods

                </button>

            </li>

            <?php endif; ?>

        </ul>

        <div class="tab-content" id="summaryTabContent">

            <div class="tab-pane fade show active py-4" id="details-tab-pane" role="tabpanel"
                aria-labelledby="details-tab" tabindex="0">

                <div class="row">

                    <div class="col-12 col-lg-8">

                        <div class="row">

                            <div class="col-12">

                                <div style="font-size: 1rem">

                                    <?= $betting_site->get_review_intro() ?>

                                </div>

                            </div>

                        </div>

                        <?php

                                $pros = $betting_site->get_review_pros();

        $cons = $betting_site->get_review_cons();

        if (! empty($pros) && ! empty($cons)):

            ?>

                        <div class="row row-cols-auto">

                            <div class="col-12">

                                <h3 class="fs-5 fw-bold mt-0">

                                    <?= $betting_site->post->post_title ?>: Pros & Cons

                                </h3>

                            </div>

                            <div class="col">

                                <?php foreach ($pros as $pro_data_set): ?>

                                <div class="fs-6">

                                    <span>

                                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/circle-checkmark-green.svg' ?>"
                                            alt="Circle Check Mark Green" loading="lazy">

                                    </span>

                                    <span><?= $pro_data_set['text'] ?></span>

                                </div>

                                <?php endforeach; ?>

                            </div>

                            <div class="col">

                                <?php foreach ($cons as $con_data_set): ?>

                                <div class="fs-6">

                                    <span>

                                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/circle-minus-red.svg' ?>"
                                            alt="Circle Minus Red" loading="lazy">

                                    </span>

                                    <span><?= $con_data_set['text'] ?></span>

                                </div>

                                <?php endforeach; ?>

                            </div>

                        </div>

                        <?php endif; ?>

                        <div class="row mt-4">

                            <div class="col-12">

                                <hr>

                            </div>

                        </div>

                        <div class="row row-cols-auto" id="webs-info">

                            <?= self::view_payment_methods($betting_site, 0) ?>

                            <?= self::view_license($betting_site) ?>

                            <?= self::view_withdrawal($betting_site); ?>

                            <?= self::view_apps($betting_site); ?>

                            <?= self::view_award($betting_site); ?>

                            <?php

            $company = $betting_site->get_company();

        if (! empty($company)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    company

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $company ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $founded = $betting_site->get_founded();

        if (! empty($founded)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    founded

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $founded ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $website = $betting_site->get_website();

        if (! empty($website)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    website

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $website ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $available_languages = $betting_site->get_available_languages();

        if (! empty($available_languages)):

            ?>

                            <div class="col pt-3">

                                <div class="container-fluid" style="max-width: 200px;">

                                    <div class="text-uppercase text-black-50 fs-07rem" style="margin-left: -12px">

                                        AVAILABLE LANGUAGES

                                    </div>

                                    <div style="position: relative; width: 160px">

                                        <div class="row row-cols-3">

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <div class="text-uppercase"><?= $available_languages[0] ?></div>

                                            </div>

                                            <?php if (! empty($available_languages[1])): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <div class="text-uppercase"><?= $available_languages[1] ?></div>

                                            </div>

                                            <?php if (! empty($available_languages[2])): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <div class="text-uppercase"><?= $available_languages[2] ?></div>

                                            </div>

                                            <?php endif; ?>

                                            <?php endif; ?>

                                        </div>



                                        <?php if (count($available_languages) > 3): ?>

                                        <div class="d-none row row-cols-3" id="webs-x-al">

                                            <?php for ($i = 3; $i < count($available_languages); $i++): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1 mt-1">

                                                <div class="text-uppercase"><?= $available_languages[ $i ] ?></div>

                                            </div>

                                            <?php endfor; ?>

                                        </div>



                                        <div class="border border-1 d-flex flex-row justify-content-center align-items-center px-1"
                                            style="height: 53px; width: 15px;  border-color: var(--bs-border-color-translucent); cursor: pointer; position: absolute; top: 0; left: 100%"
                                            data-toggle="webs-x-al" onclick="toggleExtraContent(event)">

                                            <img src="<?= WE_PLUGIN_URL . 'assets/icons/arrow-down-angular-green.svg' ?>"
                                                alt="Arrow down / up, available languages"
                                                style="filter: brightness(0%)" data-toggle="webs-x-al" loading="lazy">

                                        </div>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $customer_support = $betting_site->get_customer_support();

        if (! empty($customer_support)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    Customer support

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?php

                    $customer_support_items = array();

            foreach ($customer_support as $customer_support_data_set) {

                $customer_support_items[] = $customer_support_data_set['support'];

            }

            ?>

                                    <?= join(', ', $customer_support_items) ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $email = $betting_site->get_email();

        if (! empty($email)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    email

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $email ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $phone = $betting_site->get_phone();

        if (! empty($phone)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    phone

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $phone ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $verified_by = $betting_site->get_verified_by();

        if (! empty($verified_by)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    verified by

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $verified_by ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $safety_score = $betting_site->get_safety_score();

        if (! empty($safety_score)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    safety score

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $safety_score ?>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $accepted_cryptos = $betting_site->get_accepted_crypto();

        if (! empty($accepted_cryptos)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    ACCEPTED CURRENCIES

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?php

                    $accepted_cryptos_list = array();

            foreach ($accepted_cryptos as $crypto_data_set) {

                $crypto = get_term($crypto_data_set['id'], $crypto_data_set['subtype']);

                if (! empty($crypto) && $crypto instanceof WP_Term) {

                    $accepted_cryptos_list[] = $crypto->name;

                }

            }

            ?>

                                    <div><?= join(', ', $accepted_cryptos_list) ?></div>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $software_providers = self::$software_providers;

        if (! empty($software_providers)):

            ?>

                            <div class="col pt-3">

                                <div class="container-fluid" style="max-width: 200px;">

                                    <div class="text-uppercase text-black-50 fs-07rem" style="margin-left: -12px">

                                        Software Providers

                                    </div>

                                    <div style="position: relative; width: 160px">

                                        <div class="row row-cols-3">

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <img src="<?= $software_providers[0]['icon'] ?>"
                                                    alt="<?= $software_providers[0]['name'] ?>"
                                                    title="<?= $software_providers[0]['name'] ?>" class="img-fluid"
                                                    loading="lazy">

                                            </div>

                                            <?php if (count($software_providers) > 1): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <img src="<?= $software_providers[1]['icon'] ?>"
                                                    alt="<?= $software_providers[1]['name'] ?>"
                                                    title="<?= $software_providers[1]['name'] ?>" class="img-fluid"
                                                    loading="lazy">

                                            </div>

                                            <?php if (count($software_providers) > 2): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                                                <img src="<?= $software_providers[2]['icon'] ?>"
                                                    alt="<?= $software_providers[2]['name'] ?>"
                                                    title="<?= $software_providers[2]['name'] ?>" class="img-fluid"
                                                    loading="lazy">

                                            </div>

                                            <?php endif; ?>

                                            <?php endif; ?>

                                        </div>

                                        <?php if (count($software_providers) > 3): ?>

                                        <div class="d-none row row-cols-3" id="webs-x-sp">

                                            <?php for ($i = 3; $i < count($software_providers); $i++): ?>

                                            <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                                                class="border border-1 d-flex flex-row justify-content-center align-items-center me-1 mt-1">

                                                <?php if (! empty($software_providers[ $i ]['icon'])): ?>

                                                <img src="<?= $software_providers[ $i ]['icon'] ?>"
                                                    alt="<?= $software_providers[ $i ]['name'] ?>"
                                                    title="<?= $software_providers[ $i ]['name'] ?>" class="img-fluid"
                                                    loading="lazy">

                                                <?php endif; ?>

                                            </div>

                                            <?php endfor; ?>

                                        </div>

                                        <div class="border border-1 d-flex flex-row justify-content-center align-items-center px-1"
                                            style="height: 53px; width: 15px;  border-color: var(--bs-border-color-translucent); cursor: pointer; position: absolute; top: 0; left: 100%"
                                            data-toggle="webs-x-sp" onclick="toggleExtraContent(event)">

                                            <img src="<?= WE_PLUGIN_URL . 'assets/icons/arrow-down-angular-green.svg' ?>"
                                                alt="Arrow down / up, toggle payment methods"
                                                style="filter: brightness(0%)" data-toggle="webs-x-sp" loading="lazy">

                                        </div>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                            <?php endif; ?>

                            <?php

                                    $number_of_slots = $betting_site->get_slots_number();

        if (! empty($number_of_slots)):

            ?>

                            <div class="col pt-3">

                                <div class="text-uppercase text-black-50 fs-07rem">

                                    number of slots

                                </div>

                                <div class="border border-1 fs-08rem d-flex flex-row align-items-center px-3"
                                    style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

                                    <?= $number_of_slots ?>

                                </div>

                            </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <div class="col-12 col-lg-4">

                        <?php

                                $ratings = self::$ratings;

        if (! empty($ratings)):

            ?>

                        <div class="mt-4 mt-lg-0 d-flex justify-content-between">

                            <div class="fs-5 fw-bold text-uppercase">Overall rating</div>

                            <div class="d-flex flex-row justify-content-end align-items-center">

                                <div class="we-bs-raring-stars-container">

                                    <div class="we-bs-rating-stars"></div>

                                </div>

                                <div class="ms-2">

                                    <span class="fw-bold fs-5"><?= $ratings['overall'] ?></span>

                                    <span class="fs-6"> / 5</span>

                                </div>

                            </div>

                        </div>

                        <ul class="p-0 m-0" style="list-style: none">

                            <?php foreach ($ratings as $key => $value): ?>

                            <?php

                    $ratings_field_map = array(

                        'bonus_offer'          => array(

                            'label' => 'Bonus Offers & Free Bets',

                            'icon'  => 'review-icon-bonus.svg'

                        ),

                        'usability'            => array(

                            'label' => 'Usability, Look & Feel',

                            'icon'  => 'review-icon-usability.svg'

                        ),

                        'payment_methods'      => array(

                            'label' => 'Payment Methods',

                            'icon'  => 'review-icon-payment.svg'

                        ),

                        'customer_service'     => array(

                            'label' => 'Customer Service',

                            'icon'  => 'review-icon-customer-service.svg'

                        ),

                        'license_and_security' => array(

                            'label' => 'Licence & Security',

                            'icon'  => 'review-icon-licensing.svg'

                        ),

                        'rewards_program_key'  => array(

                            'label' => 'Rewards & Loyalty Program',

                            'icon'  => 'review-icon-rewards.svg'

                        )

                    );

                                ?>

                            <?php if (! empty($ratings_field_map[ $key ])): ?>

                            <li style="margin-top: 20px">

                                <div class="d-flex flex-row justify-content-between align-items-center">

                                    <div class="d-flex flex-row align-items-center">

                                        <img src="<?= WE_PLUGIN_URL . 'assets/icons/review/' . $ratings_field_map[ $key ]['icon'] ?>"
                                            alt="Svg icon <?= $ratings_field_map[ $key ]['label'] ?>"
                                            style="width: 20px; height: 20px" loading="lazy">

                                        <div class="ms-3">

                                            <?= $ratings_field_map[ $key ]['label'] ?>

                                        </div>

                                    </div>

                                    <div class="d-flex flex-row align-items-center">

                                        <span class="fw-6 fw-bold"><?= $value ?></span>

                                        <span class="fs-6"> / 5 </span>

                                    </div>

                                </div>

                                <div style="margin-top: 3px">

                                    <div class="progress" style=" height: 3px">

                                        <div class="progress-bar progress-bar-striped bg-info"
                                            style="width:<?= is_numeric($value) ? ($value / 5) * 100 : 0 ?>%;">
                                        </div>

                                    </div>

                                </div>

                            </li>

                            <?php endif; ?>

                            <?php endforeach; ?>

                        </ul>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <?php if (! empty($payment_methods)): ?>

            <div class="tab-pane fade" id="payments-tab-pane" role="tabpanel" aria-labelledby="payments-tab"
                tabindex="0">

                <div class="row">

                    <div class="col-12">

                        <h3>Payments methods</h3>

                    </div>

                    <div class="col-12">

                        <div class="table-responsive">

                            <table class="table table-striped table-bordered align-middle">

                                <thead>

                                    <tr>

                                        <th scope="col" class="text-center fs-07">Payment Provider</th>

                                        <th scope="col" class="text-center fs-07">Deposit min/max</th>

                                        <th scope="col" class="text-center fs-07">Withdrawal min/max</th>

                                        <th scope="col" class="text-center fs-07">Deposit time</th>

                                        <th scope="col" class="text-center fs-07">Withdrawal time</th>

                                        <th scope="col" class="text-center fs-07">Safety</th>

                                    </tr>

                                </thead>

                                <tbody class="table-group-divider">

                                    <?php foreach ($payment_methods as $payment_method): ?>

                                    <?php if (! empty($payment_method['image'])): ?>

                                    <tr>

                                        <td class="text-center fs-6">

                                            <img src="<?= $payment_method['image'] ?>"
                                                alt="<?= basename($payment_method['image']) ?>" width="135"
                                                height="40" loading="lazy">

                                        </td>

                                        <td class="text-center fs-6">

                                            <?= $payment_method['deposit'] ?? '' ?>

                                        </td>

                                        <td class="text-center fs-6">

                                            <?= $payment_method['withdrawal'] ?? '' ?>

                                        </td>

                                        <td>

                                            <?= $payment_method['deposit_time'] ?? '' ?>

                                        </td>

                                        <td class="text-center fs-6">

                                            <?= $payment_method['withdrawal_time'] ?? '' ?>

                                        </td>

                                        <td class="text-center fs-6">

                                            <?= $payment_method['safety'] ?? '' ?>

                                        </td>

                                    </tr>

                                    <?php endif; ?>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @param We_M_Betting_Site $betting_site

     * @param int $bs_index

     *

     * @return false|string

     */

    public static function view_payment_methods(BettingSite $betting_site, int $bs_index = 0): false|string
    {

        ob_start();

        ?>

<?php $payment_methods = self::$payment_methods;

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

                    <img src="<?= $payment_methods[0]['icon'] ?>" alt="icon of a payment method"
                        style="width: auto; height: 28px" loading="lazy">

                </div>

                <?php endif; ?>

                <?php if (count($payment_methods) > 1): ?>

                <?php if (! empty($payment_methods[1]['icon'])): ?>

                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                    <img src="<?= $payment_methods[1]['icon'] ?>" alt="icon of a payment method"
                        style="width: auto; height: 28px">

                </div>

                <?php endif; ?>

                <?php if (count($payment_methods) > 2): ?>

                <?php if (! empty($payment_methods[2]['icon'])): ?>

                <div style="height: 53px; width: 53px; border-color: var(--bs-border-color-translucent);"
                    class="border border-1 d-flex flex-row justify-content-center align-items-center me-1">

                    <img src="<?= $payment_methods[2]['icon'] ?>" alt="icon of a payment method"
                        style="width: auto; height: 28px">

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

                    <img src="<?= $payment_methods[ $i ]['icon'] ?>" alt="icon of a payment method"
                        style="width: auto; height: 28px">

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

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function view_license(BettingSite $betting_site): false|string
    {

        ob_start();

        $license = $betting_site->get_license();

        if (! empty($license)) :

            ?>

<div class="col pt-3">

    <div class="text-uppercase text-black-50 fs-07rem">

        license

    </div>

    <div class="border border-1 fs-08rem d-flex flex-row align-items-center"
        style="height: 53px; width: auto; border-color: var(--bs-border-color-translucent);">

        <img src="<?= $license[0] ?>" alt="<?= $betting_site->post->post_title . ' License' ?>"
            style="height: 40px; width: auto" loading="lazy">

    </div>

</div>

<?php

        endif;



        return ob_get_clean();

    }



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function view_withdrawal(BettingSite $betting_site): false|string
    {

        $withdrawal = $betting_site->get_withdrawal();

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

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function view_apps(BettingSite $betting_site): false|string
    {

        ob_start();

        $android_available = $betting_site->is_android_available();

        $ios_available     = $betting_site->is_ios_available();

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

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function view_award(BettingSite $betting_site): false|string
    {

        ob_start();

        $award = $betting_site->get_award();

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

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function reviews_navigation(BettingSite $betting_site): false|string
    {

        ob_start();

        ?>

<div id="th-icons-navigation" class="row mt-4">

    <div class="col-12">

        <div class="overflow-x-auto">

            <ul class="list-group list-group-horizontal ps-0">

                <?php

                        $reviews_sections = array(

                            array(

                                'label'    => 'Bonus',

                                'link'     => '#webs-bonus',

                                'icon'     => 'review-icon-bonus.svg',

                                'meta_key' => MetaKeys::review_bonus_key()

                            ),

                            array(

                                'label'    => 'Usability',

                                'link'     => '#webs-usability',

                                'icon'     => 'review-icon-usability.svg',

                                'meta_key' => MetaKeys::review_usability_key()

                            ),

                            array(

                                'label'    => 'Payment',

                                'link'     => '#webs-payment',

                                'icon'     => 'review-icon-payment.svg',

                                'meta_key' => MetaKeys::review_payment_key()

                            ),

                            array(

                                'label'    => 'Service',

                                'link'     => '#webs-service',

                                'icon'     => 'review-icon-customer-service.svg',

                                'meta_key' => MetaKeys::review_service_key()

                            ),

                            array(

                                'label'    => 'Licensing',

                                'link'     => '#webs-licensing',

                                'icon'     => 'review-icon-licensing.svg',

                                'meta_key' => MetaKeys::review_licensing_key()

                            ),

                            array(

                                'label'    => 'Rewards',

                                'link'     => '#webs-rewards',

                                'icon'     => 'review-icon-rewards.svg',

                                'meta_key' => MetaKeys::review_rewards_key()

                            ),

                            array(

                                'label'    => 'Sports',

                                'link'     => '#webs-sports',

                                'icon'     => 'review-icon-sport.svg',

                                'meta_key' => MetaKeys::review_sports_key()

                            ),

                            array(

                                'label'    => 'Casino',

                                'link'     => '#webs-casino',

                                'icon'     => 'review-icon-casino.svg',

                                'meta_key' => MetaKeys::review_casino_key()

                            ),

                            array(

                                'label'    => 'Esports',

                                'link'     => '#webs-esports',

                                'icon'     => 'review-icon-esports.svg',

                                'meta_key' => MetaKeys::review_esports_key()

                            ),

                            array(

                                'label'    => 'Conclusion',

                                'link'     => '#webs-conclusion',

                                'icon'     => 'review-icon-conclusion.svg',

                                'meta_key' => MetaKeys::review_conclusion_key()

                            )

                        );

        foreach ($reviews_sections as $reviews_section):

            ?>

                <?php if (! empty($betting_site->get_review_section($reviews_section['meta_key']))): ?>

                <li class="list-group-item">

                    <a href="<?= $reviews_section['link'] ?>" class="text-decoration-none text-black">

                        <div class="d-flex flex-column justify-content-center align-items-center py-2 px-3">

                            <img src="<?= WE_PLUGIN_URL . 'assets/icons/review/' . $reviews_section['icon'] ?>"
                                alt="Bonus icon" style="width: 28px; height: 28px" loading="lazy">

                            <span class="mt-2 fs-08rem"><?= $reviews_section['label'] ?></span>

                        </div>

                    </a>

                </li>

                <?php endif; ?>

                <?php endforeach; ?>

            </ul>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function reviews(BettingSite $betting_site): false|string
    {

        $reviews = array(

            array(

                'id'      => 'webs-bonus',

                'content' => $betting_site->get_bonus_review(),

            ),

            array(

                'id'      => 'webs-usability',

                'content' => $betting_site->get_usability_review(),

            ),

            array(

                'id'      => 'webs-payment',

                'content' => $betting_site->get_payment_review(),

            ),

            array(

                'id'      => 'webs-service',

                'content' => $betting_site->get_service_review(),

            ),

            array(

                'id'      => 'webs-licensing',

                'content' => $betting_site->get_licensing_review(),

            ),

            array(

                'id'      => 'webs-rewards',

                'content' => $betting_site->get_rewards_review(),

            ),

            array(

                'id'      => 'webs-sports',

                'content' => $betting_site->get_sports_review(),

            ),

            array(

                'id'      => 'webs-casino',

                'content' => $betting_site->get_casino_review(),

            ),

            array(

                'id'      => 'webs-esports',

                'content' => $betting_site->get_esports_review(),

            ),

            array(

                'id'      => 'webs-conclusion',

                'content' => $betting_site->get_conclusion_review()

            )

        );

        ob_start();

        ?>

<div class="row">

    <div class="col-12 col-lg-8">

        <?php foreach ($reviews as $review): ?>

        <?php if (! empty($review) && ! empty($review['content'])): ?>

        <div class="row pb-4 webs-review-container" id="<?= $review['id'] ?>">

            <div class="col-12">

                <?= $review['content'] ?>

                <?php if ($review['id'] == 'webs-bonus'): ?>

                <?php

                                    $categories = self::$categories;

                    $all_bonus  = self::$all_bonus;

                    ?>

                <?php if (! empty($all_bonus)): ?>

                <div class="row row-cols-auto">

                    <?php foreach ($all_bonus as $bonus): ?>

                    <?php

                                $category = get_term($bonus['category'][0]['id'], Taxonomy::$betting_site_category_slug);

                        ?>

                    <div class="col">

                        <div class="card rounded-1 position-relative we-bs-bonus-review-card mt-4" style="width: 238px">

                            <div
                                class="d-flex flex-row justify-content-end align-items-center position-absolute end-0 p-2">

                                <div class="we-bs-raring-stars-container">

                                    <div class="we-bs-rating-stars"></div>

                                </div>

                            </div>

                            <div class="badge text-bg-warning position-absolute text-uppercase">

                                <?php if (! empty($category) && ! is_wp_error($category)): ?>

                                <?= $category->name ?>

                                <?php endif; ?>

                            </div>

                            <div class="card-body pt-3" style="background-color: whitesmoke">

                                <div class="d-flex flex-column justify-content-center align-items-center my-4">

                                    <div class="d-flex justify-content-center align-items-center"
                                        style="background-color: <?= self::$logo_bg_color ?>; height: 116px; width: 116px; border-radius: 50%">

                                        <img src="<?= self::$logo_src ?>" alt="<?= $betting_site->post->post_title ?>"
                                            class="img-fluid" loading="lazy">

                                    </div>

                                    <div class="fw-bold fs-5 my-2 text-center">

                                        <?= $bonus['title'] ?>

                                    </div>

                                    <a class="btn btn-primary text-uppercase fw-bold my-2 text-decoration-none"
                                        href="<?= $bonus['link'] ?>" >

                                        Get bonus

                                    </a>

                                    <?php if (! empty($betting_site->get_tc_apply())): ?>

                                    <div class="my-2 text-black-50 fs-07rem">

                                        <?= $betting_site->get_tc_apply(); ?>

                                    </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                    </div>

                    <?php endforeach; ?>

                </div>

                <?php endif; ?>

                <?php endif; ?>

                <?php if ($review['id'] == 'webs-payment'): ?>

                <?php

                                    $payment_methods       = self::$payment_methods;

                    $payment_methods_count = count($payment_methods);

                    ?>

                <?php if (! empty($payment_methods)): ?>

                <div class="row mt-2 row-cols-auto gx-2">

                    <?php for ($i = 0; $i < min($payment_methods_count, 5); $i++): ?>

                    <div class="col mt-2">

                        <div style="width: 117px; height: 84px"
                            class="p-4 d-flex justify-content-center align-items-center border border-1 border-dark-subtle rounded-1">

                            <img src="<?= $payment_methods[ $i ]['icon'] ?>" alt="<?= "payment method $i" ?>"
                                class="img-fluid" loading="lazy" width="112" height="78">

                        </div>

                    </div>

                    <?php endfor; ?>

                    <?php if ($payment_methods_count > 5): ?>

                    <?php for ($i = 5; $i < $payment_methods_count; $i++): ?>

                    <div class="col mt-2 we-bs-review-hidden-payment-method" style="display: none;">

                        <div style="width: 117px; height: 84px;"
                            class="p-4 d-flex justify-content-center align-items-center border border-1 border-dark-subtle rounded-1">

                            <img src="<?= $payment_methods[ $i ]['icon'] ?>" alt="<?= "payment method $i" ?>"
                                class="img-fluid" loading="lazy" width="112" height="78">

                        </div>

                    </div>

                    <?php endfor; ?>

                    <div class="col mt-2">

                        <div style="width: 117px; height: 84px; cursor: pointer;"
                            class="d-flex justify-content-center align-items-center fw-bold border border-1 border-dark-subtle rounded-1"
                            id="we-bs-review-payment-methods-trigger">

                            + <?= $payment_methods_count ?>

                        </div>

                    </div>

                    <?php endif; ?>

                </div>

                <?php endif; ?>

                <?php endif; ?>

                <?php if ($review['id'] == 'webs-licensing'): ?>

                <?php

                    $license = $betting_site->get_license();

                    if (! empty($license)): ?>

                <div class="row mt-4">

                    <div class="col-12">

                        <div
                            class="d-flex justify-content-center align-items-center border border-1 border-dark-subtle rounded-1 py-2">

                            <img src="<?= $license[0] ?>" alt="license" class="img-fluid" width="200" height="59">

                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <?php endif; ?>

                <?php if ($review['id'] == 'webs-casino'): ?>

                <?php

                    $software_providers       = self::$software_providers;

                    $software_providers_count = count($software_providers);

                    ?>

                <?php if (! empty($software_providers)): ?>

                <div class="row mt-2 row-cols-auto gx-2">

                    <?php for ($i = 0; $i < min($software_providers_count, 5); $i++): ?>

                    <div class="col mt-2">

                        <div style="width: 117px; height: 84px"
                            class="p-4 d-flex justify-content-center align-items-center border border-1 border-dark-subtle rounded-1">

                            <img src="<?= $software_providers[ $i ]['icon'] ?>" alt="<?= "software provider $i" ?>"
                                class="img-fluid" loading="lazy" width="112" height="78">

                        </div>

                    </div>

                    <?php endfor; ?>

                    <?php if ($software_providers_count > 5): ?>



                    <?php for ($i = 5; $i < $software_providers_count; $i++): ?>

                    <div class="col mt-2 we-bs-review-hidden-software-providers" style="display: none;">

                        <div style="width: 117px; height: 84px;"
                            class="p-4 d-flex justify-content-center align-items-center border border-1 border-dark-subtle rounded-1">

                            <img src="<?= $software_providers[ $i ]['icon'] ?>" alt="<?= "software provider $i" ?>"
                                class="img-fluid" loading="lazy" width="112" height="78">

                        </div>

                    </div>

                    <?php endfor; ?>

                    <div class="col mt-2">

                        <div style="width: 117px; height: 84px; cursor: pointer;"
                            class="d-flex justify-content-center align-items-center fw-bold border border-1 border-dark-subtle rounded-1"
                            id="we-bs-review-software-providers-trigger">

                            + <?= $software_providers_count ?>

                        </div>

                    </div>

                    <?php endif; ?>

                </div>

                <?php endif; ?>

                <?php endif; ?>

            </div>

        </div>

        <?php endif; ?>

        <?php endforeach; ?>

    </div>

    <div class="col-12 col-lg-4">

        <div class="row">

            <div class="col-12">

                <?= Widgets::top_brands(array_slice(self::$top_betting_sites, 0, 5)) ?>

            </div>

            <div class="col-12">

                <?= Widgets::latest_news() ?>

            </div>

            <div class="col-12 mb-5">

                <?= Widgets::top_betting_sites_list(array_slice(self::$top_betting_sites, 0, 20)) ?>

            </div>

            <div class="col-12">

                <?= Widgets::top_bonuses(array_slice(self::$top_betting_sites, 0, 5)) ?>

            </div>

        </div>

    </div>

</div>

<?php

        return ob_get_clean();

    }



    /**

     * @param We_M_Betting_Site $betting_site

     *

     * @return false|string

     */

    public static function faq(BettingSite $betting_site): false|string
    {

        $faq = $betting_site->get_faq();

        ob_start();

        ?>

<?php if (! empty($faq)): ?>

<div class="row mt-4">

    <div class="col-12">

        <h3 class="fw-bold text-uppercase fs-5 mb-0">FAQS</h3>

    </div>

    <div class="col-12">

        <ol class="list-group list-group-numbered ps-0">

            <?php foreach ($faq as $data_set): ?>

            <?php if (! empty($data_set)): ?>

            <li class="list-group-item d-flex justify-content-between align-items-start py-4">

                <div class="ms-2 me-auto">

                    <div class="fw-bold mb-2">

                        <?= $data_set['question'] ?>

                    </div>

                    <?= $data_set['answer'] ?>

                </div>

            </li>

            <?php endif; ?>

            <?php endforeach; ?>

        </ol>

    </div>

</div>

<?php endif; ?>

<?php

        return ob_get_clean();

    }



    /**

     * @param array $args

     *

     * @return false|string

     */

    public static function content(array $args): false|string
    {

        if (! empty($args['id']) && is_numeric($args['id'])) {

            $post = get_post($args['id']);

        }

        if (empty($post) || ! $post instanceof WP_Post) {

            wp_redirect(get_bloginfo('url'));

            exit();

        }

        $betting_site = new BettingSite($post);

        self::init($betting_site);

        ob_start();

        ?>

<style>



</style>

<div class="container-fluid">

    <?= self::header($betting_site) ?>

    <?= self::summary($betting_site) ?>

    <?= self::reviews_navigation($betting_site); ?>

    <?= self::reviews($betting_site) ?>

    <?= self::faq($betting_site) ?>

</div>

<script>
function toggleExtraContent(e) {

    const toggleTarget = e.target.getAttribute('data-toggle');

    if (toggleTarget) {

        document.getElementById(toggleTarget).classList.toggle('d-none');

    }

}



const extraPaymentMethodsToggle = document.querySelector('div[data-toggle="we-bs-x-pm-0"]');

if (extraPaymentMethodsToggle) {

    extraPaymentMethodsToggle.addEventListener('click', toggleExtraContent, false)

}
</script>

<?php

        return ob_get_clean();

    }

}
