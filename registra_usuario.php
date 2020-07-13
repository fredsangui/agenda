<?php
	session_start();
	include_once("db_class.php");
	$telefone = $_POST["telefone"];//vetor
	$nome     = $_POST["usuario"];
	$senha    = md5($_POST["senha"]);
	$email    = $_POST["email"];
	$setor    = $_POST["setor"];
	
	
	$usuario = usuarios::usuarios_parametros($nome, $senha, $telefone, $email, $setor);
	$funciona = $usuario->inserir();
	if($funciona){
		$_SESSION['usuario'] = $nome;
		$_SESSION['setor']   = $setor;
		$_SESSION['email']   = $email;
		$_SESSION['usuario_id']   = $usuario->get_usuario_id();
		include_once('home.php');
	}else{
		//echo "Ocorreu um erro ao inserir os dados.";
		include_once('inscrevase.php');
	}
	
?>