<?php  
	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
 
	$id = $_SESSION["id"];
	
	$file_ext = substr($_FILES['arquivo']['name'], -3);
	$file_name = substr($_FILES['arquivo']['name'], 0, -4);

	$valores = array(	array("id_projeto",$id), 
						array("arquivo",$_FILES['arquivo']['name']), 
						array("nome",$file_name),
					 	array("ext",$file_ext),
					 	array("tipo",$_FILES['arquivo']['type']),
					 	array("bites",$_FILES['arquivo']['size'])
						); 
		 
	sql_insert("arquivos", $valores);

	copy( $_FILES['arquivo']['tmp_name'], "../../projetos/projeto".$id."/".$_FILES['arquivo']['name']);  
	
	
?>