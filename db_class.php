<?php
	class db{
		//host
		private $host = 'localhost';
		//usuario
		private $usuario = 'root';//id13848263_root
		//semha
		private $senha = '';//_^X$H6Vgf@>YJ+xs
		//nome bd
		private $database = 'agenda';//id13848263_agenda
		
		public function conecta_mysql(){
			$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
			
			//Ajusta o charset para a comunicação entre a aplicação e o BD
			mysqli_set_charset($con, 'utf8');
			
			if(mysqli_connect_error()){
				echo 'Tentativa de conectar com o Banco de Dados resultou em Erro:</br>' . mysqli_connect_error();	
			}			
			return $con;
		}
	}
	//alto acoplamento
	//usar SOLID?
	class usuarios extends db{
		private $nome;
		private $senha;
		private $telefone;
		private $email;
		private $setor;
		private $usuario_id;

		public function get_usuario_id(){
			return $this->usuario_id;
		}
		
		function usuarios_parametros($nome, $senha, $telefone, $email, $setor){//
			$obj = new usuarios();
			$obj->nome = $nome;
			$obj->senha = $senha;
			$obj->telefone = $telefone;
			$obj->email = $email;
			$obj->setor = $setor;
			return $obj;
		}

		public function atualiza_usuario($nome, $email, $setor, $senha){
			$con = $this->conecta_mysql();
			if($senha == ''){
				$sql = "update usuarios set email='$email', setor='$setor' where nome = '$nome'";
			}else{
				$sql = "update usuarios set email='$email', setor='$setor', senha='$senha' where nome = '$nome'";
			}
			//echo $sql."<br>";
			if(mysqli_query($con, $sql))
				$_POST['mensagem'] = 1; // Mensagem de Sucesso
			else
				$_POST['mensagem'] = 'Erro insperado';
		}
		
		public function inserir(){
			
			//verifica se nome ja existe / seleciona proximo id de usuario
			$sql = "select max(usuario)+1 from usuarios union select usuario FROM usuarios WHERE nome = '$this->nome' ";
			$con = $this->conecta_mysql();
			$resultado = mysqli_query($con, $sql);
			$proximo = mysqli_fetch_array($resultado);
			$id_usuario = $proximo[0];
			
			$existe = mysqli_fetch_array($resultado);
			//Não permitir usuarios de mesmo nome
			if(isset($existe[0])){
				$_POST['mensagem'] = '*Existe outro usuario cadastrado com esse nome.<br>';
				return false;
			}
			
			$sql = "insert into usuarios(nome, senha, email, setor) values('$this->nome', '$this->senha', '$this->email', '$this->setor') ";
			
			if($result = mysqli_query($con, $sql)){
				$_POST['mensagem'] = 1;// 'Usuário cadastrado com sucesso!!!<br>';
			}else{
				$_POST['mensagem'] ='Erro ao inserir registro de usuario<br>';
				exit;
			}
		
			$tel = new telefones();
			$tel->inserir($id_usuario,  $this->telefone);
			$this->usuario_id = $id_usuario;
			return $result;
		}
		
		public function autentica_usuario($nome, $senha){
			$con = $this->conecta_mysql();
			$sql = "select usuario, nome, senha, email, setor from usuarios where nome = '$nome'";
			$resultado = mysqli_query($con, $sql);
			//$dados = $resultado ? mysqli_fetch_array($resultado) : False;
			if($resultado){
				$dados = mysqli_fetch_array($resultado);
				if($dados['senha'] == $senha){
					return $dados;//senha incorreta 
				} else if(isset($dados['nome'])) return 3;
			}else return False;
		}		

		public function get_usuario($nome){
			$con = $this->conecta_mysql();
			$sql = "select usuario, nome, senha, email, endereco from usuarios where nome = '$nome'";
			$resultado = mysqli_query($con, $sql);
			//$dados = $resultado ? mysqli_fetch_array($resultado) : False;
			if($resultado){
				$dados = mysqli_fetch_array($resultado);
				return $dados; 
			}else return False;
		}

		public function registra_eventos($usuario, $titulo, $inicio, $fim, $diatodo){
			$con = $this->conecta_mysql();
			$sql = "INSERT INTO lembretes(usuario, titulo, inicio, fim, diatodo) "
			. "VALUES ($usuario,'$titulo','$inicio','$fim',$diatodo)";
			$resultado = mysqli_query($con, $sql);
			//echo $sql . "<br>";
			return $resultado;
		}

		public function get_lembretes($usuario){
			$con = $this->conecta_mysql();
			$sql = "SELECT * FROM lembretes WHERE usuario = '$usuario' order by lembrete DESC";
			$resultado = mysqli_query($con, $sql);
			return $resultado;
		}

		public function altera_lembrete($ini, $fim, $id){
			$con = $this->conecta_mysql();
			$sql = "UPDATE lembretes set inicio='$ini', fim='$fim' where lembrete= $id";
			$resultado = mysqli_query($con, $sql);
			return $resultado;
		}
	}
	
	class telefones extends db{
		private $usuario;
		private $telefone;
		
		public function inserir($usuario, $telefones){
			$con = $this->conecta_mysql();
			if(isset($telefones)){
				foreach($telefones as $telefone){
					if($telefone == '') continue;
					$sql = "insert into telefones(usuario, telefone) values('$usuario','$telefone')";	
					if(mysqli_query($con, $sql)) {
						$_POST['mensagem'] = 1;// 'Telefone registrado com sucesso<br>';
					}
					else {
						$_POST['mensagem'] = "Errro ao registrar telefone - $telefone<br>";
						exit;
						//header('Location: index.php?result=3');
					}
				}	
			}
			//substitur por alert
		}
		
		public function listar_telefones_usuarios($busca){
			$con = $this->conecta_mysql();
			$sql = "SELECT setor, nome, telefone, email from usuarios JOIN telefones ON usuarios.usuario = telefones.usuario ";
			if(is_numeric($busca)){
				$sql .= "where telefones.telefone like '%$busca%' ";				
			} else{
				$sql .= "where usuarios.nome like '%$busca%' ";
			}
			$sql .= 'order by setor, nome ';
			//echo $sql."<br>";
			
			$resultado = mysqli_query($con, $sql);
			return $resultado;
		}

		public function apaga_telefones_usuario($usuario_id){
			$con = $this->conecta_mysql();
			$sql = "delete from telefones where usuario = " . $usuario_id;
			//echo $sql . '<br>';
			if(mysqli_query($con, $sql)){
				$_POST['mensagem'] = 1; //sucesso
			}else{
				//echo 'Erro ao apagar telefones.<br>';
				$_POST['mensagem'] = 'Erro ao apagar telefones.<br>';
			}
			//return $resultado;
		}
	}


?>



