<?php
    include_once('src/models/Masterfile.php');
    $mf = new Masterfile();

    set_layout("dt-layout.php", array(
        'pageSubTitle' => 'Masterfile',
        'pageSubTitleText' => '',
        'pageBreadcrumbs' => array (
            array ( 'url'=>'index.php', 'text'=>'Home' ),
            array ( 'text'=>'MASTETRFILE' ),
            array ( 'text'=>'All Masterfile' )
        )

    ));
?>
<div class="widget">
    <div class="widget-title"><h4><i class="icon-reorder"></i> All Masterfile</h4></div>
    <div class="widget-body form">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
            <tr>
                <th>MF#</th>
                <th>Start Date</th>
                <th>Surname</th>
                <th>First Name</th>
                <th>Customer Type</th>
                <th>Email</th>
                <th>B. Role</th>
                <th>Edit</th>
                <th>Profile</th>
            </tr>
            </thead>
            <tbody>
                <?php
                    $rows = $mf->getAllMasterfile();
                    $rows = $rows['all'];

                    if(count($rows)){
                        foreach ($rows as $row){
                            $mf_id = $row['mf_id'];
                            $regdate_stamp = $row['regdate_stamp'];
                            $surname = $row['surname'];
                            $firstname = $row['firstname'];
                            $customer_type_name = $row['customer_type_name'];
                            $email = $row['email'];
                            $b_role = $row['b_role'];
                            // echo $company_name;
                    ?>
                    <tr>
                        <td><?=$mf_id; ?></td>
                        <td><?=$regdate_stamp; ?></td>
                        <td><?=$surname; ?></td>
                        <td><?=$firstname; ?></td>
                        <td><?=$customer_type_name; ?></td>
                        <td><?=$email; ?></td>
                        <td><?=$b_role; ?></td>
                        <td><a id="edit_link" href="index.php?num=721&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-edit"></i> Edit</a></td>
                        <td><a id="profile" href="index.php?num=724&mf_id=<?=$mf_id; ?>" class="btn btn-mini"><i class="icon-user"></i> Profile</a></td>
                    </tr>
                <?php }}	?>
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>

<? set_js(array('src/js/tabs.js')); ?>
