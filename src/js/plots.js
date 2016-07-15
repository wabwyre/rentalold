$('.edit_prop').on('click', function(){
    var edit_id = $(this).attr('edit-id');
    var data = { 'edit_id': edit_id };
    $('#edit_id').val(edit_id);

    if(edit_id != ''){
        $.ajax({
            url: '?num=3001',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                $('#plot_name').val(data['plot_name']);
                $('#units').val(data['units']);
                $('#payment_code').val(data['payment_code']);
                $('#paybill_number').val(data['paybill_number']);
                $('#property_manager').val(data['pm_mfid']);
                $('#landlord').val(data['landlord_mfid']);
                $('#lr_no').val(data['lr_no']);
            }
        });
    }
});

$('.del_prop').on('click', function(){
   $('#delete_id').val($(this).attr('edit-id'));
});