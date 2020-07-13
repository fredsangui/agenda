<?php
	
	session_start();
	require_once('db_class.php');
	$usuario = $_POST['usuario'];
	$senha    = md5($_POST['senha']);
	

	
	$dbu = new usuarios();
	$dados = $dbu->autentica_usuario($usuario, $senha);
	//var_dump($dados);
	
	//$teste = isset($dados['usuario']) ? 'retornou valor<br>' : 'vazio';
	
	//echo $teste;//$dados['usuario'] . 'novo';
	if($dados === False){
	    echo "erroBD";
	    $_GET['erro'] = 2;
		include_once('index.php');//erro no BD
		exit;	
	}
	if($dados === 3){
	    $_GET['erro'] = 3;
		include_once('index.php'); //senha incorreta
		exit;
	}
	if(isset($dados['usuario'])){//usuario encontrado
		$_SESSION['usuario'] = $dados['nome'];
		$_SESSION['setor'] = $dados['setor'];
		$_SESSION['email'] = $dados['email'];
		$_SESSION['usuario_id'] = $dados['usuario'];
		
		include_once('home.php');
	}else{
	    $_GET['erro'] = 1;
		include_once('index.php');
		
	}

?>