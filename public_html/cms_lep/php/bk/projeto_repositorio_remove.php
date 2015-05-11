<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();
	
	$id = $_SESSION['id'];
	$id_repositorio = $_GET['id']; 

	$dados = sql_select("repositorios","arquivo","","id=".$id_repositorio, false);
	remove_item("../../projetos/projeto".$id, $dados["arquivo"], "repositorios", $id_repositorio );  
	
	xml_projeto($id);

	location("../projeto_repositorio.php","msg_ok=ARQUIVO REMOVIDO COM SUCESSO");
	
?>