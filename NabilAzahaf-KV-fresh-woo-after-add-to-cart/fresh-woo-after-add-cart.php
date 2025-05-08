<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link               
 * @since             1.0.0
 * @package           FreshWooAfterAddCart
 *
 * @wordpress-plugin
 * Plugin Name:       Fresh Woo After Add Cart
 * Plugin URI:         
 * Description:       Adds a after add to cart popup
 * Version:           2.3
 * Author:            Nabil Azahaf (Kersvers Digital) 
 * Author URI:         
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fresh-woo-after-add-cart
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('FRESH_WOO_AFTER_ADD_CART_VERSION', '2.3');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-fresh-woo-after-add-cart-activator.php
 */
function activate_fresh_woo_after_add_cart()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-fresh-woo-after-add-cart-activator.php';
	FreshWooAfterAddCart_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-fresh-woo-after-add-cart-deactivator.php
 */
function deactivate_fresh_woo_after_add_cart()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-fresh-woo-after-add-cart-deactivator.php';
	FreshWooAfterAddCart_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_fresh_woo_after_add_cart');
register_deactivation_hook(__FILE__, 'deactivate_fresh_woo_after_add_cart');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-fresh-woo-after-add-cart.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fresh_woo_after_add_cart()
{

	$plugin = new FreshWooAfterAddCart();
	$plugin->run();
}
run_fresh_woo_after_add_cart();
