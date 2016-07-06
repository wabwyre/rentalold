<div class="portlet-body" style="display: block;">
   <table class="table table-striped table-bordered table-advance table-hover">
      <thead>
         <tr>
            <th><i class="icon-keyboard"></i> ID</th>
            <th class="hidden-phone"><i class="icon-question-sign"></i> Visit Date</th>
            <th>MSP Name</th>
            <th><i class="icon-money"></i> Bill Amount</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         <?php
            $query = "SELECT m.*, a.* FROM msp_visits m 
            left join afyapoa_msps a on a.customer_id = m.msp_id
            WHERE m.customer_id = '".$customer_id."' ORDER BY visit_id DESC LIMIT 10";

            // var_dump($query);exit;
            $result = run_query($query);
            while ($rows = get_row_data($result)) {
               $visit_id = $rows['visit_id'];
               $visit_date = $rows['visit_date'];
               $bill_amount = $rows['bill_amount'];
               $msp_name = $rows['msp_name'];
         ?> 
         <tr>
            <td><?=$visit_id; ?></td>
            <td><?=$visit_date; ?></td>
            <td><?=$msp_name; ?></td>
            <td><?=$bill_amount; ?></td>
            <!-- <td><a class="btn mini green-stripe" href="#">View</a></td> -->
         </tr>
         <? } ?>
      </tbody>
   </table>
</div>