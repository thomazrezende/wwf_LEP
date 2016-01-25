<?php  

	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");  
	
	conectar();
	verif_log();
	
	$id = $_GET['id']; 
	
	unlink("../../projetos/projeto".$id."/apoio.jpg"); 

	location("../projeto_apoio.php","id=".$id."&msg_ok=ARQUIVO REMOVIDO COM SUCESSO");

	
?>