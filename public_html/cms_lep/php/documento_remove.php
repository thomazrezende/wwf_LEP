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

	$dados = sql_select( "documentos","arquivo","","id='".$id."'", false );   
	remove_item('../../documentos/', $dados['arquivo'], 'documentos', $id ); 

	xml_documentos();

	location("../documentos.php","msg_ok=DOCUMENTO REMOVIDO COM SUCESSO");
	
?>