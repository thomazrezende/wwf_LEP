<?php

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php");
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
	
		$arquivos = sql_select("arquivos","id","","id_projeto=".$_SESSION["id"],true);  
			
		for($i=0; $i<count($arquivos); $i++){
	
			$itens = array("img".$arquivos[$i]["id"]."m.jpg", "img".$arquivos[$i]["id"]."p.jpg", "img".$arquivos[$i]["id"]."g.jpg");
			
			remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "arquivos", $arquivos[$i]["id"]); 
				 
		}
		
		sql_update("projetos", array(array("layout","")),"id='".$_SESSION["id"]."'");
		
		xml_videos();
		xml_proj($_SESSION["id"]);
		
		location("../proj_arquivos.php","msg_ok=ARQUIVOS REMOVIDOS COM SUCESSO");  

?>

