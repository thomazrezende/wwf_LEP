<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/xml.php");
	require_once("../_tr/mysql.php");

	conectar();
	verif_log();

	$id = $_GET["id"];

	$dados = array(	array("label", $_POST["label"]),
					array("cor", $_POST["cor"]),
					array("ativo", $_POST["ativo"]));

	sql_update("b2020_camadas", $dados, "id='".$id."'" );

	location("../b2020_camada_dados.php","id=".$id );

?>
