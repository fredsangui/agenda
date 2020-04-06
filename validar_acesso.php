<?php
	session_start();
	require_once('db_class.php');
	$usuario = $_POST['usuario'];
	$senha    = md5($_POST['senha']);
	
	echo $usuario . '<br>'; 
	echo $senha . '<br>';
	
	$dbu = new usuarios();
	$dados = $dbu->autentica_usuario($usuario, $senha);
	//var_dump($dados);
	
	$teste = isset($dados['usuario']) ? 'retornou valor<br>' : 'vazio';
	
	echo $teste;//$dados['usuario'] . 'novo';
	if($dados === False){
		header('Location: http://localhost/twitter_clone/index.php?erro=2');//erro no BD
		exit;	
	}
	if($dados === 3){
		header('Location: http://localhost/twitter_clone/index.php?erro=3'); //senha incorreta
		exit;
	}
	if(isset($dados['usuario'])){//usuario não encontrado
		$_SESSION['usuario'] = $dados['nome'];
		header('Location: home.php');
		//echo "<script>alert('Usuário encontrado.');</script>";
	}else{
		header('Location: http://localhost/twitter_clone/index.php ? erro=1');
		
	}

?>