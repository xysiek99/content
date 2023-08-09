<?php 
	session_start(); 
	session_destroy();
	header("Location: ../index.html");index
	$html = file_get_html('../test.html');
	echo $html;
?>