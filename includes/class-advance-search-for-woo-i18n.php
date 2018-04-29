<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 * @author     Umang Vaghela <umangvaghela123@gmail.com>
 */
class Advance_Search_For_Woo_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'advance-search-for-woo',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}