<?php
    include 'includes/db.php';
?>
<?php session_start(); ?>
<?php
        //set question number
		$number = (int) $_GET['n'];

		$lab = (int) $_GET['l'];

		//Pobranie pytania
		$query = "SELECT * FROM pytanie WHERE ID = $number AND numer_laboratorium = $lab";
		//Pobranie wyników
		$result = $conn->query($query) or die($conn->error.__LINE__);

		$question = $result->fetch_assoc();

		//Pobranie odpowiedzi
		
		$query = "SELECT * FROM odpowiedz WHERE id_pytania = $number";
		//Pobranie wyników
		$choices = $conn->query($query) or die($conn->error.__LINE__);

?>
<?php
        require_once 'includes/header.php';
?>
<div class="container">
	<div class="current"><strong>Quiz - Laboratorium nr <?php echo $lab; ?></strong></div>
	<p class="question">
		<?php echo $question['tresc_pytania']; ?>
	</p>
	<form action="process.php" method="post">
		<ul class="choices">
			<?php while($row = $choices->fetch_assoc()): ?>
				<li><input type="radio" name="choice" value="<?php echo $row['ID']; ?>" /><?php echo $row['tresc_odpowiedzi']; ?></li>
			<?php endwhile; ?>
		</ul>
		<input type="submit" value="Zatwierdź" class="btn btn-outline-secondary" role="button">
		<input type="hidden" name="number" value="<?php echo $number; ?>">
		<input type="hidden" name="lab" value="<?php echo $lab; ?>">
	</form>
</div>


<?php
    require_once 'includes/footer.php';
?>