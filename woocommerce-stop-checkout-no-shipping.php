<?php
/**
 * Plugin Name:       WooCommerce Stop Checkout if No Shipping Options
 * Plugin URI:        https://wpproatoz.com
 * Description:       Prevents customers from completing checkout (hides Place Order button and optionally redirects) when no shipping options/rates are available for their address — but allows virtual/downloadable-only carts to proceed normally. Displays a clear error notice with cart link. Optimized for classic shortcode checkout.
 * Version:           1.0.2
 * Requires at least: 6.0
 * Requires PHP:      8.0
 * Author:            WPProAtoZ.com
 * Author URI:        https://wpproatoz.com
 * Text Domain:       woocommerce-stop-checkout-no-shipping
 * Update URI:        https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail/releases
 * GitHub Plugin URI: https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail/releases
 * GitHub Branch:     main
 * Requires Plugins:  woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

 ////***check for updates code

require 'plugin-update-checker/plugin-update-checker.php';
use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

$myUpdateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail/',
	__FILE__,
	'woocommerce-stop-checkout-if-no-shipping-avail'
);

//Set the branch that contains the stable release.
$myUpdateChecker->setBranch('main');

//$myUpdateChecker->getVcsApi()->enableReleaseAssets();
 
 
//Optional: If you're using a private repository, specify the access token like this:
//$myUpdateChecker->setAuthentication('your-token-here');

/////////////////////

// Only run if WooCommerce is active
if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    return;
}

/**
 * Helper function: Check if shipping is required BUT no rates are available
 *
 * @return bool True if shipping is required and no rates exist (block), false otherwise (allow)
 */
function wps_no_shipping_available() {
    // Critical fix: If cart doesn't need shipping at all (virtual/downloadable only), allow checkout
    if ( ! WC()->cart->needs_shipping() ) {
        return false;
    }

    // Force calculation to ensure packages/rates are up-to-date
    WC()->cart->calculate_shipping();

    $packages = WC()->shipping()->get_packages();

    if ( empty( $packages ) ) {
        return true; // Shipping required but no packages → block
    }

    foreach ( $packages as $package ) {
        if ( ! empty( $package['rates'] ) ) {
            return false; // Found rates → allow
        }
    }

    return true; // No rates → block
}

/**
 * 1. On checkout page: Hide Place Order button + payment section + show error notice
 */
add_action( 'woocommerce_checkout_before_customer_details', 'wps_hide_place_order_if_no_shipping' );

function wps_hide_place_order_if_no_shipping() {
    if ( ! is_checkout() ) {
        return;
    }

    if ( wps_no_shipping_available() ) {
        // Improved notice with new language
        $message = esc_html__( 'Your cart contains items that we do not ship to your area. Sorry, we cannot ship to your location with the current address. Please update your shipping details or contact us for assistance.', 'woocommerce-stop-checkout-no-shipping' );

        wc_add_notice( $message, 'error' );

        // Hide Place Order button and payment area via inline CSS
        ?>
        <style>
            #place_order,
            .woocommerce-checkout-payment,
            .wc-block-checkout__place-order-button,
            .wp-block-woocommerce-checkout-place-order-button-block {
                display: none !important;
            }
        </style>
        <?php
    }
}

/**
 * 2. Block direct access to /checkout if no shipping available → redirect to cart with improved notice
 */
add_action( 'template_redirect', 'wps_block_checkout_no_shipping', 20 );

function wps_block_checkout_no_shipping() {
    if ( ! is_checkout() || is_wc_endpoint_url() || WC()->cart->is_empty() ) {
        return;
    }

    // Force calc for early timing
    WC()->cart->calculate_shipping();

    if ( wps_no_shipping_available() ) {
        // Improved notice with cart link
        $cart_url = esc_url( wc_get_cart_url() );
        $message  = sprintf(
            esc_html__( 'Your cart contains items that we do not ship to your area. No shipping options are available for your address. %sPlease return to your cart%s and update your details change to a US address or remove shippable items or contact us for assistance..', 'woocommerce-stop-checkout-no-shipping' ),
            '<a href="' . $cart_url . '">',
            '</a>'
        );

        wc_add_notice( $message, 'error' );

        wp_safe_redirect( $cart_url );
        exit;
    }
}