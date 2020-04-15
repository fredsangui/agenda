<?php
	class db{
		//host
		private $host = 'localhost';
		//usuario
		private $usuario = 'root';
		//semha
		private $senha = '';
		//nome bd
		private $database = 'agenda';
		
		public function conecta_mysql(){
			$con = mysqli_connect($this->host, $this->usuario, $this->senha, $this->database);
			
			//Ajusta o charset para a comunicação entre a aplicação e o BD
			mysqli_set_charset($con, 'utf8');
			
			if(mysqli_connect_error()){
				echo 'Tentei conectar com o Banco de Dados mas não deu.' . mysqli_connect_error();	
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
		
		public function __construct(){}
		
		function usuarios_parametros($nome, $senha, $telefone, $email, $setor){//
			$obj = new usuarios();
			$obj->nome = $nome;
			$obj->senha = $senha;
			$obj->telefone = $telefone;
			$obj->email = $email;
			$obj->setor = $setor;
			return $obj;
		}
		
		public function inserir(){
			//$dbc = new db();
			//echo "debugando entrada <br><br>$this->nome<br>$this->senha<br>$this->telefone<br>$this->email<br>$this->setor = $this->setor<br><br>";
			
			//verifica se nome ja existe / seleciona proximo id de usuario
			$sql = "select max(usuario)+1 from usuarios union select usuario FROM usuarios WHERE nome = '$this->nome' ";
			$con = $this->conecta_mysql();
			$resultado = mysqli_query($con, $sql);
			$proximo = mysqli_fetch_array($resultado);
			$id_usuario = $proximo[0];
			
			$existe = mysqli_fetch_array($resultado);
			if(isset($existe[0])){
				echo 'Existe outro usuario cadastrado com esse nome.<br>';
				header("refresh: 6;inscrevase.php");
				die;
			}
			//unset($existe[0]);			
			
			// $sql = "select count(usuario) from usuarios where nome = '$this->nome' group by usuario";
			// $resultado = mysqli_query($con, $sql);
			// $id_usuario = mysqli_fetch_array($resultado);			
			// if($id_usuario[0] != 0){
				// echo 'Nome do usuario já está cadastrado.<br>';
				// echo "<button class='btn btn-primary form-control' onClick=\"window.location = 'http://localhost/twitter_clone/inscrevase.php'\">Voltar</button>";
				// exit;
			// }
			
			$sql = "insert into usuarios(nome, senha, email, setor) values('$this->nome', '$this->senha', '$this->email', '$this->setor') ";
			
			if(mysqli_query($con, $sql)){
				echo 'Usuário cadastrado com sucesso!!!<br>';
			}else{
				echo 'Erro ao inserir registro de usuario<br>';
				echo "<button class='btn btn-primary form-control' onClick=\"window.location = 'http://localhost/twitter_clone/inscrevase.php'\">Voltar</button>";
				exit;
			}
			////Não permitir usuarios de mesmo nome
			// $sql = "select usuario, count(usuario) as n_usuarios from usuarios where nome = '$this->nome' group by usuario";
			// $resultado = mysqli_query($con, $sql);
			// if($resultado){
				// $id_usuario = mysqli_fetch_array($resultado);
				////if($id_usuario['n_usuarios'] > 1)
				// echo "Consulta: $sql<br>Registro retornou valor: $id_usuario[0]<br/>";
				// var_dump($id_usuario[0]);
				// $tel = new telefones();
				// $tel->inserir($id_usuario[0],  $this->telefone);				
			// }
			$tel = new telefones();
			$tel->inserir($id_usuario,  $this->telefone);
		}
		
		public function autentica_usuario($nome, $senha){
			$con = $this->conecta_mysql();
			$sql = "select usuario, nome, senha, email, endereco from usuarios where nome = '$nome'";
			$resultado = mysqli_query($con, $sql);
			//$dados = $resultado ? mysqli_fetch_array($resultado) : False;
			if($resultado){
				$dados = mysqli_fetch_array($resultado);
				if($dados['senha'] == $senha){
					return $dados;//senha incorreta 
				} else if(isset($dados['nome'])) return 3;
			}else return False;
		}		
	}
	
	class telefones{
		private $usuario;
		private $telefone;
		
		public function inserir(int $usuario, $telefones){
			$dbc = new db();
			$con = $dbc->conecta_mysql();
			foreach($telefones as $telefone){
				if($telefone == '') continue;
				$sql = "insert into telefones(usuario, telefone) values('$usuario','$telefone')";	
				if(mysqli_query($con, $sql)) {
					echo 'Telefone registrado com sucesso<br>';
				}
				else {
					echo "Errro ao registrar telefone - $telefone<br>";
				}
			}
			//substitur por alert
		}
		
		public function listar_telefones_usuarios($busca){
			$dbc = new db();
			$con = $dbc->conecta_mysql();
			$sql = "SELECT setor, nome, telefone from usuarios JOIN telefones ON usuarios.usuario = telefones.usuario ";
			if(is_numeric($busca)){
				$sql .= "where telefones.telefone like '%$busca%' ";				
			} else{
				$sql .= "where usuarios.nome like '%$busca%' ";
			}
			$sql .= 'order by setor, nome ';
			//echo $sql;
			
			$resultado = mysqli_query($con, $sql);
			return $resultado;
		}
	}


?>



