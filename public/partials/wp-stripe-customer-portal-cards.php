<?php
/**
 * List Stripe Cards (Payment Methods)
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Wp_Stripe_Customer_Portal
 * @subpackage Wp_Stripe_Customer_Portal/public/partials
 */
?>
<div class="wpscp wpscp-cards">
    <h3>Your Stored Cards</h3>
    <?php if (empty($items->data)) : ?>
    <p>You don't have any stored cards</p>
    <?php else: ?>
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
            <?php foreach($items->data as $card) : ?>
                <tr>
                    <td><?= $card->billing_details->name; ?></td>
                    <td><?= $card->card->last4; ?></td>
                    <td><?= $card->card->brand; ?></td>
                    <td><?= $card->card->exp_month; ?>/<?= $card->card->exp_year; ?></td>
                    <td><?php if ($card->id === $customer->invoice_settings->default_payment_method) : ?>Yes<?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
