<?php 
if(isset($_GET['action'])){// ready to carry any action
session_start();// start the session
require_once('const.php');// import the constants file
require_once('conn.php');// import the connection file
require_once('function.php');// import the functions file
$action = $_GET['action'];// set the action
if($action == PH){
	//echo 'Time to PH';
	$ph_exists_query = $db->query("SELECT * FROM `transaction` WHERE
									`payer_id`={$_SESSION['user_id']} AND `status`=0 
									ORDER BY `id` DESC LIMIT 1 ");//check query for user in table but not matched
	if($ph_exists_query && $ph_exists_query->num_rows>0){// user is already in the table but has not been matched
	//echo 'Your transaction is not yet complete';
	header("location: ../dashboard.php");
	}else{
		if(carry_out_action('payer_id',$_SESSION['user_id'])){
			echo 'Successful match';
		}else{
			echo 'match unsuccessful';
			}
	};// try to match user;
	}
elseif($action == GH){
	//time to gh
	/*==============================================================================================
	Do loop two times
	Check if any ph is available
	IF ANY PH is available, update the GH under the prospective PH
	if any PH is not available, create a new row for PH;
	================================================================================================================
	*/
	/*$gh_exists_query = $db->query("SELECT * FROM `transaction` WHERE `payee_id`={$_SESSION['user_id']} WHERE `status`=0 ORDER BY `id` DESC LIMIT 1");
	if($gh_exists_query && $gh_exists_query->num_rows>0){
		return false;
	}else{*/
	for($i=1;$i<=2;$i++){
		carry_out_action('payee_id',$_SESSION['user_id']);
	}
	//}
}elseif($action == 'confirm'){
	/**======================== Go in here and confirm  payment****/
}else{
	// 'command not recognized';
	header('location: ../dashboard.php');
	}
	}
else{// if not ready to carryout any action
	header("location: ../dashboard.php");// go back to home page
}

?>