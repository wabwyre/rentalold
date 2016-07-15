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

    public function getAllPlots(){
        $rows = $this->selectQuery('plots', '*');
        return $rows;
    }
    public function getAllAttributes(){
        $rows = $this-> selectQuery('attributes', '*');
        return $rows;
    }

    //functin to validate and to call for insert query
    public function addAttrb(){
       
        $validate = array(
            'name'=>array(
                'name'=> 'Attribute Name',
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
                'name' => $attrib_name
                ));
            return $result;
    }

    public function editAttribute(){
        extract($_POST);
        //update the attribute name
        $edit_id = $_POST['edit_id'];
         $validate = array(
            'name'=>array(
                'name'=> 'Attribute Name',
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
                'name' => $name
            ),
            array('attribute_id' => $edit_id)
            );
        return $result;
    }

    public function deleteAttribute(){
        extract($_POST);
        $this->deleteQuery();
    }
}