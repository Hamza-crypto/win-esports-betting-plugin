<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_View_Betting_Site_Card as ViewBsCard;

class We_Public {

	public static string $ajax_action_filter_list = 'we_bs_ajax_filter_list';

	/**
	 * @hookerd wp_ajax_we_bs_ajax_filter_list
	 * @hookerd wp_ajax_nopriv_we_bs_ajax_filter_list
	 * @return void
	 */
	public static function handle_ajax_action_filter_list(): void {
		check_ajax_referer( self::$ajax_action_filter_list );
		if ( empty( $_POST['data'] ) ) {
			http_response_code( 400 );
			echo 'Bad request';
			exit();
		}
		try {
			$filter_data = $_POST['data'];
			$args        = array(
				'cat_term_id'    => 0,
				'sort_by'        => 'top',
				'bonus_type'     => 'all',
				'bonus_features' => array()
			);
			if ( ! empty( $filter_data['category'] ) && is_numeric( $filter_data['category'] ) ) {
				$args['cat_term_id'] = $filter_data['category'];
			}
			if ( ! empty( $filter_data['sort'] ) ) {
				$args['sort_by'] = $filter_data['sort'];
			}
			if ( ! empty( $filter_data['bonusType'] ) ) {
				$args['bonus_type'] = $filter_data['bonusType'];
			}
			if ( ! empty( $filter_data['bonusFeatures'] ) && is_array( $filter_data['bonusFeatures'] ) ) {
				$args['bonus_features'] = $filter_data['bonusFeatures'];
			}
			if ( ! empty( $filter_data['isCrypto'] ) ) {
				$args['is_crypto'] = $filter_data['isCrypto'];
			}
			if ( ! empty( $filter_data['cryptoCurrency'] ) && is_numeric( $filter_data['cryptoCurrency'] ) ) {
				$args['crypto'] = $filter_data['cryptoCurrency'];
			}
			if ( ! empty( $filter_data['limit'] ) && is_numeric( $filter_data['limit'] ) ) {
				$args['limit'] = $filter_data['limit'];
			}

			$content = ViewBsCard::list_content( $args );
			http_response_code( 200 );
			echo trim( $content );
			exit();
		} catch ( Exception $ex ) {
			http_response_code( 500 );
			echo json_encode( array(
				'code'    => $ex->getCode(),
				'message' => $ex->getMessage()
			) );
			exit();
		}
	}

	/**
	 * @hooked wp_enqueue_scripts
	 * @return void
	 */
	public static function enqueue_scripts(): void {
		wp_register_style(
			'bs5',
			WE_PLUGIN_URL . 'assets/css/bootstrap.min.css',
			array(),
			null );
		wp_register_style(
			'we-custom',
			WE_PLUGIN_URL . 'assets/css/custom.css',
			array(),
			microtime() );
		wp_register_style(
			'we-review',
			WE_PLUGIN_URL . 'assets/css/review.css',
			array(),
			microtime()
		);

		wp_register_script(
			'bs5',
			WE_PLUGIN_URL . 'assets/js/bootstrap.bundle.js',
			array(),
			null,
			array(
				'in_footer' => true,
				'strategy'  => 'async'
			) );
		wp_register_script(
			'we-bs-archive',
			WE_PLUGIN_URL . 'assets/js/archive.js',
			array( 'jquery' ),
			microtime(),
			array( 'in_footer' => true )
		);
		wp_register_script(
			'we-bs-archive-filter',
			WE_PLUGIN_URL . 'assets/js/archive-filter.js',
			array( 'jquery' ),
			microtime(),
			array( 'in_footer' => true )
		);
		wp_register_script(
			'we-bs-review',
			WE_PLUGIN_URL . 'assets/js/review.js',
			array( 'jquery' ),
			microtime(),
			array( 'in_footer' => true )
		);
		wp_register_style(
			'we-bs-front-page',
			WE_PLUGIN_URL . 'assets/css/front-page.css',
			array(),
			microtime()
		);

		wp_enqueue_style( 'bs5' );
		wp_enqueue_style( 'we-custom' );
		wp_enqueue_style( 'we-review' );

		wp_enqueue_script( 'bs5' );

//		if ( is_page() ) {
//			wp_enqueue_script( 'we-bs-archive' );
//			wp_enqueue_script( 'we-bs-archive-filter' );
//			wp_localize_script(
//				'we-bs-archive-filter',
//				'weBsArchiveFilterObject',
//				array(
//					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
//					'nonce'   => wp_create_nonce( self::$ajax_action_filter_list ),
//					'action'  => self::$ajax_action_filter_list
//				)
//			);
//		}
		if ( is_front_page() ) {
			wp_enqueue_style( 'we-bs-front-page' );
		}
		wp_enqueue_script( 'we-bs-archive' );
		wp_enqueue_script( 'we-bs-archive-filter' );
		wp_localize_script(
			'we-bs-archive-filter',
			'weBsArchiveFilterObject',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( self::$ajax_action_filter_list ),
				'action'  => self::$ajax_action_filter_list
			)
		);
		wp_enqueue_script( 'we-bs-review' );
	}
}