<?php

namespace WPCustomerPortalForStripe;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/admin
 */
class Customer_Portal_For_Stripe_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param  string  $plugin_name  The name of this plugin.
	 * @param  string  $version  The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Customer_Portal_For_Stripe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Customer_Portal_For_Stripe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/customer-portal-for-stripe-admin.css',
			array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Customer_Portal_For_Stripe_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Customer_Portal_For_Stripe_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/customer-portal-for-stripe-admin.js',
			array( 'jquery' ), $this->version, false );

		$cssEditor = wp_enqueue_code_editor( array( 'type' => 'text/css' ) );

		if ( empty( $cssEditor ) ) {
			return;
		}

		wp_add_inline_script(
			'code-editor',
			sprintf(
				'jQuery( function() { wp.codeEditor.initialize("cpfs_custom_css", %s); } );',
				wp_json_encode( $cssEditor )
			)
		);
	}

	/**
	 * Add a settings link to the plugin list page
	 *
	 * @param $links
	 *
	 * @return mixed
	 */
	function plugin_settings_link( $links ) {
		$url = esc_url( add_query_arg(
			'page',
			'customer-portal-for-stripe',
			get_admin_url() . 'admin.php'
		) );

		$settings_link = '<a href="' . $url . '">' . __( 'Settings',
				CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN ) . '</a>';

		$links[] = $settings_link;

		return $links;
	}

	/**
	 * Adds a menu entry at Tools > WP Attachment Export
	 */
	public function admin_menu() {
		add_options_page(
			esc_attr__( 'Stripe Customer Portal', 'customer-portal-for-stripe' ),
			esc_attr__( 'Stripe Customer Portal', 'customer-portal-for-stripe' ),
			'manage_options',
			'customer-portal-for-stripe',
			array( $this, 'admin_screen' ),
			25
		);
	}

	/**
	 *
	 */
	public function admin_screen() {
		$this->enqueue_styles();
		$this->enqueue_scripts();
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/customer-portal-for-stripe-admin-display.php';
	}

	public function admin_notice() {
		?>
		<div class="notice notice-success is-dismissible">
			<p>Your settings have been updated!</p>
		</div><?php
	}

	/**
	 *
	 */
	public function admin_settings_sections() {
		add_settings_section( 'stripe_keys_section', 'Stripe Keys', false, 'customer_portal_for_stripe_settings' );
		add_settings_section( 'customization_section', 'Customizations', false, 'customer_portal_for_stripe_settings' );
	}

	/**
	 *
	 */
	public function admin_settings_fields() {
		$fields = [
			[
				'uid'         => 'cpfs_stripe_secret_key',
				'label'       => 'Stripe Secret Key',
				'section'     => 'stripe_keys_section',
				'type'        => 'password',
				'options'     => false,
				'placeholder' => 'sk_...',
			],
			[
				'uid'         => 'cpfs_stripe_publishable_key',
				'label'       => 'Stripe Publishable Key',
				'section'     => 'stripe_keys_section',
				'type'        => 'password',
				'options'     => false,
				'placeholder' => 'pk_...',
			],
			[
				'uid'         => 'cpfs_custom_css',
				'label'       => 'Custom CSS',
				'section'     => 'customization_section',
				'type'        => 'code',
				'options'     => false,
				'placeholder' => null,
			]
		];

		foreach ( $fields as $field ) {
			add_settings_field( $field['uid'], $field['label'], array(
				$this,
				'admin_settings_fields_callback'
			), 'customer_portal_for_stripe_settings', $field['section'], $field );
			register_setting(
				'customer_portal_for_stripe_settings', $field['uid'],
				function ( $value ) use ( $field ) {
					return $this->admin_settings_fields_validation_callback( $value, $field['uid'] );
				}
			);
		}
	}

	/**
	 * @param $arguments
	 */
	public function admin_settings_fields_callback( $arguments ) {
		$value = get_option( $arguments['uid'] ); // Get the current value, if there is one
		if ( ! $value ) { // If no value exists
			$value = $arguments['default'] ?? ''; // Set to our default
		}

		// Check which type of field we want
		switch ( $arguments['type'] ) {
			case 'text': // If it is a text field
			case 'password':
				printf( '<input class="regular-text" name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" autocomplete="off" />',
					$arguments['uid'], $arguments['type'], $arguments['placeholder'], $value );
				break;
			case 'textarea':
				printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
					$arguments['uid'], $arguments['placeholder'], $value );
				break;
			case 'code':
				printf( '<textarea class="large-text code" name="%1$s" id="%1$s" placeholder="%2$s" rows="10" cols="50">%3$s</textarea>',
					$arguments['uid'], $arguments['placeholder'], $value );
				break;
		}
	}

	/**
	 * @param $value
	 * @param $uid
	 *
	 * @return mixed
	 */
	public function admin_settings_fields_validation_callback( $value, $uid ) {
		$valid = true;

		switch ( $uid ) {
			case 'cpfs_stripe_secret_key':
				if ( ! preg_match( '/^sk_(test_|live_)?[A-Za-z0-9]{8,}/', $value ) ) {
					$valid = false;
					add_settings_error( 'cpfs_stripe_secret_key', esc_attr( 'cpfs_stripe_secret_key' ), 'Please enter a valid Secret Key.' );
				}
				break;

			case 'cpfs_stripe_publishable_key':
				if ( ! preg_match( '/^pk_(test_|live_)?[A-Za-z0-9]{8,}/', $value ) ) {
					$valid = false;
					add_settings_error( 'cpfs_stripe_publishable_key', esc_attr( 'cpfs_stripe_publishable_key' ), 'Please enter a valid Public Key.' );
				}
				break;
		}

		if ( ! $valid ) {
			$value = get_option( $uid, '' );
		}

		return $value;
	}

	/**
	 * @param $user
	 */
	function stripe_customer_id_user_profile_field( $user ) {
		if ( current_user_can( 'manage_options', $user->ID ) ) {
			require_once CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_PATH . 'admin/partials/customer-portal-for-stripe-customer-id-user-profile-field.php';
		}
	}

	/**
	 * @param $errors
	 * @param $update
	 * @param $user
	 *
	 * @return void
	 */
	function stripe_customer_id_user_profile_field_errors( $errors, $update, $user ) {
		if (empty($update)) {
			return;
		}

		$stripeCustomerId = sanitize_text_field( $_POST['stripeCustomerId'] );

		// The field is not required. Bail.
		if ( empty( trim( $stripeCustomerId ) ) ) {
			return;
		}

		if ( preg_match( '/^cus_[A-Za-z0-9]{8,}/', $stripeCustomerId ) ) {
			return;
		}

		$errors->add( 'stripeCustomerId_error', __( 'Please enter a valid Stripe Customer ID.', CUSTOMER_PORTAL_FOR_STRIPE_PLUGIN_TEXTDOMAIN ) );
	}

	/**
	 * @param $user_id
	 *
	 * @return false|void
	 */
	function save_stripe_customer_id_user_profile_field( $user_id ) {
		if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
			return;
		}

		if ( ! current_user_can( 'manage_options', $user_id ) ) {
			return false;
		}

		update_user_meta( $user_id, 'cpfs_stripe_customer_id', sanitize_text_field( $_POST['stripeCustomerId'] ) );
	}
}
