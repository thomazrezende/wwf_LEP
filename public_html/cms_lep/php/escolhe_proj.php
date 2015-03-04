<?php  

	require_once("../../../_tr_1048672/seguranca.php");
	require_once("../_tr/html.php");  
	
	verif_log(); 
	
	$itens = array (	array("id", $_GET["id"]),
						array("proj", $_GET["proj"])   );
	
	sessao_local($itens,true); 
	
	location("../proj_dados.php","");
	
?>