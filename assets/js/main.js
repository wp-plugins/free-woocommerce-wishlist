jQuery(document).ready(function() {

	jQuery('.fwwl-btn').click(function(e) {
		e.preventDefault();
		var this_button = jQuery(this);
		var product_id = jQuery(this).data('product');
		this_button.off('click');
		this_button.addClass('fwwl-btn-disabled');
	    post_data = 'action=fwwl-addtowishlist&p=' + product_id;
	    jQuery.ajax({
			type: 'post',
			url: fwwl_ajaxurl,
			data: post_data,
			dataType: 'json',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				this_button.addClass('fwwl-btn-ko');
				this_button.text(fwwl_msg_ko);				
			},
			success: function(data, textStatus){
				if(data.response && data.response == 'OK') {
					this_button.addClass('fwwl-btn-ok');
					this_button.text(fwwl_msg_ok);
				} else {
					this_button.addClass('fwwl-btn-ko');
					this_button.text(fwwl_msg_ko);
				}			
			}
		});
	});

});
