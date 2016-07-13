
<div class="span2"><img src="<?=$profile_pic; ?>" alt="" /> <!-- <a target="_blank" href="?num=802&mf_id=<?=$mf_id; ?>" class="profile-edit">edit</a> --></div>
<?php
    /**
     * Created by PhpStorm.
     * User: JOEL
     * Date: 7/13/2016
     * Time: 11:50 AM
     */
?>
<ul class="unstyled span10">
    <li><span>Full Name: </span><?=$row['surname'].' '.$row['firstname'].' '.$row['middlename']; ?></li>
    <li><span>Masterfile Type: </span><?=$row['customer_type_name']; ?></li>
    <li><span>Gender: </span><?=$row['gender']; ?></li>
    <li><span>Start Date: </span><?=(date('Y-m-d', $row['time_stamp'])); ?></li>
    <li><span>Business Role: </span><?=$row['b_role']; ?></li>
    <li><span>Email address: </span><?=$row['email']; ?></li>
    <li><span>ID No/Passport: </span><?=$row['id_passport']; ?></li>
    <li><span>Phone No: </span><?=$phone; ?></li>
    <li><span>House No.: </span><?=$house; ?></li>
<!--    <li><span>Plot: </span>--><?//=$house; ?><!--</li>   -->
</ul>
