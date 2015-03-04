<?php

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php");
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
			 
		$itens = array("mini".$_GET["id"].".jpg"); 
		remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "miniaturas", $_GET["id"]); 
		
		$miniaturas_new = array();

		$miniaturas = sql_select("miniaturas","id","","id_projeto='".$_SESSION["id"]."'",true);
		
		for($i=0; $i<count($miniaturas); $i++){
			array_push($miniaturas_new, $miniaturas[$i]["id"]); 
		}
		 
		$dados = array(	array("miniaturas", implode(",", $miniaturas_new ) )); 
		sql_update("projetos", $dados, "id='".$_SESSION["id"]."'" ); 

		xml_proj($_SESSION["id"]);
		
		location("../proj_mini.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO");  

?>

