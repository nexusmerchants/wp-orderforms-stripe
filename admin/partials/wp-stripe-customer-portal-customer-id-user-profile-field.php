<?php
/**
 * Stripe customer id user profile field
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/admin/partials
 */
?>
<hr style="margin:25px 0">
<h3><?php _e("Stripe Customer Portal", WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN); ?></h3>
<table class="form-table">
    <tr>
        <th><label for="stripeCustomerId"><?php _e('Stripe Customer ID', WP_STRIPE_CUSTOMER_PORTAL_PLUGIN_TEXTDOMAIN); ?></label></th>
        <td>
            <input type="text" name="stripeCustomerId" id="stripeCustomerId" value="<?php echo esc_attr( get_user_meta( $user->ID, 'wpscp_stripe_customer_id', true ) ); ?>" class="regular-text" /><br />
        </td>
    </tr>
</table>
