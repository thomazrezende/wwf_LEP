<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
			
	$nome_temp = $_FILES["tb_pb"]["tmp_name"];
	
	copy($nome_temp,"../../projetos/projeto".$_SESSION["id"]."/tb_pb.png"); 
	
	
?> 