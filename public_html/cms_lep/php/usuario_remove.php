<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/arquivo.php");

	conectar();
	verif_log();

	$id = $_GET['id'];
	sql_delete("usuarios", "id", $id, 1 );

	location("../usuarios.php","msg_ok=USUÁRIO REMOVIDO COM SUCESSO");

?>
