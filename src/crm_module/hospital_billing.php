<table id="table1" style="width: 100%" class="table table-bordered">
	<thead>
    <tr>
        <th>ID</th>
        <th>Visit Date</th>
        <th>Msp Name</th>
        <th>Mcare Bill#</th>
        <th>Bill Amount</th>
        <th>Kashpoa#</th>
        <th>Bill Id</th>
        <th>Status</th>
    </tr>
  	</thead>
  	<tbody>
     <?php
        $query = "SELECT m.*, a.*,n.status FROM msp_visits m 
            left join afyapoa_msps a on a.customer_id = m.msp_id
            Left join ndovu_requests n on n.customer_id = m.customer_id
            WHERE m.customer_id = '".$customer_id."' ORDER BY visit_id DESC LIMIT 10";
         //var_dump($query);exit;
        $result = run_query($query);
        while ($rows = get_row_data($result)) {
           $visit_id = $rows['visit_id'];
           $visit_date = $rows['visit_date'];
           $bill_amount = $rows['bill_amount'];
           $msp_name = $rows['msp_name'];
           $mcare_ref = $rows['mcare_ref'];
           $kashpoa_id = $rows['kashpoa_request_id'];
           $bill_id = $rows['kashpoa_bill_id'];
           $status = $rows['status'];
           if($status == '0'){
            $status = 'Pending';
            }elseif($status == '1'){
              $status = 'Complete';
            }elseif($status == '2'){
              $status = 'Queued';
            }else{
              $status = 'Failed';
            }
          
     ?> 
     <tr>
        <td><?=$visit_id; ?></td>
        <td><?=$visit_date; ?></td>
        <td><?=$msp_name; ?></td>
        <td><?=$mcare_ref; ?></td>
        <td><?=$bill_amount; ?></td>
        <td><?=$kashpoa_id; ?></td>
        <td><?=$bill_id; ?></td>
        <td><?=$status; ?></td>
     </tr>
     <? } ?>
  	</tbody>
</table>