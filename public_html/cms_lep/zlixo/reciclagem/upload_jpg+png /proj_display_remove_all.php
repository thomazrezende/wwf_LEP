<?php

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php");
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
	
		$banners = sql_select("banners","id","","id_proj=".$_SESSION["id"],true);  
			
		for($i=0; $i<count($banners); $i++){
			 
			$itens =  array( "ban".$banners[$i]["id"].".jpg" , "ban".$banners[$i]["id"].".png"); 
			remove_itens("../../projetos/projeto".$_SESSION["id"], $itens, "banners", $banners[$i]["id"]);  
		}
		
		$dados = array(array("display","" ));
		sql_update("projetos", $dados, "id='".$_SESSION["id"]."'");
		
		xml_proj($_SESSION["id"]);
		
		location("../proj_display.php","msg_ok=IMAGENS REMOVIDAS COM SUCESSO");  

?>

