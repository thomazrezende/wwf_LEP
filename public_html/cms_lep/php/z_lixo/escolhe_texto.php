<?php  

	require_once("../../../_tr_1048672/seguranca.php");
	require_once("../_tr/html.php");  
	
	verif_log(); 
	
	$itens = array (	array("id_critica", $_GET["id"]),
						array("autor",$_GET["autor"])   );
	
	sessao_local($itens,true); 
	
	location("../texto_dados.php","");
	
?>