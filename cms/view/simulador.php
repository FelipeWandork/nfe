<div class="col-md-9" "display-simulador">
            <form name="formulario_post" action="/nfe/controller/xml.ctrl.php" method="post" enctype="multipart/form-data">
                <label for="arquivo">Selecione o arquivo XML</label>
                <input id="arquivo" name="arquivo" type="file" class="form-control" />
                
                <label for="codigo_empresa">Código da Empresa</label>
                <input name="codigo_empresa" class="input form-control"/>

                <label for="codigo_pdv">Código do PDV</label>
                <input name="codigo_pdv" class="input form-control" />

                <label for="nome_xml">Nome do Arquivo XML</label>
                <input id='nome_xml' name="nome_xml" class="input form-control" />

                <label for="md5_xml">Chave MD5 do XML</label>
                <input name="md5_xml" class="input form-control"/>
            <br />
                <textarea id="xml" name="xml" class="form-control" rows="5"></textarea>
            <br />    
                <input type="submit" class="btn btn-primary" value="Enviar" />
            </form>
</div>
<script src="/nfe/js/jquery.min.js"></script>
<script src="/nfe/js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
