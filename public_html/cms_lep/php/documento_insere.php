<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();  
	
	if(isset($_POST["titulo"]) && !empty($_POST["titulo"])){
		
		$prox = next_id("documentos"); 
		mkdir("../../documentos/documento".$prox,0755); 
		
		$valores = array(	array("titulo",mysql_real_escape_string ($_POST["titulo"])), 
							array("publicado",0)
						); 
		 
		sql_insert("documentos", $valores);
		
		location("../documento.php?id=".$prox,""); 
	}else{ 
		location("../documentos.php","msg_erro=ESCOLHA UM TÍTULO"); 
	}
	
?>