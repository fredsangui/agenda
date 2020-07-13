<thead style="color:blue">
  <tr>
	<th>Setor</th>
	<th>Nome</th>
	<th>Telefone</th>
  </tr>
</thead>

<?php
	$busca = $_POST['buscar'];
	session_start();
	include_once('db_class.php');
	
	$telefone = new telefones();
	$lista = $telefone->listar_telefones_usuarios($busca);
	echo '<br><tbody>';
	var_dump($lista);
	while($linha = mysqli_fetch_array($lista, MYSQLI_ASSOC)){
		//echo "<a href='#' class='list-group-item'>";
		echo '<tr>';
		echo "<th>".$linha['setor']." </th>";
		echo "<th>".$linha['nome']." </th>";
		echo "<th>".$linha['telefone']." </th>";
		echo '<tr>';
		// foreach($linha as $key => $item){
			// var_dump($item);
			// echo $key .'--'. $item . '-_-';
			// echo "<li><span>".$item[0]."</span>";
			// echo "<span>".$item[1]."</span>";
			// echo "<span>".$item[2]."</span>";</li>";
		//}
		echo '<tr>';
		
	}

	echo '</tbody>';
?>
