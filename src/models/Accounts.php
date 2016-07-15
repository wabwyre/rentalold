<?php

/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 3:01 PM
 */
include_once ('src/models/Masterfile.php');

class Accounts extends Masterfile{
    public function getAllBankDetails($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('account_details', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

    public function addBankAccount(){
        extract($_POST);
            $check = array(
                // bank details
                'bank_name' => array(
                    'name' => 'Bank Name',
                    'required' => true,
                    'unique' => 'banks'
                )
            );
        $this->validate($_POST, $check);
        if($this->getValidationStatus()) {
            $this->beginTranc();
            $this->addBank();
        }
        if(!empty($bank_id)){
            if($this->addBranch($branch_name, $branch_code)){
                $this->endTranc();
               $this->flashMessage('acc', 'success', 'Branch was succesfully added!');
            }
        }else{
            $this->flashMessage('acc', 'error', 'Failed to branch! '.get_last_error());
        }
    }

    public function addBank($bank_name, $created_at, $status){
//        var_dump($result); exit;
        $result = $this->insertQuery(
            'banks',
            array(
                'bank_name' => $bank_name,
                'created_at' => $created_at,
                'status' => $status
            ),
            'bank_id'
        );
        $data=run_query($result);
        if ($data) {
            $this->flashMessage('acc', 'success', 'Bank information added successfully..');
        }else{
            $this->flashMessage('acc', 'error', 'Failed to add bank details! ' . get_last_error());
        }
        return ['mf_id'];
    }

    public function editBank(){
        if($_POST['action'] == "edit_Bank")
        {
            $bank_name=$_POST['bank_name'];
            $created_at=$_POST['created_at'];
            $status=$_POST['status'];

            //update the banks
            $query="UPDATE ".DATABASE.".banks SET 
                bank_name='$bank_name', 
                created_at='$created_at', 
                status='$status' 
                WHERE bank_id = '$bank_id'";

            $data=run_query($query);
            if ($data) {
                $this->flashMessage('acc', 'success', 'You updated the bank information successfully..');
            }else{
                $this->flashMessage('acc', 'error', 'Failed to update bank details! ' . get_last_error());
            }
        }
    }
    
    public function addBranch($branch_data = array()){
        extract($_POST);

        // validate
        $this->validate($branch_data, array(
            'branch_name' => array(
                'name' => 'Branch Name',
                'required' => true,
                'unique' => 'bank_branch'
            )
        ));
        $data = $this->insertQuery('bank_branch',
            array(
                'branch_name' => $branch_name,
                'branch_code' => $branch_code
            )
        );
        return $data;
    }

    public function getAllBank($condition = null){
        extract($_POST);
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('banks', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }

    public function getAllBranch($condition = null){
        $condition = (!is_null($condition)) ? $condition : '';
        $data = $this->selectQuery('bank_and_branches', '*', $condition);
        return array(
            'all' => $data,
            'specific' => $data[0]
        );
    }
}