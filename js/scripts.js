$(document).ready(function(){

// VERIFICA SE USUÁRIO ESTÁ CADASTRADO E DIRECIONA PARA A PÁGINA principal.php
	$('#form_login').submit(function(){
		var dados = $(this).serialize();
		$.ajax({
			type: "post",
			url: "controller/usuario.ctrl.php?p=login",
			data: dados,
			success: function(data){
				if(data == 1){
					$(location).attr('href','principal.php');
					$('.panel-body').find('.link_relatorio');
				} else {
					$("#resposta").html(data);
				}
			}
		});
		return false;
	});
	
// ouvintes dos eventos da página menu.php
	$('#bt-simulador').click(function(){
		$.ajax({
			type: "post",
			url: "../controller/menu.ctrl.php",
			data: {'p':'simulador'},
			success: function(data){
				$("#display").html(data);
				$("#display").find("*");
			}
		});
		return false;
	});
	
	$('#bt-relatorio_xml').click(function(){
		$.ajax({
			type: "post",
			url: "../controller/menu.ctrl.php",
			data: {'p':'relatorio'},
			success: function(data){
				$("#display").html(data);
				$("#display").find("*");
			}
		});
		return false;
	});
	
	$('#bt-exportacao_xml').click(function(){
		$.ajax({
			type: "post",
			url: "../controller/menu.ctrl.php",
			data: {'p':'exportacaoxml'},
			success: function(data){
				$("#display").html(data);
			}
		});
		return false;
	});
	
	$('#bt-exportacao_completa').click(function(){
		$.ajax({
			type: "get",
			url: "../controller/menu.ctrl.php?p=exportacaocompleta",
			success: function(data){
				$("#display").html(data);
			}
		});
		return false;
	});
	$('#bt-relatorio').click(function(){
		$.ajax({
			url: "../controller/relatorios.ctrl.php?r=geral",
			type: 'get',
//			dataType: 'json',
			success: function (data) {
				$("#display").html(data);
				$("#display").find("*");
//				$("input[name='nome_xml']").val(data['nome']);
//				$("#xml").val(data['xml']);
			}
		});
		return false;
	});
// 
	$("#bt-selecionar-nfe").click(function(){
		var numero_nfe = $("#numero_nfe").val();
		$.ajax({
			type: "post",
			url: "../controller/menu.ctrl.php",
			data: {'numero_nfe': numero_nfe, 'p':'exportacaoxml'},
			success: function(data){
				$("#display-arquivos").html(data);
			}
		});
		return false;
	});

	$("#bt-exportar-massa").click(function(){
		$.ajax({
			type: "post",
			url: "../controller/menu.ctrl.php",
			data: {'p':'exportacaocompleta'},
			success: function(data){
				$("#display-arquivos").html(data);	
			}
		});
		return false;
	});
	
	$("#bt-sair").click(function(){
		console.log("Oi");
		$(location).attr("href", "../controller/logout.ctrl.php");
	});

	$("form[name='formulario_post']").on("change", function () {
		var arquivo = new FormData(this);
		$.ajax({
			url: "../controller/arquivo.ctrl.php?f=ler",
			type: 'POST',
			data: arquivo,
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				$("input[name='md5_xml']").val(data['md5']);
				$("input[name='nome_xml']").val(data['nome']);
				$("#xml").val(data['xml']);
			}
		});
		return false;
	});
});
