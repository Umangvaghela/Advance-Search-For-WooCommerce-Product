(function( $ ) {
	$(window).load(function () {   
		
		
		var hidden_max_price = $('#listing_searching_max_hidden_price').val();
		$( "#display_amount_range" ).html( "$0 - $"+hidden_max_price);
				$( "#searching-slider-range" ).slider({ 
					range: true,
					min: 0,
					max: hidden_max_price,
					values: [ 0, hidden_max_price ],
					slide: function( event, ui ) {  
					$( "#display_amount_range" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
					$( "#min_amount" ).val(ui.values[ 0 ]);
					$( "#max_amount" ).val(ui.values[ 1 ]);
				}
			});
			
			
			var setCurrentPage = function(url) {
			    $('h2 span').html(url || "/");
			    $("#menu-nav a[href='" + url + "']").fadeTo(500, 0.3);
			};
			
			$('.advance_search_for_woocommerce_save_btn').click(function(e) {  
			    e.preventDefault(); 
			    var text_value 				= jQuery('.default_preview_set_search_text2').val(); 
			    var product_cat  			= jQuery( ".advance_search_category_preview_html option:selected" ).val();
			    var product_tag   			= jQuery( ".advance_search_category_tag_html option:selected" ).val();
			    var order			   		= jQuery( ".order_by_dropdown option:selected" ).val();
			    var order_by			   	= jQuery( ".advance_search_filter_dropdown option:selected" ).val();
			    var search_product_by_sku	= jQuery( ".advance_search_product_or_sku_preview_html option:selected" ).val();
			    var maxprice 				= jQuery( "#max_amount" ).val();
				var minprice 				= jQuery( "#min_amount" ).val();
				var price      				= "price["+minprice+"_"+maxprice+"]";
			    var url      				=  window.location.href; 
			    var selected_url      		=  ""; 
			    
				selected_url 				+= "price["+minprice+"_"+maxprice+"]";
				if( product_cat !='') { 
			    	selected_url 			+= "|product_cat["+product_cat+"]";
			    } 
			    if( product_tag !='') { 
			    	selected_url 			+= "|product_tag["+product_tag+"]";
			    } 
			    if( order !='') { 
			    	selected_url 			+= "|order["+order+"]";
			    }
			    if( order_by !='') { 
			    	selected_url 			+= "|order_by["+order_by+"]";
			    } 
			    if( search_product_by_sku !='' && search_product_by_sku == 'product_sku') {  
		    		if( text_value != '') {
		    			selected_url 		+= "|search_by_product_sku["+text_value+"]";
		    		}
			    } 
			    if( search_product_by_sku !='' && search_product_by_sku == 'product' ) {  
		    		if( text_value != '') { 
						selected_url 		+= "|search_by_product["+text_value+"]";
		    		}
			    }
			   	var attribute_selected_value = ''; 
			   	var attribute_selected_url   = '';
			    $( ".select_attributes_name_css option:selected" ).each(function() { 
			    	var ate 	= $( this ).val();
			    	var attribute_val = $( this ).attr('data-arribute');
			    	var attribute_val_name = $( this ).attr('data-name');
			        attribute_selected_value += "|"+attribute_val+"["+ate+"]";
			        if( ate != '' ){
			        	attribute_selected_url += "|"+attribute_val_name+"["+ate+"]";
			        }
		       });
			    
			    var targetUrl 				= '?advance_filters='+product_cat;
			    targetTitle 				= text_value;
			    window.history.pushState({url: "?advance_filters="+price}, targetTitle, "?advance_filters="+selected_url+attribute_selected_url);
			    setCurrentPage(targetUrl);
			    var shop_page_url_or_not = $('#shop_page_or_not').val();
			    
			    if( shop_page_url_or_not == 'other') { 
			    	var shop_page_url = $('form#wc_product_finder').attr('action');
			    	window.location.replace(shop_page_url+"?advance_filters="+selected_url+attribute_selected_url);
			    } else {  
			    	ajaxindicatorstart('Please wait');
			    $.ajax({ 
			    	type:'GET',
                    url: adminajaxjs.adminajaxjsurl,
                    async: false,
                    data: ({
                        action: 'advance_search_for_woocommerce_ajax_call',
                        text_value:text_value,
                        advance_filters:selected_url+attribute_selected_url,
                    }),
                    success: function (data) { 
                    	
						$('.woocommerce-result-count').remove();
						$('.woocommerce-pagination').remove();
						$('form.woocommerce-ordering').remove();
						var product_content = jQuery.parseJSON(data); 
						
						if ( $('.woocommerce-info').hasClass('woocommerce-info') && ! $('ul.products').is(':visible') ) {
							if ( typeof product_content.products != 'undefined' ) {
								$('.woocommerce-info').replaceWith(product_content.products);
							}
						} else {
							if ( typeof product_content.no_products != 'undefined' ) {
								
								$("ul.products").html(product_content.no_products).removeClass('hide_products');
								$("ul.products li").addClass("product");
							} else {
								
								$("ul.products").replaceWith(product_content.products).removeClass('hide_products');
								$("ul.products li").addClass("product");
							}
						}
						setTimeIntervalreminderinsert = setInterval(function(){ ajaxindicatorstop(); clearInterval(setTimeIntervalreminderinsert);},5000);
                    }
                });
			  }
			    
			});
			
				window.onpopstate = function(e) {
			    setCurrentPage(e.state ? e.state.url : null);
			};
				
			$('.Advance_Search_Button').click(function() {  
		
		       $(this).parent().find( ".advance_default_search_advance_search_option" ).slideToggle("fast");
		    });
			$(".advance_search_product_or_sku_preview_html").click(function () {  
				var dropdown_product_type = jQuery( ".advance_search_product_or_sku_preview_html option:selected" ).val();
				if( dropdown_product_type == 'product_sku') { 
					$(".default_preview_set_search_text2").attr("placeholder", "Search by product sku");
				} else { 
					$(".default_preview_set_search_text2").attr("placeholder", "Search by product");
				}
				
			})
			
			
			function ajaxindicatorstart(text) {
				if($('body').find('#resultLoading').attr('id') != 'resultLoading'){
					$('body').append('<div id="resultLoading" style="display:none"><div><img src="'+ajaxicon.loderurl+'"><div>'+text+'</div></div><div class="bg"></div></div>');
				}
			
				$('#resultLoading').css({
					'width':'100%',
					'height':'100%',
					'position':'fixed',
					'z-index':'10000000',
					'top':'0',
					'left':'0',
					'right':'0',
					'bottom':'0',
					'margin':'auto'
				});
			
				$('#resultLoading .bg').css({
					'background':'#000000',
					'opacity':'0.7',
					'width':'100%',
					'height':'100%',
					'position':'absolute',
					'top':'0'
				});
			
				$('#resultLoading>div:first').css({
					'width': '250px',
					'height':'75px',
					'text-align': 'center',
					'position': 'fixed',
					'top':'0',
					'left':'0',
					'right':'0',
					'bottom':'0',
					'margin':'auto',
					'font-size':'16px',
					'z-index':'10',
					'color':'#ffffff'
			
				});
			
			    $('#resultLoading .bg').height('100%');
			       $('#resultLoading').fadeIn(300);
			    $('body').css('cursor', 'wait');
			}
			
			function ajaxindicatorstop() {
			    $('#resultLoading .bg').height('100%');
			    $('#resultLoading').fadeOut(300);
			    $('body').css('cursor', 'default');
			}
			
			
		});
		
})( jQuery );
