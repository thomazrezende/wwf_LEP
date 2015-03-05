<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$id = $_SESSION["id"];
	
	$dados = array(
					array("publicado", $_POST["publicado"]),
					array("titulo", $_POST["titulo"]),
					array("sobre", $_POST["sobre"])
					);
 
 
	sql_update("projetos", $dados, "id='".$id."'" );
	
  	xml_projetos(); 

	location("../projeto_dados.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 