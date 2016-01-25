<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();   
	
	if(isset($_POST["label"]) && !empty($_POST["label"])){
		
		$prox = next_id("resultados");
		$id_projeto = $_SESSION["id"];
		
		$valores = array(	array("label", $_POST["label"]),
							array("id_projeto", $id_projeto )); 
		 
		sql_insert("resultados", $valores);
  		
		xml_projeto($id_projeto);
		
		location("../projeto_resultado.php?id=".$prox,""); 
	}else{ 
		location("../projeto_resultados.php","msg_erro=ESCOLHA UM NOME DE ARQUIVO"); 
	}
	
?>