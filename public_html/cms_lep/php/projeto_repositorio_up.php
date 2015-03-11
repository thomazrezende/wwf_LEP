<?php  
	
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 
 
	$id = $_SESSION["id"];
	
	$file_ext = substr($_FILES['arquivo']['name'], -3);
	$file_name = substr($_FILES['arquivo']['name'], 0, -4);
    
	if( file_exists("../../projetos/projeto".$id."/".$_FILES['arquivo']['name'])){ 
		
		unlink("../../projetos/projeto".$id."/".$_FILES['arquivo']['name']); 
		
		$arquivos = sql_select("repositorios","*","","id_projeto='".$id."'",true);
		$id_arquivo = "";
		
		for($i=0; $i<count($arquivos); $i++){
			if( $arquivos[$i]["arquivo"] == $_FILES['arquivo']['name'] ){
				$id_arquivo = $arquivos[$i]["id"];
				break;
			}
		}
		
		$valores = array( 	array("nome","FOII"),
							array("bites",$_FILES['arquivo']['size'])); 
		
		sql_update("repositorios", $valores, "id='".$id_arquivo."'");
		
	}else{
		
		$valores = array(	array("id_projeto",$id), 
							array("arquivo",$_FILES['arquivo']['name']), 
							array("nome",$file_name),
							array("ext",$file_ext),
							array("tipo",$_FILES['arquivo']['type']),
							array("bites",$_FILES['arquivo']['size'])
							); 
		
		sql_insert("repositorios", $valores);
	}     
    
	copy( $_FILES['arquivo']['tmp_name'], "../../projetos/projeto".$id."/".$_FILES['arquivo']['name']);  
	
	
?>