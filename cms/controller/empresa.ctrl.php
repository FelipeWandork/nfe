<?php
if(isset($_POST)){
	$nome_fantasia	= $_POST['nome_fantasia'];
	$razao_social	= $_POST['razao_social'];
	$cnpj			= $_POST['cnpj'];
	$senha			= $_POST['senha'];
	$senha2			= $_POST['senha2'];

if(!empty($nome_fantasia) && !empty($razao_social) && !empty($cnpj) && !empty($senha) && !empty($senha2)){
	if($senha === $senha2){
		
	} else {
		echo "As senhas não conferem!";
	}
} else {
	echo "Todos os campos devem ser preenchidos!";	
}
}