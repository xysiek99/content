<?php
    include 'includes/db.php';
?>
<?php session_start(); ?>
<?php 
	if(!isset($_SESSION['score'])){
		$_SESSION['score'] = 0;
	}

    if(empty($_POST["choice"])){ 
        $message = "Nie wybrano odpowiedzi";
		echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
    	exit; 
    } else {
    	if($_POST) {
			$number = $_POST['number'];
			$lab = $_POST['lab'];
			$selected_choice = $_POST['choice'];

			$next = $number+1;

			$query = "SELECT max(ID) FROM pytanie WHERE numer_laboratorium = $lab";
			$results = $conn->query($query) or die($conn->error.__LINE__);
			$total = $results->fetch_row()[0] ?? false;

			$firstquestion = "SELECT min(ID) FROM pytanie WHERE numer_laboratorium = $lab";
			$results = $conn->query($firstquestion) or die($conn->error.__LINE__);
			$fq = $results->fetch_row()[0] ?? false;


			//Poprawna odpowiedź
			$query = "SELECT * FROM odpowiedz WHERE id_pytania = $number AND czy_poprawna = 1";

			$result = $conn->query($query) or die($conn->error.__LINE__);

			$row = $result->fetch_assoc();

			$correct_choice = $row['ID'];

			if($correct_choice == $selected_choice){
				$_SESSION['score']++;
			}

			if($number == $total){
				header("Location: final.php?n=".$fq."&l=".$lab);
				exit();
			} else {
				header("Location: question.php?n=".$next."&l=".$lab);
			}
		}
    }	
 ?>
