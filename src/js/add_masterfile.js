$('#business_role').on('change', function(){
	var role = $(this).val();

	if(role == 'staff'){
		$('#customer_type_id').attr('disabled', 'disabled');
	}
});