<?php  

	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();
	
	$id = $_GET['id'];
	
	$dados = sql_select("documentos","arquivo","","id=".$id, false);   
	
	$deletar = array( array("arquivo", NULL));
	sql_update("documentos", $deletar, "id='".$id."'" ); 
	
	unlink("../../documentos/".$dados["arquivo"]);

	xml_documentos();

	location("../documento.php","id=".$id."&msg_ok=ARQUIVO REMOVIDO COM SUCESSO");

	
?>