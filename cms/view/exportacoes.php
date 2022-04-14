<div class="col-md-8">
    <form name="formulario_exportacoes" action="../controller/exportacoes.ctrl.php" method="post">
		<div class="col-md-6">
			<select class='form-control'>
                <option>Selecione a empresa...</option>
			</select>
		</div>
        <div class="col-md-6">
            <div class="input-group">
                <input id='numero_nfe' name="numero_nfe" type="number" class='input form-control' placeholder='Número da NFe'>
                <div class="input-group-btn">
                    <button id="bt-buscar-nfe" type="button" class="btn btn-default">Buscar</button>
                </div>
            </div>
		</div>
	</form>
</div>
<div class="col-md-4"></div>
<div class="col-md-12" id="display-relatorios"></div>
<script src="../js/jquery.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
