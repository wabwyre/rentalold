<div class="span2"><img src="<?=$profile_pic; ?>" alt="" /> <!-- <a target="_blank" href="?num=802&mf_id=<?=$mf_id; ?>" class="profile-edit">edit</a> --></div>
<?php
	$company = $masterfile->getCompanyName($row['company_name']);
?>
<ul class="unstyled span10">
   <li><span>Full Name: </span><?=$row['surname'].' '.$row['firstname'].' '.$row['middlename']; ?></li>
   <li><span>Masterfile Type: </span><?=$row['customer_type_name']; ?></li>
   <li><span>Gender: </span><?=$row['gender']; ?></li>
   <li><span>Start Date: </span><?=(date('Y-m-d', $row['time_stamp'])); ?></li>
   <li><span>Business Role: </span><?=$row['b_role']; ?></li>
   <li><span>Email address: </span><?=$row['email']; ?></li>
   <li><span>ID No/Passport/Buss No: </span><?=$row['id_passport']; ?></li>
   <li><span>Company Name: </span><?=$company; ?></li>
   <li><span>Phone No: </span><?=$phone; ?></li>
   <?php
   		if($row['b_role'] == 'client'){
   ?>
   <li><span>Gpay Balance: </span><?=$masterfile->getGpayBalance($_GET['mf_id']); ?></li>
   <li><span>Credit Score: </span><?=$masterfile->getCreditScoreValueByScoreCount($masterfile->getCreditScoreCountFromMfid($_GET['mf_id'])); ?></li>
   <?php } ?>
</ul>
