/**
 * Created by emurimi on 4/29/16.
 */
$('.restore_account').on('click', function(){
    var customer_account_id = $(this).attr('customer_acc_id');
    var data = { 'customer_acc_id': customer_account_id }

    if(customer_account_id != ''){
        //perform some ajax to restore masterfile and reactivate login account
        $.ajax({
            url: 'src/crm_module/restore_customer_account.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                if(data['status'] = 1){
                    $('#flash').slideDown('slow', function(){
                        location.reload(true);
                    });
                }else{
                    alert('Encountered an error!');
                }
            }
        });
    }
});

$('.delete_account').on('click', function(){
    var acc_id = $(this).attr('device_id');

    $('#delete_id').val(acc_id);
});
