<?php   


	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	 
	sql_update("displays", array(array("layout",$_POST["layout"]),array("label",$_POST["label"])), "id='".$_GET["id"]."'" );  
	
	if($_POST["home"] == 1){
		sql_update("projetos", array(array("display",$_POST["layout"])), "id='".$_SESSION["id"]."'" ); 
	}
	
	xml_proj($_SESSION["id"]); 
	
	location("../proj_display_dados.php","msg_ok=DISPLAY GRAVADO COM SUCESSO&id=".$_GET["id"]);

	
?> 