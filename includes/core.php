<?php 
session_start();
require_once('includes/function.php');
if(!logged_in()){
	header("location: index.php");
}else{
require_once('includes/const.php');
require_once('includes/conn.php');
}
?>