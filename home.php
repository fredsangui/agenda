<?php
	session_start();
	if(!isset($_SESSION['usuario']))
		header('Location: index.php?erro=1');
?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Agenda</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
		<script type="text/javascript">
			
			$(document).ready(function(){
				$('#btn_busca').click(function(){
					var serializa = $('#form_busca').serialize();
					// $('#teste').text(serializa);
					$.ajax({
						url: "pesquisa.php",
						method: 'POST',
						data: serializa,
						success: function(data){
							if(serializa) $('#lista_dados').html(data) //lista_dados
							else $('#lista_dados').html('');
						}
					});				
				});
			});
			
			
			//Código bugado
			// $(document).ready(function(){
				// $('#btn_busca').click(function(event){
					// serializa = $('#form_busca').serialize;
					// alert(serializa);
					// $.ajax({
						// url: "pesquisa.php",
						// method: 'POST',
						// data: serializa,
						// success: function(data){
																								 
							// $('#lista_dados').html(data);
							
						// },
					// });
				// });
			// })
			
		</script>
	
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <img src="imagens/agenda.png" />
			  <?php
				echo 'Bem vindo(a) '. $_SESSION['usuario'];
			  ?>
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">

	    	<div class="col-md-2">				
			
			
			</div>
	    	<div class="col-md-8">
	    		<div class="panel panel-default">
					<div class="panel-body">
						<form class="input-group" id = "form_busca">
							<input type="text" class="form-control" placeholder='telefone ou usuario' name="buscar" id="id_buscar">
								<span class="input-group-btn">
									<button class='btn btn-default' id="btn_busca" type='button'>Pesquisar</button>
								</span>
						</form>		
					</div>
				</div>
				<table class="table table-hover table-striped" id="lista_dados">
				</table>
				
			</div>
			<div class="col-md-2"></div>
			
			<br>
		</div>


	    </div>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>