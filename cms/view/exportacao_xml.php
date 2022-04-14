<?php

?>
<div id="display-arquivos" class="col-md-9">
		<form name="formulario_exportacao" action="../controller/xml.ctrl.php" method="post">
			<div class="col-md-4">
            	<div class="input-group">
                    <input id='numero_nfe' name="numero_nfe" type="number" class='input form-control' placeholder='Número da NFe'>
                    <div class="input-group-btn">
	                    <button id="bt-selecionar-nfe" type="button" class="btn btn-default">Buscar</button>
					</div>
                </div>
            </div>
            <div class="col-md-6">
            	<button id="bt-exportar-massa" type="button" class="btn btn-default">Exportação em Massa</button>
            </div>
		</form>
</div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
