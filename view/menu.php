<?php
session_start();

if(!isset($_SESSION) || !isset($_SESSION['codigo_empresa'])){
	echo "<script>location.href = '../index.php';</script>";
}
require_once "../model/empresa.class.php";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Área Administrativa</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
	<div class="col-md-12 topo">
    	<?php 
			if(isset($_SESSION)){
				$cnpjMask = "%s%s.%s%s%s.%s%s%s/%s%s%s%s-%s%s";
				$empresa = new Empresa;
				$cnpj = $empresa->format($cnpjMask, $_SESSION['cnpj_empresa']);
				echo $cnpj." - ".$_SESSION['nome_fantasia'];
            } else {
            	echo "Sessão não identificada...";
            }
		?>
    </div>
	<div class="container">
        <div class="col-md-3">
            <div class="row">
				<div class="panel-body">
                   	<div>
                    	<button class="btn btn-primary btn-opcao" id='bt-simulador'>Simulador</button>		<!-- botão temporário -->
                    </div>
                	<div>
                    	<button class="btn btn-primary btn-opcao" id='bt-relatorio_xml'>Relatório de XML</button>
                    </div>
                    <div>
                    	<button class="btn btn-primary btn-opcao" id="bt-exportacao_xml">Exportação de XML</button>
					</div>
<!--					<div>
                    	<button class="btn btn-primary btn-opcao" id="bt-exportacao_completa">Exportação Completa</button>
					</div>
-->
                    <div>
                    	<button class="btn btn-primary btn-opcao" id="bt-sair">Sair</button>
					</div>
				</div>
            </div>
        </div>
        <div class="col-md-9">
  		</div>      
        <div id="display"></div>
        </div>
	</div>
</body>
</html>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
