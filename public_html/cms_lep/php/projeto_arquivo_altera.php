<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$id = $_GET["id"];
	$id_projeto = $_SESSION["id"];
	
	$dados = array(
					array("label", $_POST["label"]),
					array("titulo", $_POST["titulo"]),
					array("grupo", $_POST["grupo"])
					);
 
 
	sql_update("arquivos", $dados, "id='".$id."'" ); 
	
  	xml_projeto($id_projeto);

	location("../projeto_arquivo.php","id=".$id."&msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 