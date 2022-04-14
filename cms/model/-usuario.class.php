<?php
session_start();
require_once "bancodedados.class.php";
class Usuario {
	public function verificarUsuario($cnpj, $senha){
		$bd = new BancoDeDados;
		$conexao = $bd->conectar();
		$senha = sha1($senha);
		$sql = "SELECT codigo_empresa, cnpj_empresa, razao_social, nome_fantasia, senha, email  FROM empresas WHERE cnpj_empresa = '".$cnpj."' and senha = '".$senha."'";
		$parse = oci_parse($conexao,$sql);
		if(!$parse){
			$e = oci_error($parse);
			echo $e['message'];
			return false;
		}
		oci_define_by_name($parse, 'CODIGO_EMPRESA', $codigo_empresa);
		oci_define_by_name($parse, 'CNPJ_EMPRESA', $cnpj_empresa);
		oci_define_by_name($parse, 'RAZAO_SOCIAL', $razao_social);
		oci_define_by_name($parse, 'NOME_FANTASIA', $nome_fantasia);
		oci_define_by_name($parse, 'SENHA', $senha);
		oci_define_by_name($parse, 'EMAIL', $email);
		$p = oci_execute($parse);
		if(!$p){
			$e = oci_error($p);
			echo $e['message'];
		} else {
			oci_fetch($parse);
			if(oci_num_rows($parse) == 1){
				$_SESSION['status'] = true;
				$_SESSION['codigo_empresa'] = $codigo_empresa;
				$_SESSION['cnpj_empresa']   = $cnpj_empresa;
				$_SESSION['razao_social']   = $razao_social;
				$_SESSION['nome_fantasia']  = $nome_fantasia;
				return true;
			} else {
				$_SESSION['status'] = false;
				return false;	
			}
		}
	}
}