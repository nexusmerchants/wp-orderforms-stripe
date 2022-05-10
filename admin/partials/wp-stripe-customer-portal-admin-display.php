<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/admin/partials
 */
?>

<div class="wrap">
    <h1>Stripe Customer Portal Settings</h1>
    <form method="POST" action="options.php">
        <?php
        settings_fields( 'wp_stripe_customer_portal_settings' );
        do_settings_sections( 'wp_stripe_customer_portal_settings' );
        submit_button(); ?>
    </form>
</div>
