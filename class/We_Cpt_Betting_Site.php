<?php

if (! defined('ABSPATH')) {

    die();

}



use We_Cpt_Betting_Site_Meta_Keys as MetaKeys;
use We_Shortcodes as Shortcodes;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

class We_Cpt_Betting_Site
{
    public static string $slug = 'wecptbs';



    /**

     * @hooked init

     * @return void

     */

    public static function create(): void
    {



        $args = [

            'label'               => esc_html__('Bettings Sites', 'winesports'),

            'labels'              => [

                'menu_name'          => esc_html__('Bettings Sites', 'winesports'),

                'name_admin_bar'     => esc_html__('Betting Site', 'winesports'),

                'add_new'            => esc_html__('Add Betting Site', 'winesports'),

                'add_new_item'       => esc_html__('Add new Betting Site', 'winesports'),

                'new_item'           => esc_html__('New Betting Site', 'winesports'),

                'edit_item'          => esc_html__('Edit Betting Site', 'winesports'),

                'view_item'          => esc_html__('View Betting Site', 'winesports'),

                'update_item'        => esc_html__('View Betting Site', 'winesports'),

                'all_items'          => esc_html__('All Bettings Sites', 'winesports'),

                'search_items'       => esc_html__('Search Bettings Sites', 'winesports'),

                'parent_item_colon'  => esc_html__('Parent Betting Site', 'winesports'),

                'not_found'          => esc_html__('No Bettings Sites found', 'winesports'),

                'not_found_in_trash' => esc_html__('No Bettings Sites found in Trash', 'winesports'),

                'name'               => esc_html__('Bettings Sites', 'winesports'),

                'singular_name'      => esc_html__('Betting Site', 'winesports'),

            ],

            'public'              => true,

            'exclude_from_search' => false,

            'publicly_queryable'  => true,

            'show_ui'             => true,

            'show_in_nav_menus'   => true,

            'show_in_admin_bar'   => true,

            'show_in_rest'        => true,

            'capability_type'     => 'post',

            'hierarchical'        => false,

            'has_archive'         => true,

            'query_var'           => 'betting-site',

            'can_export'          => true,

            'rewrite_no_front'    => false,

            'show_in_menu'        => true,

            'supports'            => [

                'title',

                'editor',

                'thumbnail',

                'custom-fields',

                'page-attributes',

            ],

            'taxonomies'          => [

                We_Taxonomy::$betting_site_category_slug,

                We_Taxonomy::$betting_site_payment_provider_slug,

                We_Taxonomy::$betting_site_esport_game_slug,

                We_Taxonomy::$betting_site_crypto_currency_slug,

                We_Taxonomy::$betting_site_software_provider_slug

            ],

            'rewrite'             => array( 'slug' => 'betting-sites' )

        ];

        register_post_type(self::$slug, $args);

    }



    /**

     * @hooked carbon_fields_register_fields

     * @return void

     */

    public static function register_fields(): void
    {

        self::register_categories_fields();

        self::register_esport_games_fields();

        self::register_sport_games_fields();

        self::register_casino_games_fields();

        self::register_regional_fields();

        self::register_bonus_fields();

        self::register_payments_fields();

        self::register_software_providers_fields();

        self::register_ratings_fields();

        self::register_custom_sort_fields();

        self::register_display_fields();
        self::register_display_featured_tags_fields();
        self::register_info_fields();

        self::register_reviews_fields();

        self::register_reviews_content_fields();

        self::register_faq_fields();

    }



    /**

     * @return void

     */

    public static function register_categories_fields(): void
    {

        Container::make('post_meta', 'Categories')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('association', MetaKeys::categories_key(), 'Select Categories')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_category_slug

                              )

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_esport_games_fields(): void
    {

        Container::make('post_meta', 'Esport Games')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('association', MetaKeys::esport_games_key(), 'Select ESport Games')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_esport_game_slug

                              )

                          ))

                 ));

    }


    /**
         * @return void
         */
    public static function register_display_featured_tags_fields(): void
    {
        Container::make('post_meta', 'Featured Tag')
                         ->where('post_type', '=', self::$slug)
                         ->add_fields(array(
                             Field::make('text', MetaKeys::display_featured_tag_key(), 'Tag')
                         ));

    }

    /**

     * @return void

     */

    public static function register_sport_games_fields(): void
    {

        Container::make('post_meta', 'Sport Games')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('association', MetaKeys::sport_games_key(), 'Select Sport Games')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_sport_game_slug

                              )

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_casino_games_fields(): void
    {

        Container::make('post_meta', 'Casino Games')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('association', MetaKeys::casino_games_key(), 'Select Casino Games')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_casino_game_slug

                              )

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_info_fields(): void
    {



        Container::make('post_meta', 'Details')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('text', MetaKeys::website_key(), 'Website'),

                     Field::make('text', MetaKeys::company_key(), 'Company'),

                     Field::make('text', MetaKeys::founded_key(), 'Founded'),

                     Field::make('text', MetaKeys::phone_key(), 'Phone'),

                     Field::make('text', MetaKeys::email_key(), 'Email')

                          ->set_attribute('type', 'email'),

                     Field::make('image', MetaKeys::license_key(), 'License'),

                     Field::make('text', MetaKeys::award_key(), 'Award'),

                     Field::make('text', MetaKeys::withdrawal_key(), 'Withdrawal'),

                     Field::make('text', MetaKeys::verified_by_key(), 'Verified By'),

                     Field::make('text', MetaKeys::transaction_speed_key(), 'Transaction Speed'),

                     Field::make('text', MetaKeys::safety_score_key(), 'Safety Score'),

                     Field::make('text', MetaKeys::slots_key(), 'Number of Slots')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0),

                     Field::make('checkbox', MetaKeys::android_available_key(), 'Available on Android'),

                     Field::make('checkbox', MetaKeys::ios_available_key(), 'Available on iOS'),

                     Field::make('complex', MetaKeys::customer_support_key(), 'Customer Support')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('text', 'support', 'Support Type')

                          ))

                          ->set_default_value(array(

                              array( 'support' => 'Live Chat' ),

                              array( 'support' => 'Phone' ),

                              array( 'support' => 'Email Support' ),

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_custom_sort_fields(): void
    {

        Container::make('post_meta', 'Manual Sort')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('text', MetaKeys::display_order_key(), 'Position')

                          ->set_help_text('Lower values display first.')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_default_value(PHP_INT_MAX)

                 ));

    }



    /**

     * @return void

     */

    public static function register_display_fields(): void
    {

        Container::make('post_meta', 'Display')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('checkbox', MetaKeys::is_hot_key(), 'Hot')

                          ->set_conditional_logic(array(

                              array( 'field' => MetaKeys::is_exclusive_key(), 'value' => false ),

                              array( 'field' => MetaKeys::is_recommended_key(), 'value' => false )

                          )),

                     Field::make('checkbox', MetaKeys::is_exclusive_key(), 'Exclusive')

                          ->set_conditional_logic(array(

                              array( 'field' => MetaKeys::is_hot_key(), 'value' => false ),

                              array( 'field' => MetaKeys::is_recommended_key(), 'value' => false )

                          )),

                     Field::make('checkbox', MetaKeys::is_recommended_key(), 'Recommended')

                          ->set_conditional_logic(array(

                              array( 'field' => MetaKeys::is_hot_key(), 'value' => false ),

                              array( 'field' => MetaKeys::is_exclusive_key(), 'value' => false )

                          )),

                     Field::make('text', MetaKeys::cta_label_key(), 'CTA Label')

                          ->set_default_value('bet now'),

                     Field::make('text', MetaKeys::tc_apply_key(), 'T&Cs'),

                     Field::make('color', MetaKeys::logo_bg_color_key(), 'Logo Background Color')

                          ->set_default_value('#000000'),

                     Field::make('rich_text', MetaKeys::play_terms_key(), 'Terms & Conditions')

                 ));

    }



    /**

     * @return void

     */

    public static function register_bonus_fields(): void
    {

        Container::make('post_meta', 'Bonus')

                 ->where('post_type', '=', self::$slug)

                 ->add_tab('Featured', array(

                     Field::make('complex', MetaKeys::featured_bonus_key(), 'Featured Bonus')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('select', 'country', 'Country')

                                   ->set_options(We_Utils::$countries),

                              Field::make('association', 'category', 'Category')

                                   ->set_types(array(

                                       array(

                                           'type'     => 'term',

                                           'taxonomy' => We_Taxonomy::$betting_site_category_slug

                                       )

                                   )),

                              Field::make('text', 'code', 'Code'),

                              Field::make('rich_text', 'title', 'Title'),

                              Field::make('text', 'link', 'Link'),

                              Field::make('complex', 'features', 'Features')

                                   ->set_layout('tabbed-vertical')

                                   ->add_fields(array(

                                       Field::make('rich_text', 'feature', 'Feature')

                                   ))

                          )),

                 ));

    }



    /**

     * @return void

     */

    public static function register_payments_fields(): void
    {



        Container::make('post_meta', 'Payment')

                 ->where('post_type', '=', self::$slug)

                 ->add_tab('Payment Methods', array(

                     Field::make('complex', MetaKeys::payment_methods_key(), 'Payment Methods')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('association', 'provider', 'Payment Provider')

                                   ->set_types(array(

                                       array(

                                           'type'     => 'term',

                                           'taxonomy' => We_Taxonomy::$betting_site_payment_provider_slug

                                       )

                                   )),

                              Field::make('text', 'deposit', 'Deposit min/max'),

                              Field::make('text', 'withdrawal', 'Withdrawal min/max'),

                              Field::make('text', 'deposit_time', 'Deposit time'),

                              Field::make('text', 'withdrawal_time', 'Withdrawal time'),

                              Field::make('text', 'safety', 'Safety'),

                          ))

                 ))

                 ->add_tab('Accepted Currencies', array(

                     Field::make('multiselect', MetaKeys::currencies_key(), 'Currency')

                          ->set_options(We_Utils::$currencies)

                 ))

                 ->add_tab('Accepted Crypto Currencies', array(

                     Field::make('association', MetaKeys::crypto_key(), 'Crypto Currency')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_crypto_currency_slug

                              )

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_software_providers_fields(): void
    {

        Container::make('post_meta', 'Software Providers')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('association', MetaKeys::software_providers_key(), 'Select Software Providers')

                          ->set_types(array(

                              array(

                                  'type'     => 'term',

                                  'taxonomy' => We_Taxonomy::$betting_site_software_provider_slug

                              )

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_regional_fields(): void
    {

        Container::make('post_meta', 'Regional')

                 ->where('post_type', '=', self::$slug)

                 ->add_tab('Available Countries', array(

                     Field::make('multiselect', MetaKeys::countries_key(), 'Country')

                          ->set_options(We_Utils::$countries)

                 ))

                 ->add_tab('Available Languages', array(

                     Field::make('multiselect', MetaKeys::available_languages_key(), 'Language')

                          ->set_options(We_Utils::$languages)

                 ))

                 ->add_tab('Restricted Countries', array(

                     Field::make('multiselect', MetaKeys::restricted_countries_key(), 'Restricted Country')

                          ->set_options(We_Utils::$countries)

                 ));

    }



    /**

     * @return void

     */

    public static function register_ratings_fields(): void
    {

        Container::make('post_meta', 'Ratings')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('text', MetaKeys::rating_overall_key(), 'Overall')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_bonus_offer_key(), 'Bonus Offers & Free Bets')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_usability_key(), 'Usability, Look & Feel')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_payment_methods_key(), 'Payment Methods')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_customer_service_key(), 'Customer Service')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_license_and_security_key(), 'Licence & Security')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                     Field::make('text', MetaKeys::rating_rewards_program_key(), 'Rewards & Loyalty Program')

                          ->set_attribute('type', 'number')

                          ->set_attribute('min', 0)

                          ->set_attribute('max', 5)

                          ->set_attribute('step', 0.1),

                 ));

    }



    /**

     * @return void

     */

    public static function register_reviews_fields(): void
    {

        Container::make('post_meta', 'Review Header')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('text', MetaKeys::review_title_key(), 'Title'),

                     Field::make('text', MetaKeys::review_subtitle_key(), 'Sub Title'),

                     Field::make('rich_text', MetaKeys::review_intro_key(), 'Introduction'),

                     Field::make('complex', MetaKeys::review_pros_key(), 'Pros')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('text', 'text', 'Text')

                          )),

                     Field::make('complex', MetaKeys::review_cons_key(), 'Cons')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('text', 'text', 'Text')

                          ))

                 ));

    }



    /**

     * @return void

     */

    public static function register_reviews_content_fields(): void
    {

        Container::make('post_meta', 'Review Content')

                 ->where('post_type', '=', self::$slug)

                 ->add_tab('Bonus', array(

                     Field::make('rich_text', MetaKeys::review_bonus_key(), 'Bonus')

                 ))

                 ->add_tab('Usability', array(

                     Field::make('rich_text', MetaKeys::review_usability_key(), 'Usability')

                 ))

                 ->add_tab('Payment', array(

                     Field::make('rich_text', MetaKeys::review_payment_key(), 'Payment')

                 ))

                 ->add_tab('Service', array(

                     Field::make('rich_text', MetaKeys::review_service_key(), 'Service')

                 ))

                 ->add_tab('Licensing', array(

                     Field::make('rich_text', MetaKeys::review_licensing_key(), 'Licensing')

                 ))

                 ->add_tab('Rewards', array(

                     Field::make('rich_text', MetaKeys::review_rewards_key(), 'Rewards')

                 ))

                 ->add_tab('Sports', array(

                     Field::make('rich_text', MetaKeys::review_sports_key(), 'Sports')

                 ))

                 ->add_tab('Casino', array(

                     Field::make('rich_text', MetaKeys::review_casino_key(), 'Casino')

                 ))

                 ->add_tab('Esports', array(

                     Field::make('rich_text', MetaKeys::review_esports_key(), 'Esports')

                 ))

                 ->add_tab('Conclusion', array(

                     Field::make('rich_text', MetaKeys::review_conclusion_key(), 'Conclusion')

                 ));

    }



    /**

     * @return void

     */

    public static function register_faq_fields(): void
    {

        Container::make('post_meta', 'FAQ')

                 ->where('post_type', '=', self::$slug)

                 ->add_fields(array(

                     Field::make('complex', MetaKeys::faq_key(), 'Content')

                          ->set_layout('tabbed-vertical')

                          ->add_fields(array(

                              Field::make('text', 'question', 'Question'),

                              Field::make('rich_text', 'answer', 'Answer')

                          ))

                 ));

    }



    /**

     * @hooked wp_insert_post_data

     *

     * @param array $data

     * @param array $postarr

     *

     * @return array

     */

    public static function insert_post_data(array $data, array $postarr): array
    {

        if ($postarr['post_type'] == self::$slug) {

            $post_id              = $postarr['ID'];

            $shortcode            = Shortcodes::$betting_site_single;

            $data['post_content'] = "[$shortcode id=\"$post_id\"]";

        }



        return $data;

    }

}
