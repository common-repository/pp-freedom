jQuery(document).ready(function($) {
	//Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.ppfrdm-color-field').wpColorPicker();
    });
	//widget form
	$('#ppfrdm_pub_wid_type').change(function(){
		if(this.value == 'local'){
			$('#ppfrdm_pub_wid_scope').prop('disabled', true);
			$('#ppfrdm_pub_wid_pkey').prop('disabled', true);
			$('#ppfrdm_pub_gen_pkey').prop('disabled', true);
		}else{
			$('#ppfrdm_pub_wid_scope').prop('disabled', false);
			$('#ppfrdm_pub_wid_pkey').prop('disabled', false);
			$('#ppfrdm_pub_gen_pkey').prop('disabled', false);
		}
	});
	$('#ppfrdm_pub_wid_scope').change(function(){
		if(this.value == 'public'){
			$('#ppfrdm_pub_wid_pkey').prop('disabled', true);
			$('#ppfrdm_pub_gen_pkey').prop('disabled', true);
		}else{
			$('#ppfrdm_pub_wid_pkey').prop('disabled', false);
			$('#ppfrdm_pub_gen_pkey').prop('disabled', false);
		}
	});
	$('#ppfrdm_pub_gen_pkey').click(function(){
		$('#ppfrdm_pub_wid_pkey').val("....");
	    var data = {
			'action': 'ppfrdm_get_pkey'
		};
		$.post(ppfrdm_ajax_object.ajax_url, data, function(response) {
			var data = jQuery.parseJSON(response);
			$('#ppfrdm_pub_wid_pkey').val(data.pkey);
		});
	});
	$('#ppfrdm_pub_wid_ptype').change(function(){
		$('#ppfrdm_pub_wid_tax').html("<option disabled selected> .... </option>");
	    var data = {
			'action': 'ppfrdm_get_texs',
			'post_type': this.value,
			'get_taxonomies': true
		};
		$.post(ppfrdm_ajax_object.ajax_url, data, function(response) {
			var data = jQuery.parseJSON(response);
			$('#ppfrdm_pub_wid_tax').html(data.taxonomies);
			$('#ppfrdm_pub_wid_trm').html(data.terms);
		});
	});
	$('#ppfrdm_pub_wid_tax').change(function(){
		$('#ppfrdm_pub_wid_trm').html("<option disabled selected> .... </option>");
	    var data = {
			'action': 'ppfrdm_get_texs',
			'taxonomy': this.value,
			'post_type': $('#ppfrdm_pub_wid_ptype').val(),
			'get_terms': true
		};
		$.post(ppfrdm_ajax_object.ajax_url, data, function(response) {
			var data = jQuery.parseJSON(response);
			$('#ppfrdm_pub_wid_trm').html(data.terms);
		});
	});

	$('#ppfrdm_pub_wid_dirl').change(function(){
	    if(this.value == 'enable'){
			$('#ppfrdm_pub_wid_intl').prop('disabled', true);
			$('#ppfrdm_pub_wid_srcl').prop('disabled', true);
		}else{
			$('#ppfrdm_pub_wid_intl').prop('disabled', false);
			$('#ppfrdm_pub_wid_srcl').prop('disabled', false);
		}
	});

	$('#ppfrdm_pul_wid_dirl').change(function(){
	    if(this.value == 'enable'){
			$('#ppfrdm_pul_wid_intl').prop('disabled', true);
			$('#ppfrdm_pul_wid_srcl').prop('disabled', true);
		}else{
			$('#ppfrdm_pul_wid_intl').prop('disabled', false);
			$('#ppfrdm_pul_wid_srcl').prop('disabled', false);
		}
	});

	//get widgetswidgets
	$('#ppfrdm_pul_get_widgets').click(function(){
		$('#ppfrdm_pul_widet').html("<option disabled selected> .... </option>");
	    var data = {
			'action': 'ppfrdm_get_widgets',
			'domain': $('#ppfrdm_pul_wid_domain').val(),
			'pkey': $('#ppfrdm_pul_wid_pkey').val(),
		};
		$.post(ppfrdm_ajax_object.ajax_url, data, function(response) {
			var data = jQuery.parseJSON(response);
			$('#ppfrdm_pul_widet').html(data.widgets);
		});
	});

	//hide color option if json is selected
	$('#ppfrdm_pub_wid_theme').change(function(){
		var selectedOption = $(this).val(); 
		if(selectedOption == 'json'){
			$('.theme_options_row').hide();
		}else{
			$('.theme_options_row').show();
		}
	});
});