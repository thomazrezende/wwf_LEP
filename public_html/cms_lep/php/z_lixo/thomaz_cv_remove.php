<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();
	
	$ok = unlink("../../thomaz/cv_thomazrezende_".get_lg().".pdf"); 
	
	location("../thomaz_curriculo.php?msg_ok=ARQUIVO REMOVIDO COM SUCESSO","");
	
?>