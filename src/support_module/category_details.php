<?php
include '../connection/config.php';


$query = "SELECT * FROM category WHERE category_id = '".$_POST['edit_id']."'";
$result = pg_query($query);
$rows = pg_fetch_assoc($result);
echo json_encode($rows);
?>