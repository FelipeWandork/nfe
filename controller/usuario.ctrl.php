<?php
/*
// Arquivo de controle de dados entre a camada VIEW e a classe usuario.class.php da camada MODEL
*/

function criticarLogin($login){
	if(!preg_match("/^[0-9]{14}$/",$login['cnpj'])){
		// lançar tentativa de acesso na tabela de erros de acesso
		echo "Tentativa de acesso inválida registrada!";
		return false;
	} else {
		return true;	
	}
}

if(criticarLogin($_POST)){
	
	require_once "../model/usuario.class.php";
	$usuario = new Usuario;
	
		$login = $usuario->verificarUsuario($_POST['cnpj'], $_POST['senha']);
		if($login){
			echo "<script>location.href = 'view/menu.php';</script>";
		} else {
			echo "Usuário não autorizado!";
		}
}