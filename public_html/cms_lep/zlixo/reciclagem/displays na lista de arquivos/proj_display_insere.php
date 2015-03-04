<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();  
	 
	$valores = array(	array("id_proj", $_SESSION["id"] )); 		
	 
	sql_insert("displays", $valores);
	
	location("../proj_arquivos.php","msg_ok=DISPLAY CRIADO COM SUCESSO"); 
	
	
?> 