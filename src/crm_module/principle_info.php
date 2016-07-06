<?php
   $prof_pic = 'crm_images/ID_'.$customer_id.'.jpg';
   if(file_exists($prof_pic)){
      $src2 = $prof_pic;
   }else{
      $src2 = 'crm_images/photo.jpg';
   }
?>
<div class="span2"><img src="<?=$src2; ?>" alt="" title="ID"/></div>
<ul class="unstyled span10">
   <li><span>Surname Name:</span> <?=$surname; ?></li>
   <li><span>First Name:</span> <?=$firstname; ?></li>
   <li><span>Last Name:</span> <?=$middle_name; ?></li>
   <li><span>Customer Type:</span> <?=$customer_type_name; ?></li>
   <li><span>Status:</span> <?=$status; ?></li>
   <li><span>Registration Date:</span> <?=$regdate_stamp; ?></li>
   <li><span>Start Date:</span> <?=date('d-M-Y', strtotime($start_date)); ?></li>
   <li><span>B.Role :</span> <?=$phone; ?></li>
   <li><span>Email:</span> <?=$username; ?></li>
   <li><span>National ID#:</span> <?=$national_id_number; ?>
   <!-- end of new data -->
</ul>