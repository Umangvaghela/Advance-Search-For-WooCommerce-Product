<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/includes
 * @author     Umang Vaghela <umangvaghela123@gmail.com>
 */
class Advance_Search_For_Woo {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Advance_Search_For_Woo_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'advance-search-for-woo';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Advance_Search_For_Woo_Loader. Orchestrates the hooks of the plugin.
	 * - Advance_Search_For_Woo_i18n. Defines internationalization functionality.
	 * - Advance_Search_For_Woo_Admin. Defines all hooks for the admin area.
	 * - Advance_Search_For_Woo_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-advance-search-for-woo-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-advance-search-for-woo-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-advance-search-for-woo-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-advance-search-for-woo-public.php';

		$this->loader = new Advance_Search_For_Woo_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Advance_Search_For_Woo_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Advance_Search_For_Woo_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Advance_Search_For_Woo_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu',$plugin_admin, 'asfw_custom_menu' );
		//$this->loader->add_action( 'widgets_init', $plugin_admin , 'advance_saerch_for_woocommerce_custom_widget' );
		$this->loader->add_action('widgets_init',$plugin_admin,  'advance_search_custom_widget_plugin');
		$this->loader->add_action('wp_ajax_Save_advance_search_settings',$plugin_admin, 'Save_advance_search_settings' ); 
		$this->loader->add_action('wp_ajax_nopriv_Save_advance_search_settings',$plugin_admin, 'Save_advance_search_settings' );		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		
		$plugin_public = new Advance_Search_For_Woo_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_archive_description', $plugin_public, 'advance_serach_for_woocommerce_shortcode', 0 );
		$this->loader->add_action('wp_ajax_save_advance_search_results',$plugin_public, 'save_advance_search_results' ); 
		$this->loader->add_action('wp_ajax_nopriv_save_advance_search_results',$plugin_public, 'save_advance_search_results' );
		
		if( !empty ( $_GET['search_by_sku_or_product'] ) && $_GET['search_by_sku_or_product'] === 'product_sku' ) {  
			$this->loader->add_filter( 'posts_search', $plugin_public , 'advance_search_for_woocommerce_filter_search', 10, 2 );
		}
		$this->loader->add_action('woocommerce_product_query',$plugin_public,'set_advance_search_order_by' , 10); 
		
		if( !empty ( $_GET['aswf'] ) ) { 
			$this->loader->add_filter('pre_get_posts',$plugin_public, 'advance_search_for_woo_filter' ); 
		} 
		
		$this->loader->add_action( 'advance-search-for-woocommerce', $plugin_public, 'advance_serach_for_woocommerce_shortcode' );
		add_shortcode( 'advance-search-for-woocommerce', array( $plugin_public, 'advance_serach_for_woocommerce_shortcode') ); 
		
		if( !empty ( $_GET['advance_filters'] ) ) {
			$this->loader->add_filter( 'pre_get_posts', $plugin_public , 'apply_user_price' );
			$this->loader->add_filter( 'pre_get_posts', $plugin_public , 'apply_user_attribute_filters' , 99999 );
			$this->loader->add_filter( 'posts_where', $plugin_public, 'advance_search_posts_where', 10, 2 );
		}
		
		$this->loader->add_action('wp_ajax_advance_search_for_woocommerce_ajax_call',$plugin_public, 'advance_search_for_woocommerce_ajax_call' ); 
		$this->loader->add_action('wp_ajax_nopriv_advance_search_for_woocommerce_ajax_call',$plugin_public, 'advance_search_for_woocommerce_ajax_call' );
		$this->loader->add_filter('woocommerce_variable_price_html', $plugin_public , 'custom_variation_price', 10, 2);
		
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Advance_Search_For_Woo_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}