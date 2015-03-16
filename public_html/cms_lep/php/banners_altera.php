<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$ids = explode(',', $_POST["ids"]); 
	
	for($i=0; $i<count($ids); $i++){
		$dados = array(	array("credito", $_POST["credito".$ids[$i]]));
		sql_update("banners", $dados, "id='".$ids[$i]."'" );
	}

  	xml_banners();

	location("../banners.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 