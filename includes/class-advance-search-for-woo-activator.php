<?php

/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 * @author     Umang Vaghela <umangvaghela123@gmail.com>
 */
class Advance_Search_For_Woo_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() { 
		
		if( !in_array( 'woocommerce/woocommerce.php',apply_filters('active_plugins',get_option('active_plugins'))) && !is_plugin_active_for_network( 'woocommerce/woocommerce.php' )   ) { 
			wp_die( "<strong>Advance Woocommerce All In One Search</strong> Plugin requires <strong>WooCommerce</strong> <a href='".get_admin_url(null, 'plugins.php')."'>Plugins page</a>." );
		}

	}

}
