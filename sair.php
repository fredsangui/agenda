<?php
	session_start();
	$usuario = $_SESSION['usuario'];
	echo "Sessão encerrada<br> Obregado pela vizita $usuario.";
	unset($_SESSION['usuario']);
	header('refresh: 5;index.php');

?>