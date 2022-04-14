<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
    <title>Notícias Dev Media</title>
</head>
<body>
	<h1>Notícias Dev Media</h1>
		<?php
//        	$link = "http://www.devmedia.com.br/xml/devmedia_full.xml"; //link do arquivo xml
//			$link = "../arquivos/NFE/33141107433945000146550010002688081002923824-nfe.xml"; //link do arquivo xml - NFE
			$link = "../arquivos/CANCELADAS/110111331209074339450001465500100011604010004_cancelada.xml"; //link do arquivo xml - CANCELADA
//			$link = "../arquivos/CARTADECORRECAO/110110331309074339450001465500100016372610016.xml"; //link do arquivo xml - CARTA DE CORREÇÃO
//			$xml = simplexml_load_file($link)->NFe->infNFe; //carrega o arquivo XML e retornando um Array
			$xml = simplexml_load_file($link); //carrega o arquivo XML e retornando um Array
//
			 isset($xml->evento->infEvento->detEvento->descEvento) ? "Sim" : "Não";

			
/*			foreach($xml ->det->children() as $tag => $valor){
				foreach($xml->det->$tag->children() as $detalhe => $valor){
					echo $detalhe." = ".$valor."<br>";
				}
			}
						
			
			
/*			foreach($xml -> ide as $ide){
				//faz o loop nas tag com o nome "item"
				//exibe o valor das tags que estão dentro da tag "item"
				//utilizamos a função "utf8_decode" para exibir os caracteres corretamente
				echo "<strong>Título:</strong> ".utf8_decode($ide -> cUF)."<br />";
				echo "<strong>Link:</strong> ".utf8_decode($ide -> cNF)."<br />";
				echo "<strong>Descrição:</strong> ".utf8_decode($ide -> natOp)."<br />";
				echo "<strong>Autor:</strong> ".utf8_decode($ide -> indPag)."<br />";
				echo "<strong>Data:</strong> ".utf8_decode($ide -> dhEmi)."<br />";
				echo "<br />";
			} //fim do foreach
*/		
		?>
</body>
</html>

<!-- Leia mais em: PHP XML: Lendo arquivos XML com PHP http://www.devmedia.com.br/lendo-arquivos-xml-com-php/17791#ixzz47PFjz91t -->