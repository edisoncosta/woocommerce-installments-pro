<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin settings class.
 */
class Woocommerce_Installments_Pro_Settings {

	/**
	 * Initialize the settings.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'settings_menu' ), 59 );
		add_action( 'admin_init', array( $this, 'plugin_settings' ) );
	}
	/**
	 * Add the settings page.
	 *
	 * @return void
	 */
	public function settings_menu() {
		add_submenu_page(
			'woocommerce',
			__( 'Installments', 'wip' ),
			__( 'Installments', 'wip' ),
			'manage_options',
			'woocommerce-installments-pro',
			array( $this, 'html_settings_page' )
		);
	}        
	/**
	 * Render the settings page for this plugin.
	 *
	 * @return void
	 */
	public function html_settings_page() {
		include_once 'views/html-settings-page.php';
	}
 	public function plugin_settings() {
		$option = 'wip_settings';

		// Set Custom Fields section.
		add_settings_section(
			'options_section',
			__( 'Installment of the display options:', 'wip' ),
			array( $this, 'section_options_callback' ),
			$option
		);
		// Displays Product Price is Required option.
		add_settings_field(
			'display_product',
			__( 'Displays Product Price?', 'wip' ),
			array( $this, 'checkbox_element_callback' ),
			$option,
			'options_section',
			array(
				'menu'  => $option,
				'id'    => 'display_product',
				'label' => __( 'If checked the parcels will be displayed in the product price.', 'wip' )
			)
		);
		// Register settings.
		register_setting( $option, $option, array( $this, 'validate_options' ) );
	}
	/**
	 * Section null fallback.
	 *
	 * @return void.
	 */
	public function section_options_callback() {

	}

	/**
	 * Checkbox element fallback.
	 *
	 * @return string Checkbox field.
	 */
	public function checkbox_element_callback( $args ) {
		$menu    = $args['menu'];
		$id      = $args['id'];
		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : '0';
		}

		$html = '<input type="checkbox" id="' . $id . '" name="' . $menu . '[' . $id . ']" value="1"' . checked( 1, $current, false ) . '/>';

		if ( isset( $args['label'] ) ) {
			$html .= ' <label for="' . $id . '">' . $args['label'] . '</label>';
		}

		if ( isset( $args['description'] ) ) {
			$html .= '<p class="description">' . $args['description'] . '</p>';
		}

		echo $html;
	}

	/**
	 * Select element fallback.
	 *
	 * @return string Select field.
	 */
	public function select_element_callback( $args ) {
		$menu    = $args['menu'];
		$id      = $args['id'];
		$options = get_option( $menu );

		if ( isset( $options[ $id ] ) ) {
			$current = $options[ $id ];
		} else {
			$current = isset( $args['default'] ) ? $args['default'] : 0;
		}

		$html = '<select id="' . $id . '" name="' . $menu . '[' . $id . ']">';
			foreach ( $args['options'] as $key => $value ) {
				$html .= sprintf( '<option value="%s" %s>%s</option>', $key, selected( $current, $key, false ), $value );
			}
		$html .= '</select>';

		if ( isset( $args['description'] ) ) {
			$html .= '<p class="description">' . $args['description'] . '</p>';
		}

		echo $html;
	}

	/**
	 * Valid options.
	 *
	 * @param  array $input options to valid.
	 *
	 * @return array        validated options.
	 */
	public function validate_options( $input ) {
		$output = array();

		// Loop through each of the incoming options.
		foreach ( $input as $key => $value ) {
			// Check to see if the current option has a value. If so, process it.
			if ( isset( $input[ $key ] ) ) {
				$output[ $key ] = woocommerce_clean( $input[ $key ] );
			}
		}

		return $output;
	}
}

new Woocommerce_Installments_Pro_Settings();
        
                