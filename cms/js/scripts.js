$(document).ready(function(){

// CONTROLE DOS BOTÕES DO MENU DO TOPO DO CMS
	$(".bt-menu").click(function(){
		var opcao = $(this).attr("name");

		$.ajax({
			url: "../controller/menu.ctrl.php",
			type: "post",
			data: {"opcao":opcao},
			success: function(data){
				$("#display").html(data);
			}
		});
		return false;
	});





// CHAMA O CONTROLLER PARA RECEBER O CADASTRO DE EMPRESA
	$("#bt-cadastrar-empresa").click(function(){
		var nome_fantasia 	= $("input[name='nome_fantasia']").val();
		var razao_social	= $("input[name='razao_social']").val();
		var cnpj			= $("input[name='cnpj']").val();
		var senha			= $("input[name='senha']").val();
		var senha2			= $("input[name='senha2']").val();
		$.ajax({
			url: "/nfe/cms/controller/empresa.ctrl.php",
			type: "post",
			data: {"nome_fantasia":nome_fantasia, "razao_social":razao_social, "cnpj":cnpj, "senha":senha, "senha2":senha2},
			success: function(data){
				$("#mensagens").html(data);
				$("#mensagens").css("display","block");
				$("#mensagens").fadeOut(5000);
			}
		});
		return false;
		
	});




















// RECEBE O ARQUIVO SELECIONADO E ENVIAR PARA O CONTROLLER CORRESPONDENTE PARA TRATAMENTO E PREENCHIMENTO DO FORMULÁRIO
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
