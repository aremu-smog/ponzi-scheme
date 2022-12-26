<?php 
	$empty_fields = array(); // array to hold fields that are empty or not set
	$fields = array("fullname","sex","bank","account_name","account_no","mail","phone","pass","pass_again");// array to hold all the fields
	foreach ($fields as $field){// begin selection of fields
		if(isset($_POST[$field])){// if the field was filled and an value was not passed
			$$field = $db->real_escape_string(trim($_POST[$field]));//create a variable with the fields name;
			if(empty($$field)){
				$empty_fields[] = $field;
				$error_message = "FATAL ERROR! The following fields are either empty or not set: ";
			}else{
				$error_message = "";
			}
		}else{
			$error_message = "FATAL ERROR! The following fields are either empty or not set: ";
			$empty_fields[] = $field;// add the empty or field that was not filled to empty fields array
		}
	}// end of loop
	$no_of_empty_fields = count($empty_fields);
	$i = 1;
	if(!empty($empty_fields)){// check if any of the fields are empty or not set
				foreach($empty_fields as $empty_field){// get the fields that are empty that are not
					$error_message .= " <b>{$empty_field}</b>";// add to error message and display the fields
					if($i < $no_of_empty_fields){// if the number of loop is not equal to the number of fields
						$error_message .= ", ";// add a comma to the end of the erro message
					}
					$i++;
				}
		}else{
				//$error_message = "Isokay";
				//$error_message = "We can now proceed with further verification";
				if(check_mail_format($mail) && !field_length($fullname,7,255) && !field_length($account_no,10,10) && !field_length($phone,11,11) && passwords_checked($pass,$pass_again)){
					$error_message = "Further checks can now take place";
					$user_exists_set = "SELECT `id` FROM `user` WHERE `account_no`='{$account_no}' OR `mail`='{$mail}' OR `phone` = '{$phone}'" ;
					$user_exists = $db->query($user_exists_set);
					if($user_exists && $user_exists->num_rows>0){
						$error_message = "Either your account number, mail or phone number have already been used on this website, kindly check and retry";
					}else{
						$new_user_set = "INSERT INTO  `user`(`fullname`,`sex`,`bank`,`account_name`,`account_no`,`mail`,`phone`,`password`) 
										VALUES ('{$fullname}','{$sex}','{$bank}','{$account_name}','{$account_no}','{$mail}','{$phone}','{$pass}')";
						$new_user = $db->query($new_user_set);
						if($new_user){
							$error_message = "Dear ".$fullname." welcome to wealth, click  <a href=\"#sign_in\" data-toggle=\"modal\" >here</a> to login and PH for the first time in order to start GH";
							foreach ($fields as $the_field){
								empty_field($the_field);
							}
						}else{
							$error_message = "Something went wrong while trying to sign you up, kindly try again";
						}
					}
				}else{
						$error_message = "FATAL ERROR! Kindly rectify the following error(s) ";
						if(!check_mail_format($mail)){$error_message .= "<br /> Your email must be of the form: example@domain.com";}
						if(field_length($fullname,'7','255')){$error_message .= '<br />Your fullname cannot be less 7 characters or greater than 255 ';	}
						if(field_length($account_no,'10','10')){$error_message .= ' <br />Your account number cannot be less than or greater than 10';	}
						if(field_length($phone,'11','11')){$error_message .= ' <br />Your phone number cannot be greater or less than 11 characters';}
						if(!passwords_checked($pass,$pass_again)){$error_message .="<br /> Password Mismatch, kindly check and retry";}
					}
			}
?>