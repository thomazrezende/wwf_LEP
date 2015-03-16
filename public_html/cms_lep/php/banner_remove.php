<?php  
	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();
	
	$id = $_GET['id'];

	sql_delete("banners", "id", $id, 1 ); 
	
	unlink("../../banners/banner".$id.".jpg");
	
	location("../banners.php","msg_ok=IMAGEM REMOVIDA COM SUCESSO");
	
	xml_banners();
?>