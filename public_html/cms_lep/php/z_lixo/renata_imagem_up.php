<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log(); 
	
	unlink("../../renata/renata_ursaia.jpg");
	up_img_var("arquivo",-1,"w",900,"../../renata/renata_ursaia","jpeg"); 

?>