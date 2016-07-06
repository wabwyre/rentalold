<?php

function gettotalrows($counting_field, $database, $table, $conditions)
{
	$query = "select count(".$counting_field.") as total from ".$database.".".$table." ".$conditions." ";	
	$result = run_query($query);	
	$rows = get_row_data($result);	
	return $rows['total'];
}

function getdata($database, $table, $conditions, $extras)
{
	$query = "select * from ".$database.".".$table." ".$conditions." ".$extras." ";
	$result = run_query($query);
	return $result;
}

function getsum_of_rowcontent($sum_field, $database, $table, $conditions)
{
	$query = "select sum(".$sum_field.") as sum from ".$database.".".$table." ".$conditions." ";	
	$result = run_query($query);	
	$rows = get_row_data($result);	
	return $rows['sum'];
}

