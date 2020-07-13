<?php
	session_start();
    if(!isset($_SESSION['usuario']))
        header('Location: index.php?erro=1');
    include_once("db_class.php");    
    $usuario = $_SESSION['usuario'];
    $telefones = new telefones;
    $list_telefones = $telefones->listar_telefones_usuarios($usuario);
    //listar_telefones_usuarios($busca) 
    $cont = 0;
    
    while($dados = mysqli_fetch_array($list_telefones)){
        $tel = $dados['telefone'];
        $n_telefone = 'telefone' . $cont;
        //div_telefones = document.getElementById("telefones_ad"); 
        $adicionar = '<div class="input-group form-group" id="tel_list'. $cont .'">';
        $adicionar .= '<input type="number" class="form-control" id="'. $n_telefone;
        $adicionar .= '" placeholder="'.$n_telefone.'" name="telefone[]" value='.$tel.'>';
        $adicionar .= "<span class = 'input-group-btn'>";
        if($cont == 0){//inclui btn add no primeiro campo 
            //$setor = $dados['setor'];
            //$email = $dados['email'];
            $adicionar .= '<button class="btn btn-primary" id="btn_adicionar" type="button"><strong>+</strong></button>';
        }else $adicionar .= '<button class="apaga_tel btn btn-danger" id="tel_list'. $cont .'" type="button"><strong>-</strong></button>';
        $adicionar .= "</span>";
        $adicionar .= '</div>';
        echo $adicionar;
        $cont++;
    }
    if($cont == 0){
        $tel = $dados['telefone'];
        $n_telefone = 'telefone0' . $cont;
        //div_telefones = document.getElementById("telefones_ad"); 
        $adicionar = '<div class="input-group form-group" id="tel_list0">';
        $adicionar .= '<input type="number" class="form-control" id="telefone0"';
        $adicionar .= 'placeholder="telefone0" name="telefone[]" >';
        $adicionar .= "<span class = 'input-group-btn'>";
        $adicionar .= '<button class="btn btn-primary" id="btn_adicionar" type="button"><strong>+</strong></button>';
        $adicionar .= "</span>";
        $adicionar .= '</div>';
        echo $adicionar;
        $cont++;
    }
    $cont--;
    echo "<input type='hidden' id='cont_tell' name='cont_tell' value=$cont>";

    //$_SESSION['setor'] = $setor;
    //$_SESSION['email'] = $email;


    
?>