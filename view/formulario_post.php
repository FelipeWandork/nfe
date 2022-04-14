<?php
if(!isset($_SESSION) || !isset($_SESSION['codigo_empresa'])){
	echo "<script>location.href = '../index.php';</script>";
}
?>
?>
<div class="container">
        <div class="col-md-9" id="display">
            <form name="formulario_post" action="../controller/xml.ctrl.php" method="post" enctype="multipart/form-data">
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
                <textarea id="xml" name="xml" class="form-control" rows="5"></textarea>
            <br />    
                <input type="submit" class="btn btn-primary" value="Enviar" />
            </form>
        </div>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
