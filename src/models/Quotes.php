<?php
include_once('src/models/Library.php');

class Quotes extends Library
{
	public function allQuotations(){
		$query = "SELECT * FROM quotes ";

		$results = run_query($query);
		return $results;
	}
	public function getAllMaintainance(){
		$query = "SELECT * FROM maintaince_vouchers ";
		$results = run_query($query);
		return $results;

	}

	//function to add quatation to the database

	public function addQuataion(){
		extract($_POST);
		//var_dump($_POST);die();
		$validate = array(
			'bid_amount'=>array(
				'name'=> 'Bid Amount',
				'required'=>true
				
			),
			'maintainance'=>array(
				'name'=> 'Maintainance',
				'required'=>true
			)
		);
		// var_dump($validate);
		$this->validate($_POST, $validate);
		if ($this->getValidationStatus()){
			//if the validation has passed, run a query to insert the details
			//into the database
			if($this-> addQuataionDetails($bid_amount, $maintainance)){
				$this->flashMessage('quotes', 'success', 'The Quotation has been added.');
			}else{
				$this->flashMessage('quotes', 'error', 'Failed to add quotation! ' . get_last_error());
			}
		}
	}

	public function addQuataionDetails($bid_amount, $maintainance){
		$contractor = $_SESSION['mf_id'];
		$bid_status = '1';
		$job_status = '1';

		$result = $this->insertQuery('quotes',
			array(
				'bid_amount' => $bid_amount,
				'maintainance_id' => $maintainance,
				'contractor_mf_id' => $contractor,
				'bid_status' => $bid_status,
				'job_status' => $job_status
			)
		);

		return $result;
	
	}

	public function getQuoteDataFromQuoteId($id){
		if(!empty($id)){
			$data = $this->selectQuery('quotes', '*', "qoute_id = '".$id."'");
			echo json_encode($data[0]);
		}
	}
}