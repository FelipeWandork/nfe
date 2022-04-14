<?php
ini_set("default_charset","utf-8");
date_default_timezone_set("America/Sao_Paulo");

require_once "datahora.class.php";

class BancoDeDados {
	private $usuario = "system";
	private $senha   = "BDxml$2016";
	private $idXml;


	public function conectar(){
		$conexao = oci_connect($this->usuario, $this->senha);
		if(!$conexao){
			$e = oci_error();
			echo $e['message'];	
		} else {
			return $conexao;
		}
	}
	public function consultarDados($tabela, $conteudo, $where, $order){
		$conexao = $this->conectar();
//		echo "SELECT ".$conteudo." FROM ".$tabela." ".$where." ".$order;
		$parse = oci_parse($conexao, "SELECT ".$conteudo." FROM ".$tabela." ".$where." ".$order);

		if(!oci_execute($parse)){
			$e = oci_error;
			echo $e['sqltext'];
		} else {
			return $parse;
		}
		oci_close($conexao);
	}
	
	public function pesquisarTabela($tabela, $where, $order){
		$conexao = $this->conectar();
		$busca = oci_parse($conexao, "SELECT 'codigo_empresa', COUNT(*) FROM ".$tabela." ".$where." ".$order);
		if(!oci_execute($busca)){
			$e = oci_error;
			echo $e['message'];
		} else {
			$row = oci_fetch_array($busca);
			if($row[1] > 0) {
				$this->setIdXml($row[0]);
				return TRUE;	
			} else {
				return FALSE;	
			}
		}
		oci_close($conexao);
	}
	
	public function updateTabela($tabela, $set, $where){
		$conexao = $this->conectar();
		$update = oci_parse($conexao, "UPDATE ".$tabela." SET ".$set." ".$where);
		if(!oci_execute($update)){
			$e = oci_error;
			echo $e['messagem'];	
		}
		oci_close($conexao);	
	}
/*
	public function inserirTabela($tabela, $campos, $valores, $mensagem_ok){
		$conexao = $this->conectar();	
		
		$parse = oci_parse($conexao, "INSERT INTO ".$tabela." (".$campos.") VALUES (".$valores.")");
		if(!oci_execute($parse)){
			$e = oci_error();
			echo $e['sqltext'];
		} else {
			echo $mensagem_ok;	
		}
		oci_close($conexao);
	}
*/
	
	public function inserirXml($tabela, $codigo_empresa, $numero_nota, $codigo_pdv, $cpf_cnpj, $tipo, $data, $hora_aut, $valor, $cancelado, $doc_original, $nome_xml, $xml, $data_aut, $chave_nf){
/*		$data = "2016-07-15 06:30:10";
		$data_aut = "2016-07-14 18:30:10";
		$hora_aut = "19:30:10";
*/
		$conexao = $this->conectar();
		$sql = "INSERT INTO ".$tabela." (codigo_empresa, numero, chave_nf, codigo_pdv, cpf_cnpj, tipo, data, data_aut, hora_aut, valor, cancelado, doc_original, nome_xml, xml) VALUES (:codigo_empresa, :numero_nota, :chave_nf, :codigo_pdv, :cpf_cnpj, :tipo, to_date(:data,'yyyy-mm-dd hh24:mi:ss'), to_date(:data_aut,'yyyy-mm-dd hh24:mi:ss'), :hora_aut, :valor, :cancelado, :doc_original, :nome_xml, EMPTY_CLOB()) RETURNING xml INTO :xml";
		$parse = oci_parse($conexao, $sql);
		$xml_clob = oci_new_descriptor($conexao, OCI_D_LOB);
		oci_bind_by_name($parse, ":codigo_empresa", $codigo_empresa, -1);
		oci_bind_by_name($parse, ":numero_nota", $numero_nota, -1);
		oci_bind_by_name($parse, ":chave_nf", $chave_nf, -1);
		oci_bind_by_name($parse, ":codigo_pdv", $codigo_pdv, -1);
		oci_bind_by_name($parse, ":cpf_cnpj", $cpf_cnpj, -1);
		oci_bind_by_name($parse, ":tipo", $tipo, -1);
		oci_bind_by_name($parse, ":data", $data, -1);
		oci_bind_by_name($parse, ":data_aut", $data_aut, -1);
		oci_bind_by_name($parse, ":hora_aut", $hora_aut, -1);
		oci_bind_by_name($parse, ":valor", $valor, -1);
		oci_bind_by_name($parse, ":cancelado", $cancelado, -1);
		oci_bind_by_name($parse, ":doc_original", $doc_original, -1);
		oci_bind_by_name($parse, ":nome_xml", $nome_xml, -1);
		oci_bind_by_name($parse, ":xml", $xml_clob, -1, OCI_B_CLOB);
		$r = oci_execute($parse, OCI_NO_AUTO_COMMIT);
		$xml_clob->save($xml);
		$e = oci_error($parse);
//		echo $e['offset']." => ".$e['message'];
		oci_commit($conexao);
		return "0";
	}

	public function gravarErro($codigo_empresa, $codigo_pdv, $nome_xml, $xml, $codigo_erro){
		$conexao = $this->conectar();
		$datahora = new DataHora;
		$data = $datahora->getData();
		$hora = $datahora->getHora();

		$sql = "INSERT INTO erros (codigo_empresa, codigo_pdv, erro, data, hora, nome_xml, xml) VALUES (:codigo_empresa, :codigo_pdv, :erro, :data, :hora, :nome_xml, EMPTY_CLOB()) RETURNING xml INTO :xml";

		$parse = oci_parse($conexao, $sql);
		$xml_clob = oci_new_descriptor($conexao, OCI_D_LOB);
		oci_bind_by_name($parse, ":codigo_empresa", $codigo_empresa, -1);
		oci_bind_by_name($parse, ":codigo_pdv", $codigo_pdv, -1);
		oci_bind_by_name($parse, ":erro", $codigo_erro, -1);
		oci_bind_by_name($parse, ":data", $data, -1);
		oci_bind_by_name($parse, ":hora", $hora, -1);
		oci_bind_by_name($parse, ":nome_xml", $nome_xml, -1);
		oci_bind_by_name($parse, ":xml", $xml_clob, -1, OCI_B_CLOB);
		oci_execute($parse, OCI_DEFAULT);
		$xml_clob->save($xml);
		oci_commit($conexao);	
	}

	public function verificarDuplicidade($tabela, $numero_nota){
		$where = " WHERE numero = ".$numero_nota;
		$order = "";
		if($this->pesquisarTabela($tabela,$where,$order)){
			exit;
		};
	}
	
	public function buscarNFe($tabela, $chnef){
		$where = " WHERE chave_nf = ".$chnef;
		$order = "";
		if($this->pesquisarTabela($tabela, $where, $order)){
			return $this->getIdXml();
		}
			
	}
	
	public function setIdXml($idxml){
		$this->idXml = $idxml;	
	}
	
	public function getIdXml(){
		return $this->idXml;	
	}
}

//$teste = new BancoDeDados;