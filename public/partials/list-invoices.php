<?php
/**
 * List Stripe Invoices
 *
 * @link       https://www.nexusmerchants.com
 * @since      1.0.0
 *
 * @package    Customer_Portal_For_Stripe
 * @subpackage Customer_Portal_For_Stripe/public/partials
 */
?>
<div class="wpscp wpscp-invoices">
    <h3>Your Invoices</h3>
    <?php if (empty($items->data)) : ?>
        <p>You don't have any invoices</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>Description</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($items->data as $invoice) : ?>
                <tr>
                    <td>
                        <?php
                        $lineItem = $invoice->lines->first();
                        $description = $lineItem->description ?? 'Unknown';
                        ?>
                        <a href="<?= $invoice->hosted_invoice_url ?? ''; ?>" target="_blank" rel="noopener"><?= $description; ?></a>
                    </td>
                    <td><?= ucfirst($invoice->status); ?></td>
                    <td><?= (new DateTime('@' . $invoice->created))->format('Y-m-d H:i:s'); ?> UTC</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
