( function( $ ) {

	'use strict';

	$(document).ready(function($){

		$('.enrollment-message .notice-dismiss').on('click', function(e) {

			e.preventDefault();

			var $this = $(this);

			var nonce = $(this).parent().data('nonce');
			//alert(nonce);

			//var nonce = $(this).data('nonce');

			$.ajax({
				type     : 'GET',
				dataType : 'json',
				url      : ajaxurl,
				data     : {
					'action'   : 'enrollment_notice_dissmiss',
					'_wpnonce' : nonce
				},
				success  : function (response) {
					if ( true === response.status ) {
						$this.parents('#cv-theme-message').fadeOut('slow');
					}
				}
			});
		});
	});

} )( jQuery );
