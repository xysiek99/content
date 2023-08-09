<?php
    include 'includes/db.php';
?>
<?php session_start(); ?>
<?php

		$lab = $_GET['lab'];
		$number = $_GET['number'];

		//Pobranie pytania
		$query = "SELECT * FROM analiza WHERE laboratorium = $lab AND ID = $number";
		//Pobranie wyników
		$result = $conn->query($query) or die($conn->error.__LINE__);

		$analysis = $result->fetch_assoc();

		$keyvalue = $analysis['slowo_klucz'];
?>

<?php
        require_once 'includes/header.php';
?>

<div class="container">
	<div class="current"><strong>Analiza - Laboratorium nr <?php echo $lab; ?>. Po wpisaniu zatwierdź klawiszem ENTER w celu sprawdzenia poprawności</strong></div>
		<!-- dodana linia w celu sprawdzenia co jest zwracane	-->
	<div class="current"><strong>WYNIKI</strong></div>
	
	<p class="question">
		<?php echo $analysis['tresc_analizy']; ?>
		
	</p>
		<div id="ok" class="alert alert-success" style="display: none;">DOBRZE</div>
		<div id="wrong" class="alert alert-danger" style="display: none;">Zle. Linia powinna zawierac <?php echo $keyvalue; ?></div>
		<input type="text" name="userinput" id="userinput" onchange="myFunction(this.value, '<?php echo $keyvalue;?>')">

		<form action="process_analysis.php" method="post">
			<input type="submit" value="Dalej" class="btn btn-outline-secondary" role="button">
			<input type="hidden" name="lab" value="<?php echo $lab; ?>">
			<input type="hidden" name="number" value="<?php echo $number; ?>">
		</form>		

		
</div>
<?php
    require_once 'includes/footer.php';
?>