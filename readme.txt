=== WooCommerce Stop Checkout if No Shipping Options ===
Contributors: Ahkonsu, WPProAtoZ
Donate link: https://wpproatoz.com/donate
Tags: woocommerce, checkout, shipping, restrict checkout, no shipping, prevent order, shipping validation, virtual products, us only shipping
Requires at least: 6.0
Tested up to: 6.9
Stable tag: 1.0.2
Requires PHP: 8.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Prevents customers from completing checkout when no shipping options are available for their address, while allowing virtual/downloadable-only carts to proceed normally.

== Description ==

This lightweight, no-settings plugin blocks checkout completion if WooCommerce finds **no shipping rates** for the customer's address (e.g., non-US country when zones are set to US-only). It provides a better user experience and prevents invalid orders.

**Key features:**
- **Hides** the Place Order button and payment section when shipping is required but unavailable
- Displays clear, user-friendly error notices (customizable via translation)
- **Redirects** direct access to `/checkout` back to the cart with a notice including a clickable cart link
- **Allows** virtual or downloadable-only carts to checkout normally (no shipping required)
- **Blocks** mixed carts (physical + virtual) if shipping isn't available for the address
- Works reliably on **classic shortcode checkout** (with partial support for block-based via CSS)
- Very lightweight — no admin settings, no bloat
- Uses proper text domain for translations
- Ideal for US-only shipping stores or strict regional fulfillment

== Installation ==

1. Upload the entire `woocommerce-stop-checkout-no-shipping` folder to the `/wp-content/plugins/` directory  
   — OR —  
   Install via **Plugins → Add New → Upload Plugin** in WordPress admin.
2. Activate the plugin through the **Plugins** menu.
3. Done! No configuration required — it works automatically on cart/checkout flows.

== Frequently Asked Questions ==

= Does this work with virtual or downloadable products? =

Yes! Carts containing **only** virtual/downloadable items (marked as such in WooCommerce) require no shipping and are fully allowed to checkout, regardless of address. Mixed carts (physical + virtual) are treated as shippable and blocked if no rates match.

= What happens with mixed carts (physical + virtual items)? =

Shipping is required for the physical items, so the plugin blocks checkout if no shipping rates are available (same as physical-only carts). Virtual items don't bypass the check.

= Does this support the block-based (Gutenberg) Checkout page? =

It primarily targets classic shortcode checkout with reliable hiding/redirects. For block checkout, it applies CSS to hide buttons where possible, but WooCommerce core usually prevents submission anyway. Test on your setup — some block elements may need extra CSS tweaks.

= Why might the Place Order button still appear briefly? =

On AJAX address changes, WooCommerce refreshes sections dynamically. The plugin hides via inline CSS on load and updates, but heavy themes/page builders (Elementor, Divi) might override styles. Inspect the button and add custom selectors if needed, or pair with **Conditional Payments for WooCommerce** (free plugin) for stronger gateway control.

= Can I customize the error messages? =

Yes — messages use the text domain `woocommerce-stop-checkout-no-shipping` and are translatable. Edit directly in the plugin file or create .po/.mo files. Future versions may add a settings page for easier customization.

= Will this conflict with other plugins? =

It's non-intrusive and usually compatible. Test with your shipping (e.g., Table Rate, Flexible Shipping) or payment plugins (PayPal, Stripe). If gateways still show when blocked, consider adding conditional logic via free plugins.

= How do I test it? =

- Add physical product → non-supported address → checkout blocked/hidden + notice.
- Add virtual product only → any address → checkout allowed.
- Mixed cart → behaves like physical.

== Screenshots ==

1. Checkout with non-supported address (shippable items) – Place Order button hidden + error notice shown
2. Direct /checkout attempt with invalid address – redirects to cart with notice including clickable cart link

== Changelog ==

= 1.0.2 =
* Added support for virtual/downloadable-only carts (allow checkout normally)
* Blocks mixed carts (physical + virtual) when shipping unavailable
* Improved error notices: Added "Your cart contains items that we do not ship to your area." phrasing
* Redirect notice now includes clickable link back to cart
* Forced shipping calculation in more places for reliability on address changes

= 1.0.1 =
* Fixed premature blocking on valid addresses by forcing calculate_shipping()
* Added check to allow virtual/downloadable carts

= 1.0.0 =
* Initial release
* Hide Place Order button/payment section when no shipping rates
* Redirect direct /checkout to cart
* Basic notice and CSS hiding for classic checkout

== Upgrade Notice ==

= 1.0.2 =
Major improvement: Virtual-only carts now allowed; mixed carts blocked correctly; nicer error messages with cart link. Update recommended for stores selling both physical and digital products.

= 1.0.1 =
Fixes false blocking on valid shipping zones — update immediately.

== Additional Info ==

Plugin URI: https://wpproatoz.com  
GitHub: https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail  
Author: WPProAtoZ.com

Feedback, bug reports, feature requests, and pull requests welcome!