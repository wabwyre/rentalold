/**
 * Created by JOEL on 7/15/2016.
 */
$('.edit_prop').on('click', function(){
    var edit_id = $(this).attr('edit-id');
    var data = { 'edit_id': edit_id };
    $('#edit_id').val(edit_id);

    if(edit_id != ''){
        $.ajax({
            url: '?num=add_branch',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(data){
                $('#branch_name').val(data['branch_name']);
                $('#branch_code').val(data['branch_code']);
                $('#created_at').val(data['created_at']);
                $('#status').val(data['status']);
            }
        });
    }
});

$('.del_branch').on('click', function(){
    $('#delete_id').val($(this).attr('edit-id'));
});