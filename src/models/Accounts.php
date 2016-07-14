<?php

/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 3:01 PM
 */
include_once ('src/models/Library.php');

class Accounts extends Library{
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
            $this->addBankAccountDetails();
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

    public function addBankAccountDetails($bank_name, $created_at, $status){
        $data = $this->insertQuery('banks',
            array(
                'bank_name' => $bank_name,
                'created_at' => $created_at,
                'status' => $status
            ),
            'bank_id'
        );
        return $data['bank_id'];
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
}