/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );
	
	
	// for paypal highlight before text
	wp.customize("paypal_highlight_before_text", function(value) {
		value.bind(function(newval) {
			$("#paypal_highlight_before_text").html(newval);
		} );
	});
	
	// for paypal highlight text
	wp.customize("paypal_highlight_text", function(value) {
		value.bind(function(newval) {
			$("#paypal_highlight_text").html(newval);
		} );
	});
	
	// for paypal highlight after text
	wp.customize("paypal_highlight_after_text", function(value) {
		value.bind(function(newval) {
			$("#paypal_highlight_after_text").html(newval);
		} );
	});
	
	// for customer care number
	wp.customize("cust_care_no", function(value) {
		value.bind(function(newval) {
			$("#cust_care_no").html(newval);
		} );
	});
	
	// for customer care email-id
	wp.customize("cust_care_id", function(value) {
		value.bind(function(newval) {
			$("#cust_care_id").html(newval);
		} );
	});
	
	// for banner top content first heading
	wp.customize("banner_del_info", function(value) {
		value.bind(function(newval) {
			$("#banner_del_info").html(newval);
		} );
	});
	
	// for banner top content first content
	wp.customize("first_banner_cntnt", function(value) {
		value.bind(function(newval) {
			$("#first_banner_cntnt").html(newval);
		} );
	});
	
	// for banner top content second heading
	wp.customize("scnd_banner_head", function(value) {
		value.bind(function(newval) {
			$("#scnd_banner_head").html(newval);
		} );
	});
	
	// for banner top content second content
	wp.customize("scnd_banner_cntnt", function(value) {
		value.bind(function(newval) {
			$("#scnd_banner_cntnt").html(newval);
		} );
	});
	
	// for banner top content third heading
	wp.customize("thrd_banner_head", function(value) {
		value.bind(function(newval) {
			$("#thrd_banner_head").html(newval);
		} );
	});
	
	// for banner top content third content
	wp.customize("thrd_banner_head", function(value) {
		value.bind(function(newval) {
			$("#thrd_banner_cntnt").html(newval);
		} );
	});
	
	// for banner img on/off
	wp.customize("craze_home_banner_on_off", function(value) {
		value.bind(function(newval) {
			$("#craze_home_banner_on_off").html(newval);
		} );
	});
	
	// for banner img 1
	wp.customize("bnr_img1", function(value) {
		value.bind(function(newval) {
			$("#bnr_img1").html(newval);
		} );
	});
	
	// for banner img 2
	wp.customize("bnr_img2", function(value) {
		value.bind(function(newval) {
			$("#bnr_img2").html(newval);
		} );
	});
	
	// for banner img 3
	wp.customize("bnr_img3", function(value) {
		value.bind(function(newval) {
			$("#bnr_img3").html(newval);
		} );
	});
	
	
	// for small banner img on/off
	wp.customize("craze_small_banner_on_off", function(value) {
		value.bind(function(newval) {
			$("#craze_small_banner_on_off").html(newval);
		} );
	});
	
	// for small banner 1 img
	wp.customize("sml_bnr1_img", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_img").html(newval);
		} );
	});
	
	// for small banner 1 highlight before text
	wp.customize("sml_bnr1_high_before_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_high_before_txt").html(newval);
		} );
	});
	
	// for small banner 1 highlight text
	wp.customize("sml_bnr1_high_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_high_txt").html(newval);
		} );
	});
	
	// for small banner 1 highlight after text
	wp.customize("sml_bnr1_high_after_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_high_after_txt").html(newval);
		} );
	});
	
	// for small banner 1 button text
	wp.customize("sml_bnr1_btn_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_btn_txt").html(newval);
		} );
	});
	
	// for small Banner 1 button link address
	wp.customize("sml_bnr1_btn_link", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr1_btn_link").html(newval);
		} );
	});
	
	// for small banner 2 img
	wp.customize("sml_bnr2_img", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_img").html(newval);
		} );
	});
	
	// for small banner 2 highlight before text
	wp.customize("sml_bnr2_high_before_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_high_before_txt").html(newval);
		} );
	});
	
	// for small banner 2 highlight text
	wp.customize("sml_bnr2_high_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_high_txt").html(newval);
		} );
	});
	
	// for small banner 2 highlight after text
	wp.customize("sml_bnr2_high_after_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_high_after_txt").html(newval);
		} );
	});
	
	// for small banner 2 button text
	wp.customize("sml_bnr2_btn_txt", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_btn_txt").html(newval);
		} );
	});
	
	// for small Banner 2 button link address
	wp.customize("sml_bnr2_btn_link", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr2_btn_link").html(newval);
		} );
	});
	
	// for small banner 3 img
	wp.customize("sml_bnr3_img", function(value) {
		value.bind(function(newval) {
			$("#sml_bnr3_img").html(newval);
		} );
	});
	
	// for body banner img
	wp.customize("body_bnnr_img", function(value) {
		value.bind(function(newval) {
			$("#body_bnnr_img").html(newval);
		} );
	});
	
	// for body banner btn
	wp.customize("body_bnnr_btn", function(value) {
		value.bind(function(newval) {
			$("#body_bnnr_btn").html(newval);
		} );
	});
	
	// for Banner Button Link Address
	wp.customize("baner_btn_link", function(value) {
		value.bind(function(newval) {
			$("#baner_btn_link").html(newval);
		} );
	});
	
	// for top rated product heading
	wp.customize("top_prdct_head", function(value) {
		value.bind(function(newval) {
			$("#top_prdct_head").html(newval);
		} );
	});

	// for sale product heading
	wp.customize("sale_prdct_head", function(value) {
		value.bind(function(newval) {
			$("#sale_prdct_head").html(newval);
		} );
	});
	 
	// for best selling product heading
	wp.customize("best_selling_prdct_head", function(value) {
		value.bind(function(newval) {
			$("#best_selling_prdct_head").html(newval);
		} );
	});
	
	// for top rated heading
	wp.customize("top_rated_prdct_head", function(value) {
		value.bind(function(newval) {
			$("#top_rated_prdct_head").html(newval);
		} );
	});
	
	// for footer content
	wp.customize("copyright_text", function(value) {
		value.bind(function(newval) {
			$("#copyright_text").html(newval);
		} );
	});
	
	
} )( jQuery );
