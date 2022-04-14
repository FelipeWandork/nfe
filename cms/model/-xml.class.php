<?php
ini_set("default_charset","utf-8");
date_default_timezone_set("America/Sao_Paulo");
require_once "../model/bancodedados.class.php";
require_once "../model/datahora.class.php";
class XML {

	private $xml;
	private $md5Xml;
	private $codigoEmpresa;
	private $codigoPdv;
	private $nomeXml;
	private $tipoXml;
	private $dataEmissao;
	private $data_aut;
	private $hora_aut;
	private $numero_nota;
	private $valor_nota;
	private $cpf_cnpj;
	private $chaveNf;

	
	/*
	*  Recebe o conteúdo integral do método POST, desmembra e repassa os valores para o método verificarParametros():
	*   - codigo_empresa
	*   - codigo_pdv
	*   - xml
	*   - nome_xml
	*   - md5_xml
	*	Caso não encontre algum dos campos acima, grava a ocorrência na tabela de erros (LOG), descarta o POST e não retorna nada
	*/

	public function receberXml($post_xml){

		$bd = new BancoDeDados;
		$dh = new DataHora;
		$d = $dh->getData();
		$h = $dh->getHora();
		
		$this->setCodigoEmpresa($post_xml['codigo_empresa']);
		$this->setCodigoPdv($post_xml['codigo_pdv']);
		$this->setXml($post_xml['xml']);
		$this->setNomeXml($post_xml['nome_xml']);
		$this->setMd5Xml($post_xml['md5_xml']);
		echo $this->getMd5Xml();
		$this->desmembrarXml();
	}
	
/******************************************
//	Após receber o XML é lido o conteúdo do POST['xml'] para capturar o 'numero_nota', 'cpf_cnpj', 'valor_nota', 'data_emissao' e 'tipo_xml' // 
//  É necessário detectar o tipo pelo número do modelo do documento. Será implementado após encontrar uma tabela completa dos modelos //
*/

	public function desmembrarXml(){
		$xml  = simplexml_load_string($this->getXml());
		var_dump($xml);
		switch(property_exists($xml, "NFe")){
			
			// lê os campos da NF, faz as devidas verificações e guarda os valores nos atributos da classe
			case true:
				$this->setNumero_Nota((int)$xml->NFe->infNFe->ide->nNF);
				$this->setCpf_Cnpj(strval($xml->NFe->infNFe->dest->CNPJ));
				$this->setValor_Nota(floatval($xml->NFe->infNFe->total->ICMSTot->vNF));
				$this->setDataEmissao(strval($xml->NFe->infNFe->ide->dEmi));
				$this->setData_aut(substr(strval($xml->protNFe->infProt->dhRecbto),0,10));
				$this->setHora_aut(substr(strval($xml->protNFe->infProt->dhRecbto),11,8));
				$this->setChaveNf(strval($xml->protNFe->infProt->chNFe));
				$this->setTipoXml('1');
				$this->verificarParametrosNFe();
				break;
				
				
			// analisa o tipo de evento para saber se é Cancelamento ou Carta de Correção para direcionar o código
			case false:
				$evento = $xml->evento->detEvento->descEvento; // pegar o texto do campo descEvento
	echo $evento;
				$chnfe  = $xml->evento->infEvento->chNFe;      // pegar a chave da NFe original
				
				if($evento == "Cancelamento"){

					$tabela = "XMLS";
					
					$this->setTipoXml('2');
					$codigo_empresa = $bd->buscarNFe($tabela, $chnfe);
					$set    = "cancelado = 1";
					$where  = " WHERE codigo_empresa = ".$codigo_empresa;
					$bd->updateTabela($tabela, $set, $where);
				}
				if($evento == "Carta de Correcao"){
					$this->setTipoXml('3');
				}
				break;

			default:
				$codigo_erro = 300;
				$bd->gravarErro($this->getCodigoEmpresa(), $this->getCodigoPdv(), $this->getNomeXml(), $this->getXml(), $codigo_erro);
				break;
		}
	}


	/*
	*  Verificar se a EMPRESA é cadastrada na base de dados (se é nosso cliente)
	*  Verificar se o PDV é cadastrado na base de dados (se pertence ao cliente certo)
	*  Verificar se o valor da chave MD5 enviada pelo POST é o mesmo gerado código PHP
	*  Verificar se qual o tipo de XML esta sendo enviado (2->Cancelamento NF-e; 3-> Carta de Correção; 5->Cancelamento NFC-e)
	*/
	
	public function verificarParametrosNFe(){
		$bd = new BancoDeDados;
		$tabela = "XMLS";
		$bd->verificarDuplicidade($tabela, $this->getNumero_Nota()); // o próprio método verificarDuplicidade para a aplicação caso seja uma nota duplicada
		$st_empresa = $this->verificarEmpresa($bd,'empresas');       // enviando a instância do BancoDeDados e a tabela que será consultada
		$st_pdv 	= $this->verificarPdv($bd, 'pdvs');              // enviando a instância do BancoDeDados e a tabela que será consultada
		$st_md5		= $this->verificarMd5($bd);

		if($st_empresa && $st_pdv && $st_md5){
			$codigo_empresa = $this->getCodigoEmpresa();
			$codigo_pdv 	= $this->getCodigoPdv();
			$numero_nota 	= $this->getNumero_Nota();
			$cpf_cnpj 		= $this->getCpf_Cnpj();
			$tipo 			= $this->getTipoXml();
			$valor 			= str_replace(".",",",$this->getValor_Nota());
			$data			= $this->getDataEmissao();
			$data_aut		= $this->getData_aut();
			$hora_aut		= $this->getHora_aut();
			$cancelado 		= 0;
			$doc_original 	= "";
			$nome_xml 		= $this->getNomeXml();
			$xml 			= $this->getXml();
			$chave_nf		= $this->getChaveNf();
			
			$bd->inserirXml($tabela, $codigo_empresa, $numero_nota, $codigo_pdv, $cpf_cnpj,$tipo,$data,$hora_aut,$valor,$cancelado,$doc_original,$nome_xml, $xml, $data_aut, $chave_nf);
		}
	}
	
	private function verificarEmpresa($bd,$tabela){	
		$where = "WHERE codigo_empresa LIKE ".$this->getCodigoEmpresa();
		$order = "";
		$status = $bd->pesquisarTabela($tabela, $where, $order);
		if($status){
			return true;
		} else {
			exit; // A empresa não existe. Encerramento da aplicação sem retorno
		}
	}
	
	private function verificarPdv($bd,$tabela){
		$where = "WHERE codigo_empresa LIKE ".$this->getCodigoEmpresa()." AND codigo_pdv LIKE ".$this->getCodigoPdv();
		$order = "";
		$status = $bd->pesquisarTabela($tabela, $where, $order);
		if($status){
			return true;
		} else {
			$codigo_erro = 100;
			$bd->gravarErro($this->getCodigoEmpresa(), $this->getCodigoPdv(), $this->getNomeXml(), $this->getXml(), $codigo_erro);
			exit;
		}
	}
	
	private function verificarMd5($bd){
		echo "<br>MD5: ".md5($this->getXml())."<br><br>";
		if( $this->getMd5Xml() == md5($this->getXml())){
			return true;
		}else {
			echo $this->getMd5Xml()."<br>";
			echo md5($this->getXml())."<br>";
			$codigo_erro = 200;
			$bd->gravarErro($this->getCodigoEmpresa(), $this->getCodigoPdv(), $this->getNomeXml(), $this->getXml(), $codigo_erro);
			exit;
		}
	}
	
	/*	
	*	Métodos GETTERS e SETTERS
	*/

	public function setXml($xml){
		$this->xml = $xml;	
	}
	
	public function getXml(){
		return $this->xml;	
	}

	public function setNomeXml($nome_xml){
		$this->nomeXml = $nome_xml;	
	}
	
	public function getNomeXml(){
		return $this->nomeXml;	
	}
	
	public function setMd5Xml($md5_xml){
		$this->md5Xml = $md5_xml;	
	}
	
	public function getMd5Xml(){
		return $this->md5Xml;	
	}
	
	public function setCodigoEmpresa($codigo_empresa){
		$this->codigoEmpresa = $codigo_empresa;	
	}
	
	public function getCodigoEmpresa(){
		return $this->codigoEmpresa;	
	}

	public function setCodigoPdv($codigo_pdv){
		$this->codigoPdv = $codigo_pdv;	
	}
	
	public function getCodigoPdv(){
		return $this->codigoPdv;	
	}
	
	public function setTipoXml($tipo_xml){
		$this->tipoXml = $tipo_xml;	
	}
	
	public function getTipoXml(){
		return $this->tipoXml;	
	}

	public function setNumero_Nota($numero_nota){
		$this->numero_nota = $numero_nota;
	}
	
	public function getNumero_Nota(){
		return $this->numero_nota;
	}
					
	public function setCpf_Cnpj($cpf_cnpj){
		$this->cpf_cnpf = $cpf_cnpj;
	}
	
	public function getCpf_Cnpj(){
		return $this->cpf_cnpf;
	}
					
	public function setValor_Nota($valor_nota){
		$this->valor_nota = $valor_nota;
	}
					
	public function getValor_Nota(){
		return $this->valor_nota;
	}

	public function setDataEmissao($data_emissao){
		$this->dataEmissao = $data_emissao;
	}
					
	public function getDataEmissao(){
		return $this->dataEmissao;
	}
	
	public function setData_aut($data_aut){
		$this->data_aut = $data_aut;
	}
					
	public function getData_aut(){
		return $this->data_aut;
	}

	public function setHora_aut($hora_aut){
		$this->hora_aut = $hora_aut;
	}
					
	public function getHora_aut(){
		return $this->hora_aut;
	}

	public function setChaveNf($chave_nf){
		$this->chaveNf = $chave_nf;
	}
					
	public function getChaveNf(){
		return $this->chaveNf;
	}
	
	
}


