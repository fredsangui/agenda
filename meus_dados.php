<?php
    if(!isset($_SESSION['usuario'])){
		session_start();
	}
    if(isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
        $email   = $_SESSION['email'];
		$setor   = $_SESSION['setor'];
		if(isset($_GET['result'])){
			$resultado = $_GET['result'];
		}else{
			$resultado = 404;
		}
    } else header("Location: index.php?erro=1");

?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Compartilhamento de Contatos</title>
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		
	
	</head>

	<body style="background-image: linear-gradient(to left, white, lightgray);">

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
              <a href="home.php">Home</a>
	        </div>
	        
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
     			<li><a href="calendario/calendario.php">Calendário</a></li>
	            <li><a href="sair.php">Sair</a></li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	
	    	<br /><br />

	    	<div class="col-md-4"></div>
	    	<div class="col-md-4">
	    		<h3>Edite seus dados</h3>
				<?php 
					if(isset($_POST['mensagem'])){
						if($_POST['mensagem'] == 1){//mensagem de sucesso
							echo '<p id="mensagem" style="color: blue">';
							echo 'Seu registro foi atualizado com sucesso.';
							echo '</p>';
						}else{//mensagem de erro
							echo '<p id="mensagem" style="color: red">';
							echo $_POST['mensagem'];
							echo '</p>';
						}
						unset($_POST['mensagem']);
					}else echo '<p id="mensagem"></p>';
				?>
	    		<br />
				<form method="post" action="atualiza_usuario.php" class="formCadastro">
					<div class="form-group">
						<input type="text" class="form-control" id="usuario" name="usuario"  placeholder="Usuário" required="requiored" disabled>
					</div>

					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email" required="requiored">
					</div>
					
					<div class="form-group">
						<input type="password" value='xxxxxxxx' class="form-control" id="senha" name="senha" placeholder="Senha" required="requiored">
					</div>

					<div class="form-group">
						<input type="hidden" class="form-control" id="conf_senha" name="conf_senha" placeholder="Repita a senha" required="requiored">
					</div>
						
					<div class="form-group">
						<input type="text" class="form-control" id="setor" placeholder="setor" name="setor" required="requiored">
					</div>
					
					<div id='telefones'>
						<h1>ajax</h1>
					</div>
					<div class="input-group form-group ">
                        
                        <button type="submit" class="btn btn-primary" id="salvar" disabled> Salvar  </button>
                        
                        <button type="button" class="btn btn-danger" id="cancelar" disabled>Cancelar</button>
                        
                    </div>
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
			var c_telefones;
			$(document).ready(function(){
                function carrega_telefones(){
                    $.ajax({
                        url: "edita_telefones.php",
                        //method: 'POST',
                        //data: serializa,
                        success: function(data){
                            $('#telefones').html(data); //lista_dados
							 
							//return c_telefones;                         
                        }
						
                    });		
                }
				carrega_telefones();

				$(document).ajaxComplete(function(){
					c_telefones = $('#cont_tell').val();  
					n_telefone  = 'telefone'+c_telefones;
					//alert(c_telefones);					
				});
				
                $('#usuario').val("<?php echo $usuario?>");
                $('#email').val("<?php echo $email?>");
                $('#setor').val("<?php echo $setor?>");

				//alert(n_telefone);
				var div_telefones;
                var edit_usuario = false;
                var edit_telefones = false;
				btn_adicionar = document.getElementById("btn_adicionar");
				//var controle_ids = [n_telefone]; 
				function habilita_ad(){
					if(document.getElementById(n_telefone).value == '')
						$("#btn_adicionar").attr('disabled', true);
					else $("#btn_adicionar").attr('disabled', false);				
				}


                $("#cancelar").click(function(){
                    //alert("cancelou");
                    $("#cancelar").enable = false;
                    $('#usuario').val("<?php echo $usuario?>");
                    $('#email').val("<?php echo $email?>");
                    $('#setor').val("<?php echo $setor?>");   
					$('#senha').val('xxxxxxxx');
					$('#conf_senha').val('xxxxxxxx');
					$('#conf_senha').attr('type', 'hidden');
                    carrega_telefones();
					$('#cancelar').attr('disabled', true);   
					$('#salvar').attr('disabled', true);  
                });

                $('.formCadastro').on('input', function(event){
                    edit_usuario = true;        
					$('#cancelar').attr('disabled', false);   
					$('#salvar').attr('disabled', false);     
                });

				$("#senha").on('input', function(){
					$("#conf_senha").attr('type', 'password');
				});
                
                
				document.getElementById('telefones').addEventListener('input', function(event){//sem jquery = .on?
					habilita_ad();
                    edit_telefones = true;
				});
	
				$(document).on('click', '#btn_adicionar', function(){
					
					c_telefones++;
					n_telefone = 'telefone'+c_telefones;
					//div_telefones = document.getElementById("telefones_ad"); 
					adicionar = '<div class="input-group form-group" id="tel_list'+c_telefones+'">';
					adicionar += '<input type="number" class="form-control" id="'+n_telefone+ "\"";
					adicionar += 'placeholder="'+n_telefone+'" name="telefone[]">';
					adicionar += "<span class = 'input-group-btn'>";
					adicionar += '<button class="apaga_tel btn btn-danger" id="tel_list'+c_telefones+'" type="button"><strong>-</strong></button>';
					adicionar += "</span>";
					adicionar += '</div>';
					//alert(n_telefone);
					//div_telefones.innerHTML += adicionar; 
					$('#telefones').append(adicionar);
					$('#'+n_telefone).focus();
					$('#btn_adicionar').attr('disabled', true);	
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
					$('#cancelar').attr('disabled', false);   
					$('#salvar').attr('disabled', false);  
				});	

				$("#salvar").on("click", function(event){
					senha = $("#senha").val();
					confirma = $("#conf_senha").val();
					if((senha != confirma) && ( senha != 'xxxxxxxx')){
						$('#mensagem').html('*As senhas não correspondem.');
						$('#mensagem').css('color', 'red');
						$("#senha").focus();
						return false;
					}
					
				});

			});
            
			var result = "<?php echo $resultado;?>";
			switch(result){
			case '1':
				alert('Erro ao atualizar usuário');
				break;
			case '2':
				alert('Erro ao apagar telefones');
				break;
			case '3':
				alert('Erro ao reincerir telefones');
				break;
			case '0':
				alert('Dados atualizados com sucesso');
				break;
			}
			
		</script>
	
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	
	</body>
</html>