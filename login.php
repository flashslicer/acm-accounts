<?php
	$msg = "<br>";
	if(isset($_POST['login'])){
		$username = strip_tags($_POST['username']);
		$password = md5(strip_tags($_POST['username']));

		$msg = "<span class = 'error col s4 offset-s4'>";

		if(empty($username) || empty($password)){
			$msg .= "Please complete input fields!";
		} else if (preg_match("/[^A-Za-z0-9._]/", $username)) {
			$msg .= "Invalid username or password!";
		} 
		else{
			include "includes/conn.php";

			$sql = "SELECT * FROM accounts WHERE username = '$username' AND password = '$password'";
			$result = mysqli_query($conn, $sql);

			if(mysqli_num_rows($result) == 0){
				$msg .= "Account does not exists!";
			} else{
				$row = mysqli_fetch_array($result);
				if($row['status'] == 0)
					$msg .= "Account is inactive, contact admin for activation.";
				else{
					session_start();
					$_SESSION['user'] = $row;
					header("location: homepage.php");
				}

			}
		}

		$msg .= "</span>";
	}

	if(isset($_POST['logout'])){
		session_start();
		session_unset();
		$msg = "<span class = 'success col s4 offset-s4'>You have successfully logged out.</span>";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>ACM | Login</title>
		<?php include "css/acm.php"; ?>
	</head>
	<body>
		<div class="row col s12 center">
			<br>
			<img src="assets/acm_logo.png" width="35%" style="margin-bottom: 0.2em;">
			<br><br>
			<?php echo $msg; ?>
		</div>
		<div class="row">
	    	<form class="col s4 offset-s4" method="post">
				<div class="row">
					<div class="input-field">
						<i class="material-icons prefix acm-color">account_circle</i>
						<input id="icon_prefix" name = "username" type="text" class="validate" required>
						<label for="icon_prefix">Username</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field">
						<i class="material-icons prefix acm-color">lock</i>
						<input id="icon_telephone" name = "password" type="password" class="validate" required>
						<label for="icon_telephone">Password</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field" style="float: right;">
						<button class="btn waves-effect waves-light acm-btn" type="submit" name="login">Log In
							<i class="material-icons right">send</i>
						</button>
					</div>
				</div>
	    	</form>
		</div>
	</body>
</html>
