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
					array("lat", $_POST["lat"]),
					array("lng", $_POST["lng"]),
					array("zoom", $_POST["zoom"])
					);
 
 
	sql_update("projetos", $dados, "id='".$id."'" );
	
  	xml_projeto($id); 

	location("../projeto_mapa.php","msg_ok=MAPA ALTERADO COM SUCESSO"); 
	
?> 