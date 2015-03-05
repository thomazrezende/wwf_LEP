<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log(); 
 
	$id = $_SESSION["id"];
	$pos = $_GET["pos"];
	$prox = next_id("arquivos"); 
	
	// parei aqui:
	// criar insert no BD com os dados do arquivo novo. Não haverá replace porque o sistema avisará quais arquivos ja existem. 
	// copy do arquivo novo para o caminho abaixo
	
	 "../../projetos/projeto".$id."/".$_FILES['arquivo'.$pos]['name'],
				

?>