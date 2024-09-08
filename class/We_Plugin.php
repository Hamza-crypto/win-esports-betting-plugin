<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_Cpt_Betting_Site as CptBettingSite;
use We_Taxonomy as Taxonomy;
use We_Admin as Admin;

class We_Plugin {

	/**
	 * @hooked init
	 * @return void
	 */
	public static function init(): void {
		Taxonomy::init();
		CptBettingSite::create();
		We_Shortcodes::init();
	}

	/**
	 * @hooked carbon_fields_register_fields
	 * @return void
	 */
	public static function register_fields(): void {
		Taxonomy::register_fields();
		CptBettingSite::register_fields();
	}

	/**
	 * @hooked admin_menu
	 * @return void
	 */
	public static function create_admin_menu(): void {
		Admin::create_root_menu();
	}

	/**
	 * @hooked wp_enqueue_scripts
	 * @return void
	 */
	public static function enqueue_scripts(): void {
		We_Public::enqueue_scripts();
	}

	/**
	 * @hooked
	 * @return void
	 */
	public static function admin_enqueue_scripts(): void {
		Admin::enqueue_scripts();
	}

	/**
	 * @hooked wp_insert_post_data
	 *
	 * @param array $data
	 * @param array $postarr
	 *
	 * @return array
	 */
	public static function insert_post_data_betting_site( array $data, array $postarr ): array {
		return CptBettingSite::insert_post_data( $data, $postarr );
	}

}