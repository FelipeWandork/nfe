<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Área Administrativa</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/estilos.css" rel="stylesheet">
	
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/scripts.js"></script>
</head>
<body>
	<div class="container">
     <div class="row vertical-center">
		<div class="col-md-6 col-md-offset-3">
		<div id="resposta"></div>
			<form id='form_login'>
				<div class="panel panel-success">
					<div class="panel-heading">Acesso restrito</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="cnpj">CNPJ</label>
							<input type="cnpj" id="cnpj" name="cnpj" class="form-control">
						</div>
						<div class="form-group">
							<label for="senha">Senha</label>
							<input type="password" id="senha" name="senha" class="form-control">
						</div>
						<button class="btn btn-success pull-right">Login</button>
					</div>
				</div>
			</form>
		</div>
    </div>
	</div>
</body>
</html>