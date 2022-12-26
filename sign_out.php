<?php 
	session_start();
	require_once('includes/function.php');// include all the functions in this page
	if(logged_in()){ // a user needs to be logged in before they can log out
		unset($_SESSION['user_id']);// unset the session
		session_destroy();// destroy all available sessions
		header("location:index.php?sign_out");// redirect to the homepage
	}elseif(!logged_in()){// a user is not loggeed and they try to logout
		header("location:index.php?signed_out");// redirect to homepage and tell them they have already logged out
	}else{// if the user is neither logged in or not logout but just trying to access the page
		header("location:index.php");// redirect them to the homepage
	}
?>