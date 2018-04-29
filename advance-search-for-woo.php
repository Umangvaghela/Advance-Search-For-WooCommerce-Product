<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           Advance_Search_For_Woo
 *
 * @wordpress-plugin
 * Plugin Name:       Advance Search For Woo
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Umang vaghela
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       advance-search-for-woo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define(PLUGIN_SLUG, 'advance-search-for-woo');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-advance-search-for-woo-activator.php
 */
function activate_advance_search_for_woo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advance-search-for-woo-activator.php';
	Advance_Search_For_Woo_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-advance-search-for-woo-deactivator.php
 */
function deactivate_advance_search_for_woo() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-advance-search-for-woo-deactivator.php';
	Advance_Search_For_Woo_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_advance_search_for_woo' );
register_deactivation_hook( __FILE__, 'deactivate_advance_search_for_woo' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-advance-search-for-woo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_advance_search_for_woo() {

	$plugin = new Advance_Search_For_Woo();
	$plugin->run();

}
run_advance_search_for_woo();
