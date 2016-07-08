<?php
	include_once('src/models/Broadcast.php');
	$broadcast = new Broadcast;

	set_title('Send Broadcast');
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Broadcasts',
		'pageSubTitleText' => '',
		'pageBreadcrumbs' => array (
			array ( 'url'=>'index.php', 'text'=>'Home' ),
			array ( 'text'=>'Broadcast' ),
			array ( 'text'=>'Send a Broadcast' )
		)
		
	));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-rss"></i> Broadcast</h4>
		<span class="actions">
			<a href="#add_types" data-toggle="modal" class="btn btn-small btn-primary"><i class="icon-plus"></i> Add</a>
			<!-- <a href="#edit_types" class="btn btn-small btn-success" id="edit_type_btn"><i class="icon-edit"></i> Edit</a> -->
			<!-- <a href="#delete_types" class="btn btn-small btn-danger" id="del_type_btn"><i class="icon-remove icon-white"></i> Delete</a> -->
		</span>
	</div>
	</br>
	<div class="widget-body form">
		<?php
			if(isset($_SESSION['broadcast'])){
				echo $_SESSION['broadcast'];
				unset($_SESSION['broadcast']);
			}
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>ID#</th>
					<th>From</th>
					<th>Subject</th>
					<th>Body</th>
					<th>To</th>
					<th>Type</th>
					<th>Created</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$result = $broadcast->getAllBroadcasts();
					while ($rows = get_row_data($result)) {
				?>
				<tr>
					<td><?=$rows['message_id']; ?></td>
					<td><?=$broadcast->getUser($rows['sender']); ?></td>
					<td><?=$rows['subject']; ?></td>
					<td><?=$rows['body']; ?></td>
					<td title="<?=$broadcast->getCustomerNames($rows['recipients'], $rows['message_type_id']); ?>"><span><?=substr($broadcast->getCustomerNames($rows['recipients'], $rows['message_type_id']),0,100); ?></span></td>
					<td><?=$broadcast->getMessageTypeName($rows['message_type_id']); ?></td>
					<td><?=$rows['created']; ?></td>
					<td><?=($rows['status'] == 0) ? 'Pending': 'Sent'; ?></td>
				</tr>
				<? } ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_types" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1"><i class="icon-rss"></i> Broadcast</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<?php
					$result = $broadcast->getMessageTypes();
					while($rows = get_row_data($result)){
				?>
	            <label class="checkbox" style="display: inline;">
                    <input type="radio" name="broad_cast_type" <?=($rows['message_type_code'] == 'INBOX') ? 'checked': ''; ?> value="<?=$rows['message_type_id']; ?>" required/> <?=$rows['message_type_name']; ?>
                </label>
                <?php } ?>
	        </div>
	        <br/>
	        <div class="row-fluid">
	        	<label for="send_to" class="control-label">Send to</label>
	        	<select name="send_to" class="span12" required id="send_to">
	        		<option value="">--Choose--</option>
	        		<option value="All">All Customers</option>
	        		<option value="Specific">Specific Customers</option>
	        		<option value="client_groups">Client Groups</option>
	        	</select>
	        </div>
	        <div class="row-fluid" style="margin-bottom: 10px; display: none;" id="specific">
	        	Recipients
		        <select id="select2_sample2" name="recipients[]" class="span12 specific_customers" multiple>
		            <?php 
		            	$result = $broadcast->getAllCustomerAccounts();
		            	//var_dump(get_row_data($result));exit;
		            	while($rows = get_row_data($result)){
		            ?>
		                <option value="<?=$rows['customer_account_id']; ?>"><?=$rows['customer_name']; ?> - Issued <?=$rows['issued_phone_number']; ?></option>
		            <?php } ?>
		        </select>
	        </div>
	        <div class="row-fluid" style="margin-bottom: 10px; display: none;" id="client_group">
	        	Client Groups
		        <select name="client_groups[]" id="select2_sample3" class="span12 client_groups" multiple>
		            <?php 
		            	$result = $broadcast->getAllClientGroups();
		            	//var_dump(get_row_data($result));exit;
		            	while($rows = get_row_data($result)){
		            ?>
		                <option value="<?=$rows['mf_id']; ?>"><?=$rows['surname']; ?></option>
		            <?php } ?>
		        </select>
	        </div>
	        <div class="row-fluid">
	        	<label for="subject">Subject</label>
	        	<input type="text" name="subject" class="span12" required/>
	        </div>
	        <div class="row-fluid" style="margin-bottom:10px;">
	        	<label for="message_type" class="control-label">Message Type:</label>
	        	<select name="message_type" class="span12" required id="message_type">
	        		<option value="">--Choose--</option>
	        		<option value="custom">Custom Message</option>
	        		<option value="predefined">Predefined Message</option>
	        	</select>
	        </div>
	        <div class="row-fluid" style="display: none;" id="custom_message">
	        	<label for="body" class="control-label">Message</label>
	        	<textarea name="body" class="span12"></textarea>
	        </div>
	        <div class="row-fluid" style="display: none;" id="predefined_message">
	        	<select name="pre_message" class="span12 live_search">
	        		<option value="">--Select a Message--</option>
		        	<?php
		        		$query = "SELECT * FROM predefined_message";
		        		$result = run_query($query);
		        		while ($rows = get_row_data($result)) {
		        	?>
		        	<option value="<?=$rows['predefined_message']; ?>"><?=$rows['predefined_message']; ?></option>
		        	<?php } ?>
		        </select>
	        </div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_broadcast"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can579'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sen582'); ?>
		</div>
	</div>
</form>
<? set_js(array('src/js/manage_broadcast.js')); ?>