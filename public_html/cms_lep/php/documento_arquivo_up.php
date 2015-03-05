<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();   

	$id = $_GET["id"];
	
	replace_arq( "arquivo" ,"../../documentos/documento".$id."/".$_FILES['arquivo']['name'],"documentos","arquivo","id='".$id."'");

?>