<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php"); 
	
	conectar();
	verif_log();   

	$id = $_GET["id"];  
	replace_arq( "arquivo" ,"../../documentos/".$_FILES['arquivo']['name'], "documentos", "arquivo","id='".$id."'"); 

	$dados = array( array("arquivo", $_FILES['arquivo']['name']));  
	sql_update("documentos", $dados, "id='".$id."'" );  
  	


?>