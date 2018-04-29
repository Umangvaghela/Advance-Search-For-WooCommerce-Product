<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advance_Search_For_Woo
 * @subpackage Advance_Search_For_Woo/admin
 * @author     Umang Vaghela <umangvaghela123@gmail.com>
 */
class Advance_Search_For_Woo_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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
		
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/advance-search-for-woo-admin.css', array('wp-jquery-ui-dialog'), $this->version, 'all' );
		wp_enqueue_style( "price-slider", plugin_dir_url( __FILE__ ) . 'css/price-slider-ui.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-choosen-css', plugin_dir_url( __FILE__ ) . 'css/chosen.css', array(), $this->version, 'all' );

		
	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-slider');
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/advance-search-for-woo-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'adminajaxjs', array('adminajaxjsurl' => admin_url( 'admin-ajax.php' )));
		wp_enqueue_script( 'asfwcopytoclipboard', plugin_dir_url( __FILE__ ) . 'js/clipboard.min.js', array( 'jquery' ), $this->version);
		wp_enqueue_script( 'choosen', plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.js', array( 'jquery' ),$this->version);
	}
	
	public function asfw_custom_menu( ) { 
		$wbm_page = 'woocommerce';
		$wbm_settings_page = add_submenu_page( $wbm_page , __( 'Advance Search', 'advance-search' ), __( 'Advance Search', 'advance-search' ), 'manage_options', 'advance-search', array(&$this,'custom_aswf_submenu_page_callback'));
	}
	
	public function custom_aswf_submenu_page_callback ( ) {
			global $wpdb,$woocommerce;
			$product_category					= "";
			$product_tag						= "";
			$product_price_ranger				= "";
			$product_search_type 				= "";
			$product_sku 						= "";
			$Product_Based_On_Search 			= "";
			$Max_product_price_range 			= "";
			$Advance_Search_Filter 				= "";
			$Advance_order_by 					= "";
			$Advance_search_attribute 			= "";
			$Advance_search_custom_css 			= "";
			$Advance_search_attribute_select 	= "";
			
			$product_category			= get_option('Advance_Search_Product_Category_Enable');
			$product_tag				= get_option('Advance_Search_Product_Tag_Enable');
			$product_price_ranger		= get_option('Advance_Search_Product_Price_Ranger_Enable');
			$product_search_type 		= get_option('Advance_Search_Product_Search_Type_Enable');
			$product_sku 				= get_option('Advance_Search_Product_Sku_Enable');
			$Product_Based_On_Search 	= get_option('Advance_Search_Product_Based_On_Search_Enable');
			$Max_product_price_range 	= get_option('Advance_Search_Max_product_price_range');
			$Advance_Search_Filter 		= get_option('Advance_Search_Filter');
			$Advance_order_by 			= get_option('Advance_order_by');
			$Advance_search_attribute 	= get_option('Advance_search_attribute');
			$Advance_search_custom_css 	= get_option('Advance_search_custom_css');
			$Advance_search_attribute_select = get_option('Advance_search_attribute_select');
			
			
		?>
		
		<div class="wrap woocommerce advance_search_plugin_admin_settings">
			<div class="advance_search_admin_title"><h1><?php echo __('Advance Search For WooCommerce Products', PLUGIN_SLUG ); ?></h1></div>
			<form method="post" id="mainform" action="" enctype="multipart/form-data">
				<div class="icon32 icon32-woocommerce-settings" id="icon-woocommerce"><br></div>
					<h2 class="nav-tab-wrapper woo-nav-tab-wrapper">
						<a class="nav-tab nav-tab-active" id="advance_search_open_setting_premium"><?php echo __('Setting' , PLUGIN_SLUG); ?></a>
						<a class="nav-tab" id="advance_search_open_preview_premium"><?php echo __('Preview', PLUGIN_SLUG ); ?></a>
						<a class="nav-tab" id="advance_search_open_shortcode_premium"><?php echo __('Shortcode', PLUGIN_SLUG ); ?></a>
						<a class="nav-tab" id="advance_search_open_custom_css_premium"><?php echo __('Custom CSS', PLUGIN_SLUG ); ?></a>
					</h2>
					<br class="clear">
			        <div class="woo-advance-search-setting-tab">
			        	<div id="message" class="updated woo_advance_save_record_messgae" style="display:none"></div>
						<h3><?php echo __('Advance Search Settings', PLUGIN_SLUG ); ?></h3>
						<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/price-slider-ui.css">
							<link rel="stylesheet" type="text/css" href="http://www.dhtmlgoodies.com/scripts/on-off-switch/css/on-off-switch.css"/>
							
								<table class="advance_woocommerce_serach_table form-table">
									<tbody>
										<tr>
											<th class="advance_"><?php echo __('Enable/Disable search by product category', PLUGIN_SLUG ); ?>  </th><td class="advance_search_html"><input type="checkbox" id="advance_search_product_category" name="advance_search_product_category" value="Active" <?php if( !empty( $product_category ) && $product_category == 'Active' ) { echo "checked" ; } ?>/></td>
										</tr>
										<tr>
											<th class="advance_"><?php echo __('Enable/Disable search by product tag', PLUGIN_SLUG ); ?></th><td class="advance_search_html"><input type="checkbox" id="advance_search_product_tag" name="advance_search_product_tag" value="Active" <?php if( !empty( $product_tag ) && $product_tag == 'Active' ) { echo "checked" ; } ?>/></td>
										</tr>
										<tr>
											<th class="advance_"><?php echo __('Enable/Disable search by product tagEnable/Disable search by product price range', PLUGIN_SLUG ); ?> </th><td class="advance_search_html"><input type="checkbox" id="advance_search_product_price_ranger" name="advance_search_product_price_ranger" value="Active" <?php if( !empty( $product_price_ranger ) && $product_price_ranger == 'Active' ) { echo "checked" ; } ?>/></td>
										</tr>
										
										<tr>
											<th class="advance_"><?php echo __('Enable/Disable search by product sku', PLUGIN_SLUG ); ?></th><td class="advance_search_html"><input type="checkbox"  name="advance_search_product_sku" id="advance_search_product_sku" value="All" <?php if( !empty( $product_price_ranger ) && $product_price_ranger == 'Active' ) { echo "checked" ; } ?>/><i></i></td>
										</tr>
										
										<tr>
											<th class="advance_"><?php echo __('Enable/Disable search by attributes', PLUGIN_SLUG ); ?></th><td class="advance_search_html"><input type="checkbox"  name="advance_search_product_attributes" id="advance_search_product_sku_attributes" value="All" <?php if( !empty( $Advance_search_attribute ) && $Advance_search_attribute == 'All' ) { echo "checked" ; } ?>/>
											
											<p></p><p class="dislay_all_attributes">
												<?php 
													$selected_attribute_val_name = array();
													$selected_attribute_val = json_decode( $Advance_search_attribute_select);
													if( !empty( $selected_attribute_val )) { 
														foreach ( $selected_attribute_val as $selected_attribute_val_results ) { 
															 $selected_attribute_val_name[] = $selected_attribute_val_results;
														} 
													}
												?>
												<select class="chzn-select" multiple="true" data-placeholder="select an attributes" name="faculty" style="width:20%"> 
													<?php  
														$attribute_taxonomies = wc_get_attribute_taxonomies();
														if( !empty($attribute_taxonomies)) { 
														foreach ( $attribute_taxonomies as $attribute_taxonomies_results ) { 
															 ?>
															 <option  <?php if( in_array( $attribute_taxonomies_results->attribute_name , $selected_attribute_val_name ) ) { echo 'selected'; } ?> value="<?php echo $attribute_taxonomies_results->attribute_name; ?>"><?php echo $attribute_taxonomies_results->attribute_label; ?></option>
													<?php } 
														}
													?>
												</select>
												</p>
											
											</td>
											
										</tr>
										
										
										<!--<tr>
											<th class="advance">Max Product Price Slider </th><td class="advance_search_html"><input type="text" id="advance_search_max_product_price_ranger" name="advance_search_max_product_price_ranger" value="<?php if(!empty( $Max_product_price_range ) && $Max_product_price_range !=''){ echo $Max_product_price_range ;} ?>"/>  Default ( 1000 )</td>
										</tr>-->
										
										<tr>
											<th class="advance_"><?php echo __('Search Type', PLUGIN_SLUG ); ?> </th>
											<td class="advance_search_html">
												<p><input type="radio"  name="advance_search_product_search_type" value="Best" <?php if( !empty( $product_search_type ) && $product_search_type == 'Best' ) { echo "checked" ; } ?>/><?php echo __('Best Matches', PLUGIN_SLUG ); ?></p>  
												<p><input type="radio"  name="advance_search_product_search_type" value="Simple" <?php if( !empty( $product_search_type ) && $product_search_type == 'Simple' ) { echo "checked" ; } ?>/><?php echo __('Simple Matches', PLUGIN_SLUG ); ?></p> 
												<!--<input type="checkbox" id="id-of-checkbox" checked name="check1">
												<input type="hidden" id="id-of-hidden" value="1" name="hidden">-->
											</td>
										</tr>
										
										<tr>
											<th class="advance_"><?php echo __('Search by singular/plural', PLUGIN_SLUG ); ?></th>
											<td class="advance_search_html">
													<p><input type="radio"  name="advance_search_all_afws" value="Singular" <?php if( !empty( $Product_Based_On_Search ) && $Product_Based_On_Search == 'Singular' ) { echo "checked" ; } ?>/><?php echo __('Singular', PLUGIN_SLUG ); ?> </p>
													<p><input type="radio"  name="advance_search_all_afws" value="plural" <?php if( !empty( $Product_Based_On_Search ) && $Product_Based_On_Search == 'plural' ) { echo "checked" ; } ?> /><?php echo __('Plural', PLUGIN_SLUG ); ?></p>
											</td>
										</tr>
										<tr>
											<th class="advance_"><?php echo __('Search by Filter', PLUGIN_SLUG ); ?></th>
											<td class="advance_search_html">
											
												<p><input type="radio"  name="advance_search_filter" <?php if( !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Product_Title') { echo "checked"; } ?>  value="Product_Title" /><?php echo __('Product title', PLUGIN_SLUG ); ?> </p>
												<p><input type="radio"  name="advance_search_filter" value="Order_by_date" <?php if( !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Order_by_date') { echo "checked"; } ?>  /><?php echo __('Product date', PLUGIN_SLUG ); ?></p>
												<p><input type="radio"  name="advance_search_filter" value="Order_By_Price" <?php if( !empty( $Advance_Search_Filter ) && $Advance_Search_Filter == 'Order_By_Price') { echo "checked"; } ?> /><?php echo __('Product price', PLUGIN_SLUG ); ?></p>
												
											</td>
										</tr>
										<tr>
											<th class="advance_"><?php echo __('Search order by', PLUGIN_SLUG ); ?> </th><td class="advance_search_html">
											
											<select name="Selectorder_by" class="advance_search_filter_order_by_html">
						    				<option value="Asc" <?php if( !empty( $Advance_order_by ) && $Advance_order_by == 'Asc') { echo "selected = 'selected'"; }?>>Order by ascending</option><option value="Desc" <?php if( !empty( $Advance_order_by ) && $Advance_order_by == 'Desc') { echo "selected = 'selected'"; }?>><?php echo __('Order by descending', PLUGIN_SLUG ); ?></option>
						    			</select> </td>
										</tr>
									</tbody>
								</table>
				  		  </form>
			        </div>
			        
			        <div class="woo-advance-search-preview-tab" style="display:none">  
			        		
			        		<h3><?php echo __('Advance Search Preview', PLUGIN_SLUG ); ?></h3> 
			        		<table class="advance_woocommerce_serach_table form-table">
									<tbody>
										<tr>
											<td>
												<input type="text" id="placeholder_changes" placeholder ="Search by product" style="width: 47%;" >
												<select name="" class="advance_search_filter_product">
								    				<option value="product"><?php echo __('Search by product', PLUGIN_SLUG ); ?></option>
								    				<option value="product sku"><?php echo __('Search by product sku', PLUGIN_SLUG ); ?> </option>
								    			</select>	
												<input type="button" name="Search" class="button button-primary" value="Search" id="Search_Button_Preview">
												
											</td>
										</tr>
										<tr class="preview_selected_category">
											<td>
												<select name="SelectCategory" id="advance_search_category_preview_html">
													<option value="Select Category"><?php echo __('Select Category', PLUGIN_SLUG ); ?></option>
													<?php 
														$prod_cat_args = array(
														'taxonomy'     => 'product_cat', 
														'orderby'      => 'name',
														'empty'        => 0
														);
														$woo_categories = get_categories( $prod_cat_args );
														
														foreach ( $woo_categories as $woo_cat ) {
															$woo_cat_id = $woo_cat->term_id; //category ID
															$woo_cat_name = $woo_cat->name; //category name 
															
															?>
														<option value="<?php echo $woo_cat_id; ?>" <?php if( $product_cat === $woo_cat_name ) { echo "selected=selected"; } ?>><?php echo $woo_cat_name; ?></option>	 
													<?php 	} ?>
												</select>
												<select name="Selecttag" id="advance_search_category_tag_html">
													<option value="Select Tag"><?php echo __('Select Tag', PLUGIN_SLUG ); ?></option> 
													<?php 
														$terms = get_terms( 'product_tag' );
														$term_array = array();
														if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
														    foreach ( $terms as $term ) { ?>
														        <option value="<?php echo $term->term_id; ?>" <?php if( $product_tag === $term->name ) { echo "selected=selected"; } ?> ><?php echo $term->name; ?></option>
														    <?php }
														} ?>
												</select>
											 </td>
										</tr>
										<tr>
											<td>	 	
												<select name="orderby" id="advance_search_order_by_preview_html">
													<option value="Ascending"><?php echo __('Order by ascending', PLUGIN_SLUG ); ?> </option>
													<option value="Descending"><?php echo __('Order by descending', PLUGIN_SLUG ); ?></option>
												</select>
												<select name="filter" id="advance_search_filter_tag_html">
													<option value="Product_title"><?php echo __('Filter by title', PLUGIN_SLUG ); ?></option>
													<option value="Product_price"><?php echo __('Filter by Price', PLUGIN_SLUG ); ?></option>
													<option value="Product_date"><?php echo __('Filter by date', PLUGIN_SLUG ); ?></option>
												</select>
												
											</td>
										</tr>
										<?php /*
										<tr>
												<td class="arrtibute_display"> 
													<?php 
														$Advance_search_attribute_select = get_option('Advance_search_attribute_select');
														$selected_attribute_val_name = array();
														$selected_attribute_val = json_decode( $Advance_search_attribute_select);
													
														foreach ( $selected_attribute_val as $selected_attribute_val_results ) { 
															$selected_attribute_val_name = $selected_attribute_val_results; ?>
															<label class="attributes_name_class"><?php //echo $selected_attribute_val_name ." : " ;  ?></label>
															<select name="advance_search_attributes_<?php echo $selected_attribute_val_name ;  ?>" class="select_attributes_name_css" > 
																<option value=""> <?php echo "select ".$selected_attribute_val_name; ?></option>
																<?php 
																	$terms = get_terms( "pa_".$selected_attribute_val_name );
																	foreach ( $terms as $terms_results ) {  ?>
																		<option value="<?php echo $terms_results->term_id; ?>" data-name ="<?php echo $selected_attribute_val_name ;?>" data-arribute ="<?php echo "pa_".$selected_attribute_val_name ; ?>"><?php echo $terms_results->name; ?></option>
																<?php } ?>
															</select>
														<?php } ?>
												</td>
										</tr>	
										*/ ?>				
									</tbody>
							</table>
																			
							<fieldset class="wbm_global">	
								<legend><div class="wbm-setting-header"><h2><?php echo __('Search by Attributes', PLUGIN_SLUG ); ?></h2></div></legend>
								<div class="category_based_settings">
									<table class="advance_woocommerce_serach_table form-table">
										<tbody>
											<tr>
												<td class="arrtibute_display"> 
													<?php 
														$Advance_search_attribute_select = get_option('Advance_search_attribute_select');
														$selected_attribute_val_name = array();
														$selected_attribute_val = json_decode( $Advance_search_attribute_select);
														if( !empty( $selected_attribute_val )) {
														foreach ( $selected_attribute_val as $selected_attribute_val_results ) { 
															$selected_attribute_val_name = $selected_attribute_val_results; ?>
															<label class="attributes_name_class"><?php //echo $selected_attribute_val_name ." : " ;  ?></label>
															<select name="advance_search_attributes_<?php echo $selected_attribute_val_name ;  ?>" class="select_attributes_name_css" > 
																<option value=""> <?php echo "Select ".$selected_attribute_val_name; ?></option>
																<?php 
																	$terms = get_terms( "pa_".$selected_attribute_val_name );
																	foreach ( $terms as $terms_results ) {  ?>
																		<option value="<?php echo $terms_results->term_id; ?>" data-name ="<?php echo $selected_attribute_val_name ;?>" data-arribute ="<?php echo "pa_".$selected_attribute_val_name ; ?>"><?php echo $terms_results->name; ?></option>
																<?php } ?>
															</select>
														<?php } }  else {  echo __('<h3>No Attributes Selected</h3>' , PLUGIN_SLUG ); } ?>
												</td>
														
											</tr>
										</tbody>
									</table>
								</div>
							</fieldset>
							<fieldset class="price_ranger_preview">
							<table class="advance_woocommerce_serach_table form-table">
								<tbody>
										<?php  
										$slider_price_max = '';
										$slider_price_min = '';
									
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
									<tr>
										<td>
											<div class="advance_searching_price_slider_main"> 
												<input type="hidden" value="<?php echo $slider_price_max; ?>" id="listing_searching_max_hidden_price">
												<p class="searching_price_range" ><?php echo __('Price Range:', PLUGIN_SLUG ); ?>   <label id="display_amount_range"></label></p>
												<div id="searching-slider-range" style="width:90%"></div>
												<input type="hidden" id="min_amount" value=<?php echo $slider_price_min; ?> >
												<input type="hidden" id="max_amount" value=<?php echo $slider_price_max; ?> >
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							</fieldset>				
						</div>			
					    <div class="woo-advance-search-shortcode-tab" style="display:none"> 
					    	<h3><?php echo __('Advance Search Shortcode', PLUGIN_SLUG ); ?> </h3>
								<table class="advance_woocommerce_serach_table form-table">
									<tbody>
										<tr>
											<td>
												<input type="text" id="clipboard" readonly value="[advance-search-for-woocommerce]" width="50%" style="width:23%">
												<input data-clipboard-target="#clipboard" class="button button-primary zclip js-textareacopybtn btn"  data-zclip-text="" type="button" value="Copy to clipboard">
											</td>
										</tr>
									</tbody>
								</table>				
					    </div>
			    	<div class="woo-advance-search-custom-css" style="display:none">
			    		<h3><?php echo __('Advance Search Custom CSS', PLUGIN_SLUG ); ?></h3>
								<table class="advance_woocommerce_serach_table form-table">
									<tbody>
										<tr>
											<td>
												<textarea name="woo-advance-search-custom-css" id="woo-advance-search-custom-id" rows="15" cols="150" ><?php echo $Advance_search_custom_css; ?></textarea>
											</td>
										</tr>
									</tbody>
								</table>
			    	</div>		
					<p class="submit">
						<input name="save" class="button-primary advance_search_for_woocommerce_save_btn" type="button" value="Save changes">
					</p>
			</form>
		</div>
	
		  
	<?php } 
	
	
	/**
	 * Function For save data 
	 * 
	 * 
	 */
	public function Save_advance_search_settings ( ) { 
		global  $wpdb;
		$product_category 			= !empty( $_POST['Product_Category']  ) ? sanitize_text_field($_POST['Product_Category'] ) : ''; 
		$product_tag 				= !empty( $_POST['Product_Tag']  ) ? sanitize_text_field($_POST['Product_Tag'] ) : ''; 
		$product_price_ranger 		= !empty( $_POST['Product_Price_Ranger']  ) ? sanitize_text_field($_POST['Product_Price_Ranger']) : ''; 
		$product_search_type 		= !empty( $_POST['Product_Search_Type']  ) ? sanitize_text_field($_POST['Product_Search_Type'] ) : ''; 
		$product_sku 				= !empty( $_POST['Product_Sku'] ) ? sanitize_text_field($_POST['Product_Sku'] ) : ''; 
		$Product_Based_On_Search	= !empty( $_POST['Product_Based_On_Search'] ) ? sanitize_text_field ( $_POST['Product_Based_On_Search'] ) : '';  
		$Max_product_price_range	= !empty( $_POST['Max_product_price_range']  ) ? sanitize_text_field($_POST['Max_product_price_range']) : '1000';  
		$Advance_search_filter		= !empty( $_POST['Advance_search_filter']  ) ? sanitize_text_field($_POST['Advance_search_filter'] ) : '';  
		$order_by					= !empty( $_POST['order_by'] ) ? sanitize_text_field( $_POST['order_by'] ): '';  
		$Advance_search_attribute	= !empty( $_POST['Advance_search_attribute']  ) ? sanitize_text_field($_POST['Advance_search_attribute']) : '';  
		$Advance_search_custom_css	= !empty( $_POST['custom_css'] ) ? sanitize_text_field($_POST['custom_css']) : '';  
		
		$Advance_search_attribute_select = !empty( $_POST['create_attribute'])? $_POST['create_attribute'] :array();
		$arrtibute_val = json_encode($Advance_search_attribute_select );
		
		update_option('Advance_Search_Product_Category_Enable',$product_category);
		update_option('Advance_Search_Product_Tag_Enable',$product_tag);
		update_option('Advance_Search_Product_Price_Ranger_Enable',$product_price_ranger);
		update_option('Advance_Search_Product_Search_Type_Enable',$product_search_type);
		update_option('Advance_Search_Product_Sku_Enable',$product_sku);
		update_option('Advance_Search_Product_Based_On_Search_Enable',$Product_Based_On_Search);
		update_option('Advance_Search_Max_product_price_range',$Max_product_price_range);
		update_option('Advance_Search_Filter',$Advance_search_filter);
		update_option('Advance_order_by',$order_by);
		update_option('Advance_search_attribute',$Advance_search_attribute);
		update_option('Advance_search_custom_css',$Advance_search_custom_css);
		update_option('Advance_search_attribute_select',$arrtibute_val);
		echo "<p><strong>Your settings have been saved.</strong></p>";	
		die();
	}
	/**
	 * Function For create custom widget
	 * 
	 * 
	 */
	public  function advance_search_custom_widget_plugin ( ){ 
		require_once 'partials/advance-search-for-woo-admin-display.php';
		register_widget( 'wpb_widget' );	
		$admin = new wpb_widget();
	}
	
}
