<?php
/**
 * @author Peter Harlacher
 * @license GPL-2.0+
 * @copyright 2021 Peter Harlacher
 * @since 24/5/21 09:41
 */

use Stripe\Customer;

/**
 * Class Wp_Stripe_Customer_Portal_Shortcodes
 */
class Wp_Stripe_Customer_Portal_Stripe
{
    /**
     * @var \Stripe\StripeClient
     */
    private \Stripe\StripeClient $stripeClient;

    /**
     * Wp_Stripe_Customer_Portal_Stripe constructor.
     */
    public function __construct()
    {
        $this->stripeClient = new \Stripe\StripeClient(get_option('wpscp_stripe_secret_key', 'invalid_key'));
    }

    /**
     * @param int|null $userId
     * @param array|null $expand
     *
     * @return \Stripe\Customer|\Stripe\StripeObject
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getOrCreateCustomer(int $userId = null, $expand = null)
    {
        $stripeOptions = empty($expand) ? null : ['expand' => array_values($expand)];
        $user = empty($userId) ? wp_get_current_user() : get_user_by('id', $userId);

        $transientKey = 'wpscpStripeCustomer_' . $user->ID;
        $customer = get_transient($transientKey);

        if ($customer === false) {
            $wpscpStripeCustomerId = get_user_meta($user->ID, 'wpscp_stripe_customer_id', true);

            if (!empty($wpscpStripeCustomerId)) {
                $customer = $this->getCustomer($wpscpStripeCustomerId, $stripeOptions);
            }

            if (empty($customer)) {
                $customer = $this->findCustomer($user, $stripeOptions);
            }

            if (empty($customer) || $customer->isDeleted()) {
                $customer = $this->createCustomer($user, $stripeOptions);
            }

            set_transient($transientKey, $customer, 900);
        }

        return $customer;
    }

    /**
     * @param string $stripeCustomerId
     * @param array|null $stripeOptions
     *
     * @return \Stripe\Customer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getCustomer(string $stripeCustomerId, $stripeOptions = null)
    {
        return $this->stripeClient->customers->retrieve($stripeCustomerId, $stripeOptions);
    }

    /**
     * @param \WP_User $user
     * @param array|null $stripeOptions
     *
     * @return \Stripe\Customer|null
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function findCustomer(WP_User $user, $stripeOptions = null)
    {
        $email = strtolower(trim($user->user_email));
        $customers = $this->stripeClient->customers->all([
            'email' => $email,
            'limit' => 1,
        ], $stripeOptions);

        if (empty($customers->data[0])) {
            return null;
        }

        $customer = $customers->data[0];
        update_user_meta($user->ID, 'wpscp_stripe_customer_id', $customer->id);

        return $customer;
    }

    /**
     * @param \WP_User $user
     * @param array|null $stripeOptions
     *
     * @return \Stripe\Customer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createCustomer(WP_User $user, $stripeOptions = null)
    {
        $customer = $this->stripeClient->customers->create([
            'email' => $user->user_email,
        ], $stripeOptions);

        update_user_meta($user->ID, 'wpscp_stripe_customer_id', $customer->id);

        return $customer;
    }

    /**
     * @param \Stripe\Customer $customer
     *
     * @return \Stripe\SetupIntent
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function createSetupIntent(Customer $customer)
    {
        return $this->stripeClient->setupIntents->create([
            'customer' => $customer->id
        ]);
    }

    /**
     * @param \Stripe\Customer $customer
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getCards(Customer $customer)
    {
        $transientKey = 'wpscpStripeCards_' . $customer->id;
        $data = get_transient($transientKey);

        if ($data === false) {
            $data = $this->stripeClient->paymentMethods->all(
                [
                    'customer' => $customer->id,
                    'type' => 'card',
                    // 'limit' => 10,
                ]
            );

            set_transient($transientKey, $data, 900);
        }

        return $data;
    }

    /**
     * @param \Stripe\Customer $customer
     * @param array|null $stripeOptions
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getInvoices(Customer $customer, $stripeOptions = null)
    {
        $transientKey = 'wpscpStripeInvoices_' . $customer->id;
        $data = get_transient($transientKey);

        if ($data === false) {
            $data = $this->stripeClient->invoices->all(
                [
                    'customer' => $customer->id,
                    // 'limit' => 10,
                ], $stripeOptions
            );

            set_transient($transientKey, $data, 900);
        }

        return $data;
    }

    /**
     * @param \Stripe\Customer $customer
     *
     * @return \Stripe\Collection
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function getSubscriptions(Customer $customer)
    {
        $transientKey = 'wpscpStripeSubscriptions_' . $customer->id;
        $data = get_transient($transientKey);

        if ($data === false) {
            $subscriptions = $this->stripeClient->subscriptions->all(
                [
                    'customer' => $customer->id,
                    // 'limit' => 10,
                ]
            );

            $data = [];
            foreach ($subscriptions as $subscription) {
                $data[] = $this->stripeClient->subscriptions->retrieve(
                    $subscription->id,
                    [
                        'expand' => [
                            'items.data.price.product'
                        ]
                    ]
                );
            }

            set_transient($transientKey, $data, 900);
        }

        return $data;
    }

    /**
     * Cancel a Stripe subscription
     */
    public function cancelSubscription()
    {
        $subscriptionId = sanitize_text_field($_POST['subscriptionId']);

        if (empty($subscriptionId)) {
            return wp_send_json_error([
                'error' => 'Missing subscription ID',
            ], 422);
        }

        try {
            $subscription = $this->stripeClient->subscriptions->retrieve($subscriptionId);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return wp_send_json_error([
                'error' => $e->getMessage(),
            ], 422);
        }

        try {
            $response = $this->stripeClient->subscriptions->cancel($subscriptionId);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return wp_send_json_error([
                'error' => $e->getMessage(),
            ], 422);
        }

        $transientKey = 'wpscpStripeSubscriptions_' . $subscription->customer;
        delete_transient($transientKey);

        return wp_send_json_success([
            'status' => $response->status,
        ]);
    }

    /**
     * Cancel a Stripe subscription
     */
    public function setDefaultPaymentMethod()
    {
        $paymentMethod = sanitize_text_field($_POST['paymentMethod']);

        if (empty($paymentMethod)) {
            return wp_send_json_error([
                'error' => 'Missing paymentMethod',
            ], 422);
        }

        global $wpscpStripe;
        $customer = $wpscpStripe->getOrCreateCustomer();

        try {
            $response = $this->stripeClient->customers->update(
                $customer->id,
                [
                    'invoice_settings' => [
                        'default_payment_method' => $paymentMethod,
                    ]
                ]
            );
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return wp_send_json_error([
                'error' => $e->getMessage(),
            ], 422);
        }

        $transientKey = 'wpscpStripeCards_' . $customer->id;
        delete_transient($transientKey);

        return wp_send_json_success([
            'status' => 'success',
        ]);
    }

    /**
     * @param int $user_id
     * @param \WP_User $oldUserData
     */
    public function updateCustomerEmailAddress(int $user_id, WP_User $oldUserData)
    {
        global $wpscpStripe;
        $user = get_userdata($user_id);
        $oldEmail = strtolower(trim($oldUserData->data->user_email));
        $newEmail = strtolower(trim($user->user_email));

        if ($newEmail !== $oldEmail) {
            $customer = $wpscpStripe->getOrCreateCustomer($user_id);

            try {
                $this->stripeClient->customers->update(
                    $customer->id,
                    [
                        'email' => $newEmail,
                    ]
                );
            } catch (\Stripe\Exception\ApiErrorException $e) {
                throw $e;
            }

            $transientKey = 'wpscpStripeCustomer_' . $user->ID;
            delete_transient($transientKey);
        }
    }
}
