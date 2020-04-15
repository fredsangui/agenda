<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Agenda</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
	
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
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="index.php">Voltar para Home</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-4"></div>
	    	<div class="col-md-4">
	    		<h3>Inscreva-se já.</h3>
	    		<br />
				<form method="post" action="registra_usuario.php" id="formCadastrarse">
					<div class="form-group">
						<input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required="requiored">
					</div>

					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required="requiored">
					</div>
					
					<div class="form-group">
						<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required="requiored">
					</div>
						
					<div class="form-group">
						<input type="text" class="form-control" id="setor" placeholder="setor" name="setor">
					</div>
					
					<div id='telefones'>
						<div class="input-group form-group">
							
							<input type="number" class="input-group form-control" id="telefone0" placeholder="telefone" name="telefone[]" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" id="btn_adicionar" type="button" disabled><strong>+</strong></button>
							<span>
							
						</div>
					</div>
					
					<button type="submit" class="btn btn-primary form-control">Inscreva-se</button>
				</form>
			</div>
			<div class="col-md-4"></div>

			<div class="clearfix"></div>
			<br />
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>
			<div class="col-md-4"></div>

		</div>


	    </div>
		
		<script type="text/javascript">
			$(document).ready(function(){
				var c_telefones = 0;
				var n_telefone = 'telefone0'; 
				var div_telefones;
				btn_adicionar = document.getElementById("btn_adicionar");
				//var controle_ids = [n_telefone]; 
				function habilita_ad(){
					if(document.getElementById(n_telefone).value == '')
						btn_adicionar.disabled = true
					else btn_adicionar.disabled = false;				
				}
				document.getElementById('telefones').addEventListener('input', function(event){//sem jquery = .on?
					habilita_ad();
				});
				
				$('#btn_adicionar').on('click', function(event){
					c_telefones++;
					n_telefone = 'telefone'+c_telefones;
					//div_telefones = document.getElementById("telefones_ad"); 
					adicionar = '<div class="input-group form-group" id="tel_list'+c_telefones+'">';
					adicionar += '<input type="number" class="form-control" id="'+n_telefone;
					adicionar += '" placeholder="'+n_telefone+'" name="telefone[]";//"'+n_telefone+'">';
					adicionar += "<span class = 'input-group-btn'>";
					adicionar += '<button class="apaga_tel btn btn-danger" id="tel_list'+c_telefones+'" type="button"><strong>-</strong></button>';
					adicionar += "</span>";
					adicionar += '</div>';
					//alert(adicionar);
					//div_telefones.innerHTML += adicionar; 
					$('#telefones').append(adicionar);
					$('#'+n_telefone).focus();
					btn_adicionar.disabled = true;	
				});
				
				$(document).on('click', '.apaga_tel',function(event){
					id_telefone = $(this).attr("id");
					//alert(id_telefone);
					$('#'+id_telefone).slideUp();
					$('#'+id_telefone).remove();

					console.log(id_telefone.substring(8,9) +' = '+c_telefones);
					if(id_telefone.substring(8,9) == c_telefones){//caso apague o ultimo telefone adicionado...
						while(true){
							c_telefones--;
							n_telefone = 'telefone' + c_telefones;
							ultimo = document.getElementById(n_telefone);
							if(ultimo) break;
							console.log(n_telefone+' em branco');
						}
						// alert(n_telefone[8] +' = '+ c_telefones);
						// return false;
					}
					console.log(n_telefone);
					habilita_ad();
				})	
			});
			
		</script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>