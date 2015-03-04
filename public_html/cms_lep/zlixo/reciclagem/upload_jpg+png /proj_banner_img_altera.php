<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	   
	if (!empty( $_FILES['banners']['name'][0]) ){   
			 
		$n_arq = count( $_FILES['banners']['name'] ); 
		
		for($i = 0; $i < $n_arq; $i++) {  
		
			$tipo = $_FILES['banners']['type'][$i];   
			
			if($tipo == "image/jpeg"){ 
				copy( $_FILES['banners']['tmp_name'][$i], "../../projetos/projeto".$_SESSION["id"]."/ban".$_GET["id"].".jpg" ); 
			} 
			
			if($tipo == "image/png"){
				copy( $_FILES['banners']['tmp_name'][$i], "../../projetos/projeto".$_SESSION["id"]."/ban".$_GET["id"].".png" ); 
			} 
		} 
	}
	
	
?> 