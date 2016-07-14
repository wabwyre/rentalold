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
}