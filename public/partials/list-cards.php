<?php
/**
 * List Stripe Cards (Payment Methods)
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/public/partials
 */

?>
<div class="cpfs cpfs-cards">
	<h3>Your Stored Cards</h3>
	<?php if ( empty( $items->data ) ) : ?>
		<p>You don't have any stored cards</p>
	<?php else : ?>
		<table>
			<thead>
			<tr>
				<th>Cardholder</th>
				<th>Last 4</th>
				<th>Brand</th>
				<th>Expires</th>
				<th>Default</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ( $items->data as $card ) : ?>
				<?php
				$is_default_card = in_array( $card->id, [
					$customer->invoice_settings->default_payment_method,
					// $customer->default_source
				] )
				?>
				<tr>
					<td><?php esc_html_e( $card->billing_details->name ); ?></td>
					<td><?php esc_html_e( $card->card->last4 ); ?></td>
					<td><?php esc_html_e( $card->card->brand ); ?></td>
					<td><?php esc_html_e( "{$card->card->exp_month}/{$card->card->exp_year}" ); ?></td>
					<td><?php if ( $is_default_card ) : ?>Yes<?php endif; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
