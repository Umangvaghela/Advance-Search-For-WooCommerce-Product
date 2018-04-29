(function( $ ) {
	$(window).load(function () {  
		
		 var max_prise_ranger = $('#listing_searching_max_hidden_price').val();
 	 	 
 	 	 $('body').on('click','.advance_search_for_woocommerce_save_btn' , function( ) { 
 	 	 	
 	 	 	var Product_Category		= $('input[id="advance_search_product_category"][type="checkbox"]:checked').val();	
 	 	 	var Product_Tag				= $('input[id="advance_search_product_tag"][type="checkbox"]:checked').val();	
 	 	 	var Product_Price_Ranger	= $('input[id="advance_search_product_price_ranger"][type="checkbox"]:checked').val();	
 	 	 	var Product_Sku				= $('input[id="advance_search_product_sku"][type="checkbox"]:checked').val();	
 	 	 	
 	 	 	/*var Product_Based_On_Search	= $('input[name="advance_search_all_afws"][type="radio"]:checked').val();	*/
 	 	 	var Product_Based_On_Search 	= $("input[type='radio'][name='advance_search_all_afws']:checked").val();
 	 	 	var Product_Search_Type			= $('input[name="advance_search_product_search_type"][type="radio"]:checked').val();
 	 	 	var Advance_search_filter		= $('input[name="advance_search_filter"][type="radio"]:checked').val();
 	 	 	var Advance_search_attribute	= $('input[name="advance_search_product_attributes"][type="checkbox"]:checked').val();
 	 	 	var Max_product_price_range		= $('#advance_search_max_product_price_ranger').val();
 	 	 	var order_by 					= $( ".advance_search_filter_order_by_html option:selected" ).val();
 	 	 	var custom_css 					= $( "#woo-advance-search-custom-id" ).val(); 
 	 	 	
 	 	 	var create_attribute			= $(".chzn-select").val();
			console.log(create_attribute);
 	 	 	$.ajax({  
 	 	 		type: "POST",
                url: adminajaxjs.adminajaxjsurl,
                data: ({
                    action: 'Save_advance_search_settings',
                    Product_Category:Product_Category ,                 
                    Product_Tag:Product_Tag,                
                    Product_Price_Ranger:Product_Price_Ranger,                  
                    Product_Search_Type:Product_Search_Type,                  
                    Product_Sku:Product_Sku,                  
                    Product_Based_On_Search:Product_Based_On_Search,                  
                    Max_product_price_range:Max_product_price_range,                  
                    Advance_search_filter:Advance_search_filter,                  
                    Advance_search_attribute:Advance_search_attribute,                  
                    order_by:order_by,                  
                    custom_css:custom_css, 
                    create_attribute:create_attribute,                 
                }),
                success: function (data) {
                	var max_prise_ranger = $('#advance_search_max_product_price_ranger').val();
                	$('.woo_advance_save_record_messgae').css('display','block').delay(2000).fadeOut('slow');;
                	$('.woo_advance_save_record_messgae').html(data);
                }
 	 	 		
 	 	 	});
 	 	 });
 	 	
		$( "#display_amount_range" ).html( "$0 - $"+max_prise_ranger);
			$( "#searching-slider-range" ).slider({ 
				range: true,
				min: 0,
				max: max_prise_ranger,
				values: [ 0, max_prise_ranger ],
				slide: function( event, ui ) {  
				$( "#display_amount_range" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
				$( "#min_amount" ).val(ui.values[ 0 ]);
				$( "#max_amount" ).val(ui.values[ 1 ]);
			}
		});
			
		/*$('body').on('click','#advance_search_preview_tab' , function() { 
			
			var Product_Category		= $('input[id="advance_search_product_category"][type="checkbox"]:checked').val();	
 	 	 	var Product_Tag				= $('input[id="advance_search_product_tag"][type="checkbox"]:checked').val();	
 	 	 	console.log(Product_Tag == 'Active');
 	 	 	var Product_Price_Ranger	= $('input[id="advance_search_product_price_ranger"][type="checkbox"]:checked').val();	
 	 	 	if( Product_Category == 'Active') { 
 	 	 		var product_category_css = 'inline-block';
 	 	 	}else { 
 	 	 		var product_category_css = 'none';
 	 	 	}
 	 	 	if( Product_Tag == 'Active') { 
 	 	 		
 	 	 		var Product_Tag_css = 'inline-block';
 	 	 	}else { 
 	 	 		var Product_Tag_css = 'none';
 	 	 	}
 	 	 	if( Product_Price_Ranger == 'Active') { 
 	 	 		var Product_Price_Ranger_css = 'inline-block';
 	 	 	}else { 
 	 	 		var Product_Price_Ranger_css = 'none';
 	 	 	}
 	 	 	$('select.advance_search_category_preview_html').css('display',product_category_css);
 	 	 	$('select.advance_search_category_tag_html').css('display',Product_Tag_css);
 	 	 	$('.advance_searching_price_slider_main').css('display',Product_Price_Ranger_css);
 	 	 	
			
		});*/
		
		
		
		/*$('body').on('click','#advance_search_open_preview' , function( ) { 
 	 	 	$('#advance_search_open_preview').addClass('nav-tab-active');
 	 	 	$('#advance_search_open_setting').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_shortcode').removeClass('nav-tab-active'); 
 	 	 	$('#advance_search_open_custom_css').removeClass('nav-tab-active');
 	 	 	
 	 	 	$('.woo-advance-search-preview-tab').css('display','block'); 
 	 	 	$('.woo-advance-search-setting-tab').css('display','none'); 
 	 	 	$('.woo-advance-search-shortcode-tab').css('display','none');
 	 	 	
 	 	 	
 	 	 	var Product_Category		= $('input[id="advance_search_product_category"][type="checkbox"]:checked').val();	
 	 	 	var Product_Tag				= $('input[id="advance_search_product_tag"][type="checkbox"]:checked').val();	
 	 	 	if( Product_Category == 'Active') { 
 	 	 		var product_category_css = 'inline-block';
 	 	 	}else { 
 	 	 		var product_category_css = 'none';
 	 	 	}
 	 	 	if( Product_Tag == 'Active') { 
 	 	 		
 	 	 		var Product_Tag_css = 'inline-block';
 	 	 	} else { 
 	 	 		var Product_Tag_css = 'none';
 	 	 	}
 	 	 	$('select#advance_search_category_preview_html').css('display',product_category_css);
 	 	 	$('select#advance_search_category_tag_html').css('display',Product_Tag_css);
 	 	 	
 	 	 	
 	 	 });*/
		
	<!---------------------------  Start admin preview tab option script   ---------------------------------------!>
			
			$('body').on('click','#advance_search_open_preview_premium' , function( ) { 
				$('#advance_search_open_preview_premium').addClass('nav-tab-active');
				$('#advance_search_open_setting_premium').removeClass('nav-tab-active');
				$('#advance_search_open_shortcode_premium').removeClass('nav-tab-active'); 
				$('#advance_search_open_custom_css_premium').removeClass('nav-tab-active');
				
				$('.woo-advance-search-preview-tab').css('display','block'); 
				$('.woo-advance-search-setting-tab').css('display','none'); 
				$('.woo-advance-search-shortcode-tab').css('display','none');
				$('.woo-advance-search-custom-css').css('display','none'); 
				
				
				var Product_Category		= $('input[id="advance_search_product_category"][type="checkbox"]:checked').val();	
				var Product_Tag				= $('input[id="advance_search_product_tag"][type="checkbox"]:checked').val();	
				var Product_Price_Ranger	= $('input[id="advance_search_product_price_ranger"][type="checkbox"]:checked').val();
				var Product_attribute		= $('input[name="advance_search_product_attributes"][type="checkbox"]:checked').val();
				
				if( Product_attribute == 'All') { 
					var product_attribute_css = 'block';
				} else { 
					var product_attribute_css = 'none';
				}
				
				if( Product_Category == 'Active') { 
					var product_category_css = 'inline-block';
				}else { 
					var product_category_css = 'none';
				}
				if( Product_Tag == 'Active') { 
					
					var Product_Tag_css = 'inline-block';
				} else { 
					var Product_Tag_css = 'none';
				}
				
				
				if( Product_Price_Ranger == 'Active') { 
 	 	 			var Product_Price_Ranger_css = 'block';
	 	 	 	}else { 
	 	 	 		var Product_Price_Ranger_css = 'none';
	 	 	 	}
	 	 	 
				if( Product_Category != 'Active' && Product_Tag != 'Active' ) { 
					$('tr.preview_selected_category').css('display',"none");
				} else { 
					$('tr.preview_selected_category').css('display',"");
				}
	 	 	 	 
				$('select#advance_search_category_preview_html').css('display',product_category_css);
				$('select#advance_search_category_tag_html').css('display',Product_Tag_css);
				$('.advance_searching_price_slider_main').css('display',Product_Price_Ranger_css);
				$('fieldset.wbm_global').css('display',product_attribute_css);
				
				
			});	
			
 	 <!---------------------------  Start admin setting tab option script   ---------------------------------------!>	 
 	 	  	
 	 		$('body').on('click','#advance_search_open_setting_premium' , function( ) { 
	 	 	 	$('#advance_search_open_preview_premium').removeClass('nav-tab-active');
	 	 	 	$('#advance_search_open_setting_premium').addClass('nav-tab-active');
	 	 	 	$('#advance_search_open_shortcode_premium').removeClass('nav-tab-active');
	 	 	 	$('#advance_search_open_custom_css_premium').removeClass('nav-tab-active');
	 	 		$('.woo-advance-search-setting-tab').css('display','block'); 
	 	 	 	$('.woo-advance-search-preview-tab').css('display','none'); 
	 	 	 	$('.woo-advance-search-shortcode-tab').css('display','none'); 
	 	 	 	$('.woo-advance-search-custom-css').css('display','none'); 
 	 	 	});
 	 	 
 	<!---------------------------  Start admin shortcode tab option script   ---------------------------------------!>	
 	
 	 	 $('body').on('click','#advance_search_open_shortcode_premium' , function( ) { 
 	 	 	$('#advance_search_open_preview_premium').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_shortcode_premium').addClass('nav-tab-active');
 	 	 	$('#advance_search_open_setting_premium').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_custom_css_premium').removeClass('nav-tab-active');
 	 	 	$('.woo-advance-search-shortcode-tab').css('display','block');
 	 	 	$('.woo-advance-search-setting-tab').css('display','none'); 
 	 	 	$('.woo-advance-search-preview-tab').css('display','none'); 
 	 	 	$('.woo-advance-search-custom-css').css('display','none'); 
 	 	 	
 	 	 }); 
 	 	 
 	<!---------------------------  Start admin custom css  tab option script   ---------------------------------------!>	
 	
 	 	 $('body').on('click','#advance_search_open_custom_css_premium' , function( ) { 
 	 	 	$('#advance_search_open_preview_premium').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_shortcode_premium').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_setting_premium').removeClass('nav-tab-active');
 	 	 	$('#advance_search_open_custom_css_premium').addClass('nav-tab-active');
 	 	 	$('.woo-advance-search-shortcode-tab').css('display','none');
 	 	 	$('.woo-advance-search-setting-tab').css('display','none'); 
 	 	 	$('.woo-advance-search-preview-tab').css('display','none'); 
 	 	 	$('.woo-advance-search-custom-css').css('display','block'); 
 	 	 	
 	 	 });
		/*new DG.OnOffSwitch({
			   el: '#id-of-checkbox',
			   textOn: 'Yes',
			   textOff: 'No',
			   height:30,
			   trackColorOn:'#0085ba',
			   trackColorOff:'#666',
			   textColorOff:'#fff',
			   trackBorderColor:'#555'
			});*/
		
		var clipboard = new Clipboard('.btn');
	
			clipboard.on('success', function(e) {
			e.clearSelection();
			});
			
			clipboard.on('error', function(e) {
			});
			
	<!------------------------------------------------                           ---------------------------------------------------------------!>
			$(".chzn-select").chosen({ 
				placeholder_text_single: "Select an attributes",
			});
	<!-------------------------------------------------							 ---------------------------------------------------------------!>		
			$('body').on('click','#advance_search_product_sku_attributes',function( ) { 
				
				 if ($(this).is(':checked')) {
					$('.dislay_all_attributes').css('display','block');
				 } else { 
				 	$('.dislay_all_attributes').css('display','none');
				 } 
			});
	<!-------------------------------------------------							------------------------------------------------------------------!>
			
		
		$('.chzn-select').live('change', function () {  
       		var attribute_id = $(this).val();
       		var attribute_results = $(".chzn-select").val(); 	
       		console.log( attribute_results );
		});	
		
		$(".advance_search_filter_product").click(function () {  
				var dropdown_product_type = jQuery( ".advance_search_filter_product option:selected" ).val();
				console.log("hellow");
				console.log(dropdown_product_type	);
				if( dropdown_product_type == 'product sku') { 
					$("input#placeholder_changes").attr("placeholder", "Search by product sku");
				} else { 
					$("input#placeholder_changes").attr("placeholder", "Search by product");
				}
				
			})
	
		});
	
})( jQuery );
