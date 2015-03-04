<?php   

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
     
	if (!empty($_POST['embed'])){
			   
		$id_emb = next_id("arquivos");
				
		$valores = array(  	array("tipo","emb"),
						 	array("embed_lb","emb".$id_emb),
							array("id_projeto", $_SESSION["id"]),
							array("embed", emb_100( $_POST["embed"] )) 
							);
		
		sql_insert("arquivos", $valores);
		
		$item_novo = "emb".$id_emb;
		$layout_antigo = implode(",",sql_select("projetos","layout","","id='".$_SESSION["id"]."'",false));
		
		if( !empty($layout_antigo) ){
			$layout_antigo = ",".$layout_antigo;
		}
		
		sql_update("projetos", array(array("layout", $item_novo.$layout_antigo)), "id='".$_SESSION["id"]."'");  			
		xml_videos();
		xml_proj($_SESSION["id"]);	  
		location("../proj_arquivos.php","msg_ok=EMBED INSERIDO COM SUCESSO");
		
	} else{		
		
		location("../proj_arquivos.php","msg_erro=CAMPO VAZIO");
	}
	
?> 