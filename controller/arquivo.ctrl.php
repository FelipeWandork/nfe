<?php
//header('Content-Type: application/json');

function lerArquivo($arquivo){
	$xml  = utf8_encode(file_get_contents($arquivo['tmp_name']));
	$nome = $arquivo['name'];
	$md5 = md5($xml);
	$json_array = array('nome'=>$nome,'xml'=>$xml,'md5'=>$md5);
	$json = json_encode($json_array);
	echo $json;
}

switch ($_GET['f']) {
	case 'ler':
		lerArquivo($_FILES['arquivo']);
		break;
}