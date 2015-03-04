<?php   

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();  
	
	if(isset($_POST["titulo"]) && !empty($_POST["titulo"])){
		
		$prox = next_id("documentos"); 
		
		$valores = array(	array("titulo",$_POST["titulo"]), 
							array("publicado",0)
							); 
		 
		sql_insert("documentos", $valores);
		
		location("../documento.php?id=".$prox,""); 
	}else{ 
		location("../documentos.php","msg_erro=ESCOLHA UM T&Iacute;TULO;"); 
	}
	
?>