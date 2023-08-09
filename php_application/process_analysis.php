<?php
    include 'includes/db.php';
?>
<?php session_start(); ?>
<?php 
	if($_POST){
		$number = $_POST['number'];
		$lab = $_POST['lab'];

		$next = $number+1;

		$query = "SELECT max(ID) FROM analiza WHERE laboratorium = $lab";
		$results = $conn->query($query) or die($conn->error.__LINE__);
		$total = $results->fetch_row()[0] ?? false;

		$firstquestion = "SELECT min(ID) FROM analiza WHERE laboratorium = $lab";
		$results = $conn->query($firstquestion) or die($conn->error.__LINE__);
		$fq = $results->fetch_row()[0] ?? false;
		

		if($number == $total){
			header("Location: final_analysis.php?n=".$fq."&l=".$lab);
			exit();
		} else {
			header("Location: analysis.php?lab=".$lab."&number=".$next);
		}

	}
?>