<?php
    session_start();
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../index.php?erro=1');
        echo "erro ao acessar variaveis de sessão.<br>";
        exit;
    }else{
        $id_usuario = $_SESSION['usuario_id'];
    }
    include_once('../db_class.php');
    $titulo = $_POST['title'];
    $inicio = $_POST['start'];
    $fim = $_POST['end'];
    $diatodo = $_POST['allDay'];
    //echo "$_SESSION['usuario'] <br> $_SESSION['usuario_id']";
    $usuario = new usuarios();
    $resultado = $usuario->registra_eventos($id_usuario, $titulo, $inicio, $fim, $diatodo);
    if($resultado){
        $resultado = $usuario->get_lembretes($id_usuario);
        $resultado = mysqli_fetch_array($resultado);
        $id = $resultado['lembrete'];
        echo $id;
    }else{
        echo 0;
    }


?>