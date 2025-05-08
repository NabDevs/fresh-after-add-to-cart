<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link        
 * @since      1.0.0
 *
 * @package    FreshWooAfterAddCart
 * @subpackage FreshWooAfterAddCart/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    FreshWooAfterAddCart
 * @subpackage FreshWooAfterAddCart/public
 * @author       < >
 */
class FreshWooAfterAddCart_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Returns crosssell products for a specific product id
	 */
	public function after_add_to_cart()
	{

		$data = [];
		$added_product = wc_get_product($_POST['product_id']);
		$data['added_product'] = $added_product;

		$data['variation'] = "";
		if ($added_product->is_type('variable')) {
			// Get WC_Product_Variation Object
			$variation = wc_get_product($_POST['variation_id']);
			// Is a WC_Product
			if (is_a($variation, 'WC_Product')) {
				// Variation name
				$data['variation'] = wc_get_formatted_variation($variation->get_variation_attributes(), true);
			}
		}

		$crosssell_ids = get_post_meta($_POST['product_id'], '_crosssell_ids', true);
		if (!$crosssell_ids) {
			global $woocommerce;

			$cart_items = $woocommerce->cart->get_cart();
			$cross_sell_ids = array();

			foreach ($cart_items as $item) {
				$product = wc_get_product($item['product_id']);
				$cross_sells = $product->get_cross_sell_ids();

				foreach ($cross_sells as $id) {
					if (!in_array($id, $cross_sell_ids)) {
						$cross_sell_ids[] = $id;
					}
				}
			}
		}

		$data['products'] = [];
		if ($crosssell_ids) {
			$args = [
				'limit'  => -1,
				'include' => $crosssell_ids
			];

			$data['products'] = wc_get_products($args);
		}

		$buttons = [
			[
				'text' => __('checkout', 'fresh-woo-after-add-cart'),
				'type' => 'action',
				'action' => get_option('woocommerce_cart_redirect_after_add') == 'yes' ? wc_get_checkout_url() : wc_get_cart_url(),
			],
			[
				'text' => __('continue shopping', 'fresh-woo-after-add-cart'),
				'type' => 'close'
			]
		];

		$this->get_fresh_woo_after_add_cart('add-to-cart', __('added to cart', 'fresh-woo-after-add-cart'), $data, $buttons);
	}

	public function woo_ajax_add_to_cart()
	{
		$product_id = apply_filters('custom_woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
		$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
		$variation_id = absint($_POST['variation_id']);
		$passed_validation = apply_filters('custom_woocommerce_add_to_cart_validation', true, $product_id, $quantity);
		$product_status = get_post_status($product_id);
		if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
			do_action('custom_woocommerce_ajax_added_to_cart', $product_id);
			if ('yes' === get_option('custom_woocommerce_cart_redirect_after_add')) {
				wc_add_to_cart_message(array($product_id => $quantity), true);
			}
			WC_AJAX::get_refreshed_fragments();
		} else {
			$data = array(
				'error' => true,
				'product_url' => apply_filters('custom_woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
			);
			echo wp_send_json($data);
		}
		wp_die();
	}

	private function get_fresh_woo_after_add_cart($template, $title, $data, $buttons)
	{
		ob_start();

		include_once 'partials/fresh-woo-after-add-cart-open.php';
		include_once "partials/fresh-woo-after-add-cart-content-{$template}.php";
		include_once 'partials/fresh-woo-after-add-cart-content-footer.php';
		include_once 'partials/fresh-woo-after-add-cart-close.php';

		$fragment = ob_get_contents();
		ob_end_clean();

		echo wp_send_json($fragment);
		die();
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{
		if (!is_cart() && !is_checkout()) {
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/fresh-woo-after-add-cart-public.css', array(), $this->version, 'all');
			wp_enqueue_style('swiper-11', plugin_dir_url(__FILE__) . 'vendor/swiper-11/swiper-bundle.min.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{
		if (!is_cart() && !is_checkout()) {
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/fresh-woo-after-add-cart-public.js', ['jquery', 'swiper-11'], $this->version, true);
			wp_enqueue_script('swiper-11', plugin_dir_url(__FILE__) . 'vendor/swiper-11/swiper-bundle.min.js', [], $this->version, true);
			wp_localize_script($this->plugin_name, 'localized', ['ajax_url' => admin_url('admin-ajax.php')]);
		}
	}
}
