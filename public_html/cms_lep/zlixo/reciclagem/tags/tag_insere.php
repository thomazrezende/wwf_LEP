<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();  
	
	if(isset($_POST["nome"]) && !empty($_POST["nome"])){ 
		
		$valores = array(	array("label_".get_lg(),$_POST["nome"])
							); 
		 
		sql_insert("tags", $valores);
		
		xml_tags();
		
		location("../tags.php","msg_ok=MARCADOR CRIADO COM SUCESSO"); 
	}else{ 
		location("../tags.php","msg_erro=ESCOLHA UM NOME"); 
	}
	
?> 