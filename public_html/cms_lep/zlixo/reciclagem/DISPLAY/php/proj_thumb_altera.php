<?php   


	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	
	sql_update("projetos", array(array("id_tb",$_GET["id"])), "id='".$_SESSION["id"]."'" ); 
	
	sessao();
	$_SESSION["id_tb"] = $_GET["id"]; 
	 
	xml_proj($_SESSION["id"]);	 
	
	location("../proj_banners.php","msg_ok=IMAGEM DEFINIDA COM SUCESSO");

	
?> 