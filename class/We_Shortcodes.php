<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_View_Betting_Site_Card as BettingSitesCard;
use We_View_Betting_Site as BettingSitePage;
use We_Footer as Footer;

class We_Shortcodes {
	public static string $betting_site_card_list = 'webs_list';
	public static string $betting_site_single = 'webs_single';
	public static string $betting_site_list_filter = 'webs_list_filter';
	public static string $footer_posts = 'webs_footer_posts';

	/**
	 * @return void
	 */
	public static function init(): void {
		add_shortcode( self::$betting_site_card_list, array( BettingSitesCard::class, 'list' ) );
		add_shortcode( self::$betting_site_single, array( BettingSitePage::class, 'content' ) );
		add_shortcode( self::$betting_site_list_filter, array( BettingSitesCard::class, 'list_filter' ) );
		add_shortcode( self::$footer_posts, array( Footer::class, 'render_posts' ) );
	}
}