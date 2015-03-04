<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log(); 
		
	$valores = array(
		array("links",$_POST["links"])
	);

	$ok = sql_update("dados", $valores , "");
	
	if($ok){
		xml_dados();
		location("../links.php?msg_ok=DADOS ALTERADOS COM SUCESSO","");
	}else{
		location("../links.php?msg_erro=ERRO","");
	}
	

?>