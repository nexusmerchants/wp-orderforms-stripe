====  OrderForms.com Stripe Manager  ====
Contributors: hiren1612,orderforms
Donate link: http://www.nexusmerchants.com/
Tags: Stripe, Subscription, Listing, MembersRequires at least: 3.0.1Tested up to: 5.0.3Stable tag: 4.5
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
A plugin connects stripe and Wordpress. Loggedin user can able to inactivate or activate own subscription and can add/update old Credit card.
== Description ==
- It gets stripe customer's data using wordpress' login Email.
- Activate plugin and set credential in setting page. Add Stripe API Key and it will be connected.
- Logged in user can able to deactivate him self in any active Stripe subscription and vise versa.
- After login, user can able to Update/Add new credit card in stripe.
== Usage ==
Get and list of all cards,active subscription and inActive subscription.
Manage card for Add/Updates.
== Templates ==
ShortCode					                Description
---------	                  				-----------	
[stripemanager_subscriptions_active] List of all active subscription for stripe. It will show CANCEL button to unsubscribe.

[stripemanager_subscriptions_active_cancel_off] List of all active subscription for stripe without CANCEL button.

[stripemanager_subscriptions_active_cancel_EndOfCycle] List of all active subscription for stripe. It shows CANCEL button but it will CANCEL on end of cycle.

[stripemanager_subscriptions_inactive] List of all inactive subscription for stripe.

[stripemanager_subscriber_cardList] List of all cards or add new card in stripe.

[stripemanager_transactions] List Of all invoices for stripe.
== Installation ==
1. Upload "OrderForms.com Stripe Manager" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.== How to Use ==
Place shortcode [memb_list_subscriptions_active] / [memb_list_subscriptions_inactive] / [subscriber_cardList] in wordpress page, you want to display all subscriptions and card list in front-end.	
== Frequently Asked Questions ==
Having problems, questions, bugs & suggestions then Contact us at support@nexusmerchants.com
== Screenshots ==
1. After activating the plugin it will be hooked in Settings Menu.2. MemberList. Here you can Add/Edit stripr API Key.3. Help. Here display all shortcode.4. Frontend display.
== Changelog === v1.0 =
* Initial release version.

= 2.3.1
* Optimizepress and spelling mistake fix

= 2.3.2
* Inactive plan issue and background color fix

= 2.3.3
* Width Issue with by bootstrap fix

= 2.3.4
* Helppage layout and Add card issue fixes

= 2.3.5
* Add card issue update

= 2.3.6
* Updates

= 2.3.7
* Add a card in popup

= 2.3.8
* Bug fixes

= 2.3.9
* CSS changes= 3.0
* Created webhook to run api goal* switch off customer not available message(do not display anything) all shortcodes* add the user if not exists in stripe and the card at the same time