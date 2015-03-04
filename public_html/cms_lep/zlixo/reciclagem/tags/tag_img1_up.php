<?php  

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();  
	
	replace_arq("tag_img","../../tags/tag".$_SESSION["id_tag"].".png","","","");

?>