<?php
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class We_Taxonomy {
	public static string $betting_site_category_slug = 'wetaxbsc';
	public static string $betting_site_payment_provider_slug = 'wetaxbspp';
	public static string $betting_site_esport_game_slug = 'wetaxbseg';

	public static string $betting_site_sport_game_slug = 'wetaxbssg';
	public static string $betting_site_casino_game_slug = 'wetaxbscg';
	public static string $betting_site_software_provider_slug = 'wetaxbssp';
	public static string $betting_site_crypto_currency_slug = 'wetaxbscc';

	/**
	 * @hooked init
	 * @return void
	 */
	public static function init(): void {
		self::create_betting_site_categories();
		self::create_betting_site_sport_games();
		self::create_betting_site_esports_games();
		self::create_betting_site_casino_games();
		self::create_betting_site_payment_providers();
		self::create_betting_site_crypto_currencies();
		self::create_betting_site_software_providers();
	}

	/**
	 * @hooked carbon_fields_register_fields
	 * @return void
	 */
	public static function register_fields(): void {
		self::register_betting_site_payment_provider_fields();
		self::register_betting_site_software_provider_fields();
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_categories(): void {
		$args = [
			'label'                => esc_html__( 'Categories', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Categories', 'winesports' ),
				'all_items'                  => esc_html__( 'All Categories', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Category', 'winesports' ),
				'view_item'                  => esc_html__( 'View Category', 'winesports' ),
				'update_item'                => esc_html__( 'Update Category', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Category', 'winesports' ),
				'new_item'                   => esc_html__( 'New Category', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Category', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Category', 'winesports' ),
				'search_items'               => esc_html__( 'Search Categories', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Categories', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Categories with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Categories', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Categories', 'winesports' ),
				'not_found'                  => esc_html__( 'No Categories found', 'winesports' ),
				'name'                       => esc_html__( 'Categories', 'winesports' ),
				'singular_name'              => esc_html__( 'Category', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => true,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => true,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array( 'slug' => 'betting-sites-categories' )
		];
		register_taxonomy( self::$betting_site_category_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_payment_providers(): void {
		$args = [
			'label'                => esc_html__( 'Payment providers', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Payment providers', 'winesports' ),
				'all_items'                  => esc_html__( 'All Payment providers', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Payment provider', 'winesports' ),
				'view_item'                  => esc_html__( 'View Payment provider', 'winesports' ),
				'update_item'                => esc_html__( 'Update Payment provider', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Payment provider', 'winesports' ),
				'new_item'                   => esc_html__( 'New Payment provider', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Payment provider', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Payment provider', 'winesports' ),
				'search_items'               => esc_html__( 'Search Payment providers', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Payment providers', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Payment providers with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Payment providers', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Payment providers', 'winesports' ),
				'not_found'                  => esc_html__( 'No Payment providers found', 'winesports' ),
				'name'                       => esc_html__( 'Payment providers', 'winesports' ),
				'singular_name'              => esc_html__( 'Payment provider', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => true,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'betting-sites-payment-providers')
		];
		register_taxonomy( self::$betting_site_payment_provider_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_esports_games(): void {
		$args = [
			'label'                => esc_html__( 'Esport Games', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Esport Games', 'winesports' ),
				'all_items'                  => esc_html__( 'All Esport Games', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Esport Game', 'winesports' ),
				'view_item'                  => esc_html__( 'View Esport Game', 'winesports' ),
				'update_item'                => esc_html__( 'Update Esport Game', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Esport Game', 'winesports' ),
				'new_item'                   => esc_html__( 'New Esport Game', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Esport Game', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Esport Game', 'winesports' ),
				'search_items'               => esc_html__( 'Search Esport Games', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Esport Games', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Esport Games with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Esport Games', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Esport Games', 'winesports' ),
				'not_found'                  => esc_html__( 'No Esport Games found', 'winesports' ),
				'name'                       => esc_html__( 'Esport Games', 'winesports' ),
				'singular_name'              => esc_html__( 'Esport Game', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'esport-games')
		];
		register_taxonomy( self::$betting_site_esport_game_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}


	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_sport_games(): void {

		$args = [
			'label'                => esc_html__( 'Sport Games', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Sport Games', 'winesports' ),
				'all_items'                  => esc_html__( 'All Sport Games', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Sport Game', 'winesports' ),
				'view_item'                  => esc_html__( 'View Sport Game', 'winesports' ),
				'update_item'                => esc_html__( 'Update Sport Game', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Sport Game', 'winesports' ),
				'new_item'                   => esc_html__( 'New Sport Game', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Sport Game', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Sport Game', 'winesports' ),
				'search_items'               => esc_html__( 'Search Sport Games', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Sport Games', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Sport Games with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Sport Games', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Sport Games', 'winesports' ),
				'not_found'                  => esc_html__( 'No Sport Games found', 'winesports' ),
				'name'                       => esc_html__( 'Sport Games', 'winesports' ),
				'singular_name'              => esc_html__( 'Sport Game', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'sport-games')
		];
		register_taxonomy( self::$betting_site_sport_game_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_casino_games(): void {
		$args = [
			'label'                => esc_html__( 'Casino Games', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Casino Games', 'winesports' ),
				'all_items'                  => esc_html__( 'All Casino Games', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Casino Game', 'winesports' ),
				'view_item'                  => esc_html__( 'View Casino Game', 'winesports' ),
				'update_item'                => esc_html__( 'Update Casino Game', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Casino Game', 'winesports' ),
				'new_item'                   => esc_html__( 'New Casino Game', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Casino Game', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Casino Game', 'winesports' ),
				'search_items'               => esc_html__( 'Search Casino Games', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Casino Games', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Casino Games with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Casino Games', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Casino Games', 'winesports' ),
				'not_found'                  => esc_html__( 'No Casino Games found', 'winesports' ),
				'name'                       => esc_html__( 'Casino Games', 'winesports' ),
				'singular_name'              => esc_html__( 'Casino Game', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'casino-games')
		];
		register_taxonomy( self::$betting_site_casino_game_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_software_providers(): void {
		$args = [
			'label'                => esc_html__( 'Software Providers', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Software Providers', 'winesports' ),
				'all_items'                  => esc_html__( 'All Software Providers', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Software Provider', 'winesports' ),
				'view_item'                  => esc_html__( 'View Software Provider', 'winesports' ),
				'update_item'                => esc_html__( 'Update Software Provider', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Software Provider', 'winesports' ),
				'new_item'                   => esc_html__( 'New Software Provider', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Software Provider', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Software Provider', 'winesports' ),
				'search_items'               => esc_html__( 'Search Software Providers', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Software Providers', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Software Providers with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Software Providers', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Software Providers', 'winesports' ),
				'not_found'                  => esc_html__( 'No Software Providers found', 'winesports' ),
				'name'                       => esc_html__( 'Software Providers', 'winesports' ),
				'singular_name'              => esc_html__( 'Software Provider', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => false,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'software-providers')
		];
		register_taxonomy( self::$betting_site_software_provider_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked init
	 * @return void
	 */
	public static function create_betting_site_crypto_currencies(): void {
		$args = [
			'label'                => esc_html__( 'Crypto currencies', 'winesports' ),
			'labels'               => [
				'menu_name'                  => esc_html__( 'Crypto currencies', 'winesports' ),
				'all_items'                  => esc_html__( 'All Crypto currencies', 'winesports' ),
				'edit_item'                  => esc_html__( 'Edit Crypto Currency', 'winesports' ),
				'view_item'                  => esc_html__( 'View Crypto Currency', 'winesports' ),
				'update_item'                => esc_html__( 'Update Crypto Currency', 'winesports' ),
				'add_new_item'               => esc_html__( 'Add new Crypto Currency', 'winesports' ),
				'new_item'                   => esc_html__( 'New Crypto Currency', 'winesports' ),
				'parent_item'                => esc_html__( 'Parent Crypto Currency', 'winesports' ),
				'parent_item_colon'          => esc_html__( 'Parent Crypto Currency', 'winesports' ),
				'search_items'               => esc_html__( 'Search Crypto currencies', 'winesports' ),
				'popular_items'              => esc_html__( 'Popular Crypto currencies', 'winesports' ),
				'separate_items_with_commas' => esc_html__( 'Separate Crypto currencies with commas', 'winesports' ),
				'add_or_remove_items'        => esc_html__( 'Add or remove Crypto currencies', 'winesports' ),
				'choose_from_most_used'      => esc_html__( 'Choose most used Crypto currencies', 'winesports' ),
				'not_found'                  => esc_html__( 'No Crypto currencies found', 'winesports' ),
				'name'                       => esc_html__( 'Crypto currencies', 'winesports' ),
				'singular_name'              => esc_html__( 'Crypto Currency', 'winesports' ),
			],
			'public'               => true,
			'show_ui'              => true,
			'show_in_menu'         => true,
			'show_in_nav_menus'    => true,
			'show_tagcloud'        => true,
			'show_in_quick_edit'   => true,
			'show_admin_column'    => false,
			'show_in_rest'         => true,
			'hierarchical'         => false,
			'query_var'            => true,
			'sort'                 => false,
			'rewrite_no_front'     => false,
			'rewrite_hierarchical' => false,
			'rewrite'              => array('slug' => 'crypto-currencies')
		];
		register_taxonomy( self::$betting_site_crypto_currency_slug, [ We_Cpt_Betting_Site::$slug ], $args );
	}

	/**
	 * @hooked carbon_fields_register_fields
	 * @return void
	 */
	public static function register_betting_site_payment_provider_fields(): void {
		$fp = self::$betting_site_payment_provider_slug . '_';
		Container::make( 'term_meta', 'Payment Provider properties' )
		         ->where( 'term_taxonomy', '=', self::$betting_site_payment_provider_slug )
		         ->add_fields( array(
			         Field::make( 'image', $fp . 'icon', 'Icon' ),
			         Field::make( 'image', $fp . 'image', 'Image' )
		         ) );
	}

	/**
	 * @hooked carbon_fields_register_fields
	 * @return void
	 */
	public static function register_betting_site_software_provider_fields(): void {
		$fp = self::$betting_site_software_provider_slug . '_';
		Container::make( 'term_meta', 'Software Provider properties' )
		         ->where( 'term_taxonomy', '=', self::$betting_site_software_provider_slug )
		         ->add_fields( array(
			         Field::make( 'image', $fp . 'thumbnail', 'thumbnail' )
		         ) );
	}

}