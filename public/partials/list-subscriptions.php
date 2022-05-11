<?php
/**
 * List Stripe Subscriptions
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/public/partials
 */
?>
<div class="cpfs cpfs-subscriptions">
    <h3>Your Subscriptions</h3>
	<?php if ( empty( $items ) ) : ?>
        <p>You don't have any subscriptions</p>
	<?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Plan</th>
                <th>Status</th>
                <th>Expires</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ( $items as $subscription ) : ?>
                <tr>
                    <td>
						<?php
						$item    = $subscription->items->first();
						$product = $item['price']->product->name ?? 'Unknown';
						$plan    = $item['plan']->nickname ?? 'Unknown';
						?>
						<?php echo "{$product}: {$plan}"; ?>
                    </td>
                    <td><?php echo ucfirst( $subscription->status ); ?></td>
                    <td><?php echo ( new DateTime( '@' . $subscription->current_period_end ) )->format( 'Y-m-d H:i:s' ); ?>
                        UTC
                    </td>
                    <td class="action-column">
						<?php if ( $atts['allow-cancel'] === 'true' && $subscription->status === 'active' ) : ?>
                            <button type="button" class="btn-cancel-subscription" data-subscription-name="<?php echo "{$product}: {$plan}"; ?>" data-subscription-id="<?php echo $subscription->id; ?>">
                                Cancel
                            </button>
						<?php endif; ?>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>
	<?php endif; ?>
</div>

<?php if ( ! empty( $items ) && ( $atts['allow-cancel'] === 'true' ) ) : ?>
    <script>
        var ajaxurl = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
        const btnCancelSubscription = document.querySelector('.btn-cancel-subscription')

        btnCancelSubscription.addEventListener('click', (e) => {
            e.preventDefault()
            const subscriptionId = e.target.dataset.subscriptionId
            const subscriptionName = e.target.dataset.subscriptionName

            if (!confirm(`Cancel subscription "${subscriptionName}" ?`)) {
                return
            }

            jQuery.ajax({
                method: "POST",
                url: ajaxurl,
                data: {
                    action: 'cpfs_cancelSubscription',
                    subscriptionId: subscriptionId,
                }
            }).done((response) => {
                // console.debug(response)
                window.location.reload()
            }).fail((error) => {
                // console.error(error)
            })
        })
    </script>
<?php endif; ?>
