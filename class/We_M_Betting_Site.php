<?php

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

use We_Cpt_Betting_Site as CptBettingSite;
use We_Cpt_Betting_Site_Meta_Keys as MetaKeys;
use We_Taxonomy as Taxonomy;
use We_Utils as Utils;

class We_M_Betting_Site {

	public WP_Post $post;

	public function __construct( WP_Post $wp_post ) {
		$this->post = $wp_post;
	}

	/**
	 * @return mixed|null
	 */
	public function get_categories(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::categories_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_display_order(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::display_order_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_logo_bg_color(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::logo_bg_color_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_tc_apply(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::tc_apply_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function is_exclusive(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::is_exclusive_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function is_hot(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::is_hot_key() );
	}

	public function is_recommended() {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::is_recommended_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_cta_label(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::cta_label_key() );
	}

	/**
	 * @param int $category_term_id
	 *
	 * @return array
	 */
	public function get_featured_bonus( int $category_term_id = 0 ): array {
		$filter = carbon_get_post_meta( $this->post->ID, MetaKeys::featured_bonus_key() );

		$result = array();

		$country_code = Utils::get_country_code();

		if ( ! empty( $coutry_code ) ) {
			$filter = array_filter( $filter, function ( $bonus ) use ( $country_code ) {
				return $bonus['country'] == $country_code;
			} );
			$filter = array_values( $filter );
		}

		if ( empty( $filter ) ) {
			$filter = array_filter( $filter, function ( $bonus ) {
				return $bonus['country'] == 'DEFAULT';
			} );
			$filter = array_values( $filter );
		}

		if ( ! empty( $category_term_id ) ) {
			$filter = array_filter( $filter, function ( $bonus ) use ( $category_term_id ) {
				if ( empty( $bonus['category'] ) ) {
					return false;
				}

				return + $bonus['category'][0]['id'] == $category_term_id;
			} );
			if ( ! empty( $filter ) ) {
				$filter = array_values( $filter )[0];
			}
		} else {
			if ( ! empty( $filter ) ) {
				$filter = $filter[0];
			}
		}

		foreach ( $filter as $key => $value ) {
			if ( $key == 'features' ) {
				foreach ( $value as $feature_set ) {
					$result['features'][] = $feature_set['feature'];
				}
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function get_payment_methods(): array {
		$payment_methods = carbon_get_post_meta( $this->post->ID, MetaKeys::payment_methods_key() );
		$result          = array();
		if ( ! empty( $payment_methods ) ) {
			foreach ( $payment_methods as $payment_method ) {
				$item = array();
				foreach ( $payment_method as $key => $value ) {
					if ( $key == 'provider' && ! empty( $value ) ) {
						$icon_id = carbon_get_term_meta( $value[0]['id'], Taxonomy::$betting_site_payment_provider_slug . '_icon' );
						if ( ! empty( $icon_id ) ) {
							$icon_data_set = wp_get_attachment_image_src( $icon_id, 'full' );
							if ( ! empty( $icon_data_set ) ) {
								$item['icon'] = $icon_data_set[0];
							}
						}
						$image_id = carbon_get_term_meta( $value[0]['id'], Taxonomy::$betting_site_payment_provider_slug . '_image' );
						if ( ! empty( $image_id ) ) {
							$image_data_set = wp_get_attachment_image_src( $image_id, 'full' );
							if ( ! empty( $image_data_set ) ) {
								$item['image'] = $image_data_set[0];
							}
						}
					} else {
						$item[ $key ] = $value;
					}
				}
				$result[] = $item;
			}
		}

		return $result;
	}

	/**
	 * @return mixed|null
	 */
	public function get_accepted_crypto(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::crypto_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_withdrawal(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::withdrawal_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_award(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::award_key() );
	}

	/**
	 * @return mixed
	 */
	public function get_license(): mixed {
		$image_id = carbon_get_post_meta( $this->post->ID, MetaKeys::license_key() );

		return wp_get_attachment_image_src( $image_id, 'full' );
	}

	/**
	 * @return mixed|null
	 */
	public function is_android_available(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::android_available_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function is_ios_available(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::ios_available_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_play_conditions(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::play_terms_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_company(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::company_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_founded(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::founded_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_website(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::website_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_available_languages(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::available_languages_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_customer_support(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::customer_support_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_email(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::email_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_phone(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::phone_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_verified_by(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::verified_by_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_safety_score(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::safety_score_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_software_providers(): mixed {
		$software_providers = carbon_get_post_meta( $this->post->ID, MetaKeys::software_providers_key() );
		$result             = array();
		if ( ! empty( $software_providers ) ) {
			foreach ( $software_providers as $software_provider ) {
				$item    = array();
				$icon_id = carbon_get_term_meta( $software_provider['id'], Taxonomy::$betting_site_software_provider_slug . '_thumbnail' );
				if ( ! empty( $icon_id ) ) {
					$icon_data_set = wp_get_attachment_image_src( $icon_id, 'full' );
					if ( ! empty( $icon_data_set ) ) {
						$item['icon'] = $icon_data_set[0];
					}
				}
				$software_provider_term = get_term( $software_provider['id'], $software_provider['subtype'] );
				if ( ! empty( $software_provider_term ) && $software_provider_term instanceof WP_Term ) {
					$item['name'] = $software_provider_term->name;
				}
				$result[] = $item;
			}
		}

		return $result;
	}

	/**
	 * @return mixed|null
	 */
	public function get_slots_number(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::slots_key() );
	}

	/**
	 * @return array
	 */
	public function get_ratings(): array {
		$bonus_offer          = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_bonus_offer_key() );
		$usability            = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_usability_key() );
		$payment_methods      = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_payment_methods_key() );
		$customer_service     = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_customer_service_key() );
		$license_and_security = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_license_and_security_key() );
		$rewards_program_key  = carbon_get_post_meta( $this->post->ID, MetaKeys::rating_rewards_program_key() );
		$ratings              = array(
			'bonus_offer'          => ! empty( $bonus_offer ) ? $bonus_offer : '',
			'usability'            => ! empty( $usability ) ? $usability : '',
			'payment_methods'      => ! empty( $payment_methods ) ? $payment_methods : '',
			'customer_service'     => ! empty( $customer_service ) ? $customer_service : '',
			'license_and_security' => ! empty( $license_and_security ) ? $license_and_security : '',
			'rewards_program_key'  => ! empty( $rewards_program_key ) ? $rewards_program_key : ''
		);
		$valid_rating_count   = 0;
		$sum                  = 0;
		foreach ( $ratings as $key => $value ) {
			if ( is_numeric( $value ) ) {
				$valid_rating_count ++;
				$sum += $value;
			}
		}
		$overall = 0;
		if ( $valid_rating_count > 0 ) {
			$overall = $sum / $valid_rating_count;
		}
		if ( ! empty( $overall ) ) {
			$ratings['overall'] = We_Utils::round_up( $overall, 1 );

		} else {
			$ratings['overall'] = 0.1;
		}

		return $ratings;
	}

	/**
	 * @return array
	 */
	public function get_available_countries(): array {
		$available_countries = array();
		$result              = carbon_get_post_meta( $this->post->ID, MetaKeys::countries_key() );
		foreach ( $result as $item ) {
			$available_countries[] = $item['country'];
		}

		return $available_countries;
	}

	/**
	 * @return mixed|null
	 */
	public function get_review_title(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::review_title_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_review_sub_title(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::review_subtitle_key() );
	}

	/**
	 * @param string $meta_key
	 *
	 * @return mixed|null
	 */
	public function get_review_section( string $meta_key ): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, $meta_key ) );
	}

	/**
	 * @return mixed
	 */
	public function get_review_intro(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_intro_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_review_pros(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::review_pros_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_review_cons(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::review_cons_key() );
	}

	/**
	 * @return mixed|null
	 */
	public function get_bonus_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_bonus_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_usability_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_usability_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_payment_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_payment_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_service_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_service_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_licensing_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_licensing_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_rewards_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_rewards_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_sports_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_sports_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_casino_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_casino_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_esports_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_esports_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_conclusion_review(): mixed {
		return apply_filters( 'the_content', carbon_get_post_meta( $this->post->ID, MetaKeys::review_conclusion_key() ) );
	}

	/**
	 * @return mixed|null
	 */
	public function get_faq(): mixed {
		return carbon_get_post_meta( $this->post->ID, MetaKeys::faq_key() );
	}

	/**
	 * @param array $terms_names
	 * @param string $taxonomy
	 * @param string $meta_key
	 *
	 * @return void
	 */
	public function set_association( array $terms_names, string $taxonomy, string $meta_key ): void {
		$association_values = array();
		foreach ( $terms_names as $term_name ) {
			$term = get_term_by( 'slug', sanitize_title( $term_name ), $taxonomy );
			if ( empty( $term ) ) {
				$term_data = wp_insert_term( $term_name, $taxonomy );
				$term      = get_term( $term_data['term_id'] );
			}
			$association_values[] = array(
				'type'    => 'term',
				'subtype' => $taxonomy,
				'id'      => $term->term_id,
				'value'   => "term:{$taxonomy}:{$term->term_id}"
			);
		}
		carbon_set_post_meta( $this->post->ID, $meta_key, $association_values );
	}

	/**
	 * @param string $meta_key
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_text_field( string $meta_key, string $value ): void {
		$value = trim( stripcslashes( htmlspecialchars_decode( $value ) ) );
		carbon_set_post_meta( $this->post->ID, $meta_key, $value );
	}

	/**
	 * @param string $url
	 *
	 * @return void
	 */
	public function set_post_thumbnail( string $url ): void {
		$attachment_id = Utils::upload_file( $url, $this->post->ID );
		if ( ! empty( $attachment_id ) ) {
			set_post_thumbnail( $this->post->ID, $attachment_id );
		}
	}

	/**
	 * @param string $url
	 *
	 * @return void
	 */
	public function set_license( string $url ): void {
		$attachment_id = Utils::upload_file( $url );
		if ( ! empty( $attachment_id ) ) {
			carbon_set_post_meta( $this->post->ID, MetaKeys::license_key(), $attachment_id );
		}
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_available_languages( string $value ): void {
		$available_languages = array();
		$raw_value_parts     = explode( " ", $value );
		$value_parts         = array_filter( $raw_value_parts, function ( $item ) {
			return ! empty( $item );
		} );
		$value_parts         = array_values( $value_parts );
		foreach ( $value_parts as $part ) {
			$available_languages[] = strtolower( $part );
		}
		if ( ! empty( $available_languages ) ) {
			carbon_set_post_meta( $this->post->ID, MetaKeys::available_languages_key(), $available_languages );
		}
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_customer_support( string $value ): void {
		$customer_support = array();
		$raw_value_parts  = explode( ",", $value );
		$value_parts      = array_filter( $raw_value_parts, function ( $item ) {
			return ! empty( $item );
		} );
		$value_parts      = array_values( $value_parts );
		foreach ( $value_parts as $part ) {
			$customer_support[] = array( 'support' => trim( htmlspecialchars_decode( $part ) ) );
		}
		if ( ! empty( $customer_support ) ) {
			carbon_set_post_meta( $this->post->ID, MetaKeys::customer_support_key(), $customer_support );
		}
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_software_providers( string $value ): void {
		$software_providers = array();
		$data               = json_decode( str_replace( "\n", "", stripcslashes( $value ) ) );
		$taxonomy           = Taxonomy::$betting_site_software_provider_slug;
		foreach ( $data as $object ) {
			$term_name  = $object->title;
			$term_image = $object->image;
			$term       = get_term_by( 'slug', sanitize_title( $term_name ), $taxonomy );
			if ( empty( $term ) ) {
				$term_data = wp_insert_term( $term_name, $taxonomy );
				if ( ! is_wp_error( $term_data ) ) {
					$term          = get_term( $term_data['term_id'], $taxonomy );
					$attachment_id = Utils::upload_file( $term_image );
					if ( ! empty( $attachment_id ) ) {
						carbon_set_term_meta( $term->term_id, $taxonomy . '_thumbnail', $attachment_id );
					}
				}
			}
			if ( ! empty( $term ) ) {
				$software_providers[] = array(
					'value'   => "term:$taxonomy:$term->term_id",
					'type'    => 'term',
					'subtype' => $taxonomy,
					'id'      => $term->term_id
				);
			}
		}
		if ( ! empty( $software_providers ) ) {
			carbon_set_post_meta( $this->post->ID, MetaKeys::software_providers_key(), $software_providers );
		}
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_payment_providers( string $value ): void {
		$json     = json_decode( str_replace( "\n", "", stripcslashes( $value ) ) );
		$taxonomy = Taxonomy::$betting_site_payment_provider_slug;
		foreach ( $json as $object ) {
			$term_name     = $object->title;
			$term_icon_url = $object->image;
			$term          = get_term_by( 'slug', sanitize_title( $term_name ), $taxonomy );
			if ( empty( $term ) ) {
				$term_data = wp_insert_term( $term_name, $taxonomy );
				if ( ! is_wp_error( $term_data ) ) {
					$term          = get_term( $term_data['term_id'], $taxonomy );
					$attachment_id = Utils::upload_file( $term_icon_url );
					if ( ! empty( $attachment_id ) ) {
						carbon_set_term_meta( $term->term_id, $taxonomy . '_icon', $attachment_id );
					}
				}
			}
		}
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_payment_methods( string $value ): void {
		$payment_methods = array();
		$json            = json_decode( str_replace( "\n", "", stripcslashes( $value ) ), true );
		$taxonomy        = Taxonomy::$betting_site_payment_provider_slug;
		foreach ( $json as $item ) {
			if ( empty( $item['payement provider'] ) || empty( trim( $item['payement provider'] ) ) ) {
				continue;
			}
			if ( empty( $item['img'] ) || empty( trim( $item['img'] ) ) ) {
				continue;
			}
			$term_name           = $item['payement provider'];
			$term_wide_image_url = $item['img'];
			$term                = get_term_by( 'slug', sanitize_title( $term_name ), $taxonomy );
			$provider            = array();
			if ( ! empty( $term ) ) {
				$attachment_id = carbon_get_term_meta( $term->term_id, $taxonomy . '_image' );
				if ( empty( $attachment_id ) ) {
					$attachment_id = Utils::upload_file( $term_wide_image_url );
					carbon_set_term_meta( $term->term_id, $taxonomy . '_image', $attachment_id );
				}
				$provider = array(
					array(
						'value'   => "term:$taxonomy:$term->term_id",
						'type'    => 'term',
						'subtype' => $taxonomy,
						'id'      => $term->term_id
					)
				);
			}

			$deposit = '';
			if ( ! empty( $item['Deposit min/max'] ) ) {
				$deposit = trim( htmlspecialchars_decode( $item['Deposit min/max'] ) );
			}
			$withdrawal = '';
			if ( ! empty( $item['Withdrawal min/max'] ) ) {
				$withdrawal = trim( htmlspecialchars_decode( $item['Withdrawal min/max'] ) );
			}
			$deposit_time = '';
			if ( ! empty( $item['Deposit time'] ) ) {
				$deposit_time = trim( htmlspecialchars_decode( $item['Deposit time'] ) );
			}
			$withdrawal_time = '';
			if ( ! empty( $item['Withdrawal time'] ) ) {
				$withdrawal_time = trim( htmlspecialchars_decode( $item['Withdrawal time'] ) );;
			}
			$safety = '';
			if ( ! empty( $item['Safety'] ) ) {
				$safety = trim( htmlspecialchars_decode( $item['Safety'] ) );
			}
			$payment_methods[] = array(
				'provider'        => $provider,
				'deposit'         => $deposit,
				'withdrawal'      => $withdrawal,
				'deposit_time'    => $deposit_time,
				'withdrawal_time' => $withdrawal_time,
				'safety'          => $safety
			);
		}
		if ( ! empty( $payment_methods ) ) {
			carbon_set_post_meta( $this->post->ID, MetaKeys::payment_methods_key(), $payment_methods );
		}
	}

	/**
	 * @param string $color
	 *
	 * @return void
	 */
	public function set_logo_bg_color( string $color ): void {
		carbon_set_post_meta( $this->post->ID, MetaKeys::logo_bg_color_key(), $color );
	}

	/**
	 * @param string $jsons_string
	 *
	 * @return void
	 */
	public function set_ratings( string $jsons_string ): void {
		$json_std = json_decode( str_replace( "\n", "", stripcslashes( $jsons_string ) ) );
		$ratings  = $json_std->ratings;
		foreach ( $ratings as $rating ) {
			$rating_name  = trim( htmlspecialchars_decode( $rating->category ) );
			$rating_value = (float) $rating->score;
			switch ( $rating_name ) {
				case "Bonus Offers & Free Bets":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_bonus_offer_key(), $rating_value );
					break;
				case "Usability, Look & Feel":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_usability_key(), $rating_value );
					break;
				case "Payment Methods":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_payment_methods_key(), $rating_value );
					break;
				case "Customer Service":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_customer_service_key(), $rating_value );
					break;
				case "Licence & Security":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_license_and_security_key(), $rating_value );
					break;
				case "Rewards & Loyalty Program":
					carbon_set_post_meta( $this->post->ID, MetaKeys::rating_rewards_program_key(), $rating_value );
					break;
			}
		}
		$ratings        = $this->get_ratings();
		$overall_rating = $ratings['overall'];
		carbon_set_post_meta( $this->post->ID, MetaKeys::rating_overall_key(), $overall_rating );
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_review_title( string $value ): void {
		$title = trim( stripcslashes( htmlspecialchars_decode( $value ) ) );
		carbon_set_post_meta( $this->post->ID, MetaKeys::review_title_key(), $title );
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_review_subtitle( string $value ): void {
		$subtitle = trim( stripcslashes( htmlspecialchars_decode( $value ) ) );
		carbon_set_post_meta( $this->post->ID, MetaKeys::review_subtitle_key(), $subtitle );
	}

	/**
	 * @param array $data
	 *
	 * @return void
	 */
	public function set_reviews( array $data ): void {
		$this->set_review_section(
			MetaKeys::review_bonus_key(),
			$data['Bonus Offers Title'] ?? '',
			$data['Bonus Offers'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_usability_key(),
			$data['Usability Title'] ?? '',
			$data['Usability'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_payment_key(),
			$data['Payment Methods Title'] ?? '',
			$data['Payment Methods'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_service_key(),
			$data['Customer Service Title'] ?? '',
			$data['Customer Service'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_licensing_key(),
			$data['Licensing Title'] ?? '',
			$data['Licensing'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_rewards_key(),
			$data['Rewards Title'] ?? '',
			$data['Rewards'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_sports_key(),
			$data['Sports Title'] ?? '',
			$data['Sports'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_casino_key(),
			$data['Casino Title'] ?? '',
			$data['Casino I'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_esports_key(),
			$data['Esports Title'] ?? '',
			$data['Esports I'] ?? ''
		);
		$this->set_review_section(
			MetaKeys::review_conclusion_key(),
			$data['Conclusion Title'] ?? '',
			$data['Conclusion'] ?? ''
		);
	}

	/**
	 * @param string $meta_key
	 * @param string $title
	 * @param string $content
	 *
	 * @return void
	 */
	private function set_review_section( string $meta_key, string $title = '', string $content = '' ): void {
		if ( ! empty( $title ) && ! empty( $content ) ) {
			$section_title   = trim( stripcslashes( htmlspecialchars_decode( $title ) ) );
			$section_content = trim( stripcslashes( htmlspecialchars_decode( $content ) ) );
			$section         = "<h2>$section_title</h2><p>$section_content</p>";
			carbon_set_post_meta( $this->post->ID, $meta_key, $section );
		}
	}

	/**
	 * @param array $data
	 *
	 * @return void
	 */
	public function set_bonus( array $data ): void {
		$bonus_data = $this->make_bonus_data( $data );
		$taxonomy   = Taxonomy::$betting_site_category_slug;
		$bonus      = array();
		foreach ( $bonus_data as $bonus_category_name => $bonus_data_set ) {
			if ( empty( $bonus_data_set ) ) {
				continue;
			}
			$term = get_term_by( 'slug', sanitize_title( $bonus_category_name ), $taxonomy );
			if ( empty( $term ) ) {
				$term_data = wp_insert_term( $bonus_category_name, $taxonomy );
				$term      = get_term( $term_data['term_id'], $taxonomy );
			}
			$category       = array(
				'type'    => 'term',
				'subtype' => $taxonomy,
				'id'      => $term->term_id,
				'value'   => "term:{$taxonomy}:{$term->term_id}"
			);
			$bonus_features = array();
			if ( ! empty( $bonus_data_set['features'] ) ) {
				$bonus_features_lines = explode( "\n", $bonus_data_set['features'] );
				$bonus_features_lines = array_filter( $bonus_features_lines, function ( $line ) {
					return ! empty( $line );
				} );
				$bonus_features_lines = array_values( $bonus_features_lines );
				foreach ( $bonus_features_lines as $bonus_features_line ) {
					$bonus_features[] = array( 'feature' => trim( htmlspecialchars_decode( $bonus_features_line ) ) );
				}
			}
			$promo_code = '';
			if ( ! empty( $bonus_data_set['promo_code'] ) ) {
				$promo_code = trim( htmlspecialchars_decode( $bonus_data_set['promo_code'] ) );
			}
			$title = '';
			if ( ! empty( $bonus_data_set['title'] ) ) {
				$title = trim( htmlspecialchars_decode( $bonus_data_set['title'] ) );
			}
			$link = '';
			if ( ! empty( $bonus_data_set['url'] ) ) {
				$link = trim( urldecode( $bonus_data_set['url'] ) );
			}

			$bonus[] = array(
				'country'  => 'DEFAULT',
				'category' => array( $category ),
				'code'     => $promo_code,
				'title'    => $title,
				'link'     => $link,
				'features' => $bonus_features
			);
		}
		carbon_set_post_meta( $this->post->ID, MetaKeys::featured_bonus_key(), $bonus );
	}

	/**
	 * @param int $display_order
	 *
	 * @return void
	 */
	public function set_display_order( int $display_order = PHP_INT_MAX ): void {
		carbon_set_post_meta( $this->post->ID, MetaKeys::display_order_key(), $display_order );
	}

	/**
	 * @param string $value
	 *
	 * @return void
	 */
	public function set_available_countries( string $value = '' ): void {
		$available_countries = array( 'DEFAULT' );
		carbon_set_post_meta( $this->post->ID, MetaKeys::countries_key(), $available_countries );
	}


	/**
	 * @param array $data
	 *
	 * @return array|array[]
	 */
	private function make_bonus_data( array $data ): array {
		$bonus_data_set = array();

		if ( ! empty( $data['Casino'] ) ) {
			$bonus_data_set['casino']['features'] = $data['Casino'];
		}
		if ( ! empty( $data['Sport'] ) ) {
			$bonus_data_set['sports']['features'] = $data['Sport'];
		}
		if ( ! empty( $data['Esports'] ) ) {
			$bonus_data_set['esports']['features'] = $data['Esports'];
		}

		if ( ! empty( $data['Casino Code Promo'] ) ) {
			$bonus_data_set['casino']['promo_code'] = $data['Casino Code Promo'];
		}
		if ( ! empty( $data['Sport Code Promo'] ) ) {
			$bonus_data_set['sports']['promo_code'] = $data['Sport Code Promo'];
		}
		if ( ! empty( $data['Esports Code Promo'] ) ) {
			$bonus_data_set['esports']['promo_code'] = $data['Esports Code Promo'];
		}

		if ( ! empty( $data['Casino Price'] ) ) {
			$bonus_data_set['casino']['title'] = $data['Casino Price'];
		}
		if ( ! empty( $data['Sport Price'] ) ) {
			$bonus_data_set['sports']['title'] = $data['Sport Price'];
		}
		if ( ! empty( $data['Esports Price'] ) ) {
			$bonus_data_set['esports']['title'] = $data['Esports Price'];
		}

//		if ( ! empty( $data['Website'] ) ) {
//			if ( ! empty( $bonus_data_set['casino'] ) ) {
//				$bonus_data_set['casino']['url'] = 'https://' . $data['Website'];
//			}
//			if ( ! empty( $bonus_data_set['sports'] ) ) {
//				$bonus_data_set['sports']['url'] = 'https://' . $data['Website'];
//			}
//			if ( ! empty( $bonus_data_set['esports'] ) ) {
//				$bonus_data_set['esports']['url'] = 'https://' . $data['Website'];
//			}
//		}

		return $bonus_data_set;
	}

	/**
	 * @param $args
	 *
	 * @return array
	 */
	public static function getAll( $args ): array {
		global $wpdb;

		$posts_table_name      = $wpdb->prefix . 'posts';
		$posts_meta_table_name = $wpdb->prefix . 'postmeta';

		$post_in = '';

//		$sql = "select distinct
//    post_id from {$posts_meta_table_name}
//	where meta_key like %s
//	and meta_value <> %s";
//
//		$sql_query = $wpdb->prepare( $sql, '%bonus|link%', '' );
//
//		$result = $wpdb->get_results( $sql_query );
//
//		if ( ! empty( $result ) ) {
//			$post_ids = array();
//			foreach ( $result as $std_object ) {
//				$post_ids[] = $std_object->post_id;
//			}
//			$post_in = "and posts.ID in (" . implode( ",", $post_ids ) . ")";
//		} else {
//			return array();
//		}

		$post_not_in = '';
		if ( ! empty( $args['postIds'] ) ) {
			$post_not_in_arr = array_filter( $args['postIds'], function ( $item ) {
				return ! empty( $item ) && is_numeric( $item );
			} );
			$post_not_in     = "and posts.ID not in (" . implode( ",", $post_not_in_arr ) . ")";
		}


		$sql = "select
    posts.ID as post_id, posts.post_title, posts.post_status,
    post_meta.meta_id, post_meta.meta_key, post_meta.meta_value
	from {$posts_table_name} posts join {$posts_meta_table_name} post_meta
    on posts.ID = post_meta.post_id
	where posts.post_type = %s
	and posts.post_status = %s
	{$post_in}
	{$post_not_in}
	order by posts.ID desc";

		$sql_query = $wpdb->prepare( $sql, CptBettingSite::$slug, 'publish' );
		$result    = $wpdb->get_results( $sql_query );

		if ( empty( $result ) ) {
			return array();
		}
		$formatted_result = array();

		foreach ( $result as $std_object ) {
			$post_id = $std_object->post_id;
			if ( ! isset( $formatted_result[ $post_id ] ) ) {
				$formatted_result[ $post_id ] = array();
			}
			if ( empty( $formatted_result[ $post_id ]['post_id'] ) ) {
				$formatted_result[ $post_id ]['post_id'] = $post_id;
			}
			if ( empty( $formatted_result[ $post_id ]['post_title'] ) ) {
				$formatted_result[ $post_id ]['post_title'] = $std_object->post_title;
			}
			if ( empty( $formatted_result[ $post_id ]['post_status'] ) ) {
				$formatted_result[ $post_id ]['post_status'] = $std_object->post_status;
			}
			$meta_key_parts        = explode( "|", $std_object->meta_key );
			$meta_key_parts        = array_filter( $meta_key_parts, function ( $meta_key_part ) {
				return strlen( $meta_key_part ) > 0;
			} );
			$meta_key_parts        = array_values( $meta_key_parts );
			$meta_key_parts_length = count( $meta_key_parts );
			$meta_value            = $std_object->meta_value;
			$meta_key              = $meta_key_parts[0];

			if ( count( $meta_key_parts ) > 1 ) {
				if ( ! isset( $formatted_result[ $post_id ][ $meta_key ] ) ) {
					$formatted_result[ $post_id ][ $meta_key ] = array();
				}
				switch ( $meta_key ) {
					case '_' . MetaKeys::countries_key():
					case '_' . MetaKeys::available_languages_key():
						$formatted_result[ $post_id ][ $meta_key ][] = $meta_value;
						break;
					case '_' . MetaKeys::crypto_key():
					case '_' . MetaKeys::esport_games_key():
					case '_' . MetaKeys::categories_key():
					case '_' . MetaKeys::software_providers_key():
						if ( $meta_key_parts[ $meta_key_parts_length - 1 ] == 'id' ) {
							$formatted_result[ $post_id ][ $meta_key ][] = $meta_value;
						}
						break;
					case '_' . MetaKeys::customer_support_key():
						if ( $meta_key_parts[1] == 'support' ) {
							$formatted_result[ $post_id ][ $meta_key ][] = $meta_value;
						}
						break;
					case '_' . MetaKeys::featured_bonus_key():
						$index = $meta_key_parts[2];
						$index = explode( ":", $index )[0];
						$field = $meta_key_parts[1];
						if ( is_numeric( $index ) && ! isset( $formatted_result[ $post_id ][ $meta_key ][ $index ] ) ) {
							$formatted_result[ $post_id ][ $meta_key ][ $index ] = array();
							$featured_bonus                                      = &$formatted_result[ $post_id ][ $meta_key ][ $index ];
						}

						switch ( $field ) {
							case 'country':
								if ( ! isset( $featured_bonus[ $field ] ) ) {
									$featured_bonus[ $field ] = array();
								}
								$featured_bonus[ $field ][] = $meta_value;
								break;
							case 'features:feature':
								if ( ! isset( $featured_bonus['features'] ) ) {
									$featured_bonus['features'] = array();
								}
								$featured_bonus['features'][] = $meta_value;
								break;
							case 'category':
								if ( $meta_key_parts[ $meta_key_parts_length - 1 ] == 'id' ) {
									$featured_bonus['category'] = $meta_value;
								}
								break;
							case 'code':
							case 'title':
							case 'link':
								$featured_bonus[ $field ] = $meta_value;
								break;
						}
						break;
					case '_' . MetaKeys::payment_methods_key():
						$index = $meta_key_parts[2];
						$field = $meta_key_parts[1];
						if ( is_numeric( $index ) && ! isset( $formatted_result[ $post_id ][ $meta_key ][ $index ] ) ) {
							$formatted_result[ $post_id ][ $meta_key ][ $index ] = array();
							$payment_method                                      = &$formatted_result[ $post_id ][ $meta_key ][ $index ];
						}
						switch ( $field ) {
							case 'deposit':
							case 'withdrawal':
							case 'deposit_time':
							case 'withdrawal_time':
							case 'safety':
							case 'provider':
								$payment_method[ $field ] = $meta_value;
								break;
						}
						break;
				}
			} else {
				$formatted_result[ $post_id ][ $meta_key ] = $meta_value;
			}
		}

		if ( ! empty( $args['cat_term_id'] ) && is_numeric( $args['cat_term_id'] ) ) {
			$category_term_id = $args['cat_term_id'];
			$formatted_result = array_filter( $formatted_result, function ( $item ) use ( $category_term_id ) {
				return ! empty( $item[ '_' . MetaKeys::categories_key() ] ) && in_array( $category_term_id, $item[ '_' . MetaKeys::categories_key() ] );
			} );
			$formatted_result = array_values( $formatted_result );
			foreach ( $formatted_result as &$item ) {
				$featured_bonus = &$item[ '_' . MetaKeys::featured_bonus_key() ];
				$featured_bonus = array_filter( $featured_bonus, function ( $bonus ) use ( $category_term_id ) {
					return $bonus['category'] == $category_term_id;
				} );
				$featured_bonus = array_values( $featured_bonus );
			}
		}

		if ( ! empty( $args['country_code'] ) ) {
			$country_code = strtoupper( $args['country_code'] );
		} else {
			$country_code = Utils::get_country_code();
		}
		if ( ! empty( $country_code ) && $country_code != 'all' ) {
			$field            = '_' . MetaKeys::countries_key();
			$formatted_result = array_filter( $formatted_result, function ( $item ) use ( $country_code, $field ) {
				return ( in_array( $country_code, $item[ $field ] ) || in_array( 'DEFAULT', $item[ $field ] ) );
			} );
			$formatted_result = array_values( $formatted_result );
			foreach ( $formatted_result as $item ) {
				$featured_bonus = &$item[ '_' . MetaKeys::featured_bonus_key() ];
				$featured_bonus = array_filter( $featured_bonus, function ( $bonus ) use ( $country_code ) {
					return ( in_array( $country_code, $bonus['country'] ) || in_array( 'DEFAULT', $bonus['country'] ) );
				} );
				$featured_bonus = array_values( $featured_bonus );
			}
		}

		if ( ! empty( $args['is_crypto'] ) ) {
			$formatted_result = array_filter( $formatted_result, function ( $item ) {
				return ! empty( $item[ '_' . MetaKeys::crypto_key() ] );
			} );
			$formatted_result = array_values( $formatted_result );
		}

		if ( ! empty( $args['crypto'] ) && is_numeric( $args['crypto'] ) ) {
			$crypto_id        = $args['crypto'];
			$formatted_result = array_filter( $formatted_result, function ( $item ) use ( $crypto_id ) {
				return ! empty( $item[ '_' . MetaKeys::crypto_key() ] ) && in_array( $crypto_id, $item[ '_' . MetaKeys::crypto_key() ] );
			} );
			$formatted_result = array_values( $formatted_result );
		}

		if ( ! empty( $args['esport'] ) && is_numeric( $args['esport'] ) ) {
			$esport_game_id   = $args['esport'];
			$formatted_result = array_filter( $formatted_result, function ( $item ) use ( $esport_game_id ) {
				return ! empty( $item[ '_' . MetaKeys::esport_games_key() ] ) && in_array( $esport_game_id, $item[ '_' . MetaKeys::esport_games_key() ] );
			} );
			$formatted_result = array_values( $formatted_result );
		}

		$payment_providers_ids = array();
		foreach ( $formatted_result as $item ) {
			if ( ! empty( $item[ '_' . MetaKeys::payment_methods_key() ] ) ) {
				foreach ( $item[ '_' . MetaKeys::payment_methods_key() ] as $payment_method ) {
					$payment_providers_ids[] = $payment_method['provider'];
				}
			}
		}

		if ( ! empty( $payment_providers_ids ) ) {
			$payment_providers_ids     = array_filter( $payment_providers_ids, function ( $pp ) {
				return ! empty( $pp );
			} );
			$payment_providers_ids     = array_values( $payment_providers_ids );
			$table_name                = $wpdb->prefix . 'termmeta';
			$sql                       = "SELECT * FROM $table_name WHERE term_id IN (" . implode( ",", $payment_providers_ids ) . ")";
			$result                    = $wpdb->get_results( $sql );
			$formatted_payment_methods = array();
			foreach ( $result as $std_object ) {
				if ( ! isset( $formatted_payment_methods[ $std_object->term_id ] ) ) {
					$formatted_payment_methods[ $std_object->term_id ] = array();
				}
				switch ( $std_object->meta_key ) {
					case '_wetaxbspp_icon':
						$formatted_payment_methods[ $std_object->term_id ]['icon'] = $std_object->meta_value;
						break;
					case '_wetaxbspp_image':
						$formatted_payment_methods[ $std_object->term_id ]['image'] = $std_object->meta_value;
						break;

				}
			}

			foreach ( $formatted_result as &$item ) {
				if ( ! empty( $item[ '_' . MetaKeys::payment_methods_key() ] ) ) {
					foreach ( $item[ '_' . MetaKeys::payment_methods_key() ] as &$payment_method ) {
						$term_id = $payment_method['provider'];
						if ( ! empty( $formatted_payment_methods[ $term_id ]['icon'] ) ) {
							$payment_method['icon'] = $formatted_payment_methods[ $term_id ]['icon'];
						}
						if ( ! empty( $formatted_payment_methods[ $term_id ]['image'] ) ) {
							$payment_method['image'] = $formatted_payment_methods[ $term_id ]['image'];
						}
					}
				}
			}
		}

		if ( empty( $args['sort_by'] ) || $args['sort_by'] == 'top' ) {
			usort( $formatted_result, array( We_M_Betting_Site::class, 'sort_by_overall_rating_2' ) );
			usort( $formatted_result, array( We_M_Betting_Site::class, 'sort_by_custom_display_order_2' ) );
		}

		$duplicates             = array();
		$duplicate_indexes      = array();
		$formatted_result_count = count( $formatted_result );
		for ( $i = 0; $i < $formatted_result_count; $i ++ ) {
			$bs_i = $formatted_result[ $i ];
			for ( $j = 0; $j < $formatted_result_count; $j ++ ) {
				if ( $i == $j ) {
					continue;
				}
				$bs_j = $formatted_result[ $j ];
				if ( $bs_i['post_id'] == $bs_j['post_id'] ) {
					if ( empty( $duplicates ) ) {
						$duplicates[]        = $bs_i;
						$duplicate_indexes[] = $i;
					} else {
						$duplicate_exist = array_filter( $duplicates, function ( $bs_d ) use ( $bs_i ) {
							return $bs_d['post_id'] == $bs_i['post_id'];
						} );
						if ( empty( $duplicate_exist ) ) {
							$duplicates[]        = $bs_i;
							$duplicate_indexes[] = $i;
						}
					}
				}
			}
		}

		if ( ! empty( $duplicate_indexes ) ) {
			foreach ( $duplicate_indexes as $index ) {
				array_splice( $formatted_result, $index, 1 );
			}
		}

		if ( ! empty( $args['limit'] ) && is_numeric( $args['limit'] ) ) {
			return array_splice( $formatted_result, 0, (int) $args['limit'] );
		}

		return $formatted_result;

	}

	/**
	 * @param We_M_Betting_Site $a
	 * @param We_M_Betting_Site $b
	 *
	 * @return int
	 */
	public static function sort_by_overall_rating( We_M_Betting_Site $a, We_M_Betting_Site $b ): int {
		return $b->get_ratings()['overall'] <=> $a->get_ratings()['overall'];
	}

	/**
	 * @param We_M_Betting_Site $a
	 * @param We_M_Betting_Site $b
	 *
	 * @return int
	 */
	public static function sort_by_custom_display_order( We_M_Betting_Site $a, We_M_Betting_Site $b ): int {
		$a_display_order = $a->get_display_order();
		$b_display_order = $b->get_display_order();
		$a_comp_value    = $a_display_order > 0 ? $a_display_order : PHP_INT_MAX;
		$b_comp_value    = $b_display_order > 0 ? $b_display_order : PHP_INT_MAX;

		return $a_comp_value <=> $b_comp_value;
	}

	/**
	 * @param array $a
	 * @param array $b
	 *
	 * @return int
	 */
	public static function sort_by_id( array $a, array $b ): int {
		return $b['post_id'] <=> $a['post_id'];
	}

	/**
	 * @param array $a
	 * @param array $b
	 *
	 * @return int
	 */
	public static function sort_by_overall_rating_2( array $a, array $b ): int {
		if ( ! empty( $b[ '_' . MetaKeys::rating_overall_key() ] ) && ! empty( $a[ '_' . MetaKeys::rating_overall_key() ] ) ) {
			return $b[ '_' . MetaKeys::rating_overall_key() ] <=> $a[ '_' . MetaKeys::rating_overall_key() ];
		}

		return 0;
	}

	/**
	 * @param array $a
	 * @param array $b
	 *
	 * @return int
	 */
	public static function sort_by_custom_display_order_2( array $a, array $b ): int {
		$a_display_order = $a[ '_' . MetaKeys::display_order_key() ] ?? 0;
		$b_display_order = $b[ '_' . MetaKeys::display_order_key() ] ?? 0;

		return $a_display_order <=> $b_display_order;
	}
}
