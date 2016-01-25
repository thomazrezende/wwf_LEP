<?php
	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/arquivo.php");
	require_once("../_tr/xml.php");

	conectar();
	verif_log();

	$id = $_GET['id'];

	remove_pasta('../../b2020/camadas/camada'.$id, 'b2020_camadas', $id, '' ,'');

	location("../b2020_camadas.php","msg_ok=CAMADA REMOVIDA COM SUCESSO");

?>
