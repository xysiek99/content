<?php 
	//Dane uwierzytelniajce połaczenia

	//Hostname
	$serverName = getenv('DB_HOST', 'db');
	$username = getenv('DB_USER', 'telelabp_user11');
	$password = getenv('DB_PASS', 'telelabp_user11!');
	$dbname = getenv('DB_NAME', 'telelabp_DB');

	//Obiekt mysqli
	$conn = mysqli_connect($serverName, $username, $password, $dbname);
	mysqli_query($conn, "SET CHARSET utf8");
	mysqli_query($conn, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	//Obsługa wyjtków/błędów
	if (mysqli_connect_errno())
  	{
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	}
?>
