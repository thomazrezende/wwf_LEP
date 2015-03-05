<?php    
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	
	$dados = array(array("layout",$_POST["layout"]));
	
	sql_update("projetos", $dados, "id='".$_SESSION["id"]."'"); 
	
	xml_proj($_SESSION["id"]); 
	
	location("../proj_arquivos.php","msg_ok=LAYOUT ALTERADO COM SUCESSO&pagey=".$_POST["pagey_out"]);

	
?> 