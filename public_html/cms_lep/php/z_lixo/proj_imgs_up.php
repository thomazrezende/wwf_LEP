<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
     
	if (!empty($_FILES['imagens']['name'][0])){  
	        
	$layout_novo = "";		
			 
	$n_arq = count($_FILES['imagens']['name']);  
		$n = next_id("arquivos");
		
		for($i = 0; $i < $n_arq; $i++) {  
		
			$id_img = $n+$i;
			
			up_img_var("imagens",$i,"w",640,"../../projetos/projeto".$_SESSION["id"]."/img".$id_img."m","jpeg"); 
			up_img_var("imagens",$i,"w",860,"../../projetos/projeto".$_SESSION["id"]."/img".$id_img."g","jpeg"); 
			up_img_fixo("imagens",$i,110,95,"../../projetos/projeto".$_SESSION["id"]."/tb".$id_img,"jpeg");
			up_img_fixo("imagens",$i,36,36,"../../projetos/projeto".$_SESSION["id"]."/tb".$id_img."p","jpeg");
			
			
			$valores = array( array("tipo","img"),
								array("id_projeto",$_SESSION["id"]),
								array("file",$_FILES['imagens']['name'][$i]) 
								);
			
			sql_insert("arquivos", $valores);  
			
			$layout_novo .= "img".$id_img;
			
			if($i < $n_arq-1){ 
				$layout_novo .= ",";
			}
			
		}
		
		//layout
		$layout_antigo = implode(",",sql_select("projetos","layout","","id='".$_SESSION["id"]."'",false));
		
		if( !empty($layout_antigo) ){
			$layout_antigo = ",".$layout_antigo;
		}
		
		sql_update("projetos", array(array("layout", $layout_novo.$layout_antigo)), "id='".$_SESSION["id"]."'"); 
		
		xml_proj($_SESSION["id"]);
			  
	} 
	
?> 