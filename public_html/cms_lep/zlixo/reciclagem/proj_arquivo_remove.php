<?php

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
	
	if($_GET["tipo"] == "img"){
		$itens = array("img".$_GET["id"]."m.jpg", "img".$_GET["id"]."p.jpg", "img".$_GET["id"]."g.jpg"); 
		remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "arquivos", $_GET["id"]); 
	}else{
		remove_item("", "", "arquivos", $_GET["id"]);
	} 
	
	verifica_vinculo("projetos","layout",$_SESSION["id"],$_GET["tipo"].$_GET["id"]);
	
	xml_proj($_SESSION["id"]);
	location("../proj_arquivos.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO"); 


?>

