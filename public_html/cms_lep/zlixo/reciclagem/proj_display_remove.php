<?php   


	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log(); 
	
	verifica_vinculo( "projetos", "layout", $_SESSION["id"], "dsp".$_GET["id"] );
	
	sql_delete( "displays", "id", $_GET["id"], 1 ); 
	
	location("../proj_arquivos.php","msg_ok=DISPLAY REMOVIDO COM SUCESSO"); 
	
	
?> 