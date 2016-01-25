<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");

	conectar();

	$id = $_GET["id"];

	if( empty($_POST["senha_nova"]) || empty($_POST["senha_confirma"]) ) {

		$msg="PREENCHA OS 2 CAMPOS";
		location("../redefinir_senha.php","id=".$id."&msg_erro=".$msg);

	}

	elseif( $_POST["senha_nova"] != $_POST["senha_confirma"]) {

		$msg="CONFIRMAÇÃO INVÁLIDA";
		location("../redefinir_senha.php", "id=".$id."&msg_erro=".$msg);

	}else{

		$senha_nova = getPasswordHash(getPasswordSalt(), $_POST["senha_nova"] );
		$ok = sql_update("usuarios", array(array("senha",$senha_nova)),"id=".$id);

		if($ok){
			$msg="SENHA ALTERADA COM SUCESSO";
			location("../login.php","msg_ok=".$msg);
		}else{
			$msg="HOUVE UM ERRO. POR FAVOR TENTE NOVAMENTE";
			location("../redefinir_senha.php", "id=".$id."&msg_erro=".$msg);
		}

	}

?>
