<?php
ini_set("default_charset","utf-8");
date_default_timezone_set("America/Sao_Paulo");

require_once "../model/xml.class.php";
require_once "../model/datahora.class.php";

function verificarPost(){
	$status = false;
	$i = 0;
	if(!empty($_POST)){
		foreach($_POST as $campo=>$valor){

			// verificando se todos os campos estão presentes no $_POST
			// a classe só será instanciada, caso os parâmetros estejam todos presentes
			if(($campo == 'codigo_empresa') or ($campo == 'codigo_pdv') or ($campo == 'xml') or ($campo == 'nome_xml') or ($campo == 'md5_xml')) {
				$status = true;
			} else {
				// registrar em log  .txt e abortar
				$arquivo = "logs/erro_campoausente.txt";
				gravarErro($arquivo,$campo);
				$status = false;
				break;
			}
		}
	} else {
		// condição temporária.... else desnecessário
		echo "Nenhum um post enviado!";	
	}

	// se algum campo não for válido aborta o script sem retorno, caso contrário instancia a classe e chama o primeiro método
	if ($status == false) {
		exit;
	} else {
		$xmlclass = new XML;
		$r = $xmlclass->receberXml($_POST);
		echo $r;
	}
}
	// FUNCIONANDO
function gravarErro($arquivo, $campo){
	$datahora = new DataHora;
	$dh = $datahora->getData()." - ".$datahora->getHora();
	$arquivo = 	fopen($arquivo,'a');
	fwrite($arquivo, $dh." => Campo [".$campo."] do POST é desconhecido \r\n");
	fclose($arquivo);
}

verificarPost();