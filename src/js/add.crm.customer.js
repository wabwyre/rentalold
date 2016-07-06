// $(document).ready(function(){
$('#b_role').change(function(){
    var role = $(this).val();
    if(role=="staff"){
        $('#customer_type_id').attr('disabled','disabled');
        $('#company_name').attr('disabled', 'disabled').val('');
        $('#user_role').removeAttr('disabled');
        $('#gender').removeAttr('disabled');
        $('#email').text('Username:');
        $('#userole').text('User Role*');
    }else if(role=="client"){
        $('#customer_type_id').removeAttr('disabled');
        $('#company_name').removeAttr('disabled');
        $('#gender').removeAttr('disabled');
        $('#user_role').attr('disabled', 'disabled').val('');
        $('#email').text('Email');
    }
});

// var role = $('#b_role').val();
// if(role=="staff"){
//     $('#customer_type_id').attr('disabled','disabled');
//     $('#user_role').removeAttr('disabled');
//     $('#company_name').attr('disabled', 'disabled');
// }else if(role=="client"){
//     $('#customer_type_id').removeAttr('disabled');
//     $('#company_name').removeAttr('disabled');
//     $('#user_role').attr('disabled', 'disabled').val('');
// }
// // });

// client group validation
$('#b_role').change(function(){
    var role = $(this).val();
    if(role=="client group"){
        $('#firstname').attr('readonly','readonly').val('');
        $('#middlename').attr('readonly', 'readonly').val('');
        $('#company_name').attr('disabled', 'disable').val('');
        $('#gender').attr('disabled', 'disabled').val('');
        $('#customer_type_id').removeAttr('disabled').val(1);
        $('#user_role').attr('disabled', 'disabled').val('');
        $('#variation').text('Title*');
        $('#gender2').text('Gender');
        $('#mf_type').text('Masterfile Type');
        $('#id_pass').text('Business No.');
        $('#userole').text('User Role');
    }else if(role=="client"){
        $('#firstname').removeAttr('readonly');
        $('#middlename').removeAttr('readonly');
        $('#company_name').removeAttr('disabled');
        $('#user_role').attr('disabled', 'disabled').val('');
        $('#variation').text('Surname*');
        $('#gender2').text('Gender*');
        $('#mf_type').text('Masterfile Type*');
        $('#customer_type_id').val('');
        $('#id_pass').text('Id/Passport*');
        $('#userole').text('User Role');
    }else if(role=="staff"){
        $('#firstname').removeAttr('readonly');
        $('#middlename').removeAttr('readonly');
        // $('#company_name').removeAttr('disabled');
        $('#variation').text('Surname*');
        $('#gender2').text('Gender*');        
        $('#mf_type').text('Masterfile Type');
        $('#id_pass').text('Id/Passport*');
        $('#userole').text('User Role*');
    }
});

var role = $('#b_role').val();
if(role=="client group"){
    $('#firstname').attr('readonly','readonly').val('');
    $('#middlename').attr('readonly', 'readonly').val('');
    $('#gender').attr('disabled', 'disabled').val('');
    $('#company_name').attr('disabled', 'disabled').val('');
    $('#customer_type_id').removeAttr('disabled').val(1);
    $('#user_role').attr('disabled', 'disabled').val('');
    $('#variation').text('Title*');
    $('#gender2').text('Gender*');
    $('#mf_type').text('Masterfile Type');
    $('#id_pass').text('Business No.');
}else if(role=="client"){
    $('#firstname').removeAttr('readonly');
    $('#middlename').removeAttr('readonly');
    $('#company_name').removeAttr('disabled');
    $('#user_role').attr('disabled', 'disabled').val('');
    $('#variation').text('Surname:*');
    $('#gender2').text('Gender*');
    $('#mf_type').text('Masterfile Type*');
    $('#customer_type_id').val('');
    $('#id_pass').text('Id/Passport*');
}else if(role=="staff"){
    $('#firstname').removeAttr('readonly');
    $('#middlename').removeAttr('readonly');
    $('#company_name').attr('disabled', 'disabled');
    $('#variation').text('Surname*');
    $('#gender2').text('Gender*');
    $('#mf_type').text('Masterfile Type');
    $('#id_pass').text('Id/Passport*');
}

