<?php
	
	include("includes/config.php");
	include("includes/classes/Account.php");	
	include("includes/classes/Constants.php");	

	$account = new Account($con);

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name) {
		if(isset($_POST[$name])) {
			echo $_POST[$name];
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Musify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Bree+Serif&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oxygen&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/register.js"></script>
</head>
<body>


	<?php

		if(isset($_POST['registerButton'])) {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").hide();
						$("#registerForm").show();  
					});
				  </script>';
		}
		else {
			echo '<script>
					$(document).ready(function() {
						$("#loginForm").show();
						$("#registerForm").hide();  
					});
				  </script>';
		} 

	?>


	<div id="background">
		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="register.php" method="POST">
					<div id="logo"></div>
					<h2>Login to your account</h2>
					<p>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson"
							value="<?php   getInputValue('loginUsername'); ?>" autocomplete="off" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password" required>
					</p>
					
					<?php echo $account->getError(Constants::$loginFailed);  ?> 
					<button type="submit" name="loginButton">LOG IN</button>
					
					<div class="hasAccountText">
						Don't have an account yet? <span id="hideLogin">Signup here</span>
					</div>
				</form>

				<form id="registerForm" action="register.php" method="POST">
					<div id="smallLogo"></div>
					<h2>Create your free account</h2>
					<p>
						<label for="username">Username</label>
						<input id="username" name="username" type="text" placeholder="e.g. bartSimpson" value="<?php getInputValue('username'); ?>" autocomplete="off" required>
						<?php echo $account->getError(Constants::$usernameCharacters);  ?>
						<?php echo $account->getError(Constants::$usernameTaken);  ?>
					</p>

					<p>
						<label for="firstName">First name</label>
						<input id="firstName" name="firstName" type="text" placeholder="e.g. Bart" value="<?php   getInputValue('firstName'); ?>" autocomplete="off" required>
						<?php echo $account->getError(Constants::$firstNameCharacters);  ?>
					</p>

					<p>
						<label for="lastName">Last name</label>
						<input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson" value="<?php   getInputValue('lastName'); ?>" autocomplete="off" required>
						<?php echo $account->getError(Constants::$lastNameCharacters);  ?>
					</p>

					<p>
						<label for="email">Email</label>
						<input id="email" name="email" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email'); ?>" autocomplete="off" required>
					</p>

					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com" value="<?php getInputValue('email2'); ?>" autocomplete="off" required>
						<?php echo $account->getError(Constants::$emailsDoNotMatch);  ?>
						<?php echo $account->getError(Constants::$emailInvalid);  ?> 
						<?php echo $account->getError(Constants::$emailTaken);  ?>
					</p>

					<p>
						<label for="password">Password</label>
						<input id="password" name="password" type="password" placeholder="Your password" required>
					</p>

					<p>
						<label for="password2">Confirm password</label>
						<input id="password2" name="password2" type="password" placeholder="Confirm password" required>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch);  ?>
						<?php echo $account->getError(Constants::$passwordsNotAlphanumeric);  ?>
						<?php echo $account->getError(Constants::$passwordsCharacters);  ?>
					</p>

					<button type="submit" name="registerButton">SIGN UP</button>

					<div class ="hasAccountText">
						Already have an account? <span id="hideRegister">Login here</span>
					</div>

				</form>
			</div>  

			<div id="rightSection">
				<h1>Get free music, right now</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with.</li>
					<li>Create your own playlist.</li>
					<li>Follow artist to keep up to date.</li>	
				</ul>
			</div>

		</div>
	</div>
</body>
</html>