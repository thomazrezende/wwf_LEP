<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();   
	
	if(isset($_POST["label"]) && !empty($_POST["label"])){
		
		$prox = next_id("arquivos"); 
		$id_projeto = $_SESSION["id"];
		
		$valores = array(	array("label", $_POST["label"]),
							array("id_projeto", $id_projeto )); 
		 
		sql_insert("arquivos", $valores);
		
		location("../projeto_arquivo.php?id=".$prox,""); 
	}else{ 
		location("../projeto_arquivos.php","msg_erro=ESCOLHA UM NOME DE ARQUIVO"); 
	}
	
?>