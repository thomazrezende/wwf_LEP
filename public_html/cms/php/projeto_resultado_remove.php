<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();
	
	$id_arquivo = $_GET['id'];
	$id_projeto = $_SESSION["id"];
	
	sql_delete("resultados", "id", $id_arquivo, 1);

  	xml_projeto($id_projeto);
	
	location("../projeto_resultados.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO");
	
?>