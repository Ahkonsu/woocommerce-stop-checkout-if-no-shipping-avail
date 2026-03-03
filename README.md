# WooCommerce Stop Checkout if No Shipping Options
![Plugin Version](https://img.shields.io/badge/version-1.0.2-blue.svg) ![WordPress](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg) ![WooCommerce](https://img.shields.io/badge/WooCommerce-8.0%2B-blue.svg) ![PHP](https://img.shields.io/badge/PHP-8.0%2B-blue.svg) ![License](https://img.shields.io/badge/license-GPLv2-green.svg)

A lightweight WordPress/WooCommerce plugin that prevents checkout completion when no shipping rates are available for the customer's address (ideal for US-only shipping stores), while allowing virtual/downloadable products to proceed normally.

---
## Overview

**WooCommerce Stop Checkout if No Shipping Options** blocks invalid orders by hiding the Place Order button, disabling payment gateways visually, and redirecting direct access to `/checkout` ? cart when shipping is required but unavailable (e.g., non-US address with US-only zones).

It smartly allows carts with **only virtual/downloadable items** to checkout freely (no shipping needed), but blocks **mixed carts** (physical + virtual) if shipping fails.

Developed by **[WPProAtoZ](https://wpproatoz.com)** — no admin settings, no bloat, just reliable protection against undeliverable orders.

GitHub: [https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail](https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail)

---
## Features

- **Blocks checkout** when shipping is required but no rates match the address
- **Hides** Place Order button and payment section via inline CSS
- **Shows** clear error notices (with custom phrasing: "Your cart contains items that we do not ship to your area.")
- **Redirects** direct `/checkout` attempts to cart with a notice including a **clickable cart link**
- **Allows** virtual/downloadable-only carts to checkout normally (any address)
- **Blocks** mixed carts (physical + virtual) if shipping unavailable
- **Optimized** for classic shortcode checkout (CSS targets block elements too where possible)
- **Lightweight** — no database options, no heavy hooks, proper text domain for translations
- **Safe** — forces shipping recalculation, skips empty carts/endpoints

Perfect for stores limiting shipping to specific regions (e.g., US-only) while selling digital products.

---
## Installation

1. **Download** the latest release from [GitHub Releases](https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail/releases)
2. **Upload** via WordPress admin: **Plugins ? Add New ? Upload Plugin** ? select the `.zip`
3. **Activate** the plugin
4. Done! No configuration needed — it activates automatically on cart/checkout

Alternatively, clone the repo:
```bash
git clone https://github.com/Ahkonsu/woocommerce-stop-checkout-if-no-shipping-avail.git woocommerce-stop-checkout-no-shipping
