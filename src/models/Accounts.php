<?php

/**
 * Created by PhpStorm.
 * User: JOEL
 * Date: 7/14/2016
 * Time: 3:01 PM
 */
include_once ('src/models/Masterfile.php');

class Accounts extends Masterfile{
    
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

    public function addBank($post){
        //var_dump($_POST); exit;
        $result = $this->insertQuery(
            'banks',
            array(
                'bank_name' => $bank_name,
                'created_at' => $created_at,
                'status' => $status
            )
            //'bank_id'
        );
        var_dump($result);exit;
        $data=run_query($result);
        if ($data) {
            $this->flashMessage('acc', 'success', 'Bank information added successfully..');
        }else{
            $this->flashMessage('acc', 'error', 'Failed to add bank details! ' . get_last_error());
        }
        //return ['mf_id'];
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

    public function addBranch($post){
        $this->validate($post, array(
            'branch_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique' => 'bank_branch'
            ),
            'branch_code' => array(
                'required' => true,
                'unique' => 'bank_branch'
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->insertQuery('bank_branch',
                array(
                    'branch_name' => $post['branch_name'],
                    'branch_code' => $post['branch_code'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                )
            );
            if($result){
                $this->flashMessage('acc', 'success', 'A new branch has been added!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function editBranch($post){
//        var_dump($post);exit;
        $this->validate($post, array(
            'branch_name' => array(
                'name' => 'Name',
                'required' => true,
                'unique2' => array(
                    'table' => 'bank_branch',
                    'skip_column' => 'branch_id',
                    'skip_value' => $post['edit_id'],
                )
            ),
            'branch_code' => array(
                'name' => 'Branch Code',
                'required' => true,
                'unique2' => array(
                    'table' => 'bank_branch',
                    'skip_column' => 'branch_id',
                    'skip_value' => $post['edit_id']
                )
            )
        ));

        if($this->getValidationStatus()) {
            $result = $this->updateQuery2('bank_branch',
                array(
                    'branch_name' => $post['branch_name'],
                    'branch_code' => $post['branch_code'],
                    'created_at' => $post['created_at'],
                    'status' => $post['status']
                ),
                array(
                    'branch_id' => $post['edit_id']
                )
            );

            if($result){
                $this->flashMessage('acc', 'success', 'Branch has been updated!');
            }else{
                $this->flashMessage('acc', 'error', 'Encountered an error!');
            }
        }
    }

    public function deleteBranch($id){
        if($this->deleteQuery2('plots', array(
            'branch_id' => $id
        ))){
            $this->flashMessage('acc', 'success', 'Branch has been deleted');
        }else{
            $this->flashMessage('acc', 'warning', 'The Branch is being used somewhere else in the system!');
        }
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

    public function getBranchByBranchId($id){
        $data = $this->selectQuery('branch_name', '*', "branch_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function getBankByBankId($id){
        $data = $this->selectQuery('bank_name', '*', "bank_id = '".sanitizeVariable($id)."' ");
        echo json_encode($data[0]);
    }

    public function getBankBranchesByBankId($id){
        $data = $this->selectQuery('bank_branch', '*', "bank_id = '".$id."'");
        echo json_encode($data);
    }
}