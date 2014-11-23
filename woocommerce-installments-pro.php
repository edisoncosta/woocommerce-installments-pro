<?php
/*
Plugin Name: WooCommerce Installments PRO
Plugin URI: https://github.com/edisoncosta/woocommerceinstallmentspro
Description: Adiciona ao preço do produto e carrinho opções de parcelamento.
Version: 1.0.0
Author: Edison Costa
Author URI: http://www.lojaplus.com.br
Text Domain: wip
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
Domain Path: /languages
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! class_exists( 'Woocommerce_Installments_Pro' ) ) :

/**
 * Plugin main class.
 */
class Woocommerce_Installments_Pro {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 *
	 */
	private function __construct() {
		// Load plugin text domain.
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_admin() ) {
				$this->admin_includes();
			}

			$this->includes();
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_fallback_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get assets url.
	 *
	 * @return string
	 */
	public static function get_assets_url() {
		return plugins_url( 'assets/', __FILE__ );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-installments-pro' );

		load_textdomain( 'wip', trailingslashit( WP_LANG_DIR ) . 'woocommerce-installments-pro/wip-' . $locale . '.mo' );
		load_plugin_textdomain( 'wip', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Includes.
	 *
	 * @return void
	 */
	private function includes() {
	
	}

	/**
	 * Admin includes.
	 *
	 * @return void
	 */
	private function admin_includes() {
            include_once 'includes/admin/class-wc-wip-settings.php';	    
	}

	/**
	 * WooCommerce fallback notice.
	 *
	 * @return string Fallack notice.
	 */
	public function woocommerce_fallback_notice() {
		echo '<div class="error"><p>' . sprintf( __( 'WooCommerce Installments Pro depends on %s to work!', 'wip' ), '<a href="http://wordpress.org/extend/plugins/woocommerce/">' . __( 'WooCommerce', 'wip' ) . '</a>' ) . '</p></div>';
	}
}

/**
 * Initialize the plugin.
 */
add_action( 'plugins_loaded', array( 'Woocommerce_Installments_Pro', 'get_instance' ) );

endif;
