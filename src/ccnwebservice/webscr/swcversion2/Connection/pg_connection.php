<?php 
	$dbcon3 = pg_connect("host=192.168.100.13 port=5432 dbname=menu user=Isaac password=atuta");

	if(!$dbcon3)
	{
		echo "Unable to connect";
	}
	$dbcon = pg_connect("host=192.168.100.13 port=5432 dbname=ebppp user=Isaac password=atuta");

	if(!$dbcon3)
	{
		echo "Unable to connect";
	}
?>