<?php 
	// unset any variables just incase
	session_start(); 
	unset($_SESSION["username"]);
	unset($_SESSION["subject-id"]);
	unset($_SESSION["subject-edit"]);
?>
<!DOCTYPE html>
<head>
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../static/css/login.css">
</head>
	<body>
		<div class = welcome>
			<i class="fas fa-clinic-medical fa-3x"></i>
			<p class = "welcome-back font">Welcome Back!</p>
		</div>
		<div class=login-form align = "center">
			<form class="pure-form pure-form-aligned" method = "POST" action="check-login.php">
			    <fieldset>
				    <div class="pure-control-group">
				        <input id="username" name="username" type="text" placeholder="Username">
				    
				    <div class="pure-control-group">
				        <input id="password" name="password" type="password" placeholder="Password">
				    </div>
					<button class="pure-button login-button font">Login</button>
					<div class="pure-control-group">
						<?php
							if (isset($_SESSION["error"])) {
								$error = $_SESSION["error"];
								echo "<span class='error'>$error</span>";
								unset( $_SESSION["error"]);
							}
						?>
					</div>
			    </fieldset>
			</form>
		</div>
	</body>
</html>