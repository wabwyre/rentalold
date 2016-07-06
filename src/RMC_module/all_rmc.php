<?php
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Revenue Channel Records',
	'pageSubTitleText' => '',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'Revenue Management' ),
		array ( 'text'=>'All Revenue Channel Records' )
	)
	
));

?>
<div class="widget">
        <div class="widget-title">
            <h4><i class="icon-reorder"></i>REVENUE CHANNELS</h4>
            <span class="actions">
                  <a href="index.php?num=621" class="btn btn-primary btn-small">NEW REVENUE CHANNEL</a>
              </span>
        </div>
    <div class="widget-body">
        <table id="table1" style="width: 100%" class="table table-bordered">
            <thead>
                      <tr>
                      <th>Revenue Channel ID</th>
                      <th>Revenue Channel Name</th>
                      <th>Revenue Channel Code</th>
                      <th>EDIT</th>    
            </tr>
            </thead>
            <tbody>
                <?php
                    $distinctQuery = "SELECT * FROM revenue_channel Order by revenue_channel_id DESC "; 
                    $resultId = run_query($distinctQuery);	

                        $con = 1;
                        $total = 0;
                        while($row = get_row_data($resultId))
                        {
                            $revenue_channel_name=$row['revenue_channel_name'];
                            $revenue_channel_id=$row['revenue_channel_id'];
                            $revenue_channel_code = $row['revenue_channel_code'];

                            //var_dump($row);exit;		
                ?>
                    <tr>
                        <td><?=$revenue_channel_id; ?></td>
                        <td><?=$revenue_channel_name; ?></td>
                        <td><?=$revenue_channel_code; ?></td>	
                        <td><a id="edit_link" class="btn btn-mini" href="index.php?num=622&edit_id=<?=$revenue_channel_id; ?>">
                        <i class="icon-edit"></i> Edit</a></td>
                    </tr>
                <?php } ?>  
            </tbody>
        </table>
        <div class="clearfix"></div>
    </div>
</div>