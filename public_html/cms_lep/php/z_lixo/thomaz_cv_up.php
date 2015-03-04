<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();  
	
	replace_arq("pdf_".get_lg(),"../../thomaz/cv_thomazrezende_".get_lg().".pdf","","","");

?>