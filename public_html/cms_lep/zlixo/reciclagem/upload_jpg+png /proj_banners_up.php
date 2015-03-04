<?php   

	require_once("../../../../_tr_8362036/seguranca.php"); 
	require_once("../../../../_tr_8362036/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
	   
	if (!empty( $_FILES['banners']['name'][0]) ){   
			 
		$n_arq = count( $_FILES['banners']['name'] );
	  
	  	$display_array = sql_select("projetos","display", "", "id='".$_SESSION["id"]."'",false);
		$display = $display_array["display"]; 
		  
		$n = next_id("banners");
			
		for($i = 0; $i < $n_arq; $i++) {  
		
			$tipo = $_FILES['banners']['type'][$i];    
			
			if($tipo == "image/jpeg"){ 
				
				if( $display != "" ) $display.=",";
				$display.="ban".$n;			
			
				copy( $_FILES['banners']['tmp_name'][$i], "../../projetos/projeto".$_SESSION["id"]."/ban".$n.".jpg" );  
				
				$valores = array( 	array("id_proj",$_SESSION["id"]) );
				
				sql_insert("banners", $valores);
			
				$n++; 
								
			} 
			
			if($tipo == "image/png"){
				copy( $_FILES['banners']['tmp_name'][$i], "../../projetos/projeto".$_SESSION["id"]."/ban".($n-1).".png" );  
			}
			
		} 
		
		$dados = array(array("display",$display)); 
		sql_update("projetos", $dados, "id='".$_SESSION["id"]."'");
		
	}
	
	
?> 