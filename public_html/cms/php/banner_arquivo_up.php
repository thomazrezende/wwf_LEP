<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();

	$id = $_GET['id'];

	unlink("../../banners/banner".$id."jpg");

	up_img_fixo("arquivo",-1,900,300,"../../banners/banner".$id,"jpeg"); 
	
?> 