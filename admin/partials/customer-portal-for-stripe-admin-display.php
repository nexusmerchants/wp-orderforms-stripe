<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/admin/partials
 */
?>

<div class="wrap">
    <h1>Stripe Customer Portal Settings</h1>
    <form method="POST" action="options.php">
        <?php
        settings_fields( 'customer_portal_for_stripe_settings' );
        do_settings_sections( 'customer_portal_for_stripe_settings' );
        submit_button(); ?>
    </form>
</div>
