<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log(); 
	
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_16x9.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_15x10.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_4x3.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_1x1.jpg");

	location("../proj_capa.php","msg_ok=IMAGEM REMOVIDA COM SUCESSO");

?>