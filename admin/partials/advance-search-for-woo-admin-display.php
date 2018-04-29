<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/admin/partials
 */

// Creating the widget 
class wpb_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		'wpb_widget', __('Advance Search ', PLUGIN_SLUG), 
		array( 
			'description' => __( 'Advance Search for woocommerce widget', 'advance_search_widget_domain' )) 
		);
		
	}
	
	public function widget( $args, $instance ) {
/*		$delete		= apply_filters( 'widget_title', $instance['delete'] );
		if( !empty(  $delete )){ 
			echo $args['before_title'] . $title . $args['after_title'];
		}
*/		
	}		
	// Widget Backend 
	public function form( $instance ) { 
		?>
		<p >
			<p><a href="<?php echo site_url('wp-admin/admin.php?page=advance-search'); ?> " target="_blank"> <?php echo __('Advance Search Setting' , PLUGIN_SLUG ); ?> </p>
		</p>	
		<?php 
	}
		
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}		
}