<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link        
 * @since      1.0.0
 *
 * @package    FreshWooAfterAddCart
 * @subpackage FreshWooAfterAddCart/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    FreshWooAfterAddCart
 * @subpackage FreshWooAfterAddCart/includes
 * @author       < >
 */
class FreshWooAfterAddCart_i18n
{


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain(
			'fresh-woo-after-add-cart',
			false,
			dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
		);
	}
}
