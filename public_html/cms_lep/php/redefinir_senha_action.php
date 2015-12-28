<?php
require_once("../../../_control/acesso.php");
require_once("../../../_control/seguranca.php");
require_once("../_tr/mysql.php");
require_once("../_tr/html.php");

conectar();

	$id = $_GET["id"];
	$dados = sql_select("usuarios", "*", "", "id='".$id."'", false);

	$token_date = strtotime($dados["token_date"])+3600;
	$token = $dados["token"];

	$actual_date = strtotime($_SERVER["REQUEST_TIME"]);
	$get_token = $_GET["token"];

	if( $token == $get_token && $actual_date < $token_date ){

		sessao_local( array(array("token_ok",md5("token_ok_02894621"))),true );
		location("../redefinir_senha.php","id=".$id."&msg_ok=ESCOLHA SUA NOVA SENHA");

	}else{

		location("../login.php","msg_erro=TEMPO DE REDEFINIÇÃO DE SENHA ESGOTADO");

	}
