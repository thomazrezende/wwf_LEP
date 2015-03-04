<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
     
	if (!empty($_FILES['banners']['name'][0])){  
	         
	$n_arq = count($_FILES['banners']['name']);  
		$n = next_id("banners");
		
		for($i = 0; $i < $n_arq; $i++) { 
			
			$nome_temp = $_FILES["banners"]["tmp_name"][$i]; 
			list($w,$h) = getimagesize($nome_temp);
			
			$prop = $w/$h;
			
			//16x4.5 (3.5)
			if($prop > 3){
				up_img_fixo("banners",$i,640,180,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."m","jpeg");
				up_img_fixo("banners",$i,224,63,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."p","jpeg");
				up_img_fixo_all("banners",$i,100,60,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."pp","jpeg","#ffffff"); 
				$tipo = "h";
			}
			
			//8x9 (.8)
			elseif($prop < 1){ 
				up_img_fixo("banners",$i,320,360,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."m","jpeg"); 
				up_img_fixo("banners",$i,112,126,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."p","jpeg");
				up_img_fixo_all("banners",$i,100,60,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."pp","jpeg","#ffffff");
				$tipo = "v";
			}
			
			//16x9 (1.7)
			else{ 
				up_img_fixo("banners",$i,640,360,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."m","jpeg");
				up_img_fixo("banners",$i,216,122,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."p","jpeg");
				up_img_fixo("banners",$i,100,60,"../../projetos/projeto".$_SESSION["id"]."/ban".($n+$i)."pp","jpeg"); 
				$tipo = "n"; 
			} 
			 
			
			$valores = array( 	array("dd_tipo",$tipo), 
								array("id_proj",$_SESSION["id"]) 
								);
			
			sql_insert("banners", $valores);  
			
		}
		proj_banners($_SESSION["id"]);
		
		xml_proj($_SESSION["id"]);	  
	} 
	
?> 