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
		var_dump($_POST);die();

		$query = "INSERT INTO quotes ";
	}
}