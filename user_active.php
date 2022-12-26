<?php $current_transaction_set = $db->query("SELECT *	FROM `transaction` 	WHERE
															(`payer_id`={$_SESSION['user_id']} OR
															 `payee_id`={$_SESSION['user_id']})
															 ORDER BY `id` DESC LIMIT 1");// query to ensure that user is on the website but yet to be matched
				if($current_transaction_set && $current_transaction_set->num_rows>0){// if query was successful
					$current_transaction = $current_transaction_set->fetch_object();// get all relevant data
					if($current_transaction->payer_id == $_SESSION["user_id"]){// if the user is the payer (i.e to provide help) and is not matched
						if($current_transaction->matched==1){
							if($current_transaction->status==1){
								/**========================== You are now ready to get helped ***/
								echo 'Redirect to get help';
							}elseif($current_transaction->status == 0){
							echo 'You have being paired to make payments to '.$current_transaction->payee_id.' And time is not on your side';
							}
						}elseif($current_transaction->matched==0){
							echo 'Kindly check back, you will be matched';
						}
					}elseif($current_transaction->payee_id == $_SESSION["user_id"]){// if user is the payee(i.e to get help)
						if($current_transaction->matched==1){
							if($current_transaction->status == 1){
								/**** ============================== You are now ready to RE-PH **************/
							}elseif($current_transaction->status==0){
								/***======================================== You have being matched to get helped**/
							}
						}
						}
				}else{
					/*** ------------------ SEEING THIS PAGE IS A FATAL ERROR ----------------------------------------------**/
					echo 'Nothing dey';
				}
?>