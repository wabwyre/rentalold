<?php
require_once 'src/models/plots.php';
$prop = new Plots();

if(App::isAjaxRequest()) {
	$prop->getPlotByPlotId($_POST['edit_id']);
}else{
	set_title('Add Plot');
	/**
	 * Set the page layout that will be used
	 */
	set_layout("dt-layout.php", array(
		'pageSubTitle' => 'Plot Manager',
		'pageSubTitleText' => 'Allows one to manage plots',
		'pageBreadcrumbs' => array(
			array('url' => 'index.php', 'text' => 'Home'),
			array('text' => 'PLOTS'),
			array('text' => 'Plot Manager')
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
					<td><a href="#update_prop" class="btn btn-mini btn-warning edit_prop" edit-id="<?php echo $plot['plot_id']; ?>" data-toggle="modal"><i class="icon-edit"></i> Edit</a> </td>
					<td><a href="#del_prop" class="btn btn-mini btn-danger del_prop" edit-id="<?php echo $plot['plot_id']; ?>" data-toggle="modal"><i class="icon-trash"></i> Delete</a></td>
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
				<input type="text" name="plot_name" class="span12" value="<?php echo $prop->get('name'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="units">Units/Houses:</label>
				<input type="number" min="1" name="units" class="span12" value="<?php echo $prop->get('units'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="payment_code">Payment Code:</label>
				<input type="text" name="payment_code" class="span12" value="<?php echo $prop->get('payment_code'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="paybill_number">Paybill Number:</label>
				<input type="text" name="paybill_number" class="span12" value="<?php echo $prop->get('paybill_number'); ?>"/>
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
					<option value="<?php echo $pm['mf_id']; ?>" <?php echo ($pm['mf_id'] == $prop->get('property_manager')) ? 'selected' : ''; ?>><?php echo $pm['full_name']; ?></option>
					<?php }} ?>
				</select>
			</div>

			<label for="landlord">Landlord:</label>
			<div class="row-fluid">
				<select name="landlord" class="span12 live_search">
					<option value="">--Choose Landlord--</option>
					<?php
					$landlord = $prop->getAllMasterfile("b_role = '".Landlord."'");
					$landlord = $landlord['all'];
					if(count($landlord)){
						foreach ($landlord as $landy){
							?>
							<option value="<?php echo $landy['mf_id']; ?>" <?php echo ($landy['mf_id'] == $prop->get('landlord')) ? 'selected' : ''; ?>><?php echo $landy['full_name']; ?></option>
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

<form action="" method="post">
	<div id="update_prop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="myModalLabel1">Update Plot </h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<label for="plot_name">Name:</label>
				<input type="text" name="ed_plot_name" id="plot_name" class="span12" value="<?php echo $prop->get('name'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="units">Units/Houses:</label>
				<input type="number" min="1" name="ed_units" id="units" class="span12" value="<?php echo $prop->get('units'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="payment_code">Payment Code:</label>
				<input type="text" name="payment_code" id="payment_code" class="span12" value="<?php echo $prop->get('payment_code'); ?>"/>
			</div>
			<div class="row-fluid">
				<label for="paybill_number">Paybill Number:</label>
				<input type="text" name="ed_paybill_number" id="paybill_number" class="span12" value="<?php echo $prop->get('paybill_number'); ?>"/>
			</div>
			<label for="property_manager">Property Manager:</label>
			<div class="row-fluid" style="margin-bottom: 10px;">
				<select name="ed_property_manager" id="property_manager" class="span12 live_search">
					<option value="">--Choose PM--</option>
					<?php
					$pms = $prop->getAllMasterfile("b_role = '".Property_Manager."'");
					$pms = $pms['all'];
					if(count($pms)){
						foreach ($pms as $pm){
							?>
							<option value="<?php echo $pm['mf_id']; ?>" <?php echo ($pm['mf_id'] == $prop->get('property_manager')) ? 'selected' : ''; ?>><?php echo $pm['full_name']; ?></option>
						<?php }} ?>
				</select>
			</div>

			<label for="landlord">Landlord:</label>
			<div class="row-fluid">
				<select name="ed_landlord" id="landlord" class="span12 live_search">
					<option value="">--Choose Landlord--</option>
					<?php
					$landlord = $prop->getAllMasterfile("b_role = '".Landlord."'");
					$landlord = $landlord['all'];
					if(count($landlord)){
						foreach ($landlord as $landy){
							?>
							<option value="<?php echo $landy['mf_id']; ?>" <?php echo ($landy['mf_id'] == $prop->get('landlord')) ? 'selected' : ''; ?>><?php echo $landy['full_name']; ?></option>
						<?php }} ?>
				</select>
			</div>
		</div>
		<!-- the hidden fields -->
		<input type="hidden" name="action" value="edit_property"/>
		<input type="hidden" name="edit_id" id="edit_id"/>
		<div class="modal-footer">
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Can651'); ?>
			<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Sav652'); ?>
		</div>
	</div>
</form>

<form action="" method="post">
		<div id="del_prop" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel1">Delete Plot </h3>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete the selected plot?</p>
			</div>
			<!-- the hidden fields -->
			<input type="hidden" name="action" value="delete_property"/>
			<input type="hidden" name="delete_id" id="delete_id"/>
			<div class="modal-footer">
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'No653'); ?>
				<?php createSectionButton($_SESSION['role_id'], $_GET['num'], 'Yes654'); ?>
			</div>
		</div>
	</form>
<?php set_js(array('src/js/plots.js')); } ?>