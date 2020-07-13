[<?php
	session_start();
	if(!isset($_SESSION['usuario_id'])){
		header('Location: ../index.php?erro=1');
		echo "Erro ao acessar variaveis de sessão.";
		exit;
	}else{
		$id_usuario = $_SESSION['usuario_id'];
	}
	include_once('../db_class.php');
	$usuario = new usuarios();
	$lembretes = $usuario->get_lembretes($id_usuario);
	if($lembretes){ 
		$primeiro = true;
		while($lembrete = mysqli_fetch_array($lembretes)){
			$id      = $lembrete['lembrete'];
			$titulo  = $lembrete['titulo'];
			$inicio  = $lembrete['inicio'];
			$fim     = $lembrete['fim'];
			$diatodo = $lembrete['diatodo'] ? 1 : 0;
			if($primeiro) $primeiro = false;
			else echo ","; 
			echo '{"id": '.$id.',';
			echo"\"title\": \"$titulo\",";
			if(isset($inicio))echo"\"start\": \"$inicio\",";
			if(isset($fim))echo"\"end\": \"$fim\",";
			echo"\"allDay\":$diatodo,";
			echo"\"className\": \"info\"}";
		}

	} else{
		echo "{
			'title': 'Erro no BD',
			'start': new Date(y, m, d)
		}";
	}
?>]
