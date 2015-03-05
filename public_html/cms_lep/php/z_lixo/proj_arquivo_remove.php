<?php    
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
		 
	if($_GET["tipo"] == "img"){
		$itens = array("img".$_GET["id"]."g.jpg", "img".$_GET["id"]."m.jpg", "tb".$_GET["id"].".jpg", "tb".$_GET["id"]."p.jpg", ); 
		remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "arquivos", $_GET["id"]);  
	}

	if($_GET["tipo"] == "emb"){
		remove_item("", "", "arquivos", $_GET["id"]); 
	}   

	verifica_vinculo( "projetos", "layout", $_SESSION["id"], "item".$_GET["id"] );	 
	
	xml_proj($_SESSION["id"]); 
	
	location("../proj_arquivos.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO");

	
?> 