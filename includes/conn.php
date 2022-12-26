<?php 
$db = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
if($db->connect_errno){
	die("There was an error while trying to connect to hour database");
}
?>