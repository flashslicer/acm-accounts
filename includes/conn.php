<?php
	$host = "localhost";
	$uname = "root";
	$pass = "";

	$conn = mysqli_connect($host, $uname, $pass);
	mysqli_select_db($conn, "acm");

?>