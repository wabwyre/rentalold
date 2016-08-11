$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'land_lord' || role == 'property_manager'){
		// alert('working');
		$('#house').attr('disabled', 'disabled').val('');
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#lr_no').attr('disabled', 'disabled').val('');
		$('#skills').attr('disabled', 'disabled').val('');
		$('#core_activity').attr('disabled', 'disabled').val('');
	}else if(role == 'tenant'){
		$('#house').removeAttr('disabled').val('');
		$('#occupation').removeAttr('disabled').val('');
		$('#lr_no').removeAttr('disabled').val('');
		$('#user_role').val('70');
	}else if(role == 'contractor'){
		$('#skills').removeAttr('disabled', 'disable').val('');
		$('#core_activity').removeAttr('disabled', 'disable').val('');
		$('#house').attr('disabled', 'disabled').val('');
		$('#plot').attr('disabled', 'disabled').val('');
		$('#occupation').attr('disabled', 'disabled').val('');
	}
});

$('#b_role').on('change', function(){
	var role = $(this).val();

	if(role == 'tenant' || role == 'property_manager'){
		// alert('working');
		$('#account_no').attr('disabled', 'disabled').val('');
		$('#bank_name').attr('disabled', 'disabled').val('');
		$('#branch_name').attr('disabled', 'disabled').val('');
		$('#pin_no').attr('disabled', 'disabled').val('');
		$('#skills').attr('disabled', 'disabled').val('');
		$('#core_activity').attr('disabled', 'disabled').val('');
	}else if(role == 'land_lord'){
		$('#account_no').removeAttr('disabled').val('');
		$('#bank_name').removeAttr('disabled').val('');
		$('#branch_name').removeAttr('disabled').val('');
		$('#pin_no').removeAttr('disabled').val('');
		$('#user_role').val('68');
	}else if(role == 'contractor'){
		$('#skills').removeAttr('disabled', 'disable').val('');
		$('#core_activity').removeAttr('disabled', 'disable').val('');
		$('#house').attr('disabled', 'disabled').val('');
		$('#plot').attr('disabled', 'disabled').val('');
		$('#occupation').attr('disabled', 'disabled').val('');
		$('#user_role').val('69');
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

// start wizard validation
var FormWizard = function () {

	var form1 = $('#form_sample_1');
	return {
		//main function to initiate the module
		init: function () {
			if (!jQuery().bootstrapWizard) {
				return;
			}

			// default form wizard
			$('#form_wizard_1').bootstrapWizard({
				'nextSelector': '.button-next',
				'previousSelector': '.button-previous',
				onTabClick: function (tab, navigation, index) {
					alert('on tab click disabled');
					return false;
				},
				onNext: function (tab, navigation, index) {
					var total = navigation.find('li').length;
					var current = index + 1;
					// set wizard title
					$('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
					// set done steps
					jQuery('li', $('#form_wizard_1')).removeClass("done");
					var li_list = navigation.find('li');
					for (var i = 0; i < index; i++) {
						jQuery(li_list[i]).addClass("done");
					}

					if (current == 1) {
						$('#form_wizard_1').find('.button-previous').hide();
					} else {
						$('#form_wizard_1').find('.button-previous').show();
					}

					if (current >= total) {
						$('#form_wizard_1').find('.button-next').hide();
						$('#form_wizard_1').find('.button-submit').show();
					} else {
						$('#form_wizard_1').find('.button-next').show();
						$('#form_wizard_1').find('.button-submit').hide();
					}
					App.scrollTo($('.page-title'));
				},
				onPrevious: function (tab, navigation, index) {
					var total = navigation.find('li').length;
					var current = index + 1;
					// set wizard title
					$('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
					// set done steps
					jQuery('li', $('#form_wizard_1')).removeClass("done");
					var li_list = navigation.find('li');
					for (var i = 0; i < index; i++) {
						jQuery(li_list[i]).addClass("done");
					}

					if (current == 1) {
						$('#form_wizard_1').find('.button-previous').hide();
					} else {
						$('#form_wizard_1').find('.button-previous').show();
					}

					if (current >= total) {
						$('#form_wizard_1').find('.button-next').hide();
						$('#form_wizard_1').find('.button-submit').show();
					} else {
						$('#form_wizard_1').find('.button-next').show();
						$('#form_wizard_1').find('.button-submit').hide();
					}

					App.scrollTo($('.page-title'));
				},
				onTabShow: function (tab, navigation, index) {
					var total = navigation.find('li').length;
					var current = index + 1;
					var $percent = (current / total) * 100;
					$('#form_wizard_1').find('.bar').css({
						width: $percent + '%'
					});
				}
			});

			$('#form_wizard_1').find('.button-previous').hide();
			$('#form_wizard_1 .button-submit').click(function () {
				//alert('Finished! Hope you like it :)');
			}).hide();
		}

	};

}();
//end of wizard validation