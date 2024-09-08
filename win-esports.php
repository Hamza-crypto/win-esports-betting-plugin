<?php
/*
Plugin Name: Win Esports
Author:Adel Mahjoub
Version: 1.0.0
Requires Plugins: carbon-fields
Text Domain: winesports
Domain Path: /languages
Author URI: https://wa.me/52701854
*/

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

define( 'WE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once WE_PLUGIN_DIR . 'class/We_Plugin.php';
require_once WE_PLUGIN_DIR . 'class/We_Taxonomy.php';
require_once WE_PLUGIN_DIR . 'class/We_M_Betting_Site.php';
require_once WE_PLUGIN_DIR . 'class/We_Cpt_Betting_Site.php';
require_once WE_PLUGIN_DIR . 'class/We_Cpt_Betting_Site_Meta_Keys.php';
require_once WE_PLUGIN_DIR . 'class/We_View_Betting_Site_Card.php';
require_once WE_PLUGIN_DIR . 'class/We_View_Betting_Site.php';
require_once WE_PLUGIN_DIR . 'class/We_Utils.php';
require_once WE_PLUGIN_DIR . 'class/We_Shortcodes.php';
require_once WE_PLUGIN_DIR . 'class/We_Admin.php';
require_once WE_PLUGIN_DIR . 'class/We_Public.php';
require_once WE_PLUGIN_DIR . 'class/We_Blocks.php';
require_once WE_PLUGIN_DIR . 'class/We_Widgets.php';
require_once WE_PLUGIN_DIR . 'class/We_Footer.php';

use We_Admin as Admin;
use We_Blocks as Blocks;
use We_Cpt_Betting_Site as CptBettingSite;
use We_Plugin as Plugin;
use We_Shortcodes as Shortcodes;
use We_Taxonomy as Taxonomy;
use We_Utils as Utils;
use We_Widgets as Widgets;

register_activation_hook( __FILE__, array( Utils::class, 'create_uploaded_files_table' ) );

add_action( 'init', array( CptBettingSite::class, 'create' ), 10 );

add_action( 'init', array( Taxonomy::class, 'init' ), PHP_INT_MAX );

add_action( 'init', array( Shortcodes::class, 'init' ), PHP_INT_MAX );

add_action( 'admin_menu', array( Plugin::class, 'create_admin_menu' ) );

add_action( 'wp_enqueue_scripts', array( Plugin::class, 'enqueue_scripts' ), PHP_INT_MAX );

add_action( 'admin_enqueue_scripts', array( Plugin::class, 'admin_enqueue_scripts' ), PHP_INT_MAX );

add_action( 'enqueue_block_editor_assets', array( Blocks::class, 'enqueue_block_editor_assets' ), PHP_INT_MAX );

add_action( 'carbon_fields_register_fields', array( CptBettingSite::class, 'register_fields' ), 10 );

add_action( 'carbon_fields_register_fields', array( Taxonomy::class, 'register_fields' ), PHP_INT_MAX );

add_action( 'carbon_fields_register_fields', array( Blocks::class, 'register' ), PHP_INT_MAX );

add_filter( 'wp_insert_post_data', array( Plugin::class, 'insert_post_data_betting_site' ), PHP_INT_MAX, 2 );

add_action(
	'wp_ajax_' . Admin::$ajax_axtion_save_widgets_settings,
	array( Admin::class, 'handle_ajax_action_save_widgets_settings' )
);

add_action( 'wp_ajax_' . Admin::$ajax_action_bs_import, array( Admin::class, 'handle_ajax_action_bs_import' ) );

add_action(
	'wp_ajax_' . We_Public::$ajax_action_filter_list,
	array(
		We_Public::class,
		'handle_ajax_action_filter_list'
	)
);
add_action(
	'wp_ajax_nopriv_' . We_Public::$ajax_action_filter_list,
	array(
		We_Public::class,
		'handle_ajax_action_filter_list'
	)
);

Widgets::init();
