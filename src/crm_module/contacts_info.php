<!--begin form-->
<form action="" enctype="multipart/form-data" class="form-horizontal">   
    <div class="row-fluid">
	    <div class="span6">
		    <div class="control-group">
			    <label  class="control-label">PREMIUM: </label>
			    <div class="controls">
				    <b><?=$total_premium; ?></b>
			    </div>
		    </div>
	    </div>
	    <div class="span6">
		<div class="control-group">
			<label  class="control-label">DEPOSIT:</label>
			<div class="controls">
				<b><?=$amount_paid; ?></b>
			</div>
			</div>
		</div>
    </div>
    
    <div class="row-fluid">
	    <div class="span6">
		    <div class="control-group">
			    <label  class="control-label">LOAN: </label>
			    <div class="controls">
				    <b><?=$loan_amount; ?></b>
			    </div>
		    </div>
	    </div>
	    <div class="span6">
		<div class="control-group">
			<label  class="control-label">DEPENDANTS:</label>
			<div class="controls">
				<b><?=$total_deps; ?></b>
			</div>
			</div>
		</div>
    </div>
    
    
    <div class="row-fluid">
	    <div class="span6">
		    <div class="control-group">
			    <label  class="control-label">PHONE: </label>
			    <div class="controls">
				    <b><?=$phone; ?></b>
			    </div>
		    </div>
	    </div>
	    <div class="span6">
		<div class="control-group">
			<label  class="control-label">ADDRESS:</label>
			<div class="controls">
				<b><?=$address_name; ?></b>
			</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<div class="control-group">
				<label  class="control-label">EMAIL: </label>
				<div class="controls">
			        <b><?=$email; ?></b>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<label class="control-label">ID NO./PASSPORT:</label>
				<div class="controls">
					<b><?=$national_id_number; ?></b>
				</div>
			</div>
		</div>
	</div>
	
</form>
<!-- END FORM -->