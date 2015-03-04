<?php  
	require_once("../../../_tr_1048672/seguranca.php");
	require_once("../_tr/html.php");  
	
	verif_log();
	
	$itens = array (array("id", $_GET["id"]),
					array("titulo", $_GET["id"]." - ".$_GET["titulo"]));
	
	sessao_local($itens, true);
	
	location("../projeto_dados.php","");	
?>