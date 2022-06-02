if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_ajax_update_count' ) ) {
  function yith_wcwl_ajax_update_count() {
    wp_send_json( array(
      'count' => yith_wcwl_count_all_products()
    ) );
  }

  add_action( 'wp_ajax_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
  add_action( 'wp_ajax_nopriv_yith_wcwl_update_wishlist_count', 'yith_wcwl_ajax_update_count' );
}


if ( defined( 'YITH_WCWL' ) && ! function_exists( 'yith_wcwl_enqueue_custom_script' ) ) {
	function yith_wcwl_enqueue_custom_script() {
		wp_add_inline_script(
		  'jquery-yith-wcwl',
		  "
			jQuery( function( $ ) {
			  $('<span class=\"header-icon-counter\" id=\"header-wishlist-counter\"></span>').insertAfter('.ec-favorites')
			  $( document ).on( 'added_to_wishlist removed_from_wishlist', function() {
				$.get( yith_wcwl_l10n.ajax_url, {
				  action: 'yith_wcwl_update_wishlist_count'
				}, function( data ) {
				  
				  $('#header-wishlist-counter').text(data.count)
				  $('.add_to_wishlist').click(function(data){
					$('#header-wishlist-counter').text(data.count);
				  });
				  
				} );
			  } ).trigger('added_to_wishlist');
			});
		  "
		);
	  
	}
}