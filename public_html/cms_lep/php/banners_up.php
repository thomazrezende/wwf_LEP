<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
       	
	$n_arq = count($_FILES['imagens']['name']);  

	$n = next_id("banners");

	for($i = 0; $i < $n_arq; $i++) {  

		$id_img = $n+$i;

		up_img_fixo("imagens",$i,900,300,"../../banners/banner".$id_img,"jpeg"); 

		$valores = array( array("id",$id_img));

		sql_insert("banners", $valores);    

	}

	xml_banners();
	
?> 