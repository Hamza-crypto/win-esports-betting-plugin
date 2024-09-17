<?php



if (! defined('ABSPATH')) {

    die();

}



class We_Cpt_Betting_Site_Meta_Keys
{
    public static string $key_prefix = 'websf_';



    /**

     * @return string

     */

    public static function categories_key(): string
    {

        return self::$key_prefix . 'categories';

    }



    /**

     * @return string

     */

    public static function display_order_key(): string
    {

        return self::$key_prefix . 'display_order';

    }


    /**
     * @return string
     */
    public static function display_featured_tag_key(): string
    {
        return self::$key_prefix . 'featured_tag';
    }


    /**

     * @return string

     */

    public static function is_exclusive_key(): string
    {

        return self::$key_prefix . 'is_exclusive';

    }



    /**

     * @return string

     */

    public static function is_hot_key(): string
    {

        return self::$key_prefix . 'is_hot';

    }



    /**

     * @return string

     */

    public static function is_recommended_key(): string
    {

        return self::$key_prefix . 'is_recommended';

    }



    /**

     * @return string

     */

    public static function cta_label_key(): string
    {

        return self::$key_prefix . 'cta_label';

    }



    /**

     * @return string

     */

    public static function logo_bg_color_key(): string
    {

        return self::$key_prefix . 'logo_bg_color';

    }



    /**

     * @return string

     */

    public static function tc_apply_key(): string
    {

        return self::$key_prefix . 'tc_apply_18';

    }



    /**

     * @return string

     */

    public static function play_terms_key(): string
    {

        return self::$key_prefix . 'play_terms';

    }



    /**

     * @return string

     */

    public static function featured_bonus_key(): string
    {

        return self::$key_prefix . 'featured_bonus';

    }



    /**

     * @return void

     */

    public static function all_bonus_key(): string
    {

        return self::$key_prefix . 'all_bonus';

    }



    /**

     * @return string

     */

    public static function payment_methods_key(): string
    {

        return self::$key_prefix . 'payment_methods';

    }



    /**

     * @return string

     */

    public static function withdrawal_key(): string
    {

        return self::$key_prefix . 'withdrawal';

    }



    /**

     * @return string

     */

    public static function license_key(): string
    {

        return self::$key_prefix . 'license';

    }



    /**

     * @return string

     */

    public static function award_key(): string
    {

        return self::$key_prefix . 'award';

    }



    /**

     * @return string

     */

    public static function android_available_key(): string
    {

        return self::$key_prefix . 'android_available';

    }



    /**

     * @return string

     */

    public static function ios_available_key(): string
    {

        return self::$key_prefix . 'ios_available';

    }



    /**

     * @return string

     */

    public static function company_key(): string
    {

        return self::$key_prefix . 'company';

    }



    /**

     * @return string

     */

    public static function founded_key(): string
    {

        return self::$key_prefix . 'founded';

    }



    /**

     * @return string

     */

    public static function website_key(): string
    {

        return self::$key_prefix . 'website';

    }



    /**

     * @return string

     */

    public static function countries_key(): string
    {

        return self::$key_prefix . 'countries';

    }



    /**

     * @return string

     */

    public static function available_languages_key(): string
    {

        return self::$key_prefix . 'available_languages';

    }


    public static function restricted_countries_key(): string
    {

        return self::$key_prefix . 'restricted_countries';

    }



    /**

     * @return string

     */

    public static function customer_support_key(): string
    {

        return self::$key_prefix . 'customer_support';

    }



    /**

     * @return string

     */

    public static function email_key(): string
    {

        return self::$key_prefix . 'email';

    }



    /**

     * @return string

     */

    public static function phone_key(): string
    {

        return self::$key_prefix . 'phone';

    }



    /**

     * @return string

     */

    public static function verified_by_key(): string
    {

        return self::$key_prefix . 'verified_by';

    }



    /**

     * @return string

     */

    public static function transaction_speed_key(): string
    {

        return self::$key_prefix . 'transaction_speed';

    }



    /**

     * @return string

     */

    public static function safety_score_key(): string
    {

        return self::$key_prefix . 'safety_score';

    }



    /**

     * @return string

     */

    public static function currencies_key(): string
    {

        return self::$key_prefix . 'currencies';

    }



    /**

     * @return string

     */

    public static function crypto_key(): string
    {

        return self::$key_prefix . 'crypto';

    }



    /**

     * @return string

     */

    public static function software_providers_key(): string
    {

        return self::$key_prefix . 'software_providers';

    }



    /**

     * @return string

     */

    public static function slots_key(): string
    {

        return self::$key_prefix . 'slots';

    }



    /**

     * @return string

     */

    public static function review_title_key(): string
    {

        return self::$key_prefix . 'rev_title';

    }



    /**

     * @return string

     */

    public static function review_subtitle_key(): string
    {

        return self::$key_prefix . 'rev_subtitle';

    }



    /**

     * @return string

     */

    public static function review_intro_key(): string
    {

        return self::$key_prefix . 'rev_intro';

    }



    /**

     * @return string

     */

    public static function review_pros_key(): string
    {

        return self::$key_prefix . 'rev_pros';

    }



    /**

     * @return string

     */

    public static function review_cons_key(): string
    {

        return self::$key_prefix . 'rev_cons';

    }



    /**

     * @return string

     */

    public static function rating_overall_key(): string
    {

        return self::$key_prefix . 'rat_overall';

    }



    /**

     * @return string

     */

    public static function rating_bonus_offer_key(): string
    {

        return self::$key_prefix . 'rat_bf';

    }



    /**

     * @return string

     */

    public static function rating_usability_key(): string
    {

        return self::$key_prefix . 'rat_ux';

    }



    /**

     * @return string

     */

    public static function rating_payment_methods_key(): string
    {

        return self::$key_prefix . 'rat_pm';

    }



    /**

     * @return string

     */

    public static function rating_customer_service_key(): string
    {

        return self::$key_prefix . 'rat_cs';

    }



    /**

     * @return string

     */

    public static function rating_license_and_security_key(): string
    {

        return self::$key_prefix . 'rat_ls';

    }



    /**

     * @return string

     */

    public static function rating_rewards_program_key(): string
    {

        return self::$key_prefix . 'rat_rlp';

    }



    public static function review_bonus_key(): string
    {

        return self::$key_prefix . 'rev_bonus';

    }



    public static function review_usability_key(): string
    {

        return self::$key_prefix . 'rev_usability';

    }



    public static function review_payment_key(): string
    {

        return self::$key_prefix . 'rev_payment';

    }



    public static function review_service_key(): string
    {

        return self::$key_prefix . 'rev_service';

    }



    public static function review_licensing_key(): string
    {

        return self::$key_prefix . 'rev_licensing';

    }



    public static function review_rewards_key(): string
    {

        return self::$key_prefix . 'rev_rewards';

    }



    public static function review_sports_key(): string
    {

        return self::$key_prefix . 'rev_sports';

    }



    public static function review_casino_key(): string
    {

        return self::$key_prefix . 'rev_casino';

    }



    public static function review_esports_key(): string
    {

        return self::$key_prefix . 'rev_esports';

    }



    public static function review_poker_key(): string
    {

        return self::$key_prefix . 'rev_poker';

    }



    public static function review_conclusion_key(): string
    {

        return self::$key_prefix . 'rev_conclusion';

    }



    /**

     * @return string

     */

    public static function faq_key(): string
    {

        return self::$key_prefix . 'faq';

    }



    /**

     * @return string

     */

    public static function esport_games_key(): string
    {

        return self::$key_prefix . 'esport_games';

    }



    /**

     * @return string

     */

    public static function sport_games_key(): string
    {

        return self::$key_prefix . 'sport_games';

    }



    /**

     * @return string

     */

    public static function casino_games_key(): string
    {

        return self::$key_prefix . 'casino_games';

    }

}
