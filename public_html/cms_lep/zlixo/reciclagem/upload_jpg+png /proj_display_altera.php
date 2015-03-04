<?php    
	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	
	$dados = array(array("display",$_POST["display_layout"]));
	
	sql_update("projetos", $dados, "id='".$_SESSION["id"]."'");
	
	// lixo
	if(isset($_GET["lixo"]) && $_GET["lixo"] == "ok"){
		remove_itens("../../projetos/projeto".$_SESSION["id"], array( "ban".$_GET["id"].".jpg", "ban".$_GET["id"].".png" ) , "banners", $_GET["id"]);
	}  
	
	xml_proj($_SESSION["id"]); 
	
	location("../proj_display.php","msg_ok=LAYOUT ALTERADO COM SUCESSO");

	
?> 