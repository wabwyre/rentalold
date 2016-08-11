<?php
include_once('src/models/Library.php');
/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/8/2016
 * Time: 4:19 PM
 */
class House extends Library
{
    public function getAllHouses($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $rows = $this->selectQuery('houses_and_plots', '*', $condition);
        return array(
            'all' => $rows,
            'specific' => $rows[0]
        );
    }

    public function attachHouseToTenant($tenant_mf_id, $house_id){
        $result = $this->updateQuery(
            'houses',
            "tenant_mf_id = '".sanitizeVariable($tenant_mf_id)."'",
            "house_id = '".sanitizeVariable($house_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function attachPlotToLandlord($landlord_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "landlord_mf_id = '".sanitizeVariable($landlord_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function attachPlotToPmManager($pm_mf_id, $plot_id){
        $result = $this->updateQuery(
            'plots',
            "pm_mf_id = '".sanitizeVariable($pm_mf_id)."'",
            "plot_id = '".sanitizeVariable($plot_id)."'"
        );
        if($result)
            return true;
        else
            return false;
    }

    public function getHouseModelDetails($id){
        $rows = $this->selectQuery('houses', '*'," house_id = '".$id."' ");
        return $rows[0];
    }

    public function getHouseAttributeDetails($id){
        $rows = $this->selectQuery('houses_attributes', '*'," house_id = '".$id."' ");
        return $rows;
    }

    public function listAllAttributes(){
        $rows = $this->selectQuery('attributes', '*');
        return $rows;
    }

    public function checkIfHouseAttributeisAttached($house,$attribute){
        $query = "SELECT * FROM house_attr_allocations 
		WHERE house_id = '".sanitizeVariable($house)."' AND attribute_id = '".sanitizeVariable($attribute)."' 
		";
        $result = run_query($query);
        $num_rows = get_num_rows($result);
        if($num_rows == 1){
            return true;
        }
    }

    public function getAllPlots(){
        $rows = $this->selectQuery('plots', '*');
        return $rows;
    }
    public function getAllAttributes(){
        $rows = $this-> selectQuery('attributes', '*');
        return $rows;
    }

    //function to validate and to call for insert query
    public function addAttrb(){
       
        $validate = array(
            'name'=>array(
                'attribute_name'=> 'Attribute Name',
                'required'=>true)
           
        );
        // var_dump($validate);
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            $name = $_POST['name'];
            if($this-> addAttrbDetails($name)){
                $this->flashMessage('attributes', 'success', 'The attribute has been added.');
            }else{
                $this->flashMessage('attributes', 'error', 'Failed to add attribute! ' . get_last_error());
            }
        }
    }
    // function to insert attribute details

    public function addAttrbDetails($attrib_name){
        $result = $this->insertQuery('attributes',
            array(
                'attribute_name' => $attrib_name
                ));
            return $result;
    }

    public function editAttribute(){
        extract($_POST);
        //update the attribute name
        $edit_id = $_POST['edit_id'];
         $validate = array(
            'name'=>array(
                'attribute_name'=> 'Attribute Name',
                'required'=>true)
           
        );


        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            if($this-> editAttributeDetails($name, $edit_id)){
                $this->flashMessage('attributes', 'success', 'The Attribute has been edited.');
            }else{
                $this->flashMessage('attributes', 'error', 'Failed to edit Attribute! ' . get_last_error());
            }
        }
    }

    public function editAttributeDetails($name, $edit_id){
        $result = $this->updateQuery2('attributes',
            array(
                'attribute_name' => $name
            ),
            array('attribute_id' => $edit_id)
            );
        return $result;
    }

    public function deleteAttribute(){
        extract($_POST);
        $result = $this->deleteQuery('attributes', "attribute_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('attributes', 'success', 'The Attribute has been Deleted.');
        else
            $this->flashMessage('attributes', 'error', 'Encountered an error! '.get_last_error());
    }


    //method to draw data from the database

    public function getHouseData(){
        $rows = $this->selectQuery('houses', '*');
        return $rows;
    }

    
    public function attachHouseAttribute(){
        extract($_POST);
        //var_dump($_POST);die();
        $validate = array(
            'house_id'=>array(
                'name'=> 'House Name ',
                'required'=>true
            ),
            'attribute_id'=>array(
                'name'=> 'Attributes',
                'required'=>true
            ),
            'attribute_value'=>array(
                'name'=> 'Specifications Value',
                'required'=>true
            )
        );
        //var_dump($validate);die();
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //var_dump($this->getValidationStatus());exit;
            //if the validation has passed, run a query to insert the details
            //into the database
            if($this-> addHousattrd($house_id,$attribute_id,$attribute_value )){
                //var_dump($this->addHousattrd());exit();
                $this->flashMessage('house', 'success', 'The House Attribute has been Attached.');
            }else{
                $this->flashMessage('house', 'error', 'Failed to Attach House Attribute! ' . get_last_error());
            }
        }

    }

    public function addHousattrd($house_id,$attribute_id,$attribute_value ){
        $result = $this->insertQuery('house_attr_allocations',
            array(
                'house_id' => $house_id,
                'attribute_id' => $attribute_id,
                'attr_value' => $attribute_value
            )
        );
        return $result;
    }

    public function editHouseAttribute(){
        extract($_POST);
        //var_dump($_POST);exit;
        $validate = array(
            'attribute_value'=>array(
                'name'=> 'Specifications Value',
                'required'=>true
            )
        );

        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()){
            //if the validation has passed, run a query to insert the details
            //into the database
            $result = $this->updateQuery2(
                'house_attr_allocations',
                array('attr_value' => $attribute_value
                ),
                array(
                    'house_attr_id' => $edit_id
                )
            );
            if($result){
                $this->flashMessage('house', 'success', 'House Attribute has been Updated.');
            }else{
                $this->flashMessage('house', 'error', 'Failed to update House Attribute! ' . get_last_error());
            }
        }
    }

    public function detachHouseAttribute($delete_id){
        extract($_POST);
        $result= $this->deleteQuery('house_attr_allocations', "house_attr_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('house', 'success', 'The House Attribute has been Detached.');
        else
            $this->flashMessage('house', 'error', 'Encountered an error! '.get_last_error());
    }
    //method to prepare data to be inserted to the db
    public function addHouse()
    {
        extract($_POST);
        $validate = array(
            'house_number' => array(
                'name' => 'House No',
                'required' => true),
            'plot' => array(
                'name' => 'Plot',
                'required' => true
            )
        );
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()) {
            //if the validation has passed, run a query to insert the details
            //into the database
            if ($this->addHouseDetails($house_number, $plot)) {
                $this->flashMessage('houses', 'success', 'House has been added.');
            } else {
                $this->flashMessage('houses', 'error', 'Failed to add the house! ' . get_last_error());
            }
        }
    }
        //method to insert house details into the db
        public function addHouseDetails($house_number, $plot){
            $result = $this->insertQuery('houses',array(
                'house_number' => $house_number,
                'plot_id' => $plot
            ));
            return $result;
        }

    public function getAllplts(){
        $query = "SELECT * FROM plots";
        $results = run_query($query);
        return $results;

    }
    //function to fetch for edit data
    public function getHouseDataFromId($id){
        if(!empty($id)){
            $data = $this->selectQuery('houses', '*', "house_id = '".$id."'");
            echo json_encode($data[0]);
        }
    }

    //function to delete a house
    public function deleteHouse(){
        extract($_POST);
//        var_dump($_POST);die();
        $result= $this->deleteQuery('houses', "house_id = '".$delete_id."'");
        if($result)
            $this->flashMessage('houses', 'success', 'House deleted.');
        else
            $this->flashMessage('houses', 'error', 'House not deleted! '.get_last_error());

    }


    //method to edit house details
    public function editHouse(){
        extract($_POST);
        //var_dump($_POST);die();
        $validate = array(
            'house_number' => array(
                'name' => 'House No',
                'required' => true),
            'plot' => array(
                'name' => 'Plot',
                'required' => true
            )
        );
        $this->validate($_POST, $validate);
        if ($this->getValidationStatus()) {
            //if the validation has passed, run a query to insert the details
            //into the database
            $result = $this->updateQuery2(
                'houses',
                array(
                    'house_number' => $house_number,
                    'plot_id' => $plot
                ),
                array(
                    'house_id' => $edit_id
                )
            );

            if ($result) {
                $this->flashMessage('houses', 'success', 'House has been added.');
            } else {
                $this->flashMessage('houses', 'error', 'Failed to add the house! ' . get_last_error());
            }
        }
    }

    //function to get the name of the plot given the plot id
    public function getPlotName($p_id){
        $rows= $this->selectQuery('plots', 'plot_name'," plot_id = '".$p_id."' ");

        //$pname = $rows['plot_name'];
       // var_dump($rows);die();
        return $rows[0]['plot_name'];

    }

    //method to get all allocation details of a house
    public function getAllocDetails($id){
        $results = $this->selectQuery('house_attributes','*'," house_id = '".$id."' ");
        return $results;
    }

    public function getAllMyTenants(){
        $data = $this->selectQuery('pm_tenants', '*', "created_by = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllMyLandlords(){
        $data = $this->selectQuery('my_landlords', '*', "created_by = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllPlotsUnderLandlord(){
        $data = $this->selectQuery('landlords_plots', '*', "pm_mfid = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllContractorsUnderPM(){
        $data = $this->selectQuery('pm_contractors', '*', "pm_mfid = '".$_SESSION['mf_id']."'");
        return $data;
    }

    public function getAllMyHouses(){
        $data = $this->selectQuery('my_houses', '*', "landlord_mf_id = '".$_SESSION['mf_id']."'");
        return $data;
    }
    //function to get house allocation details
    public function getDetails($id){
        $results = $this->selectQuery('house_attr_allocations','attr_value'," house_attr_id = '".$id."' ");
        echo json_encode($results[0]);
    }
    //function to get all services attachd to a house
    public function getAllServices($type){
        $results = $this->selectQuery('service_channels','*'," service_option_type ='".$type."'");
        return $results;

    }
    //function to attach services to a house when checkbox is clicked
    public function attachService($service_id, $house_id){
        $return  = array();
        $rows = $this->selectQuery('house_services', 'COUNT(*) AS count',
            "house_id = '".sanitizeVariable($house_id)."' AND service_channel_id = '".sanitizeVariable($service_id)."'");
        $count = $rows[0]['count'];

        if($count > 0){
            $this->setWarning('House is already attached to the selected service!');
        }
        if(count($this->getWarnings()) == 0){
            $this->setPassed(true);
        }
        $valid = $this->getValidationStatus();
        if($valid) {
            $result = $this->insertQuery('house_services', array(
                'service_channel_id' => $service_id,
                'house_id' => $house_id
            ));
            if ($result) {
                $return = array(
                    'success' => true
                );
            } else {
                $return = array(
                    'success' => false
                );
            }
        }else{
            $return = array(
                'success' => false,
                'warnings' => $this->getWarnings()
            );
        }
        return $return;
    }
    //function to detach a house service on uncheck
    public function detachService($s_id,$h_id){
        $query = "delete from house_services where house_id = '$h_id' and service_channel_id = '$s_id'";
        $result = run_query($query);
//        $result =$this->deleteQuery2('house_services',array(
//            'house_service_id' => $s_id,
//            'house_id' => $h_id
//        ));
        if($result){
            $return = array(
                'success' => true
            );
        }else{
            $return = array(
                'success' => false
            );
        }
        return $return;
    }
}
    

