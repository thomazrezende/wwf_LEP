<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/xml.php");
	require_once("../_tr/mysql.php");

	conectar();
	verif_log();

	$id = $_GET["id"];

	$dados = array(
					array("nome", $_POST["nome"]),
					array("admin", $_POST["admin"]),
					array("email", $_POST["email"])
					);

	sql_update("usuarios", $dados, "id='".$id."'" );

	location("../usuario.php","id=".$id."&msg_ok=DADOS ALTERADOS COM SUCESSO");

?>
