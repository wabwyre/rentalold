<?php
include '../connection/config.php';


$query = "SELECT * FROM address WHERE address_id = '".$_POST['edit_id']."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);
?>