<?php
session_start();
include("includes/function.php");
if(logged_in()){
	header("location: dashboard.php");
}else{
require_once("includes/const.php"); 
if(isset($_POST["sign_up"]) || isset($_POST["sign_in"])){
	require_once('includes/conn.php');
	if(isset($_POST["sign_up"])){
		include("includes/sign_up.php");
	}else if(isset($_POST["sign_in"])){
		include("includes/sign_in.php");
	}
}
?>

<!doctype html>
<!--
/*======================================== SEEING THIS ONLY MEANS YOU KNOW A BIT OF HOW THE WEB WORKS
											WELL LET'S SKIP THE CHIT-CHAT
											THIS WEBSITE WAS CODED BY: AREMU OLUWAGBAMILA (SMOG): CEO and Founder of SMOGTECHn
											and this website is a ponzi scheme website
											
-->
<html lang="en">
	<head>
		<title><?php echo DOC_TITLE;?></title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/smog.css" />
		<link rel="stylesheet" href="css/font-awesome.min.css" />
	</head>
	<body>
	<!--/*===================================================== NAVIGATION BAR/HEADER ===================================================== */	-->
		<nav class="navbar navbar-inverse">
			<a  class="navbar-brand logo"><?php echo strtoupper(DOC_TITLE); ?></a>
			<!-- /* ============================================ SIGN IN FORM =============================================================== */ -->
				<a href="#sign_in" data-toggle="modal" class="navbar-btn btn btn-primary pull-right">SIGN IN</a>
		</nav>
		<section class="modal fade" id="sign_in">
			<section class="modal-dialog">
				<section class="modal-content">
					<section class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal"> &times; </button>
					 <?php echo '<h3>'.DOC_TITLE." SIGN IN FORM</h3>"; ?>
					</section>
					<section class="modal-body">
						<p class="text-danger" id="login_message">Message goes here</p>
						<form action="#" method="post">
							<div class="form-group">
								<label for="user_mail">E-mail</label>
								<input type="text" name="user_mail" id="user_mail" required placeholder="Kindly enter your registered email address here" class="form-control" />
							</div>
							<div class="form-group">
								<label for="user_pass">Password</label>
								<input type="password" name="user_pass" id="user_pass" required  placeholder="Enter your password here" class="form-control" />
							</div>
							<div class="form-group">
								<a href="javascript:void(0);" onclick="sign_in();" class="btn btn-primary">SIGN IN</a>
							</div>
						</form>
					</section>
					<section class="modal-footer">
						Having trouble signing in? Click <a href="#">here</a>
					</section>
				</section>
			</section>
		</section>
		</div>
		<section class="container"><!-- SIGN UP FORM AND ADDITIONAL INFO -->
		<?php if(isset($_GET["sign_out"])){
			?>
				<div class="alert alert-success"> You have successfully signed out!</div>
			<?php
		}elseif(isset($_GET['signed_out'])){
			?>
			<div class="alert alert-warning">You have already signed out, don't try anything funny. Abeg</div>
			<?php
		} ?>
			<section class="col-md-6"><!-- ADDITONAL INFO -->
				<h2 class="page-header">How it Works</H2>
				<p>Provide help with an amount of 20,00naira and get help from two persons in the system</p>
			</section>
			<section class="col-md-6"><!-- SIGN UP -->
				<h2 class="page-header">Sign Up Now</h2>
				<?php 
					if(isset($error_message)){
						?>
						<section class="alert alert-success"><?php echo $error_message; ?></section>
						<?php
					}else{
				?>
				<section class="alert alert-danger">
					<p>Kindly note that the details on this form once filled cannot be changed</p>
				</section>
					<?php } ?>
				<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
					<div class="form-group">
						<label for="fullname">Fullname</label><!-- Users Fullname -->
						<input type="text" minlength="7"  maxlength="255"
							value="<?php if(isset($fullname)){echo $fullname;}?>"
						name="fullname" required class="form-control" id="fullname" placeholder="Enter your fullname here..."/>
						<span id="message_fullname">Message</span>
					</div>
					<div class="form-group">
						<label for="sex">Sex</label><!-- Users sex -->
						<select class="form-control" name="sex" id="sex" required>
							<option value="">Kindly choose a your sex</option>
							<option <?php if(isset($sex) && $sex=="M"){echo "selected";} ?> value="M">Male</option>
							<option <?php if(isset($sex) && $sex=="F"){echo "selected";} ?> value="F">Female</option>
						</select>
					</div>
					<div class="form-group">
						<label for="bank">BANK</label><!-- Users Bank -->
						<select class="form-control" name="bank" id="bank" required>
							<option value="">Kindly choose your Bank</option>
							<?php 
							/* Array of Banks is below */
								$banks = array("Access Bank","Diamond Bank","Equitorial TrustBank","Fidelity Bank","First Bank","FCMB","GTBank","Intercontinental Bank","StanbiIBTC Bank","Standard Chartered Bank","Sterling Bank","UBA","Unity Bank","Wema Bank","Zenith International Bank");
								/* Foreach loop to get each as an option */
								foreach($banks as $the_bank){
									?>
									<option <?php if(isset($bank) && $bank==$the_bank){echo "selected";} ?>><?php echo $the_bank; ?></option>
									<?php } //---------------- end of foreach banks as the bank *//?>
						</select>
					</div>
					<div class="form-group">
						<label for="account_name">Account Name</label><!-- Users Fullname -->
						<input type="text" minlength="7"  maxlength="255"
							value="<?php if(isset($account_name)){echo $account_name;} // accountn = AcountName?>"
						name="account_name" required class="form-control" id="account_name" placeholder="Enter your fullname here..."/>
						 <span id="message_accountn"></span>
					</div>
					<div class="form-group">
						<label for="account">Account Number</label><!-- User's Account Number -->
						<input type="text"  maxlength="10" minlength="10" 
							value="<?php if(isset($account_no)){echo $account_no;}?>"
						name="account_no" required class="form-control" id="account_no" placeholder="Enter your account number here..."/>
						 <span id="message_account_no"></span>
					</div>
					<div class="form-group">
						<label for="mail">E-mail</label><!-- User's Email -->
						<input type="mail" value="<?php if(isset($mail)){echo $mail;}?>" maxlength="255"name="mail" required class="form-control" id="mail" placeholder="Enter your e-mail here..."/>
						 <span id="message_mail"></span>
					</div>
					<div class="form-group"><!-- User's Phone number -->
						<label for="phone">Phone number</label>
							<input type="text" value="<?php if(isset($phone)){echo $phone;}?>" minlength='11' maxlength="11" name="phone" required class="form-control" id="phone" placeholder="Enter your active phone number here"/>
						 <span id="message_phone"></span>
					</div>
					<div class="form-group"><!-- User's Password -->
						<label for="pass">Password</label>
							<input type="password" name="pass" required class="form-control" id="pass"/>
					</div>
					<div class="form-group"><!-- Repeat_Password -->
						<label for="pass">Password Again</label>
							<input type="password" name="pass_again" required class="form-control" id="pass_again"/>
					</div>
					<div class="form-group">
						<input type="submit" name="sign_up"  class="btn btn-primary" value="SIGN UP"/>
					</div>
				</form>
			</section>
		</section>
		<section class="text-center">
			<p class="text-center"> &copy; <?php echo DOC_TITLE.', '.date("Y"); ?></p>
		</section>
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/smog.js"></script>
	</body>
</html>
<?php } ?>