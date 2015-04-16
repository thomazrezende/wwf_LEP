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
		array("credito", $_POST["credito"]),
		array("link", vrf_http($_POST["link"])),
		array("tema", $_POST["tema"])
	);

	sql_update("banners", $dados, "id='".$id."'" );

  	xml_banners();

	location("../banner.php","id=".$id."&msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 