<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();  
	
	replace_arq("pdf_".get_lg(),"../../thomaz/cv_thomazrezende_".get_lg().".pdf","","","");

?>