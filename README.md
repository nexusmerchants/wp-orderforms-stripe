# Customer Portal for Stripe

Contributors: nexusmerchants, tacocode  
Donate link: https://www.orderforms.com  
Tags: stripe, billing, customer, subscription, invoice, checkout, credit-card  
Requires at least: 5.7.2  
Tested up to: 5.9.3  
Stable tag: 4.1.0   
Requires PHP: 7.4   
License: GPLv2 or later 
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Provides shortcodes for Stripe Invoices, Subscriptions & Cards.

## Description

Customer Portal for Stripe provides shortcodes which allows the currently signed in user to
manage their Stripe subscriptions, see their invoices & manage their cards:

- `[cpfs_list_subscriptions allow-cancel="true"]`
  Lists up to 10 Stripe subscriptions. The default value for`allow-cancel` is `false`.
  To allow a user to cancel their subscriptions, set `allow-cancel="true"`.

- `[cpfs_list_invoices]`
  Lists up to 10 Stripe invoices.

- `[cpfs_list_cards]`
  Lists up to 10 credit cards stored at Stripe.

- `[cpfs_add_card]`
  Allows a user to add a new card. The newly added card will be set as default.

**Notes:**

- On first visit of any of the pages containing a `cpfs_*` shortcode, the currently signed in user will be looked up
  in Stripe using the user's email address. If not matching customer is found, a customer will be created.
  
- If needed, an administrator can manually link a Stripe cutomer ID to a user by editing the affected user profile 
  in WP Admin and updating the `Stripe Customer ID` field.

- If an administrator updates the email address of any user in WP Admin, the Stripe customer email will be updated as 
  well (or created if the customer doesn't exist).

- If a user updates their email address in WordPress, **_their email will not be updated in Stripe_**.

- Responses from Stripe are being cached for 15 minutes to avoid excessive API calls.

## Installation

1. Upload `customer-portal-for-stripe` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place any of the `[cpfs_*]` shortcodes into your pages

---

## Changelog

**4.1.0**
- Complete plugin rewrite

**1.1.0**   
- Initial release

## Upgrade Notice

**4.1.0**
- This upgrade is incompatible with previous versions as it replaces all shortcodes. 
