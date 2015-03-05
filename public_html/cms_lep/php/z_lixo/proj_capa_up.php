<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log(); 
	
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_16x9.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_4x3.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_15x10.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa_1x1.jpg");
	unlink("../../projetos/projeto".$_SESSION["id"]."/capa.jpg");
	
	copy($_FILES["imagem"]["tmp_name"],"../../projetos/projeto".$_SESSION["id"]."/capa.jpg");   
	up_img_fixo("imagem",-1,640,360,"../../projetos/projeto".$_SESSION["id"]."/capa_16x9","jpeg");
	up_img_fixo("imagem",-1,640,427,"../../projetos/projeto".$_SESSION["id"]."/capa_15x10","jpeg");  
	up_img_fixo("imagem",-1,640,480,"../../projetos/projeto".$_SESSION["id"]."/capa_4x3","jpeg"); 
	up_img_fixo("imagem",-1,640,604,"../../projetos/projeto".$_SESSION["id"]."/capa_1x1","jpeg"); 
	
?>