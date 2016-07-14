<?php
require_once 'src/models/plots.php';
$prop = new Plots();

set_title('Add Plot');
/**
 * Set the page layout that will be used
 */
set_layout("dt-layout.php", array(
	'pageSubTitle' => 'Plot Manager',
	'pageSubTitleText' => 'Allows one to manage plots',
	'pageBreadcrumbs' => array (
		array ( 'url'=>'index.php', 'text'=>'Home' ),
		array ( 'text'=>'PLOTS' ),
		array ( 'text'=>'Plot Manager' )
	),
	'pageWidgetTitle' => 'Plot Details'
));
?>
<div class="widget">
	<div class="widget-title"><h4><i class="icon-reorder"></i> Plot Manager</h4>
		<span class="actions">
			<a href="#add_prop" class="btn btn-small btn-primary" data-toggle="modal"><i class="icon-plus"></i> Add</a>
		</span>
	</div>
	<div class="widget-body">
		<?php
			$prop->splash('plots');
			(isset($_SESSION['warnings'])) ? $prop->displayWarnings('warnings') : '';
		?>
		<table id="table1" class="table table-bordered">
			<thead>
				<tr>
					<th>Plot#</th>
					<th>Name</th>
					<th>Units/Houses</th>
					<th>Payment Code</th>
					<th>Property Manager</th>
					<th>LandLord</th>
					<th>Update</th>
					<th>Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$plots = $prop->getAllPlots();
				if(count($plots)){
					foreach ($plots as $plot){
			?>
				<tr>
					<td><?php echo $plot['plot_id']; ?></td>
					<td><?php echo $plot['plot_name']; ?></td>
					<td><?php echo $plot['units']; ?></td>
					<td><?php echo $plot['payment_code']; ?></td>
					<td><?php echo $prop->getFullName($plot['pm_mfid']); ?></td>
					<td><?php echo $prop->getFullName($plot['landlord_mfid']); ?></td>
					<td><a href="#update_prop" class="btn btn-mini btn-warning edit_prop" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
					<td><a href="#del_prop" class="btn btn-mini btn-danger del_prop" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
				</tr>
			<?php }} ?>
			</tbody>
		</table>
		<div class="clearfix"></div>
	</div>
</div>

<!-- The Modals -->
<form action="" method="post">
	<div id="add_prop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Add Plot </h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="plot_name">Name:</label>
				<input type="text" name="name" class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="units">Units/Houses:</label>
				<input type="number" min="1" name="units" class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="payment_code">Payment Code:</label>
				<input type="text" name="payment_code" class="span12"/>
			</div>
			<div class="row-fluid">
				<label for="paybill_number">Paybill Number:</label>
				<input type="text" name="paybill_number" class="span12"/>
			</div>
			<label for="property_manager">Property Manager:</label>
			<div class="row-fluid" style="margin-bottom: 10px;">
				<select name="property_manager" class="span12 live_search">
					<option value="">--Choose PM--</option>
					<?php
						$pms = $prop->getAllMasterfile("b_role = '".Property_Manager."'");
						$pms = $pms['all'];
						if(count($pms)){
							foreach ($pms as $pm){
					?>
					<option value="<?php echo $pm['mf_id']; ?>"><?php echo $pm['full_name']; ?></option>
					<?php }} ?>
				</select>
			</div>

			<label for="landlord">Landlord:</label>
			<div class="row-fluid">
				<select name="landlord" class="span12 live_search">
					<option value="">--Choose Landlord--</option>
					<?php
					$pms = $prop->getAllMasterfile("b_role = '".Landlord."'");
					$pms = $pms['all'];
					if(count($pms)){
						foreach ($pms as $pm){
							?>
							<option value="<?php echo $pm['mf_id']; ?>"><?php echo $pm['full_name']; ?></option>
						<?php }} ?>
				</select>
			</div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="add_property"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Clo649'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav650'); ?>
		</div>
	</div>
</form>
