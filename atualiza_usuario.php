<?php
    if(!isset($_SESSION['usuario'])){
		session_start();
	}
    if(!isset($_SESSION['usuario']))
        header('Location: index.php?erro=1');
    $usuario_id = $_SESSION['usuario_id'];
	$nome     = $_SESSION['usuario'];
	$senha    = $_POST["conf_senha"] == '' ? '' : md5($_POST["conf_senha"]);
    $email    = $_POST["email"];
    $_SESSION['email'] = $email;
    $setor    = $_POST["setor"];
    $_SESSION['setor'] = $setor;
    
    include_once('db_class.php');
    //"atualizar dados<br>";
    $usuario = new usuarios();
    $usuario->atualiza_usuario($nome,$email,$setor,$senha);
    //header("refresh: 5; meus_dados.php");
    $telefone = new telefones();
    $telefone->apaga_telefones_usuario($usuario_id);
    if(isset($_POST["telefone"])){
        $tel_num = $_POST["telefone"];//vetor
        $telefone->inserir($usuario_id, $tel_num);
    }
    
    include_once('meus_dados.php');
?>