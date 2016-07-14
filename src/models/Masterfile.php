<?php
	include_once('src/models/House.php');
	
	class Masterfile extends House{
        private $_destination = 'crm_images/';

		public function addMf(){
			if(!empty($_POST['b_role'])) {
                $this->validate($_POST, array(
                    // personal details
                    'surname' => array(
                        'name' => 'Surname',
                        'required' => true
                    ),
                    'firstname' => array(
                        'name' => 'First Name',
                        'required' => true
                    ),
                    'id_passport' => array(
                        'name' => 'National Id/Passport',
                        'required' => true,
                        'unique' => 'masterfile'
                    ),
                    'gender' => array(
                        'name' => 'Gender',
                        'required' => true
                    ),
                    'email' => array(
                        'name' => 'Email Address',
                        'required' => true,
                        'unique' => 'masterfile'
                    ),
                    'regdate_stamp' => array(
                        'name' => 'Start Date',
                        'required' => true
                    ),

                    // address details
                    'county' => array(
                        'name' => 'County',
                        'required' => true
                    ),
                    'town' => array(
                        'name' => 'Town',
                        'required' => true
                    ),
                    'phone_number' => array(
                        'name' => 'Phone Number',
                        'required' => true
                    ),
                    'postal_address' => array(
                        'name' => 'Postal Address',
                        'required' => true
                    ),
                    'postal_code' => array(
                        'name' => 'Postal Code',
                        'required' => true
                    ),
                    'address_type_id' => array(
                        'name' => 'Address Type',
                        'required' => true
                    ),
                    'customer_type_id' => array(
                        'name' => 'Masterfile Type',
                        'required' => true
                    ),
                ));
                if($this->getValidationStatus()) {
                    switch ($_POST['b_role']) {
                        case Tenant:
                            $this->addTenant($_POST);
                            break;

                        case Landlord:
                            $this->addLandlord($_POST);
                            break;

                        case Contractor:
                            $this->addContractor($_POST);
                            break;

                        case Property_Manager:
                            $this->addPM($_POST);
                            break;
                    }
                }
			}else{
				$this->flashMessage('mf','warning','You must select a business role!');
			}
		}

        public function addTenant($tenant_data = array()){
            extract($_POST);
            // validate

            $this->validate($tenant_data, array(
                'house' => array(
                    'name' => 'House',
                    'required' => true
                )
            ));
            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    if($this->attachHouseToTenant($mf_id, $house)){
                        if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                            if($this->createLoginAccount($tenant_data, $mf_id)) {
                                $this->endTranc();
                                $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                            }
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                        }
                    }else{
                        $this->flashMessage('mf', 'error', 'Failed to attach tenant to selected house! '.get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
        }

        public function addContractor($contractor_data){
            extract($_POST);
            // validate
            //var_dump($contractor_data); exit;
            $this->validate($contractor_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                        if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_address)) {
                            if($this->createLoginAccount($contractor_data, $mf_id)) {
                                $this->endTranc();
                                $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                            }
                        }else {
                            $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                        }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
        }

        public function addLandlord($landlord_data = array()){
            extract($_POST);
            //var_dump($landlord_data);exit;
            // validate
            $this->validate($landlord_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                ),
                'plot' => array(
                    'name' => 'Plot',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    if($this->attachPlotToLandlord($mf_id, $plot)){
                        if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                            if($this->createLoginAccount($landlord_data, $mf_id)) {
                                $this->endTranc();
                                $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                            }else{
                                $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                            }
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                        }
                    }else{
                        $this->flashMessage('mf', 'error', 'Failed to attach land lord to selected plot! '.get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
            App::redirectTo('?num=722');
        }

        public function addPM($pm_data){
            extract($_POST);
//            var_dump($pm_data);exit;
            // validate
            $this->validate($pm_data, array(
                'user_role' => array(
                    'name' => 'System User Role',
                    'required' => true
                )
            ));

            if($this->getValidationStatus()){
                $uniq_id = uniqid();
                $destination = $this->_destination.$uniq_id.$_FILES['profile-pic']['name'];
                $image_path = '';
                if(!empty($_FILES['profile-pic']['name'])) {
                    $image_path = $this->uploadImage($_FILES['profile-pic']['tmp_name'], $destination);
                }else{
                    $image_path = '';
                }

                $this->beginTranc();

                $mf_id = $this->addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email);
                if(!empty($mf_id)){
                    if($this->addAddress($phone_number, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code)) {
                        
                        if($this->createLoginAccount($pm_data, $mf_id)) {
                            $this->endTranc();
                            $this->flashMessage('mf', 'success', 'Masterfile has been added.');
                        }else{
                            $this->flashMessage('mf', 'error', 'Failed to create login account! ' . get_last_error());
                        }
                    }else {
                        $this->flashMessage('mf', 'error', 'Failed to create address! ' . get_last_error());
                    }
                }else{
                    $this->flashMessage('mf', 'error', 'Failed to add Personal Details! '.get_last_error());
                }
            }
        }

        public function addPersonalDetails($surname, $firstname, $middlename, $id_passport, $gender, $image_path, $regdate_stamp, $b_role, $customer_type_id, $email){
            $data = $this->insertQuery('masterfile',
                array(
                    'surname' => $surname,
                    'firstname' => $firstname,
                    'middlename' => $middlename,
                    'id_passport' => $id_passport,
                    'gender' => $gender,
                    'images_path' => $image_path,
                    'regdate_stamp' => $regdate_stamp,
                    'b_role' => $b_role,
                    'dob' => 'NULL',
                    'time_stamp' => time(),
                    'customer_type_id' => $customer_type_id,
                    'email' => $email,
                    'company_name' => 'NULL'
                ),
                'mf_id'
            );

            return $data['mf_id'];
        }

        public function addAddress($phone, $postal_address, $town, $mf_id, $address_type_id, $ward, $street, $building, $county, $postal_code){
            $result = $this->insertQuery('address',
                array(
                    'phone' => $phone,
                    'postal_address' => $postal_address,
                    'town' => $town,
                    'mf_id' => $mf_id,
                    'address_type_id' => $address_type_id,
                    'ward' => $ward,
                    'street' => $street,
                    'building' => $building,
                    'county' => $county,
                    'postal_code' => $postal_code
                )
            );

            return $result;
        }

        public function createLoginAccount($post, $mf_id){
            $email = $post['email'];
            $full_name = $post['surname'].' '.$post['firstname'];

            $pass_data = $this->generatePassword();
            $result = $this->insertQuery('user_login2',
                array(
                    'username' => $email,
                    'password' => $pass_data['pass_hash'],
                    'user_active' => '1',
                    'user_role' => $post['user_role'],
                    'mf_id' => $mf_id,
                    'email' => $email
                )
            );
            if($result) {
                $subject = "Welcome! Login Credentials";
                $body = "Dear $full_name\n";
                $body .= "Thank you for registering! Your login credentials are as follows;\n\n";
                $body .= "Username: $email\n";
                $body .= "Password: ".$pass_data['plain_pass'];
                return ($this->sendEmail($email, $subject, $body)) ? true : false;
            }
        }

        private static function generatePassword(){
            $password = rand(100000, 999999);
            return array(
                'plain_pass' => $password,
                'pass_hash' => sha1($password)
            );
        }
		
		public static function findMasterFileByRoleName($role_name)
		{
			$query = "SELECT * FROM masterfile mf INNER JOIN user_login2 ul ON "
					."mf.mf_Id = ul.mf_id INNER JOIN user_roles ur ON "
					."ul.user_role = ur.role_id WHERE ur.role_status is true "
					."AND mf.active is TRUE AND ur.role_name = '$role_name'";			
			$result = run_query($query);
			return $result;
		}

		public function getCustomerAddresses($mf_id){
			$query = "SELECT a.*, at.address_type_name, cr.county_name FROM address a
			LEFT JOIN address_types at ON at.address_type_id = a.address_type_id 
			LEFT JOIN county_ref cr ON cr.county_ref_id = a.county
			WHERE mf_id = '".sanitizeVariable($mf_id)."'
			 ORDER BY at.address_type_name";
			return run_query($query);
		}

		public function checkForExistingRevenueChannelName($revenue_name, $mf_id){
			$query = "SELECT * FROM revenue_channel WHERE revenue_channel_name = '".$revenue_name."' AND mf_id = '".$mf_id."'";
			$result = run_query($query);
			$num_row = get_num_rows($result);
			if($num_row == 1){
				return true;
			}else{
				return false;
			}
		}

		public function addAddressType(){
			extract($_POST);
		   if(!checkForExistingEntry('address_types', 'address_type_name', $address_type_name)){
	            $distinctQuery = "INSERT INTO address_types(address_type_name, status) 
	                    VALUES('".$address_type_name."','".$status."')";
	            $result = run_query($distinctQuery);

	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not added.
	                                </div>'; 
	                $_SESSION['done-add'] = $errormessage;
	              }else{
	              $_SESSION['done-add'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry added successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Address Type Name('.$address_type_name.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-add'] = $errormessage;
	        }
		}

		public function editAddress(){
			extract($_POST);
			if(!onEditcheckForExistingEntry('address', 'postal_address', $postal_address, 'address_id', $edit_id)){
				$query = "UPDATE address SET 
						phone = '".sanitizeVariable($phone_no)."',
						postal_address = '".sanitizeVariable($postal_address)."',
						town = '".sanitizeVariable($town)."',
						ward = '".sanitizeVariable($ward)."',
						address_type_id = '".sanitizeVariable($address_type_id)."',
						street = '".sanitizeVariable($street)."',
						building = '".sanitizeVariable($building)."',
						county = '".sanitizeVariable($county)."'
                    WHERE address_id = '".$_POST['edit_id']."' ";

	            $result = run_query($query);
	            // var_dump($query); exits;
	            if (!$result) {
	                $errormessage = '<div class="alert alert-error">
	                                    <button class="close" data-dismiss="alert">×</button>
	                                    <strong>Error!</strong> Entry not updated.
	                                </div>'; 
	                $_SESSION['done-deal'] = $errormessage;
	              }else{
	              $_SESSION['done-deal'] = '<div class="alert alert-success">
	                        <button class="close" data-dismiss="alert">×</button>
	                        <strong>Success!</strong> Entry updated successfully.
	                    </div>';
	                }
	        } 
	          else{
	             $errormessage = '<div class="alert alert-warning">
	                                     <button class="close" data-dismiss="alert">×</button>
	                                     <strong>Warning!</strong> The Postal Address ('.$postal_address.') already exists. Try another!
	                                 </div>'; 
	                 $_SESSION['done-deal'] = $errormessage;
	        }
		}

		public function deleteAddress(){
			$query = "DELETE FROM address WHERE address_id = '".$_POST['delete_id']."'";
			$result = run_query($query);
			if($result){
				$_SESSION['done-deal'] = '<div class="alert alert-success">
						<button class="close" data-dismiss="alert">&times;</button>
						<strong>Success!</strong> The Address has been removed.
					</div>';
			}
		}

        public function getAllMasterfile($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('all_masterfile', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data[0]
            );
        }

        public function getAllDelMasterfile($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('deleted_masterfile', '*', $condition);
            return array(
                'all' => $data,
                'specific' => $data[0]
            );
        }

        public function editMf($post){
            $this->validate($_POST, array(
                // personal details
                'surname' => array(
                    'name' => 'Surname',
                    'required' => true
                ),
                'firstname' => array(
                    'name' => 'First Name',
                    'required' => true
                ),
                'id_passport' => array(
                    'name' => 'National Id/Passport',
                    'required' => true,
                    'unique2' => array(
                        'table' => 'masterfile',
                        'skip_column' => 'mf_id',
                        'skip_value' => $post['mf_id']
                    )
                ),
                'gender' => array(
                    'name' => 'Gender',
                    'required' => true
                ),
                'regdate_stamp' => array(
                    'name' => 'Start Date',
                    'required' => true
                ),
                'customer_type_id' => array(
                    'name' => 'Masterfile Type',
                    'required' => true
                ),
            ));
            // upload the image if there is any
            $uniq_id = uniqid();
            $filename = $_FILES['images_path']['name'];
            $destination = $this->_destination.$uniq_id.$filename;
            $image_path = '';

            if($filename != '') {
                $image_path = $this->uploadImage($_FILES['images_path']['tmp_name'], $destination);
            }

            $result = $this->updateQuery(
                'masterfile',
                "surname = '" . sanitizeVariable($post['surname']) . "',
                firstname = '" . sanitizeVariable($post['firstname']) . "',
                middlename = '" . sanitizeVariable($post['middlename']) . "',
                id_passport = '" . sanitizeVariable($post['id_passport']) . "',
                gender = '" . sanitizeVariable($post['gender']) . "',
                images_path = '" . sanitizeVariable($image_path) . "',
                regdate_stamp = '" . sanitizeVariable($post['regdate_stamp']) . "',
                b_role = '" . sanitizeVariable($post['b_role']) . "'
                ",
                "mf_id = '".$post['mf_id']."'"
            );
            if ($result) {
                $this->flashMessage('mf', 'success', 'Masterfile has been updated!');
            }else {
                $this->flashMessage('mf', 'error', 'Encountered an error while updating the masterfile!');
            }
        }


        public function getAllUserRoles($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('user_roles', '*', $condition);
            return $data;
        }

        public function getAllMasterfileType($condition = null){
            $condition = (!is_null($condition)) ? $condition : '';
            $data = $this->selectQuery('customer_types', '*', $condition);
            return $data;
        }


        public function blockUser($mf_id){
            $query = "UPDATE user_login2 SET user_active = '0', status = '0' WHERE mf_id = '".$mf_id."'";
            if(run_query($query)){
                return true;
            }else{
                return false;
            }
        }

        public function deleteMasterfile(){
            if(!empty($_POST['delete_id'])){
                $query = "DELETE FROM masterfile WHERE mf_id = '".$_POST['delete_id']."'";
                if(run_query($query)){
                    $_SESSION['done-deal'] = '<div class="alert alert-success">
                        <button class="close" data-dismiss="alert">×</button>
                        <strong>Success!</strong> Masterfile has been permanently deleted!.
                    </div>';
                }else{
                    var_dump(get_last_error());exit;
                }
            }
        }

        public function getFullName($mf_id){
            if(!empty($mf_id))
                $data = $this->selectQuery('masterfile', 'surname, firstname, middlename', "mf_id = '".sanitizeVariable($mf_id)."'");
            else
                $data = '';
            return $data;
        }
    }


