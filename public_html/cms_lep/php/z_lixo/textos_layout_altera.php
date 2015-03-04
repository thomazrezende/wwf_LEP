<?php    
	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	
	$dados = array(array("textos",$_POST["layout"]));
	
	sql_update("renata", $dados, ""); 
	
	xml_renata(); 
	
	location("../textos.php","msg_ok=LAYOUT ALTERADO COM SUCESSO&pagey=".$_POST["pagey_out"]);

	
?> 