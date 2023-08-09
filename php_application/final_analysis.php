<?php
    include 'includes/header.php';
?>
<?php session_start(); ?>
<?php 
	$firstquestion = (int) $_GET['n'];
	$lab = (int) $_GET['l']; 
?>
<div class="container">
	<h2>Koniec</h2>
	<p>Gratuluję ukończenia analizy!</p>
	<a href="analysis.php?lab=<?php echo $lab ?>&number=<?php echo $firstquestion ?>" class="btn btn-outline-secondary" role="button">Ponów analizę</a>
</div>

<?php
    include 'includes/footer.php';
?>