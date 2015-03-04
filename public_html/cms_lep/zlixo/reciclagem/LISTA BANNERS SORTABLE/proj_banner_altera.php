<?php   


	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	 
	$ids = explode(",",$_GET["ids"]);
	
	for($i=0; $i<count($ids); $i++){  
		sql_update("banners", array(array("dd_ordem",$i)), "id='".$ids[$i]."'" ); 
	}
	
	proj_banners($_SESSION["id"]);
	 
	xml_proj($_SESSION["id"]); 
	
	location("../proj_banners.php","");

	
?> 