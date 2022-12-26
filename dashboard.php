<?php 
session_start();
require_once('includes/function.php');
if(!logged_in()){
	header("location: index.php");
}else{
require_once('includes/const.php');
require_once('includes/conn.php');

?>
<!doctype>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
		<title><?php echo DOC_TITLE ?> | Dashboard</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/font-awesome.min.css" />
		<link rel="stylesheet" href="css/smog.css" />
	</head>
	<body>
	<nav class="navbar navbar-inverse" >
		  <div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#"><?php echo DOC_TITLE; ?></a>
		</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			  <ul class="nav navbar-nav pull-right">
				<li ><a href="#" class="disabled"><span class="fa fa-user"></span> <?php 
				$user_fullname_set = get_user_data('fullname',$_SESSION['user_id']); 
				if($user_fullname_set){
				echo $user_fullname_set->fullname;
				}
				?></a></li>
				<li><a href="sign_out.php"><span class="fa fa-sign-out"></span> SIGN OUT</a></li>
			  </ul>
		  </div>
	</nav>
		<section class="container">
		<?php if(user_active($_SESSION['user_id'])){//  if user has carried out any transaction on the system
					// user is active on the system
					$check_transaction = user_active($_SESSION['user_id']);
					if($_SESSION['user_id'] == $check_transaction->payer_id){// if the user is to pay, carryout the action that follow suit
					$user_ph_query = $db->query("SELECT * FROM `transaction` WHERE `payer_id` = {$_SESSION['user_id']} ORDER BY `id` DESC LIMIT 1");// user is in the system but yet to be matched
					if($user_ph_query && $user_ph_query->num_rows == 1){// we are getting the last time the user is to make payment
						$user_ph = $user_ph_query->fetch_object(); // get all data related to the user at that point
						if($user_ph->matched == 0){
							echo 'You will soon be matched';
						}elseif($user_ph->matched == 1){
							if($user_ph->status == 1){
								//header("location: action.php?action=".GH."");
								echo 'You need to get help';
							}elseif($user_ph->status == 0){
								//show the details fo the person you need to make payment too
								$prospective_gh = get_user_data('fullname',$user_ph->payee_id);
								echo 'You need to make payment to '.$prospective_gh->fullname;
							}
						}
					}
					}elseif($_SESSION['user_id'] == $check_transaction->payee_id){// if the user is to receive payment, carrout the action that follows suit
					$user_gh_query = $db->query("SELECT * FROM `transaction` WHERE `payee_id`={$_SESSION['user_id']} AND `status` = 0 LIMIT 2");
					if($user_gh_query && $user_gh_query->num_rows>0){
						while($user_gh = $user_gh_query->fetch_object()){
								if($user_gh->matched==0){
									echo 'Not matched <br />';
								}elseif($user_gh->matched==1){
									echo 'Matched with sos sos so and so. Check details here... <br />';
								}
						}
					}else{
						echo 'All the current GH transaction has completed';
					}
					}
					
			}else{// user has not carried out any transaction on the system
			echo 'You need to first PH into this system before you begin to GH <br/>
			click the button below to <a href="includes/action.php?action='.PH.'">Provide help</a>';
			// display error message to refer them
			}
			?>
		</section>		
		<script src="js/jquery.js" ></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/smog.js"></script>
	</body>
</html>
<?php } ?>