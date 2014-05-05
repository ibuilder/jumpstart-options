jQuery(document).ready(function($) {

	$('.' + gform_up.prefix + '_delete_link').on('click', function(e) {
		e.preventDefault();

		var $this = $(this);

		$.ajax({
			url:      gform_up.url,
			type:     'post',
			async:    true,
			cache:    false,
			dataType: 'html',
			data: {
				action:   gform_up.action,
				post_id:  $this.data('post_id'),
				form_id:  $this.data('form_id'),
				meta:     $this.data('meta'),
				nonce:    gform_up.nonce
			},

			success: function( response )
			{
				//console.log(response);
				if ( '1' === response )
				{
					//console.log('test');
					$this.closest('.' + gform_up.prefix + '_upload_container').fadeOut();
				}
			},

			error: function( xhr )
			{
				//console.log(xhr.responseText);
			}
		});
	});

});
