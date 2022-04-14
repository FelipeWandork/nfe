<?php
//header('Content-Type: application/json; charset=utf-8');
// Controller de relatórios que responde a uma chamada Ajax do arquivo scripts.js
require_once "../model/bancodedados.class.php";

function relatorioDescendente(){
	$bd = new BancoDeDados;
	$conexao = $bd->conectar();
	$conteudo = "codigo_empresa, numero, codigo_pdv, cpf_cnpj, tipo, data, hora_aut, valor, cancelado, doc_original, nome_xml, xml, data_aut, chave_nf";
	$tabela   = "XMLS";
	$where    = "WHERE codigo_empresa LIKE ".$_SESSION['codigo_empresa'];
	$order    = "ORDER BY DATA ASC";
	$relatorio = $bd->consultarDados($tabela, $conteudo, $where, $order);
	return $relatorio;		
}

function exportarXML($chave){
		
}