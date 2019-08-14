====  OrderForms.com Stripe Manager  ====
Contributors: orderforms
Donate link: http://www.nexusmerchants.com/
Tags: Stripe, Subscription, Listing, Members
Requires at least: 4.5
Tested up to: 5.2.2
Stable tag: 3.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

List Stripe subscriptions inside WordPress. Users can deactivate/activate own subscription(s) and add/update credit card data.

== Description ==

- Gets Stripe customer data using user's WordPress login email.
- Users can activate/deactivate their Stripe subscription(s).
- Users can update/add credit card data stored in Stripe.

== Usage ==

Place any of the following shortcodes into a page where you want to display the subscriptions/credit card tools.

`[stripemanager_subscriptions_active]`: Lists active Stripe subscriptions. `Cancel` button available.

`[stripemanager_subscriptions_active_cancel_off]`: Lists active Stripe subscriptions. `Cancel` button unavailable.

`[stripemanager_subscriptions_active_cancel_EndOfCycle]`: Lists active Stripe subscriptions. Subscription will be cancelled at the end of cycle. `Cancel` button available.

`[stripemanager_subscriptions_inactive]`: Lists inactive Stripe subscriptions.

`[stripemanager_subscriber_cardList]`: Stripe credit card management.

`[stripemanager_transactions]`: Lists Stripe invoices.

== Installation ==

1. Upload "OrderForms.com Stripe Manager" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Set the Stripe secret in settings page.

= Issues / Bug reporting =

Problems, questions, bugs & suggestions: https://github.com/nexusmerchants/wp-orderforms-stripe/issues

== Changelog ==

= 3.1.0 =
* `[stripemanager_subscriptions_active_cancel_EndOfCycle]` now includes subscriptions with status:trialing
* Cleanup

= 3.0 =
* Created webhook to run api goal
* switch off customer not available message(do not display anything) all shortcodes
* add the user if not exists in stripe and the card at the same time

= 2.3.9 =
* CSS changes

= 2.3.8 =
* Bug fixes

= 2.3.7 =
* Add a card in popup

= 2.3.6 =
* Updates

= 2.3.5 =
* Add card issue update

= 2.3.4 =
* Help page layout and Add card issue fixes

= 2.3.3 =
* Width Issue with by bootstrap fix

= 2.3.2 =
* Inactive plan issue and background color fix

= 2.3.1 =
* Optimizepress and spelling mistake fix

= v1.0 =
* Initial release version
