<?php  

	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();
	
	$id = $_GET['id'];

	remove_pasta('../../documentos/documento'.$id, 'documentos', $id, false, false);
	//remove_pasta($path, $tabela, $id, $tabelas_vinc, $lbs_vinc){ 
	
	location("../documentos.php","msg_ok=DOCUMENTO REMOVIDO COM SUCESSO");
	
?>