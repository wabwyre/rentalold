$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'land_lord' || role == 'property_manager' || role == 'contractor'){
		// alert('working');
		$('#house').attr('disabled', 'disabled').val('');
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#lr_no').attr('disabled', 'disabled').val('');
	}else if(role == 'tenant'){
		$('#house').removeAttr('disabled').val('');
		$('#occupation').removeAttr('disabled').val('');
		$('#lr_no').removeAttr('disabled').val('');
	}
});