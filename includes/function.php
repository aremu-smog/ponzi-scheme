<?php
	function empty_field($name){
		if(isset($$name)){
			$$name = '';
		}else{
			return false;
		}
	}
	function check_mail_format($mail){//check if the normal mail format: example@domain.com
		if(@ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $mail)){//if the mail format is of the form: example@domain.com
			return true;// return true
		}else{//if mail format is not of the format: example@gmail.com
			return false;// return false
		}
	}
	function field_length($field,$min_value,$max_value){// check if the lenght of the field is not less/more than the required minimum/maximu respectively
		$length = strlen($field); // length of the field
		if(($length < $min_value) || ($length > $max_value) ){// if the lenght of the field is less/more than the required minimum/maximum 
			return true;// return true
		}else{// if the length of the field is not lesser/more than the required minimum/maximu values
			return false;// return false
		}
	}
	function passwords_checked($main,$other){// check if two passwords matched
		if($main == $other){// if the main password equals the other password
			return true;// return true
		}else{// if the main password does not equal the other password
			return false;// return false
		}
	}
	
	function logged_in(){// check if the user is already logged in to the website
		if(isset($_SESSION["user_id"]) && !empty($_SESSION['user_id'])){// check there is a session for the user already
			return true;// return true
		}else{// else 
			return false;//////////////////return true
		}
	}
	
	function user_active($id){
		global $db;
		$query = $db->query("SELECT `id`,`payee_id`,`payer_id` FROM `transaction` WHERE `payer_id` = {$id} OR `payee_id`={$id}");
		if($query && $query->num_rows > 0){
			$result = $query->fetch_object();
			return $result;
		}else{
			return false;
		}
	}
	
	function get_user_data($data,$id){
		global $db;
		$query = $db->query("SELECT `{$data}` FROM `user` WHERE `id` ={$id}  LIMIT 1");// the user is still active on the website
		if($query &&  $query->num_rows==1){
			$result = $query->fetch_object();
			return $result;
		}else{
			return false;
		}
	}
	
	function carry_out_action($parameter,$id){
		global $db;
		if($parameter=='payer_id'){
			$other_parameter = 'payee_id';
		}elseif($parameter =='payee_id'){
			$other_parameter = 'payer_id';
		}
		$action_query = $db->query("SELECT * FROM `transaction` WHERE `{$other_parameter}`!=0 AND `matched`=0 LIMIT 1");// get all the users ready for the other action
		if($action_query && $action_query->num_rows>0){// if there are  users is ready for payment
		$action = $action_query->fetch_object();// get the user's property
		$do_query = "UPDATE `transaction` SET `{$parameter}` = {$id}, `matched` = 1 WHERE `{$other_parameter}`={$action->$other_parameter} ";// update assign the PHP to that user
		}else{
		$do_query = "INSERT INTO `transaction`(`{$parameter}`) VALUES ({$id})";/// create a new row to that is available for GH;
		}
		$do_action = $db->query($do_query); // carryout the query;
		if($do_action){
			return true;
		}else{
			return false;
		}
	}
?>