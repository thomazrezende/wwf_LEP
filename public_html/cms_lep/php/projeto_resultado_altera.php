<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$id = $_GET["id"];
	$id_projeto = $_SESSION["id"]; 
 
	$legenda = "";

	for($i=0; $i<10; $i++){
		
		$lb = $_POST["legenda".$i."_label"];
		
		if(!empty($lb)){
			
			$hex = $_POST["legenda".$i."_hex"];
			if(empty( $hex )) $hex = "#000000";
			
			if($hex[0] != "#" ){ // valor em RGB
				$rgb = explode(',',$hex);
				if(!empty($rgb[0]) && !empty($rgb[1]) && !empty($rgb[2])){
					$hex = rgb2hex($rgb); 
				}else{
					$hex = "#000000";
				}
			}		
				
			$legenda .= $lb.",";
			$legenda .= $hex."|";
		}  
	}

	$dados = array(
					array("label", $_POST["label"]),
					array("titulo", $_POST["titulo"]),
					array("titulo_legenda", $_POST["titulo_legenda"]),
					array("legenda", $legenda)
					);
 
 
	sql_update("resultados", $dados, "id='".$id."'" ); 
	
  	xml_projeto($id_projeto);

	location("../projeto_resultado.php","id=".$id."&msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 