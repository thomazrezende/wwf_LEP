<?php   
 
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();  

	$dados = array(	array("embed", emb_100($_POST["embed"])),
					array("autoplay", $_POST["autoplay"] ),
					array("embed_lb", $_POST["embed_lb"] )
					); 
		
	 
	sql_update("arquivos", $dados, "id='".$_SESSION["id_file"]."'" );
	
	xml_videos();
	xml_proj($_SESSION["id"]); 
	
	location("../proj_arquivo_dados.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 