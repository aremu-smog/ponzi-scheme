<?php 
session_start();
if(isset($_POST['user_pass']) && isset($_POST['user_mail'])){
	require_once('function.php');
	require_once('const.php');
	require_once('conn.php');
	$user_password = $db->real_escape_string(trim($_POST['user_pass']));
	$user_email = $db->real_escape_string(trim($_POST['user_mail']));
	if(empty($user_password) || empty($user_email)){
			echo 'No field can be empty, kindly fill the following field(s) : ';
		if(empty($user_email)){
			echo '<b>Email</b>';
		}elseif(empty($user_password)){
			echo '<b>Password</b>';
		}
		echo ' and try again';
	}else{
		if(!check_mail_format($user_email)){
			echo 'Wrong mail format! Your mail must be of the form: <b>example@domain.com</b>';
		}else {
			$user_exists = $db->query("SELECT `id`,`password`,`blocked`,`category` FROM  `user` WHERE `mail` = '{$user_email}' LIMIT 1");
			if($user_exists && $user_exists->num_rows == 1){
				$user = $user_exists->fetch_object();
				if($user_password == $user->password){
						if($user->blocked == 1){// user has been blocked from the website 
							echo 'Dear user, you have being blocked from this webiste due to your inability to comply to set rules and regulations';
						}elseif($user->blocked == 0){// user is yet to be blocked
						$_SESSION['user_id'] = $user->id;
						echo $user->category;// admin which can be admin or normal user
						}
					}else{
						echo 'Password mismatch, kindly try again';
				}
			}else{
				echo 'EMAIL FOUND! Your mail must be registered on this website before you can use this website';
			}
		}
	}
}else{
	header("location: index.php");
}
?>