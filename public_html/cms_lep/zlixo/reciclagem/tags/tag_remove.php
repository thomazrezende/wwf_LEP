<?php   


	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();  
	
	remove_itens("../../tags", array("tag".$_GET["id"].".png"),"tags",$_GET["id"]);

	xml_tags();
	
	location("../tags.php","msg_ok=MARCADOR REMOVIDO COM SUCESSO"); 
	
	
?> 