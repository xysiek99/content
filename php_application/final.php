<?php
    include 'includes/header.php';
?>
<?php session_start(); ?>
<?php 
	$firstquestion = (int) $_GET['n'];
	$lab = (int) $_GET['l']; 
	$score = $_SESSION['score'];
	$username = $_SESSION['sessionUser'];
	unset($_SESSION['score']);
?>
<div class="container">
	<h2>Koniec</h2>
	<p>Gratuluję ukończenia quizu!</p>
	<p>Twój wynik: <?php echo $score; ?></p>
	<a href="question.php?n=<?php echo $firstquestion ?>&l=<?php echo $lab ?>" class="btn btn-outline-secondary" role="button">Ponów quiz</a>
	<input type="hidden" id="score" name="score" value="<?php echo $score; ?>">
	<input type="hidden" id="username" name="username" value="<?php echo $username; ?>">
</div>
<br>
<div class="container">
	<button class="btn btn-outline-secondary" type="button" onclick="HTMLtoPDF()">Zapisz wynik</button>
</div>

<?php
    include 'includes/footer.php';
?>