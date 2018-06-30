<?php
	session_start();
	if(!isset($_SESSION['user']))
		header("location: logout.php");
?>

<html>
	<head>
		<title>ACM | Home</title>
		<?php include "css/acm.php"; ?>
	</head>
	<body class="acm-body">
		<div class="center" style="float: left; width:20%;">
			<img src="assets/acm_icon.png" width="60%" style="margin-top: 2em; margin-bottom: 2em;">	
			<div class="collection">
				<a href="menu-membership.php" target="acm-menu" class="collection-item"><span class="acm-color">Membership</span></a>
				<a href="menu-finance.php" target="acm-menu" class="collection-item"><span class="acm-color">Finance</span></a>
				<a href="menu-events.php" target="acm-menu" class="collection-item"><span class="acm-color">Events</span></a>
				<a href="AccountsPage/admin_member_management.php" target="acm-menu" class="collection-item"><span class="acm-color">Accounts</span></a>
			</div>
			<form method="post" action="login.php">
				<button class="btn waves-effect"  style = "background-color: #555;" type="submit" name="logout">Log out
						<i class="material-icons left">power_settings_new</i>
				</button>
			</form>
		</div>
		<iframe name = "acm-menu" src="welcome.php" frameborder="0" width="80%" height="100%"></iframe>
	</body>
</html>