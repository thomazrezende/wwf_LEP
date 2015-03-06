<?php  
	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
 
	$id = $_SESSION["id"];

	$arr_nome = explode(".",$_FILES['arquivo']['name']);

	$valores = array(	array("id_projeto",$id), 
						array("arquivo",$_FILES['arquivo']['name']), 
						array("nome",$arr_nome[0]),
					 	array("ext",$arr_nome[1]),
					 	array("tipo",$_FILES['arquivo']['type']),
					 	array("bites",$_FILES['arquivo']['size'])
						); 
		 
	sql_insert("arquivos", $valores);

	copy( $_FILES['arquivo']['tmp_name'], "../../projetos/projeto".$id."/".$_FILES['arquivo']['name']);  
	
	
?>