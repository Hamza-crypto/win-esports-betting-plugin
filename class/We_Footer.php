<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_Cpt_Betting_Site as CptBettingSite;
use We_M_Betting_Site as BettingSite;
use We_Taxonomy as Taxonomy;

class We_Footer {

	/**
	 * @param array $args
	 *
	 * @return false|string
	 */
	public static function render_posts( array $args ): false|string {
		$tag              = 'h4';
		$title            = '';
		$text_color       = '#000000';
		$posts_type       = 'post';
		$posts_category   = 0;
		$include          = array();
		$posts_number     = 10;
		$post_name_suffix = '';

		if ( ! empty( $args['ids'] ) ) {
			$include      = explode( ",", $args['ids'] );
			$include      = array_filter( $include, function ( $post_id ) {
				return ! empty( $post_id );
			} );
			$include      = array_values( $include );
			$posts_number = - 1;
		}

		if ( ! empty( $tag ) ) {
			$tag = $args['tag'];
		}

		if ( ! empty( $args['title'] ) ) {
			$title = $args['title'];
		}

		if ( ! empty( $args['color'] ) ) {
			$text_color = $args['color'];
			if ( ! str_starts_with( $text_color, "#" ) ) {
				$text_color = "#" . $text_color;
			}
		}

		if ( ! empty( $args['type'] ) ) {
			$posts_type = $args['type'];
			if ( $posts_type == We_Cpt_Betting_Site::$slug ) {
				$post_name_suffix = ' review';
			}
		}

		if ( ! empty( $args['category'] ) && is_numeric( $args['category'] ) ) {
			$posts_category = $args['category'];
		}

		$posts = get_posts( array(
			'numberposts' => $posts_number,
			'category'    => $posts_category,
			'orderby'     => 'date',
			'order'       => 'DESC',
			'include'     => $include,
			'post_type'   => $posts_type,
		) );

		ob_start();
		?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
					<?= "<$tag style=\"color: $text_color\" class=\"text-uppercase fw-bold fs-5\">" ?>
					<?= $title ?>
					<?= '</' . $tag . '>' ?>
                </div>
            </div>
            <div class="row row-cols-auto">
                <div class="col-12">
					<?php if ( ! empty( $posts ) ): ?>
                        <ul class="p-0">
							<?php foreach ( $posts as $post ): ?>
                                <li>
                                    <div class="d-flex flex-row">
                                        <div>
                                            <img src="<?= WE_PLUGIN_URL . 'assets/icons/arrow-more-white.svg' ?>"
                                                 alt="arrow icon"
                                                 width="5" height="5">
                                        </div>
                                        <a href="<?= get_permalink( $post ) ?>"
                                           class="text-decoration-none fs-6 ms-2"
                                           style="color: <?= $text_color ?>">
											<?= $post->post_title . $post_name_suffix ?>
                                        </a>
                                    </div>
                                </li>
							<?php endforeach; ?>
                        </ul>
					<?php endif; ?>
                </div>
            </div>
        </div>
		<?php
		return ob_get_clean();
	}
}