<?php
	session_start();
	include_once("db_class.php");
	$telefone = $_POST["telefone"];//vetor
	$nome     = $_POST["usuario"];
	$senha    = md5($_POST["senha"]);
	$email    = $_POST["email"];
	$setor    = $_POST["setor"];
	
	
	$usuario = usuarios::usuarios_parametros($nome, $senha, $telefone, $email, $setor);
	$usuario->inserir();
	//$_SESSION['usuario'] = $nome;
	//header('Location: home.php');
?>