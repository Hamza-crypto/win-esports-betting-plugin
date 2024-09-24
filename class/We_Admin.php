<?php

if (! defined('ABSPATH')) {
    die();
}

use We_Cpt_Betting_Site as CptBettingSite;
use We_Cpt_Betting_Site_Meta_Keys as MetaKeys;
use We_Taxonomy as Taxonomy;
use We_M_Betting_Site as BettingSite;

class We_Admin
{
    public static string $page_title = 'WIN Esports';
    public static string $menu_title = 'WIN ESports';
    public static string $root_menu_slug = 'we-admin-root';
    public static string $capability = 'read';
    public static int $position = 25;
    public static string $ajax_axtion_save_widgets_settings = 'we_bs_ajax_save_widgets_settings';
    public static string $ajax_action_bs_import = 'we_bs_ajax_import';

    /**
     * @return void
     */
    public static function root_menu_callback(): void
    {
        include_once WE_PLUGIN_DIR . 'admin/root.php';
    }

    /**
     * @hooked admin_menu
     * @return void
     */
    public static function create_root_menu(): void
    {
        add_menu_page(
            self::$page_title,
            self::$menu_title,
            self::$capability,
            self::$root_menu_slug,
            array( self::class, 'root_menu_callback' ),
            '',
            self::$position
        );
    }

    /**
     * @hooked wp_ajax_we_bs_ajax_save_widgets_settings
     * @return void
     */
    public static function handle_ajax_action_save_widgets_settings(): void
    {
        check_ajax_referer(self::$ajax_axtion_save_widgets_settings);
        if (empty($_POST['data'])) {
            http_response_code(400);
            echo 'Bad request';
            exit();
        }

        try {
            $keys = array(
                We_Widgets::$all_betting_sites_url_meta_key,
                We_Widgets::$top_bonuses_title_meta_key,
                We_Widgets::$top_brands_title_meta_key,
                We_Widgets::$latest_new_category_meta_key
            );
            foreach ($_POST['data'] as $key => $value) {
                if (in_array($key, $keys)) {
                    update_option($key, $value);
                }
            }
            We_Widgets::init();
        } catch (Exception $ex) {
            http_response_code(500);
            echo json_encode(array(
                'code'    => $ex->getCode(),
                'message' => $ex->getMessage()
            ));
            exit();
        }

        http_response_code(200);
        echo 'OK';
        exit();
    }

    /**
     * @hooked wp_ajax_we_bs_ajax_import
     * @return void
     */
    public static function handle_ajax_action_bs_import(): void
    {
        check_ajax_referer(self::$ajax_action_bs_import);
        if (empty($_POST['data'])) {
            http_response_code(400);
            echo 'Bad request';
            exit();
        }
        try {
            $betting_site_data = $_POST['data'];
            if (! empty($betting_site_data['Name'])) {
                $post_id = self::primary_import($betting_site_data);
            }
            if (! empty($betting_site_data['Affiliate Link'])) {
                self::secondary_import($betting_site_data, $post_id);
            }

        } catch (Exception $ex) {
            http_response_code(500);
            echo json_encode(array(
                'code'    => $ex->getCode(),
                'message' => $ex->getMessage()
            ));
            exit();
        }

        http_response_code(200);
        echo 'OK';
        exit();
    }

    /**
     * @param array $betting_site_data
     *
     * @return void
     */
    public static function primary_import(array $betting_site_data)
    {
        $betting_site_slug = sanitize_title($betting_site_data['Name']);
        $existing_post     = get_page_by_path($betting_site_slug, OBJECT, CptBettingSite::$slug);
        $existing_post_id  = empty($existing_post) ? 0 : $existing_post->ID;
        $post_args         = array(
            'ID'          => $existing_post_id,
            'post_title'  => $betting_site_data['Name'],
            'post_status' => 'draft',
            'post_type'   => CptBettingSite::$slug,
        );
        $post_id           = wp_insert_post($post_args);
        if (empty($existing_post_id)) {
            $post_args['ID'] = $post_id;
            wp_update_post($post_args);
        }
        $post = get_post($post_id);

        $betting_site = new BettingSite($post);
        $betting_site->set_available_countries();
        $betting_site->set_display_order();

        if (! empty($betting_site_data['Image'])) {
            $betting_site->set_post_thumbnail($betting_site_data['Image']);
        }
        if (! empty($betting_site_data['Style'])) {
            $betting_site_logo_bg_color = trim(str_replace("background-color:", "", $betting_site_data['Style']));
            $betting_site->set_logo_bg_color($betting_site_logo_bg_color);
        }

        if (! empty($betting_site_data['Score'])) {
            $betting_site->set_ratings($betting_site_data['Score']);
        }

        if (! empty($betting_site_data['Title'])) {
            $betting_site_review_title_parts = explode("\n", $betting_site_data['Title']);
            $betting_site->set_review_title(
                count($betting_site_review_title_parts) >= 1 ?
                    $betting_site_review_title_parts[0] : ''
            );
            $betting_site->set_review_subtitle(
                count($betting_site_review_title_parts) >= 2 ?
                    $betting_site_review_title_parts[1] : ''
            );
        }

        $betting_site->set_reviews($betting_site_data);

        if (! empty($betting_site_data['Detail'])) {
            $betting_site->set_text_field(MetaKeys::review_intro_key(), $betting_site_data['Detail']);
        }

        if (! empty($betting_site_data['Award'])) {
            $betting_site->set_text_field(MetaKeys::award_key(), $betting_site_data['Award']);
        }

        if (! empty($betting_site_data['Company'])) {
            $betting_site->set_text_field(MetaKeys::company_key(), $betting_site_data['Company']);
        }

        if (! empty($betting_site_data['Founded'])) {
            $betting_site->set_text_field(MetaKeys::founded_key(), $betting_site_data['Founded']);
        }

        if (! empty($betting_site_data['Website'])) {
            $betting_site->set_text_field(MetaKeys::website_key(), $betting_site_data['Website']);
        }

        if (! empty($betting_site_data['Email'])) {
            $betting_site->set_text_field(MetaKeys::email_key(), $betting_site_data['Email']);
        }

        if (! empty($betting_site_data['Phone'])) {
            $betting_site->set_text_field(MetaKeys::phone_key(), $betting_site_data['Phone']);
        }

        if (! empty($betting_site_data['Withdrawal'])) {
            $betting_site->set_text_field(MetaKeys::withdrawal_key(), $betting_site_data['Withdrawal']);
        }

        if (! empty($betting_site_data['Verified By'])) {
            $betting_site->set_text_field(MetaKeys::verified_by_key(), $betting_site_data['Verified By']);
        }

        if (! empty($betting_site_data['Transaction Speed'])) {
            $betting_site->set_text_field(MetaKeys::transaction_speed_key(), $betting_site_data['Transaction Speed']);
        }

        if (! empty($betting_site_data['Safety Score'])) {
            $betting_site->set_text_field(MetaKeys::safety_score_key(), $betting_site_data['Safety Score']);
        }

        if (! empty($betting_site_data['Number Of Slots'])) {
            $betting_site->set_text_field(MetaKeys::slots_key(), $betting_site_data['Number Of Slots']);
        }

        if (! empty($betting_site_data['License'])) {
            $betting_site->set_license($betting_site_data['License']);
        }

        if (! empty($betting_site_data['Available Languages'])) {
            $betting_site->set_available_languages($betting_site_data['Available Languages']);
        }

        if (! empty($betting_site_data['Customer Support'])) {
            $betting_site->set_customer_support($betting_site_data['Customer Support']);
        }

        if (! empty($betting_site_data['Software Providers'])) {
            $betting_site->set_software_providers($betting_site_data['Software Providers']);
        }

        if (! empty($betting_site_data['Payement Method'])) {
            $betting_site->set_payment_providers($betting_site_data['Payement Method']);
        }

        if (! empty($betting_site_data ['Table Of Payement'])) {
            $betting_site->set_payment_methods($betting_site_data['Table Of Payement']);
        }

        $available_categories = array();
        if (! empty($betting_site_data['Casino'])) {
            $available_categories[] = 'Casino';
        }
        if (! empty($betting_site_data['Sport'])) {
            $available_categories[] = 'Sports';
        }
        if (! empty($betting_site_data['Esports'])) {
            $available_categories[] = 'Esports';
        }
        if (! empty($available_categories)) {
            $betting_site->set_association(
                $available_categories,
                Taxonomy::$betting_site_category_slug,
                MetaKeys::categories_key()
            );
        }

        if (! empty($betting_site_data['Available Currency'])) {
            $currencies = explode(",", $betting_site_data['Available Currency']);
            $currencies = array_filter($currencies, function ($item) {
                return ! empty($item);
            });
            $currencies = array_values($currencies);
            $betting_site->set_association(
                $currencies,
                Taxonomy::$betting_site_crypto_currency_slug,
                MetaKeys::crypto_key()
            );
        }

        if (! empty($betting_site_data['Jeu'])) {
            $esport_games = explode(",", $betting_site_data['Jeu']);
            $esport_games = array_filter($esport_games, function ($item) {
                return ! empty($item);
            });
            $esport_games = array_values($esport_games);
            $esport_games = array_map(function ($item) {
                return trim(str_replace("Betting Sites", "", $item));
            }, $esport_games);
            $betting_site->set_association(
                $esport_games,
                Taxonomy::$betting_site_esport_game_slug,
                MetaKeys::esport_games_key()
            );
        }

        $betting_site->set_bonus($betting_site_data);

        return $post_id;
    }

    /**
     * @param array $betting_site_data
     *
     * @return void
     */
    public static function secondary_import(array $betting_site_data, $post_id): void
    {
        $betting_site_slug = sanitize_title(trim($betting_site_data['Casino/betting site']));
        $existing_post     = get_page_by_path($betting_site_slug, OBJECT, CptBettingSite::$slug);
        if (empty($existing_post)) {
            return;
        }
        $betting_site = new BettingSite($existing_post);
        if (! empty($betting_site_data['Affiliate link'])) {
            $link = trim($betting_site_data['Affiliate link']);
            if (! empty($link)) {
                $categories = $betting_site->get_categories();
                $all_bonus  = array();
                foreach ($categories as $category) {
                    $bonus = $betting_site->get_featured_bonus($category['id']);
                    if (! empty($bonus)) {
                        $all_bonus[] = $bonus;
                    }
                }
                if (! empty($all_bonus)) {
                    foreach ($all_bonus as &$bonus) {
                        $bonus['link'] = $link;
                        $features      = array();
                        foreach ($bonus['features'] as $feature) {
                            $features[] = array( 'feature' => $feature );
                        }
                        $bonus['features'] = $features;
                    }
                    wp_update_post(array( 'ID' => $betting_site->post->ID, 'post_status' => 'publish' ));
                    carbon_set_post_meta($betting_site->post->ID, MetaKeys::featured_bonus_key(), $all_bonus);
                }
            }
        }

        if (! empty($betting_site_data['GEOs'])) {

            $all_countries        = array_keys(We_Utils::$countries);
            $available_countries  = array();
            $restricted_countries = array();

            $available_countries_string = trim(strtoupper($betting_site_data['GEOs']));
            if ($available_countries_string == 'ALL') {
                $available_countries = array_filter($all_countries, function ($country_code) {
                    return ! empty($country_code) && $country_code != 'DEFAULT';
                });
                $available_countries = array_values($available_countries);
            } else {
                $available_countries = explode(",", $available_countries_string);
                $available_countries = array_map(function ($country_code) {
                    return trim(strtoupper($country_code));
                }, $available_countries);
                $available_countries = array_filter($available_countries, function ($country_code) {
                    return ! empty($country_code) && strlen($country_code) < 3;
                });
                $available_countries = array_values($available_countries);
            }

            if (! empty($betting_site_data['Restricted GEOs'])) {
                $restricted_countries_string = trim(strtoupper($betting_site_data['Restricted GEOs']));
                $restricted_countries        = explode(",", $restricted_countries_string);
                $restricted_countries        = array_map(function ($country_code) {
                    return trim(strtoupper($country_code));
                }, $restricted_countries);
                $restricted_countries        = array_filter($restricted_countries, function ($country_code) {
                    return ! empty($country_code) && strlen($country_code) < 3;
                });
                $restricted_countries        = array_values($restricted_countries);
            }

            $result = array();
            if (! empty($restricted_countries)) {
                $result = array_diff($available_countries, $restricted_countries);
            } else {
                $result = $available_countries;
            }
            carbon_set_post_meta($betting_site->post->ID, MetaKeys::countries_key(), $result);
        }

        if (! empty($betting_site_data['Disclaimer'])) {
            $disclaimer = trim(htmlspecialchars_decode($betting_site_data['Disclaimer']));
            carbon_set_post_meta($betting_site->post->ID, MetaKeys::play_terms_key(), $disclaimer);
        }

        if (! empty($betting_site_data['Affiliate Link'])) {
            update_post_meta($post_id, '_websf_featured_bonus|link|0|0|value', $betting_site_data['Affiliate Link']);
        }
    }

    /**
     * @hooked admin_enqueue_scripts
     * @return void
     */
    public static function enqueue_scripts(): void
    {
        $page = get_admin_page_parent();
        if ($page == self::$root_menu_slug) {
            wp_enqueue_style(
                'webs5css',
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
            );
            wp_enqueue_script(
                'websxlsxjs',
                'https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js',
                array(),
                false,
                array( 'in_footer' => true )
            );
            wp_enqueue_script(
                'websimportjs',
                WE_PLUGIN_URL . 'assets/js/import.js',
                array(),
                microtime(),
                array( 'in_footer' => true )
            );
            wp_enqueue_script(
                'webssavewidgetssettings',
                WE_PLUGIN_URL . 'assets/js/save-widgets-settings.js',
                array(),
                microtime(),
                array( 'in_footer' => true )
            );
            wp_localize_script(
                'websimportjs',
                'weBsImportObject',
                array(
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce'   => wp_create_nonce(self::$ajax_action_bs_import),
                    'action'  => self::$ajax_action_bs_import
                )
            );
            wp_localize_script(
                'webssavewidgetssettings',
                'weBsSaveWidgetsSettingsObject',
                array(
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'nonce'   => wp_create_nonce(self::$ajax_axtion_save_widgets_settings),
                    'action'  => self::$ajax_axtion_save_widgets_settings
                )
            );
        }


        global $post;
        if ($post->post_type == 'wecptbs') {
            wp_enqueue_script(
                'avg-rating', // Handle of the script
                WE_PLUGIN_URL . 'assets/js/avg-rating.js',
                array('jquery'), // Dependencies (jQuery in this case)
                null, // Version (null uses the theme's version)
                true // Load in footer
            );

        }

    }
}