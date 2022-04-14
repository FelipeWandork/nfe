<?php
// require_once "classes/conexao.class.php";
// require_once "classes/bancodedados.class.php";
require_once "classes/xml.class.php";

// $conn = oci_new_connect('system','WDK123','localhost/teste');

// $conn = new Conexao;
// $db  = new BancoDeDados;

$xml  = new XML;

// $conn->conectar();

$arquivo = "nfe.xml";

$xml->lerArquivoXML($arquivo);

/*
$x = simplexml_load_file($arquivo);
foreach($x->nfeProc as $ide){
	echo $ide->serie;
}
*/

//$xml->lerArquivoXML($arquivo);


?>