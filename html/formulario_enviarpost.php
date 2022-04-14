<?php

	if(!isset($_SESSION['status'])){
		echo "<script>location.href = 'index.php';</script>";
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/scripts.js"></script>
</head>

<body>
<div class="col-md-9">
<h3>Formulário de Simulação de Envio do XML</h3>
<span id="resposta"></span>
<form name="formulario" action="main.php" method="post" enctype="multipart/form-data">
	<label for="arquivo">Selecione o arquivo XML</label>
    <input id="arquivo" name="arquivo" type="file" class="form-control" />
    
	<label for="codigo_empresa">Código da Empresa</label>
    <input name="codigo_empresa" class="input form-control"/>
<br />
	<label for="codigo_pdv">Código do PDV</label>
    <input name="codigo_pdv" class="input form-control" />
<br />
	<label for="nome_xml">Nome do Arquivo XML</label>
    <input id='nome_xml' name="nome_xml" class="input form-control" />
<br />
	<label for="md5_xml">Chave MD5 do XML</label>
    <input name="md5_xml" class="input form-control"/>
<br />
	<label for="xml">Conteúdo do XML</label>
    <label for="md5">MD5 do conteúdo XML: </label>
<br />    
    <textarea id="xml" name="xml" class="form-control" rows="5"></textarea>
<br />    
    <input type="submit" class="btn btn-primary" value="Enviar" />
</form>
</div>
</body>
</html>