<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/public
 * @author     Umang Vaghela <umangvaghela123@gmail.com>
 */
class Advance_Search_For_Woo_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advance_Search_For_Woo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advance_Search_For_Woo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advance-search-for-woo-public.css', array('wp-jquery-ui-dialog'), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Advance_Search_For_Woo_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Advance_Search_For_Woo_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advance-search-for-woo-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'adminajaxjs', array('adminajaxjsurl' => admin_url( 'admin-ajax.php' )));
		wp_localize_script( $this->plugin_name, 'ajaxicon', array('loderurl' => site_url('wp-content/plugins/advance-search-for-woo/public/images/ajax-loader.gif')) );

	} 
	public function advance_serach_for_woocommerce_shortcode ( $atts = array() ){  
		global $wpdb , $woocommerce;
		if( !empty( $_GET['advance_filters'] ) && $_GET['advance_filters'] !='') { 
			advance_search_args_converter();
		}
		$product_tag_value = '';
		$product_cat_value = '';
		$product_order_value = '';
		$product_order_by_value = '';
		$product_max_price_value = '';
		$product_max_price_value = '';
		if(!empty( sanitize_text_field( $_POST['product_tag'] ) ) && sanitize_text_field( $_POST['product_tag'] !="" ) ){ 
			$product_tag_value = sanitize_text_field ( $_POST['product_tag'][0] );
		}
		if(!empty( sanitize_text_field( $_POST['product_cat'] ) ) && sanitize_text_field( $_POST['product_cat'] !="" ) ) { 
			$product_cat_value = sanitize_text_field($_POST['product_cat'][0] );
		}
		if(!empty( sanitize_text_field( $_POST['order'] ) ) && sanitize_text_field( $_POST['order'] !="" ) ){ 
			$product_order_value = sanitize_text_field($_POST['order'][0]);
		}
		if(!empty( sanitize_text_field($_POST['order_by']) )  && sanitize_text_field( $_POST['order_by'] !="") ) { 
			if( sanitize_text_field( $_POST['order_by'] ) == '_price') { 
				$product_order_by_value = sanitize_text_field( $_POST['order_by'] );
			} else {
				$product_order_by_value = sanitize_text_field( $_POST['order_by'][0] );
			}
		}		
		if(!empty( sanitize_text_field( $_POST['price']) )  && sanitize_text_field( $_POST['price'] !="" ) ) {  
			list( $_GET['min_price'], $_GET['max_price'] ) = $_POST['price'];
			$product_max_price_value  = $_GET['max_price'];
			$product_min_price_value  = $_GET['min_price'];
		} 
		$search_text_get = '';
		$product_search_sku_get_value_selected = '';
		$product_search_get_value_selected = '';
		if( !empty( sanitize_text_field( $_POST['search_by_product_sku']) ) ) { 
			$search_text_get = $_POST['search_by_product_sku'][0];
			$product_search_sku_get_value_selected = "selected = 'selected'";
		} 
		if( !empty( sanitize_text_field( $_POST['search_by_product'] ) ) && sanitize_text_field( $_POST['search_by_product'] ) !='' ){ 
			$search_text_get = $_POST['search_by_product'][0];
			$product_search_get_value_selected = "selected = 'selected'";
		}
		
		$product_category			= get_option('Advance_Search_Product_Category_Enable');
		$product_tag				= get_option('Advance_Search_Product_Tag_Enable');
		$product_price_ranger		= get_option('Advance_Search_Product_Price_Ranger_Enable');
		$product_search_type 		= get_option('Advance_Search_Product_Search_Type_Enable');
		$product_sku 				= get_option('Advance_Search_Product_Sku_Enable');
		$Product_Based_On_Search 	= get_option('Advance_Search_Product_Based_On_Search_Enable');
		$Max_product_price_range 	= get_option('Advance_Search_Max_product_price_range');
		$Advance_Search_Filter 		= get_option('Advance_Search_Filter');
		$Advance_search_attribute 	= get_option('Advance_search_attribute');
		$Advance_order_by 			= get_option('Advance_order_by'); 
		if( !empty( $product_category ) && $product_category ==='Active'){ 
			$category_display = "inline-block";
		}else { 
			$category_display = "none";
		}
		if( !empty( $product_tag ) && $product_tag ==='Active'){ 
			$tag_display_css = "inline-block";
		}else { 
			$tag_display_css = "none";
		}
		if( !empty( $product_price_ranger ) && $product_price_ranger === 'Active'){ 
			$advance_price_ranger_display = "block";
		}else { 
			$advance_price_ranger_display = "none";
		}
		if( !empty( $Max_product_price_range ) && $Max_product_price_range !=''){ 
			$max_product_price_range_display = $Max_product_price_range;
		}else { 
			$max_product_price_range_display = "1000";
		}
		$action = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$search_text = !empty( $_GET['s'] ) ? $_GET['s'] : '' ; 
		$slider_price_max = '';
		$slider_price_min = '';
		$get_price_query = "SELECT MIN(cast({$wpdb->postmeta}.meta_value as unsigned)) as min_price, MAX(cast({$wpdb->postmeta}.meta_value as unsigned)) as max_price
							FROM {$wpdb->posts}
							INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
							INNER JOIN {$wpdb->postmeta} AS pm1 ON ({$wpdb->posts}.ID = pm1.post_id)
							WHERE {$wpdb->posts}.post_type = 'product'
							AND {$wpdb->posts}.post_status = 'publish'
							AND ( {$wpdb->postmeta}.meta_key = '_price' AND {$wpdb->postmeta}.meta_value > 0
							) ";
		$prices = $wpdb->get_row($get_price_query);
		if( !empty ($prices->min_price) && !empty ($prices->max_price) && $prices->min_price != $prices->max_price ) { 
			$slider_price_min = $prices->min_price;
			$slider_price_max = $prices->max_price;
		}
		?>
		<link rel="stylesheet" href="<?php echo site_url('wp-content/plugins/advance-search-for-woo/public/css/jquery-ui.css'); ?>">
			<div class="Advance_search_for_woo_display_main"> 
				<?php if(is_shop() ) { 
					$shop_page_url_or_not = "shop";
				?>
				<div class="Adavance_search_for_woo_title"><h2><?php echo __( ' Advance Search For WooCommerce', PLUGIN_SLUG) ?></h2></div>
				<form name="wc_product_finder" id="wc_product_finder" class="woocommerce" action="<?php esc_url( $action ); ?>" method="get">
				<?php } else { 
					$shop_page_url_or_not = "other";	
					?> 
					<form name="wc_product_finder" id="wc_product_finder" class="woocommerce" action="<?php echo  $action ; ?>" method="POST">
				<?php } ?> 
				<div class="Default_search_preview_tab">
					<input type="hidden" name="shop_page_or_not" id="shop_page_or_not" value="<?php echo $shop_page_url_or_not; ?>" />
					<input type="hidden" name="post_type" value="product" />
					<input type="hidden" name="aswf" value="asfw" />
					<input type="text"  placeholder ="<?php echo __('Search by product' , PLUGIN_SLUG ); ?>" name="s" value="<?php echo $search_text_get; ?>" class="default_preview_set_search_text2"><select name="search_by_sku_or_product" class="advance_search_product_or_sku_preview_html"><option value="product" <?php echo $product_search_get_value_selected; ?>> <?php echo __('Search by product' , PLUGIN_SLUG ); ?></option><option value="product_sku" <?php echo $product_search_sku_get_value_selected; ?>> <?php echo __('Search by product sku' , PLUGIN_SLUG ); ?> </option></select><input type="button"  value="Submit" class="button button-primary advance_search_for_woocommerce_save_btn" >
				</div>
					<div class="Advance_Search_Button"> <?php echo __('Advance Search Filter Option' , PLUGIN_SLUG ); ?> </div>
					<div class="advance_default_search_advance_search_option">
					<?php 
						$product_search						= !empty( sanitize_text_field( $_GET['aswf'] ) ) ? $_GET['aswf'] : '';
						$product_cat  						= !empty( sanitize_text_field( $_GET['product_cat'] ) ) ? $_GET['product_cat'] : ''; 
						$product_tag  						= !empty( sanitize_text_field( $_GET['product_tag'] ) ) ? $_GET['product_tag'] : ''; 
						$order_by_filter_results  			= !empty( sanitize_text_field( $_GET['order_by_filter'] ) ) ? $_GET['order_by_filter'] : ''; 
						$advance_search_filter_results  	= !empty( sanitize_text_field( $_GET['advance_search_filter_results'] ) ) ? $_GET['advance_search_filter_results'] : '';  
						$price_selected  = "";
						$date_selected  = "";
						$title_selected  = ""; 
						if( empty( $product_search  ) && !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Order_By_Price' ) {  
							$price_selected = "selected='selected'";
						} 
						if( empty( $product_search  ) && !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Order_by_date' ) {  
							$date_selected = "selected='selected'";
						} 
						if( empty( $product_search  ) && !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Product_Title' ) {  
							$title_selected = "selected='selected'";
						}
						$prod_cat_args = array(
						'taxonomy'     => 'product_cat', 
						'orderby'      => 'name',
						'empty'        => 0
						);
						$woo_categories = get_categories( $prod_cat_args );
					?>
						<div class="Advance_search_select_category">
							<select name="product_cat" class="advance_search_category_preview_html" style="display:<?php echo $tag_display_css; ?>"> 
								<option value=""><?php echo __('Select Category' , PLUGIN_SLUG ); ?></option>
								<?php 
									foreach ( $woo_categories as $woo_cat ) {
										$woo_cat_id = $woo_cat->term_id; //category ID
										$woo_cat_name = $woo_cat->name; //category name 
										?>
									<option value="<?php echo $woo_cat_id; ?>" <?php if( $product_cat_value == $woo_cat_id ) { echo "selected=selected"; } ?>><?php echo $woo_cat_name; ?></option>	
								<?php 	} 
								?>
							</select>
							<select name="product_tag" class="advance_search_category_tag_html" style="display:<?php echo $category_display; ?>"> 
							<option value=""> <?php echo __('Select Tag' , PLUGIN_SLUG ); ?></option>
								<?php  
									$terms = get_terms( 'product_tag' );
									$term_array = array();
									if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
									    foreach ( $terms as $term ) { ?>
									        <option value="<?php echo $term->term_id; ?>" <?php if( $product_tag_value == $term->term_id ) { echo "selected=selected"; } ?> ><?php echo $term->name; ?></option>
									    <?php }
									}
								?>
							</select>
						</div>
						<div class="order_by_filter">
							<!--<p class="order_by_filter_inner_html"><label>Order by</label>-->
								<select name="order_by_filter" class="order_by_dropdown">
									<option value="Asc" <?php  if( ( !empty( $order_by_filter_results ) && $order_by_filter_results === 'Asc' ) || ( !empty( $product_order_value ) && $product_order_value == 'Asc') ) { echo "selected=selected"; }?>> <?php echo __('Order by ascending' , PLUGIN_SLUG ); ?></option>
									<option value="Desc" <?php  if( ( !empty( $order_by_filter_results ) && $order_by_filter_results === 'Desc' ) || ( !empty( $product_order_value ) && $product_order_value == 'Desc')) { echo "selected=selected"; }?>> <?php echo __('Order by descending' , PLUGIN_SLUG ); ?></option>
								</select> 
								<?php  
									if( !empty( sanitize_text_field( $_GET['advance_filters'] ) ) && sanitize_text_field  ( $_GET['advance_filters'] ) !='' )	{  ?> 
									
										<select name="advance_search_filter_results" class="advance_search_filter_dropdown">
											<option value="_price" <?php if( ( !empty( $product_order_by_value ) && $product_order_by_value == '_price')  ) {echo "selected='selected'"; } ?> > <?php echo __('Filter by price', PLUGIN_SLUG ); ?></option>
											<option value="date" <?php if( ( !empty( $product_order_by_value ) && $product_order_by_value == 'date') ) { echo "selected='selected'"; } ?>> <?php echo __('Filter by date', PLUGIN_SLUG ); ?></option>     
											<option value="title" <?php if( ( !empty( $product_order_by_value ) && $product_order_by_value == 'title') ) { echo "selected='selected'"; } ?>> <?php echo __('Filter by title', PLUGIN_SLUG ); ?></option>
										</select>
									<?php } else { ?>
									
										<select name="advance_search_filter_results" class="advance_search_filter_dropdown">
											<option value="_price" <?php if( ( !empty( $advance_search_filter_results ) && $advance_search_filter_results === "_price" ) ) {echo "selected='selected'"; } ?> <?php echo $price_selected; ?>> <?php echo __('Filter by price', PLUGIN_SLUG ) ?></option>
											<option value="date" <?php if( ( !empty( $advance_search_filter_results ) && $advance_search_filter_results === "date" )) { echo "selected='selected'"; } ?> <?php echo $date_selected; ?>> <?php echo __('Filter by date', PLUGIN_SLUG ); ?></option>     
											<option value="title" <?php if( ( !empty( $advance_search_filter_results ) && $advance_search_filter_results === "title" )) { echo "selected='selected'"; } ?> <?php echo $title_selected; ?>> <?php echo __('Filter by title', PLUGIN_SLUG ) ?></option>
										</select>
									<?php }
								?>
						</div>	
						<div class="advace_search_filter_html"> 
							<!--<p class="order_by_filter_inner_html"><label>Filter</label> -->
						</div>
						<?php  
							if(!empty( $Advance_search_attribute ) && $Advance_search_attribute === 'All') { 
						?>
						<div class="advance_search_attributes">
							<fieldset class="wbm_global">
								<legend><div class="wbm-setting-header"><h5><?php echo __('Search by Attributes', PLUGIN_SLUG ); ?></h5></div></legend>
								<?php 
									$Advance_search_attribute_select = get_option('Advance_search_attribute_select');
									$selected_attribute_val_name = array();
									$selected_attribute_val = json_decode( $Advance_search_attribute_select);
									$taxonomies_attribute_name = array();	
									$taxonomies_attribute_id = array();	
									 foreach ( $selected_attribute_val as $selected_attribute_val_results ) { 
										if ( !empty( $_POST['terms'] ) ) {
								            foreach ( $_POST['terms'] as $t ) {
								               $taxonomies_attribute_name[]  =  $t[0];
								               $taxonomies_attribute_id[]  =  $t[1];
								            }
								        }
										$selected_attribute_val_name = $selected_attribute_val_results; ?>
										<label class="attributes_name_class"><?php //echo $selected_attribute_val_name ." : " ;  ?></label>
										<select name="advance_search_attributes_<?php echo $selected_attribute_val_name ;  ?>" class="select_attributes_name_css" > 
											<option value=""> <?php echo "Select ".$selected_attribute_val_name; ?></option>
											<?php  
												$terms = get_terms( "pa_".$selected_attribute_val_name );
												foreach ( $terms as $terms_results ) {  
													 ?>
													<option value="<?php echo $terms_results->term_id; ?>" <?php if( in_array( $terms_results->term_id , $taxonomies_attribute_id)) { echo "selected = 'selected'" ;} ?> data-name ="<?php echo $selected_attribute_val_name ;?>" data-arribute ="<?php echo "pa_".$selected_attribute_val_name ; ?>"><?php echo $terms_results->name; ?></option>
											<?php } ?>
										</select>
									<?php } ?>
									<p></p>
								</fieldset>		
						</div>
						<?php }  
						$get_price_query = "SELECT MIN(cast({$wpdb->postmeta}.meta_value as unsigned)) as min_price, MAX(cast({$wpdb->postmeta}.meta_value as unsigned)) as max_price
							FROM {$wpdb->posts}
							INNER JOIN {$wpdb->postmeta} ON ({$wpdb->posts}.ID = {$wpdb->postmeta}.post_id)
							INNER JOIN {$wpdb->postmeta} AS pm1 ON ({$wpdb->posts}.ID = pm1.post_id)
							WHERE {$wpdb->posts}.post_type = 'product'
							AND {$wpdb->posts}.post_status = 'publish'
							AND ( {$wpdb->postmeta}.meta_key = '_price' AND {$wpdb->postmeta}.meta_value > 0 ) ";
							$prices = $wpdb->get_row($get_price_query);
							if( !empty ($prices->min_price) && !empty ($prices->max_price) && $prices->min_price != $prices->max_price ) { 
								$slider_price_min = $prices->min_price;
								$slider_price_max = $prices->max_price;
							}
						?>
						<div class="advance_searching_price_slider_main" style="display:<?php echo $advance_price_ranger_display; ?>">	
							<input type="hidden" value="<?php echo $slider_price_max;  ?>" id="listing_searching_max_hidden_price">
							<p class="searching_price_range"> <?php echo __('Price Range:', PLUGIN_SLUG ); ?> <span id="display_amount_range"></span></p>
							<div id="searching-slider-range"></div> 
							<input type="hidden"  id="min_amount" name="min_price" value="<?php echo $slider_price_min; ?>">
							<input type="hidden"  id="max_amount" name="max_price" value="<?php echo $slider_price_max;  ?>">
						</div>
					</div>
				</form>
			</div>
			<div class="woocommecr-notice"></div>
	<?php }
	
	/**
	 * Function for get query record 
	 *
	 * @param unknown_type $query
	 */
	
	public  function advance_search_for_woo_filter ( $query ) { 
		
		global $wpdb;
		$Product_Based_On_Search 	= get_option('Advance_Search_Product_Based_On_Search_Enable'); 
		$Product_search_by_sku	 	= get_option('Advance_Search_Product_Sku_Enable');
		if ( ! is_admin() ) {
			if ( ! $query->is_main_query() )
				return;
			$query_args = array();
			$min_price 					= !empty( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '0';
			$max_price 					= !empty( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '1000';
			$product_cat 				= !empty( $_GET['product_cat'] ) ? esc_attr( $_GET['product_cat'] ) : '';
			$product_tag 				= !empty( $_GET['product_tag'] ) ? esc_attr( $_GET['product_tag'] ) : '';
			$Product_order_by			= !empty( $_GET['order_by_filter'] ) ? esc_attr( $_GET['order_by_filter'] ) : '';
			$search_by_sku_or_product	= !empty( $_GET['search_by_sku_or_product'] ) ? esc_attr( $_GET['search_by_sku_or_product'] ) : '';
			$Advance_search_attribute_select = get_option('Advance_search_attribute_select');
			$selected_attribute_val_name = array();
			$selected_attribute_val = json_decode( $Advance_search_attribute_select);
			$terms_result_array = array();
			$advance_search_attributes = array();
			foreach ( $selected_attribute_val as $selected_attribute_val_results ) { 
				$selected_attribute_val_name = $selected_attribute_val_results; 
					$terms = get_terms( "pa_".$selected_attribute_val_name );
					foreach ( $terms as $terms_results ) {  
						$terms_result_array  			= "advance_search_attributes_".$selected_attribute_val_name;
						if( in_array( "advance_search_attributes_age" , $_GET) ) {		
							$advance_search_attributes[]	=  $terms_result_array;
						}				
					} 
				} 
			
			if(!empty( $advance_search_attributes  ) && ( in_array( $advance_search_attributes , "advance_search_attributes".$advance_search_attributes))) { 
									
			}
			// Basic arguments
			$query_args['post_type'] 	= 'product';
			$query_args['post_status']  = 'publish';
			// Pagination
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		    $query_args['paged'] = $paged; 
		    
		    $search_keyword 		= esc_attr( $_GET['s'] );
		    $string 				= str_replace(' ', '-', $search_keyword); // Replaces all spaces with hyphens.
			$search_keyword 		= preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		   
		    if( !empty( $Product_Based_On_Search  ) && ( $Product_Based_On_Search === 'Singular' )) { 
				$search_keyword_new = '';
				$search_keyword_new_a = array();
				$search_keyword_split = explode( "-", trim( $search_keyword ) );
				if ( is_array( $search_keyword_split ) && count( $search_keyword_split ) > 0 ) {
					foreach ( $search_keyword_split as $search_keyword_element ) {
						if ( strlen( $search_keyword_element ) > 2 ) {
							$search_keyword_new_a[] = rtrim( strtolower($search_keyword_element), 's' );
						} else {
							$search_keyword_new_a[] = $search_keyword_element;
						}
					}
					$search_keyword_new = implode("-", $search_keyword_new_a);
				}
				
				if ( '' != $search_keyword && $search_keyword_new != $search_keyword ) {
					$search_keyword = $search_keyword_new;
				} 
			}
			if( $search_keyword && strlen( $search_keyword ) > 0 ) {
		    	$query_args['s'] = $search_keyword;
		    } else {
		    	$query_args['s'] = '';
		    }
		   if( !empty( $Product_search_by_sku ) && $Product_search_by_sku == 'All' && !empty( $search_by_sku_or_product ) && $search_by_sku_or_product === 'product_sku' ) { 
		   		$query_args['meta_query']['relation'] = 'OR';	
		   		$query_args['meta_query'][] = array(
			        'key' => '_sku',
			        'value' => $query_args['s'],
			        'compare' => 'LIKE'
			    );
			}
		    // Check selected taxonomies
		    if( !empty( $product_cat ) && $product_cat != 'all' && $product_cat !='' ) { 
				$query_args['tax_query']['relation'] = 'AND';
				$query_args['tax_query'][] = array(
				'taxonomy' => 'product_cat',
				'field' => 'slug',
				'terms' => $product_cat,
				);
	    	 }
	    	 
			// Check selected tag
	    	 if( !empty( $product_tag ) && $product_tag != 'all' &&$product_tag !=''  ) { 
				$query_args['tax_query']['relation'] = 'AND';
				$query_args['tax_query'][] = array(
				'taxonomy' => 'product_tag',
				'field' => 'slug',
				'terms' => $product_tag,
				);
	    	 }
	    	 
		    // Check selected tag
			if( '' != $min_price ) { 
				
				$query_args['meta_query'][] = array(
			        'key' => '_price',
			        'value' => $min_price,
			        'compare' => '>=',
			        'type' => 'NUMERIC'
			    );
			}
			// Add maximum price
			if( '' != $max_price ) { 
				$query_args['meta_query']['relation'] = 'AND';
				$query_args['meta_query'][] = array(
			        'key' => '_price',
			        'value' => $max_price,
			        'compare' => '<=',
			        'type' => 'NUMERIC'
			    );
			}
		    // Check text search string
		    // Set query variables
			    foreach ( $query_args as $key => $value ) {
				$query->set( $key, $value );
			}

		}
		
	}
	/**
	 * Function to override woocomerce product query hooks 
	 *
	 * @param unknown_type $q
	 */
	
	public function set_advance_search_order_by ( $q ) { 
		
		$Product_order_by	= !empty( $_GET['order_by_filter'] ) ? esc_attr( $_GET['order_by_filter'] ) : '';
		$Product_price_order	= !empty( $_GET['advance_search_filter_results'] ) ? esc_attr( $_GET['advance_search_filter_results'] ) : '';
		if( !empty( $Product_price_order ) && $Product_price_order == "_price") {
			$q->set( 'orderby', 'meta_value_num' );
			$q->set( 'order', $Product_order_by );
			$q->set( 'meta_key', $Product_price_order );
		} else if ( !empty( $Product_price_order ) && $Product_price_order == 'title' ) { 
			$q->set( 'orderby', $Product_price_order );
			$q->set( 'order', $Product_order_by );
		} else { 
			$q->set( 'orderby', 'date' );
			$q->set( 'order', $Product_order_by );
		}
		
	} 
	
	public  function  advance_search_for_woocommerce_filter_search ( $term ) { 
		$search = "";
   		return $search;
	}
	
	/**
	 * Function For to change where condition in wp_query 
	 * 
	 * Return $where condition  
	 */
	public function advance_search_posts_where ( $where, $wp_query  ) { 
		global $wpdb;
		if( !empty( $_POST['search_by_product'] )  && $_POST['search_by_product'][0] != '' ) { 
			     $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $_POST['search_by_product'][0] ) ) . '%\'';
		}
		 return $where;
	}
	/**
	 * Function For filter price 
	 * 
	 */
	public  function apply_user_price( $query, $is_shortcode = FALSE ) {
	
	if ( ( ( ! is_admin() && $query->is_main_query() ) || $is_shortcode ) && ( @ $_GET['advance_filters'] || $query->get( $option_permalink['variable'], '' ) ) ) {
			advance_search_args_converter( $query );
			if ( !empty(  $_POST['price'] ) ) {
				list( $_GET['min_price'], $_GET['max_price'] ) = $_POST['price'];
				add_filter( 'loop_shop_post_in', 'price_filter'  );
			} 
	
		}
	} 
	/**
	 * Function For get max price from woocommrece all product 
	 * 
	 * 
	 */
	/**
	 * Function for apply filter for all 
	 * 
	 * 
	 */
	 public static function apply_user_attribute_filters ( $query ) {
	        if( $query->is_main_query() &&
            ( is_shop() or is_product_category() or is_product_taxonomy() or is_product_tag() ) ) {
            advance_search_args_converter();
            $args = advance_search_args_parser();

            if ( @ $_POST['price'] ) {
                list( $_GET['min_price'], $_GET['max_price'] ) = $_POST['price'];
                add_filter( 'loop_shop_post_in',  'price_filter'  );
            }
				
			if( !empty( $_POST['search_by_product'] )  ||  !empty( $_POST['search_by_product_sku'] ) ) { 
				$args_fields = array( 'tax_query', 'fields', 'meta_query' ); 
			} else { 
				$args_fields = array( 'tax_query', 'fields' );
			}
			
          	foreach ( $args_fields as $args_field ) {
                if ( $args[$args_field] ) {
                    $query->set( $args_field, $args[$args_field] );
                }
            }
            
            if ( !empty( $_POST['order_by'] ) && $_POST['order_by'][0] == 'date' ) {
            	
        		$query->set( 'orderby', 'date' );
				$query->set( 'order', $_POST['order'][0] );
            }
            if ( !empty( $_POST['order_by'] ) && $_POST['order_by'][0] == 'title' ) {
            	
        		$query->set( 'orderby', 'title' );
				$query->set( 'order', $_POST['order'][0] );
            }
            if ( !empty( $_POST['order_by'] ) && $_POST['order_by'][0] == 'price' ) {
            		
        		$query->set('meta_key' , '_price');
        		$query->set('orderby' , 'meta_value_num');
        		$query->set('order' , $_POST['order'][0]);
            		
            }
            
        }
		
        return $query;
    }
    /**
     * Function For ajax call
     * 
     */
    public function advance_search_for_woocommerce_ajax_call ( ) { 
    	global $wp_query, $wp_rewrite;
		advance_search_args_converter(); 
		if( isset($_POST['search_by_product']) && ($_POST['search_by_product']) > 0 ) {
			$args['s'] = $_POST['search_by_product'][0];
			$Product_Based_On_Search = get_option('Advance_Search_Product_Based_On_Search_Enable');
			$search_keyword 		 = esc_attr( $_POST['search_by_product'][0] );
		    $string 				 = str_replace(' ', '-', $search_keyword); // Replaces all spaces with hyphens.
			$search_keyword 		 = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
		   
		    if( !empty( $Product_Based_On_Search  ) && ( $Product_Based_On_Search === 'plural' )) { 
				$search_keyword_new = '';
				$search_keyword_new_a = array();
				$search_keyword_split = explode( "-", trim( $search_keyword ) );
				
				if ( is_array( $search_keyword_split ) && count( $search_keyword_split ) > 0 ) {
					foreach ( $search_keyword_split as $search_keyword_element ) {
						if ( strlen( $search_keyword_element ) > 2 ) {
							$search_keyword_new_a[] = rtrim( strtolower($search_keyword_element), 's' );
						} else {
							$search_keyword_new_a[] = $search_keyword_element;
						}
					}
					$search_keyword_new = implode("-", $search_keyword_new_a);
				}
				
				if ( '' != $search_keyword && $search_keyword_new != $search_keyword ) {
					$search_keyword = $search_keyword_new;
				} 
			}

			if( $search_keyword && strlen( $search_keyword ) > 0 ) {
		    	$args['s'] = $search_keyword;
		    } else {
		    	//$args['s'] = '';
		    }
			
			
        }
        
		if( !empty( $_POST['price'] ) ) { 
			
			if( '' != $_POST['price'][0] ) { 
			$meta_query['relation'] = 'AND';	
			
			$meta_query[] = array(
			        'key' => '_price',
			        'value' => $_POST['price'][0],
			        'compare' => '>=',
			        'type' => 'NUMERIC'
			    );
			}

			// Add maximum price
			if( '' != $_POST['price'][1] ) { 
				
				$meta_query[] = array(
			        'key' => '_price',
			        'value' => $_POST['price'][1],
			        'compare' => '<=',
			        'type' => 'NUMERIC'
			    );
			}
			
		}
		
			
		$attributes_terms = $tax_query = array();
        $attributes       = advance_search_get_attributes();
        $taxonomies       = array();
        
        $tax_query['relation'] = 'AND';
        if( !empty( $_POST['product_tag'] )  && $_POST['product_tag'] != '-1'  ) {
			$tax_query[] = array( 
				'taxonomy' => 'product_tag',
				'field'    => 'id',
				'terms'    => strip_tags( $_POST['product_tag'][0] ),
				'operator' => 'IN'
			);
    	}
		if ( !empty( $_POST['product_cat'] )  && $_POST['product_cat'] != '-1' ) {
			$tax_query[] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => strip_tags( $_POST['product_cat'][0] ),
				'operator' => 'IN',
			); 
		}
		if ( !empty( $_POST['search_by_product_sku'] ) && $_POST['search_by_product_sku'] != '-1'  ) { 
			$meta_query['relation'] = 'AND';
			$meta_query[] = array(
				'key' => '_sku',
				'value' => $_POST['search_by_product_sku'][0],
				'compare' => 'LIKE'
				);
			
		}
			
        if ( !empty( $attributes ) ) {
            foreach ( $attributes as $k => $v ) {
                $terms = get_terms( array( $k ), $args = array( 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'id=>slug' ) );
                if ( $terms ) {
                    foreach ( $terms as $term_id => $term_slug ) {
                        $attributes_terms[ $k ][ $term_id ] = $term_slug;
                    }
                }
                unset( $terms );
            }
        }
        unset( $attributes );

        if ( !empty( $_POST['terms'] ) ) {
            foreach ( $_POST['terms'] as $t ) {
                if( !isset($taxonomies[ $t[0] ]) ) {
                    $taxonomies[ $t[0] ] = array();
                }
                $taxonomies[ $t[0] ][]        = $attributes_terms[ $t[0] ][ $t[1] ];
                $taxonomies_operator[ $t[0] ] = $t[2];
            }
        }
        unset( $attributes_terms );

        if ( !empty( $taxonomies ) ) {
            if ( $taxonomies ) {
                foreach ( $taxonomies as $k => $v ) {
                    if ( $taxonomies_operator[ $k ] == 'AND' ) {
                        $op = 'AND';
                    } else {
                        $op = 'IN';
                    }
                    $tax_query[] = array(
                        'taxonomy' => $k,
                        'field'    => 'slug',
                        'terms'    => $v[0],
                        'operator' => $op
                    );
                }
            }
        }
        
        
        
         if ( !empty( $_POST['order_by'] ) && $_POST['order_by'][0] == 'date' ) {
            	
				$args['orderby'] = 'date'; 
				$args['order'] =  $_POST['order'][0]; 
        }
        if ( !empty( $_POST['order_by'] ) && $_POST['order_by'][0] == 'title' ) {
        	
			
			$args['orderby'] = 'title'; 
			$args['order'] =  $_POST['order'][0]; 
        }
        if ( !empty( $_POST['order_by'] ) && $_POST['order_by'] == '_price' ) {
  
    		
    		$args['meta_key'] = '_price';
			$args['orderby'] = 'meta_value_num';
			$args['order'] = $_POST['order_by'][0];
        		
        }


        $args['tax_query'] 	= $tax_query;
        $args['meta_query'] = $meta_query;
        $args['post_type'] = 'product'; 
        
        
        
        $wp_query = new WP_Query( $args );
          
        ob_start();
		do_action('woocommerce_before_shop_loop');
            if ( $wp_query->have_posts() ) {
                woocommerce_product_loop_start();
                woocommerce_product_subcategories();

                while ( have_posts() ) {
                    the_post();
                    wc_get_template_part( 'content', 'product' );
                }

                woocommerce_product_loop_end();
                wp_reset_postdata();

                $_RESPONSE['products'] = ob_get_contents();
            } else {
               
                 echo "<div class='no-products" . ( ( $br_options['no_products_class'] ) ? ' '.$br_options['no_products_class'] : '' ) . "'> There is no  product for search </div>";
                $_RESPONSE['no_products'] = ob_get_contents();
            }
            ob_end_clean();
        

        echo json_encode( $_RESPONSE );
        die();
    } 
	
}

if( ! function_exists( 'advance_search_args_converter' ) ) {

	/**
     * convert args-url to normal filters
     * 
     */
    function advance_search_args_converter() { 
    	
        if ( preg_match( "~\|~", $_GET['advance_filters'] ) ) {
            $filters = explode( "|", $_GET['advance_filters'] );
        } else {
            $filters[0] = $_GET['advance_filters'];
        }

        foreach ( $filters as $filter ) { 
        	    
			if ( preg_match( "~\[~", $filter ) ) {
			    list( $attribute, $value ) = explode( "[", trim( preg_replace( "~\]~", "", $filter) ), 2 );
			    if ( preg_match( "~\-~", $value ) ) {
			        $value    = explode( "-", $value );
			        $operator = 'OR';
			    } elseif ( preg_match( "~\_~", $value ) ) {
			        list( $min, $max ) = explode( "_", $value );
			        $operator = '';
			    } else {
			        $value    = explode( " ", $value );
			        $operator = 'AND';
			    }
			} else{
			    list( $attribute, $value ) = explode( "-", $filter, 2 );
			}

        	 
            if ( $attribute == 'price' ) {
                $_POST['price'] = array( $min, $max ); 
            } elseif ( $attribute == 'product_cat' ) {
                $_POST['product_cat'] = $value;
            } elseif ( $attribute == 'product_tag' ) {
                $_POST['product_tag'] = $value;
            } elseif ( $attribute == 'order_by' ) {
                $_POST['order_by'] = $value;
            } elseif ( $attribute == 'order' ) {
                $_POST['order'] = $value;
            } elseif ( $attribute == 'search_by_product_sku' ) {
                $_POST['search_by_product_sku'] = $value;
            } elseif ( $attribute == 'search_by_product' ) {
                $_POST['search_by_product'] = $value;
            } else {
                if ( $operator ) {
                    foreach ( $value as $v ) {
                        $_POST['terms'][] = array( "pa_" . $attribute, $v, $operator );
                    }
                } else {
                    $_POST['limits'][] = array( "pa_" . $attribute, $min, $max );
                }
            }
        }
    }
}


function price_filter( $filtered_posts ){
    global $wpdb;

    if ( !empty( $_POST['price'] ) ) {
        $matched_products = array( 0 );
        $min     = floatval( $_POST['price'][0] );
        $max     = floatval( $_POST['price'][1] );

        $matched_products_query = apply_filters( 'woocommerce_price_filter_results', $wpdb->get_results( $wpdb->prepare("
            SELECT DISTINCT ID, post_parent, post_type FROM $wpdb->posts
            INNER JOIN $wpdb->postmeta ON ID = post_id
            WHERE post_type IN ( 'product', 'product_variation' ) AND post_status = 'publish' AND meta_key = %s AND meta_value BETWEEN %d AND %d
        ", '_price', $min, $max ), OBJECT_K ), $min, $max );

        if ( $matched_products_query ) {
            foreach ( $matched_products_query as $product ) {
                if ( $product->post_type == 'product' )
                    $matched_products[] = $product->ID;
                if ( $product->post_parent > 0 && ! in_array( $product->post_parent, $matched_products ) )
                    $matched_products[] = $product->post_parent;
            }
        }

        // Filter the id's
        if ( sizeof( $filtered_posts ) == 0) {
            $filtered_posts = $matched_products;
        } else {
            $filtered_posts = array_intersect( $filtered_posts, $matched_products );
        }

    }

    return (array) $filtered_posts;
}

// Get attribute value  

if( ! function_exists( 'advance_search_args_parser' ) ) {
    /**
     * 
     *
     * @param array $args
     *
     * @return array
     */
    function advance_search_args_parser ( $args = array() ) {
       
        $attributes_terms = $tax_query = array();
        $attributes       = advance_search_get_attributes();
        $taxonomies       = array();
        
        $tax_query['relation'] = 'AND';
        if( !empty( $_POST['product_tag'] )  && $_POST['product_tag'] != '-1'  ) {
			$tax_query[] = array( 
				'taxonomy' => 'product_tag',
				'field'    => 'id',
				'terms'    => strip_tags( $_POST['product_tag'][0] ),
				'operator' => 'IN'
			);
    	}
		if ( !empty( $_POST['product_cat'] )  && $_POST['product_cat'] != '-1' ) {
			$tax_query[] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'id',
				'terms'    => strip_tags( $_POST['product_cat'][0] ),
				'operator' => 'IN',
			); 
		}
		if ( !empty( $_POST['search_by_product_sku'] ) && $_POST['search_by_product_sku'] != '-1'  ) { 
			$meta_query['relation'] = 'AND';
			$meta_query[] = array(
				'key' => '_sku',
				'value' => $_POST['search_by_product_sku'][0],
				'compare' => 'LIKE'
				);
			
		}
		
			
        if ( !empty( $attributes ) ) {
            foreach ( $attributes as $k => $v ) {
                $terms = get_terms( array( $k ), $args = array( 'orderby' => 'name', 'order' => 'ASC', 'fields' => 'id=>slug' ) );
                if ( $terms ) {
                    foreach ( $terms as $term_id => $term_slug ) {
                        $attributes_terms[ $k ][ $term_id ] = $term_slug;
                    }
                }
                unset( $terms );
            }
        }
        unset( $attributes );

        if ( !empty( $_POST['terms'] ) ) {
            foreach ( $_POST['terms'] as $t ) {
                if( !isset($taxonomies[ $t[0] ]) ){
                    $taxonomies[ $t[0] ] = array();
                }
                $taxonomies[ $t[0] ][]        = @ $attributes_terms[ $t[0] ][ $t[1] ];
                $taxonomies_operator[ $t[0] ] = $t[2];
            }
        }
        unset( $attributes_terms );


        if ( !empty( $taxonomies ) ) {
           // $tax_query['relation'] = 'AND';
            if ( $taxonomies ) {
                foreach ( $taxonomies as $k => $v ) {
                    if ( $taxonomies_operator[ $k ] == 'AND' ) {
                        $op = 'AND';
                    } else {
                        $op = 'IN';
                    }

                    $tax_query[] = array(
                        'taxonomy' => $k,
                        'field'    => 'slug',
                        'terms'    => $v[0],
                        'operator' => $op
                    );
                }
            }
        }

        if ( @ $_POST['orderby'] ) {
            //br_aapf_parse_order_by( $args );
        }
           
        $args['tax_query'] 	= $tax_query; 
        if( !empty( $meta_query )  ) {
        	$args['meta_query'] = $meta_query;
        }
        $args['post_type'] = 'product';
        

       

        return $args;
    }
}

if( ! function_exists( 'advance_search_get_attributes' ) ) {
    /**
     * Get all possible woocommerce attribute taxonomies
     *
     * @return mixed|void
     */
    function advance_search_get_attributes() {
        $attribute_taxonomies = wc_get_attribute_taxonomies();
        $attributes           = array();

        if ( $attribute_taxonomies ) {
            foreach ( $attribute_taxonomies as $tax ) {
                $attributes[ wc_attribute_taxonomy_name( $tax->attribute_name ) ] = $tax->attribute_label;
            }
        }

        return  $attributes ;
    }
}