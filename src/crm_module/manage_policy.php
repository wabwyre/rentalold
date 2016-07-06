<?
   if(isset($_SESSION['manage_policy'])){
      echo $_SESSION['manage_policy'];
      unset($_SESSION['manage_policy']);
   }
?>
<div class="accordion" id="accordion1">
   <div class="accordion-group">
      <div class="accordion-heading">
         <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_1">
         <i class="icon-chevron-left"></i>
         Send SMS
         </a>
      </div>
      <div id="collapse_1" class="accordion-body collapse in">
         <div class="accordion-inner">
            <form action="" method="post">
               <div class="row-fluid">
                  <div class="span12">
                     <textarea name="sms" rows="3" cols="6" class="span12" style="text-align: left;">Welcome to Afyapoa, <?=$customer_name; ?>, Your Policy Number is <?=$policy_no; ?> and is valid from <?=$start_date; ?> to <?=$expiry_date; ?>.</textarea>
                     <input type="hidden" name="target" value="<?=$phone; ?>"/>
                     <input type="hidden" name="action" value="resend_sms"/>
                  </div>
               </div>
               <div class="form-actions">
                  <? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav444'); ?>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="accordion-group">
      <div class="accordion-heading">
         <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse_2">
         <i class="icon-chevron-left"></i> Send Policy Data to MCARE</a>
      </div>
      <div id="collapse_2" class="accordion-body collapse">
         <div class="accordion-inner">
            <form action="" method="post">
               <div class="row-fluid">
                  <h4>Policy Holder Details</h4>
                  <div class="span5">
                     <ul class="unstyled span10">
                        <li><span>Customer ID#:</span> <b style="color:#000;"><?=$customer_id; ?></b></li>
                        <li><span>Policy No:</span> <b style="color:#000;"><?=$policy_no; ?></b></li>
                        <li><span>Surname Name:</span><b style="color:#000;"><?=$surname; ?></b></li>
                        <li><span>First Name:</span> <b style="color:#000;"><?=$firstname; ?></b></li>
                        <li><span>Last Name:</span> <b style="color:#000;"><?=$middle_name; ?></b></li>
                        <li><span>D.o.B:</span> <b style="color:#000;"><?=$dob; ?></b></li>
                        <li><span>Phone :</span> <b style="color:#000;"><?=$phone; ?></b></li>
                        <li><span>Email:</span> <b style="color:#000;"><?=$username; ?></b></li>
                        <li><span>National ID#:</span> <b style="color:#000;"><?=$national_id_number; ?></b><li>
                        <li><span>Agent#:</span> <b style="color:#000;"><?=$agent_no; ?></b><li>
                     </ul>
                     <input type="hidden" name="customer_id" value="<?=$customer_id; ?>"/>
                     <input type="hidden" name="target"/>

                     <input type="hidden" name="action" value="send_to_mcare"/>
                  </div>

               </div>
               <h4>Dependant Details</h4>
                  <table id="table1" style="width: 100%" class="table table-bordered">
   <thead>
     <tr>
        <th>DEP_ID#</th>
        <th>Policy_ID#</th>
        <th>Names</th>
        <th>DoB</th>
        <th>Mcare#</th>
        <th>Gender</th>
        <th>Status</th>
     </tr>
   </thead>
   <tbody>  
 <?php
      $distinctQuery = "SELECT * "
           . "FROM afyapoa_dependants "
           . "WHERE afyapoa_id = $policy_no "
           . "Order by dependant_id DESC ";
           // var_dump($distinctQuery);exit;
      $resultId = run_query($distinctQuery);
      while($row = get_row_data($resultId)){
         $dependant_id=$row['dependant_id'];
           $afyapoa_id = $row['afyapoa_id'];
         $names=$row['dependant_names'];
         $mcare_id = $row['mcare_id'];
         $gender = $row['dependant_gender'];
         $status = $row['status'];
         if($status == 1){
            $choice = 'Active';
         }else{
            $choice = 'Inactive';
         }
         $dob = $row['dependant_dob'];
 ?>
      <tr>
         <td><?=$dependant_id; ?></td>
         <td><?=$afyapoa_id; ?></td>
         <td><?=$names; ?></td>
         <td><?=$dob; ?></td>
         <td><?=$mcare_id; ?> </td>
         <td><?=$gender; ?></td> 
         <td><?=$choice; ?></td>
      </tr>
   <?php } ?>
  </tbody>
</table>
               <div class="form-actions">
                  <? createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sen445'); ?>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>