<?php
	
	if (isset($_POST['submit'])){
		require 'db.php';

		$username = $_POST['username'];
		$password = $_POST['psw'];
		
		if(empty($username) || empty($password)){
			header("Location: ../index.php?error=emptyfields");
			exit();
		} else {
			$sql = "SELECT * FROM uzytkownik WHERE nazwa = ?";
			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt, $sql)){
				header("Location: ../index.php?error=sqlerror");
				exit();
			} else {
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				echo '$result';

				if ($row = mysqli_fetch_assoc($result)) {
					$passCheck = password_verify($password, $row['haslo']);
					if ($passCheck == false){
						header("Location: ../index.php?error=wrongpass");
						exit();
					} elseif ($passCheck == true) {
						session_start();
						$_SESSION['sessionid'] = $row['id'];
						$_SESSION['sessionUser'] = $row['nazwa'];
						$_SESSION['hint'] = $row['podpowiedz'];
						header("Location: ../index.php?success=loggedin");
						exit();
					} else {
						header("Location: ../index.php?error=wrongpas2");
						exit();
					}
				} else {
					header("Location: ../index.php?error=nouser");
					exit();
				}
			}
		}

	} else {
		header("Location: ../index.php?error=accessforbidden");
		exit();
	}
?>