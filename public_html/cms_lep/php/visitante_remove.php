<?php  
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	
	conectar();
	verif_log();
	
	$id = $_GET['id'];
		 
	sql_delete("visitantes", "id", $id, 1 ); 

	location("../visitantes.php","msg_ok=VISITANTE REMOVIDO COM SUCESSO");
	
?>