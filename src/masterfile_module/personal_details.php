<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="b_role" class="control-label">Business Role<span>*</span></label>
            <div class="controls">
              <select name="b_role" class="span12" id="b_role">
                  <option value="">--Choose Business Role--</option>
                  <option value="client" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'client') echo 'selected'; ?>>Client</option>
                  <option value="tenant" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'tenant') echo 'selected'; ?>>Tenant</option>
                  <option value="agent" <?php if(isset($_POST['b_role']) && $_POST['b_role'] == 'agent') echo 'selected'; ?>>Agent</option>
              </select>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="surname" class="control-label" id="variation">Surname</label>
            <div class="controls  input-icon">
                <input type="text" name="surname" class="span12" value="<?=(isset($_POST['surname'])) ? $_POST['surname'] : ''; ?>" id="surname"/>
            </div>				
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="regdate_stamp" class="control-label">Start Date<span>*</span></label>
            <div class="controls">
                <input type="text" class="date-picker span12" name="regdate_stamp" value="<?php
                if(isset($_POST['regdate_stamp'])){
                        echo $_POST['regdate_stamp'];
                }else{
                        echo date('m/d/Y');
                }
                ?>" />
            </div>
        </div>
    </div>
</div>
	
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="firstname" class="control-label">First Name</label>
            <div class="controls">
                    <input type="text" name="firstname" class="span12" id="firstname" value="<?=(isset($_POST['firstname'])) ? $_POST['firstname'] : ''; ?>" placeholder="First Name"/>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="id_pass" id="id_pass">ID # or Passport<span>*</span></label>
            <div class="controls">
                    <input type="text" name="national_id_number" value="<?=(isset($_POST['national_id_number'])) ? $_POST['national_id_number'] : ''; ?>" class="span12" />
            </div>
        </div>
    </div>			
</div>
		
<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="middlename" class="control-label">Middle Name</label>
            <div class="controls">
                    <input type="text" name="middlename" class="span12" id="middlename" value="<?=(isset($_POST['middlename'])) ? $_POST['middlename'] : ''; ?>" placeholder="Middle Name" />
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="gender" class="control-label">Gender</label>
            <div class="controls">
                <select name="gender" class="span12" id="gender">
                    <option value="">--Choose Gender--</option>
                    <option value="Male" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
        </div>
    </div>	
</div>

<div class="row-fluid">
    <div class="span6">
        <div class="control-group">
            <label for="email" class="control-label">Email/Username <span>*</span></label>
            <div class="controls">
                    <input type="email" name="email" class="span12" value="<?=(isset($_POST['email'])) ? $_POST['email'] : ''; ?>" placeholder="email" />
            </div>
        </div>        
    </div>
    <div class="span6">
        <div class="control-group">
            <label class="control-label" for="company_name">Company Name</label>
            <div class="controls">
                <select name="company_name" id="company_name" class="span12">
                    <option value="">--Choose Company Name--</option>
                    <?php
                        $query = "SELECT * FROM masterfile  
                        where b_role = 'agent'";
                        $result = run_query($query);
                        while ($rows = get_row_data($result)) {
                    ?>
                    <option value="<?=$rows['mf_id']; ?>" <?php if(isset($_POST['company_name']) && $rows['mf_id'] == $_POST['company_name']) { echo 'selected'; } ?>><?=$rows['surname']; ?></option>
                    <?php } ?>
                </select> 
            </div>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">
	<label for="user_role" class="control-label">User Role</label>
        <div class="controls">
            <select name="user_role" id="user_role" class="span12">
                <option value="">--Choose User Role--</option>
                <?php
                    $query = "SELECT ucr.*, ur.role_name FROM user_created_roles ucr 
                    LEFT JOIN user_roles ur ON ur.role_id = ucr.role_id
                    where ucr.mf_id = '".$_SESSION['mf_id']."'";
                    $result = run_query($query);
                    while ($rows = get_row_data($result)) {
                ?>
                <option value="<?=$rows['role_id']; ?>" <?php if(isset($_POST['user_role']) && $rows['role_id'] == $_POST['user_role']) { echo 'selected'; } ?>><?=$rows['role_name']; ?></option>
                <?php } ?>
            </select> 
        </div>      
    </div>
    <div class="span6">
        <div class="control-group">
            <label for="customer_type_id" class="control-label">Masterfile Type</label>
            <div class="controls">
                <select class="span12" name="customer_type_id" id="customer_type_id">
                    <option value="">--Choose Customer Type--</option>
                    <?php
                        $query = run_query("SELECT * FROM customer_types ORDER BY customer_type_name");

                        if ( $query !== false )
                        {
                            while ( $fetch = get_row_data($query) )
                            {
                    ?>
                    <option value="<?=$fetch['customer_type_id']; ?>" <?=(isset($_POST['customer_type_id']) && $fetch['customer_type_id'] == $_POST['customer_type_id']) ? 'selected': ''; ?>><?=$fetch['customer_type_name']; ?></option>
                    <?php
                            }
                        }
                    ?>
                </select>
            </div>
        </div>
    </div>    
</div>

<div class="row-fluid">
    <div class="span6">
        <label class="control-label">Profile Pic</label>
        <div class="controls">
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;"><img src="assets/img/profile/photo.jpg" /></div>
                <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 100px; max-height: 100px; line-height: 20px;"></div>
                <div>
                    <span class="btn btn-file"><span class="fileupload-new">Select image</span><span class="fileupload-exists">Change</span><input class="span12" type="file" name="profile-pic"/></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div> 
        </div>
    </div> 		                                                               
</div>
