<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();
	
	$id = $_SESSION['id'];
	$id_arquivo = $_GET['id'];
	
	$dados = sql_select("arquivos","arquivo","","id=".$id_arquivo, false);
	remove_item("../../projetos/projeto".$id, $dados["arquivo"], "arquivos", $id_arquivo );  
	
	location("../projeto_repositorio.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO");
	
?>