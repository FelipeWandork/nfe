<?php
require_once "bancodedados.class.php";
require_once "datahora.class.php";
require_once "../controller/relatorios.ctrl.php";
class Empresa {

// ????? analisar a necessidade
private $codigo_empresa;
private $cnpj_empresa;
private $razao_social;
private $nome_fantasia;
private $senha;
private $email;


	
	public function simularPost(){
/*		$arquivo = fopen("../view/formulario_post.php","r");
		while(!feof($arquivo)){
			echo fgets($arquivo);
		}
		fclose($arquivo);
*/
		require_once "../view/formulario_post.php";	
	}
	
	public function gerarRelatorio(){
		$bd = new BancoDeDados;
		$conteudo = "*";
		$tabela   = "XMLS";
		$where    = "WHERE codigo_empresa LIKE ".$_SESSION['codigo_empresa'];
		$order    = "";	
		$resultado = $bd->consultarDados($tabela, $conteudo, $where, $order);
		return $resultado;
	}
	
	public function exportarXml($numero_nfe){
		if(empty($numero_nfe)){
			require_once "../view/exportacao_xml.php";
		} else {
			$bd = new BancoDeDados;
			$conteudo = "*";
			$tabela   = "XMLS";
			$where    = "WHERE numero LIKE ".$numero_nfe." AND codigo_empresa LIKE ".$_SESSION['codigo_empresa'];
			$order    = "";	
			$resultado = $bd->consultarDados($tabela, $conteudo, $where, $order);
			$path = "../exportacao/".$_SESSION['codigo_empresa']."/";
			if(!file_exists($path)){
				if(!mkdir($path)){
					echo "Erro ao criar diretório ".$path;
				}
			}
			
			echo count($resultado);
			
			// Gerando o arquivo XML para download
			while($r = oci_fetch_array($resultado,OCI_ASSOC)){
				$nome_xml	= $r['NOME_XML'];
				$xml 		= $r['XML']->load();
				$arquivo 	= fopen($path.$nome_xml, 'w+');
				fwrite($arquivo,$xml);
				fclose($arquivo);
			}
		}
	}
	
	public function exportarCompleta(){
		$bd  = new BancoDeDados;
		$conteudo = "*";
		$tabela   = "XMLS";
		$where    = "WHERE codigo_empresa LIKE ".$_SESSION['codigo_empresa'];
		$order	  = "";
		$resultado = $bd->consultarDados($tabela, $conteudo, $where, $order);
		$path = "../exportacao/".$_SESSION['codigo_empresa']."/";
		if(!file_exists($path)){
			if(!mkdir($path)){
				echo "Erro ao criar diretório ".$path;
			}
		}
		$path = $path."zip/";
		if(!file_exists($path)){
			if(!mkdir($path)){
				echo "Erro ao criar diretório ".$path;
			}
		}

		while($r = oci_fetch_array($resultado,OCI_ASSOC)){
			$nome_xml	= $r['NOME_XML'];
			$xml 		= $r['XML']->load();
			$arquivo 	= fopen($path.$nome_xml, 'w+');
			fwrite($arquivo,$xml);
			fclose($arquivo);
		}
		return $path;
	}
		
	public function compactarArquivos($path){
		$datahora = new DataHora;
		$arquivo_zip = $datahora->getData()." - ".$_SESSION['cnpj_empresa'].".zip";
		$diretorio = dir($path);
		$arquivos  = array();
		while($arquivo = $diretorio -> read()){
			if($arquivo != '.' && $arquivo != '..'){
				$arquivos[] = $arquivo;
			}
		}
		if(count($arquivos)){
			$zip = new ZipArchive;
			if($zip->open($path.$arquivo_zip, ZipArchive::CREATE)){
				foreach($arquivos as $arquivo){
					if(strrchr($arquivo, ".") == ".xml"){
						$zip->addFile($path.$arquivo, $arquivo);
					}
				}
			} else {
				echo "Arquivo ZIP <strong>não</strong> criado!";	
			}
			$zip->close();
		}
		array_map('unlink', glob($path.'*.xml'));
	}


	function format($mask,$string){
		return  vsprintf($mask, str_split($string));
	}
	
	
}

?>
