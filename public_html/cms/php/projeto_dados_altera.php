<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$id = $_SESSION["id"];
	
	$dados = array(
					array("publicado", $_POST["publicado"]),
					array("titulo", $_POST["titulo"]),
					array("resumo", $_POST["resumo"]),
					array("sobre", $_POST["sobre"])
					);
 
	sql_update("projetos", $dados, "id='".$id."'" ); 
  	xml_projeto($id);

	$dados = sql_select("dados","layout_home","","",false);  
	$layout_home = explode(",",$dados["layout_home"]); 
	$key = array_search("item".$id, $layout_home);

	if($_POST["publicado"] == 0){  
		if( $key !== false ){  
			unset( $layout_home[$key] );  
			$layout_novo = implode(",",$layout_home);
			sql_update("dados", array(array("layout_home",$layout_novo)), "" ); 
		} 
	}else{  
		if( $key === false ){  
			array_push($layout_home, "item".$id ); 
			$layout_novo = implode(",",$layout_home);
			sql_update("dados", array(array("layout_home",$layout_novo)), "" );  
		} 
	}	
	
	xml_dados();

	location("../projeto_dados.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 