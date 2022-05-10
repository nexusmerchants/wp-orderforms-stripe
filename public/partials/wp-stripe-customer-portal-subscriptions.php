<?php
/**
 * List Stripe Subscriptions
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/public/partials
 */
?>
<div class="wpscp wpscp-subscriptions">
    <h3>Your Subscriptions</h3>
    <?php if (empty($items)) : ?>
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
            <?php foreach($items as $subscription) : ?>
                <tr>
                    <td>
                        <?php
                        $item = $subscription->items->first();
                        $product = $item['price']->product->name ?? 'Unknown';
                        $plan = $item['plan']->nickname ?? 'Unknown';
                        ?>
                        <?= "{$product}: {$plan}"; ?>
                    </td>
                    <td><?= ucfirst($subscription->status); ?></td>
                    <td><?= (new DateTime('@' . $subscription->current_period_end))->format('Y-m-d H:i:s'); ?> UTC</td>
                    <td class="action-column">
                        <?php if ($atts['allow-cancel'] === 'true' && $subscription->status === 'active') : ?>
                            <button type="button" class="btn-cancel-subscription" data-subscription-name="<?= "{$product}: {$plan}"; ?>" data-subscription-id="<?= $subscription->id; ?>">Cancel</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php if (!empty($items) && ($atts['allow-cancel'] === 'true')) : ?>
<script>
    var ajaxurl = "<?= admin_url('admin-ajax.php'); ?>";
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
                action: 'wpscp_cancelSubscription',
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
