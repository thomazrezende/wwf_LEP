<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	
 	$visitantes = sql_select( "visitantes","id","","",true );
	
	for($i=0; $i<count($visitantes); $i++){  
		
		$id = $visitantes[$i]['id']; 
		
		$dados = array(	array("ativo", $_POST["ativo".$id]));
		
		sql_update("visitantes", $dados, "id='".$id."'" ); 
	}

	location("../visitantes.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 