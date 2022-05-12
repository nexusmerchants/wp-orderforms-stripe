<?php

namespace WPCustomerPortalForStripe;

/**
 * Class Customer_Portal_For_Stripe_Shortcodes
 */
class Customer_Portal_For_Stripe_Shortcodes {
	public static $shortcodes = [
		'cpfs_list_cards',
		'cpfs_add_card',
		'cpfs_list_subscriptions',
		'cpfs_list_invoices',
	];

	/**
	 * Init
	 */
	public function init_shortcodes() {
		foreach ( self::$shortcodes as $shortcode ) {
			add_shortcode( $shortcode, [ $this, $shortcode ] );
		}
	}

	/**
	 * @param $atts
	 * @param  string  $content
	 *
	 * @return string
	 */
	public function cpfs_list_cards( $atts, $content = "" ) {
		if ( ! is_user_logged_in() ) {
			return __( "Please sign in to view this content.", CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN );
		}

		global $cpfsStripe;
		$customer = $cpfsStripe->getOrCreateCustomer();
		$items    = $cpfsStripe->getCards( $customer );

		ob_start();
		require_once CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'public/partials/list-cards.php';

		return ob_get_clean();
	}

	public function cpfs_add_card( $atts, $content = "" ) {
		if ( ! is_user_logged_in() ) {
			return __( "Please sign in to view this content.", CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN );
		}

		global $cpfsStripe;

		try {
			$customer = $cpfsStripe->getOrCreateCustomer();
		} catch ( \Exception $e ) {
			wp_die( $e->getMessage() );
		}

		if ( $customer ) {
			try {
				$setupIntent = $cpfsStripe->createSetupIntent( $customer );
			} catch ( \Exception $e ) {
				wp_die( $e->getMessage() );
			}
		}

		ob_start();
		require_once CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'public/partials/add-card.php';

		return ob_get_clean();
	}

	public function cpfs_list_subscriptions( $atts, $content = "" ) {
		if ( ! is_user_logged_in() ) {
			return __( "Please sign in to view this content.", CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN );
		}

		$atts = shortcode_atts( array(
			'include-cancelled' => false,
			'allow-cancel'      => false,
		), $atts );

		global $cpfsStripe;

		try {
			$customer = $cpfsStripe->getOrCreateCustomer();
		} catch ( \Exception $e ) {
			wp_die( $e->getMessage() );
		}

		if ( $customer ) {
			try {
				$items = $cpfsStripe->getSubscriptions( $customer );
			} catch ( \Exception $e ) {
				wp_die( $e->getMessage() );
			}
		}

		ob_start();
		require_once(
			CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'public/partials/list-subscriptions.php'
		);

		return ob_get_clean();
	}

	public function cpfs_list_invoices( $atts, $content = "" ) {
		if ( ! is_user_logged_in() ) {
			return __( "Please sign in to view this content.", CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN );
		}

		extract( shortcode_atts( array(
			'limit' => 25,
		), $atts ) );

		global $cpfsStripe;

		try {
			$customer = $cpfsStripe->getOrCreateCustomer();
		} catch ( \Exception $e ) {
			wp_die( $e->getMessage() );
		}

		if ( $customer ) {
			try {
				$items = $cpfsStripe->getInvoices( $customer );
			} catch ( \Exception $e ) {
				wp_die( $e->getMessage() );
			}
		}

		ob_start();
		require_once CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'public/partials/list-invoices.php';

		return ob_get_clean();
	}
}
