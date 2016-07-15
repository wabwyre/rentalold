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

$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'tenant' || role == 'contractor' || role == 'property_manager'){
		// alert('working');
		$('#account_no').attr('disabled', 'disabled').val('');
		$('#bank_name').attr('disabled', 'disabled').val('');
		$('#branch_name').attr('disabled', 'disabled').val('');
	}else if(role == 'land_lord'){
		$('#account_no').removeAttr('disabled').val('');
		$('#bank_name').removeAttr('disabled').val('');
		$('#branch_name').removeAttr('disabled').val('');
	}
});

$('#bank_name').on('change', function(){
	var bank_id = $(this).val();
	var data = { 'bank_id': bank_id };

	if(bank_id != ''){
		$.ajax({
			url: '?num=722',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				var branches = '<option value="">--Choose Branch--</option>';
				for(var i = 0; i < data.length; i++){
					branches += '<option value="'+data[i].branch_id+'">'+data[i].branch_name+'</option>';
				}
				$('#branch_name').html(branches);
			}
		});
	}
});