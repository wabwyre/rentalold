<?php
$attendant=$_GET['attendant'];
//delete the attendant
$delete_attendant="DELETE FROM ".DATABASE.".market_attendant WHERE attendant_id=$attendant";
$del_attendant=run_query($delete_attendant);

?>