<?php
session_start();
require_once "../model/empresa.class.php";
$empresa = new Empresa;

if(isset($_POST)){
	switch($_POST['p']){
		case "simulador":
			$empresa->simularPost();
			break;
	
		case "relatorio":
			$resultado = $empresa->gerarRelatorio();
			
			$tabela  = "<div class='table-responsive'>";
			$tabela .= "<table class='table table-hover'>";
			$tabela .= "<thead>Relatório das NFe</thead>";
			$tabela .= "<tr><th>#</th><th>PDV</th><th>DATA</th><th>VALOR</th><th>CANCELADO</th></tr>";
			$tabela .= "<tbody>";

			while($registro = oci_fetch_array($resultado)){
//				$valor = number_format($registro[7],'2');
				$tabela .= "<tr><td>".$registro[1]."</td><td>".$registro[2]."</td><td>".$registro[5]."</td><td>R$ ".$registro[7]."</td><td>".$registro[8]."</td></tr>";
			}
			
			$tabela .= "</tbody></table></div>";
			echo $tabela;
			break;
		
		case "exportacaoxml":
			$path = "../exportacao/".$_SESSION['codigo_empresa']."/";
			$diretorio = dir($path);
			if(isset($_POST['numero_nfe'])){
				$empresa->exportarXml($_POST['numero_nfe']);
				// Listando os arquivos do diretório de exportação em ordem decrescente de data
				echo "Arquivos do diretório '<strong>".$path."</strong>':<br />";
					$tabela  = "<table class='table table-responsive'>";
					$tabela .= "<thead><th>Download</th><th>Arquivos</th></thead>";
					$tabela .= "<tbody>";

				while($arquivo = $diretorio -> read()){
					if($arquivo != '.' && $arquivo != '..' && $arquivo != 'zip'){
						$tabela .= "<tr><td><a href='".$path.$arquivo."' download><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span></a></td>";
						$tabela .= "<td>".$arquivo."</td></tr>";
					}
				}
				$tabela .= "</tbody></table>";
				echo $tabela;
				$diretorio -> close();
			} else {
				$empresa->exportarXml("");	
			}
			break;

		case "exportacaocompleta":
			$path = $empresa->exportarCompleta();
			$empresa->compactarArquivos($path);
			if(file_exists($path)){
				$tabela  = "<table class='table table-responsive'>";
				$tabela .= "<thead><th>Download</th><th>Arquivos</th></thead>";
				$tabela .= "<tbody>";
				$diretorio = dir($path);
				while($arquivo_zip = $diretorio->read()){
					if($arquivo_zip != '.' && $arquivo_zip != '..'){
						$tabela .= "<tr><td><a href='".$path.$arquivo_zip."' download><span class='glyphicon glyphicon-download-alt' aria-hidden='true'></span></a></td>";
						$tabela .= "<td>".$arquivo_zip."</td></tr>";
					}
				}
				echo $tabela;
			}
			break;
	}
}