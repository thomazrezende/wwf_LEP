<?php   


	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();  
	
	remove_pasta("../../projetos/projeto".$_GET["id"], "projetos", $_GET["id"], array("arquivos"), array("id_projeto"));
	
	xml_videos();
	xml_proj_lista();
	
	verifica_vinculo_renata('home',"item".$_GET["id"]);

	location("../projetos.php","msg_ok=PROJETO REMOVIDO COM SUCESSO"); 
	
	
?> 