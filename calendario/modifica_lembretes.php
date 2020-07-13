<?php
    include_once('../db_class.php');
    $inicio = $_POST['inicio'];
    $fim    = $_POST['fim'];
    $id     = $_POST['id'];
    $usuario = new usuarios();
    $result  = $usuario->altera_lembrete($inicio, $fim, $id);
    $result  = $result ? 'Data do evento alterada com sucesso.' : 'Erro ao alterar data da evento.';
    echo $result;

?>