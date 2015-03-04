<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log(); 
		
	$valores = array(
		array("email",$_POST["email"]),
		array("twitter",$_POST["twitter"]),
		array("fbook",$_POST["fbook"]),
		array("sobre_lep",$_POST["sobre_lep"]),
		array("sobre_psc",$_POST["sobre_psc"])
	);

	$ok = sql_update("dados", $valores , "");
	
	if($ok){
		xml_dados();
		location("../lep_dados.php?msg_ok=DADOS ALTERADOS COM SUCESSO","");
	}else{
		location("../lep_dados.php?msg_erro=ERRO","");
	}
	

?>