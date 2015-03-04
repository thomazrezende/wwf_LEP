<?php   
 
	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");

	conectar();
	verif_log();  

	$dados = array(	array("label_".get_lg(),$_POST["label_".get_lg()]),
					array("graf1",$_POST["graf1"]),
					array("graf2",$_POST["graf2"])
					);
					  
	sql_update("tags", $dados, "id='".$_SESSION["id_tag"]."'" );
	 
	xml_tags(); 
	
	location("../tag_dados.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 