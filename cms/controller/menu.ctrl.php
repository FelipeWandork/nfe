<?php
$opcao = $_POST['opcao'];
switch ($opcao){
	case "simulador":
		require_once "../view/simulador.php";
		break;	
	case "cadastro":
		require_once "../view/cadastro.php";
		break;
	case "relatorios":
		require_once "../view/relatorios.php";
		break;
	case "exportacoes":
		require_once "../view/exportacoes.php";
		break;
	case "sair":
		require_once "../controller/logout.ctrl.php";
		break;
}