<?php

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php");
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
	
	$itens = array("ban".$_GET["id"]."m.jpg", "ban".$_GET["id"]."p.jpg", "ban".$_GET["id"]."pp.jpg");
	
	remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "banners", $_GET["id"]); 
		
	xml_proj($_SESSION["id"]);
	location("../proj_banners.php","msg_ok=IMAGEM REMOVIDA COM SUCESSO"); 


?>

