<?php   


	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php");  
	require_once("../_tr/xml.php");  
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();

	sql_delete("critica","id", $_GET["id"], 1);
	
	xml_textos(); 
	
	verifica_vinculo_renata('textos',"item".$_GET["id"]);

	location("../textos.php","msg_ok=TEXTO REMOVIDO COM SUCESSO"); 
	
	
?> 