<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();  
	
	if(isset($_POST["titulo"]) && !empty($_POST["titulo"])){
		
		$prox = next_id("projetos"); 
		mkdir("../../projetos/projeto".$prox,0755);
		mkdir("../../repositorio/projeto".$prox,0755);
		
		$valores = array(	array("titulo",$_POST["titulo"]), 
							array("publicado",0)
							);
		
		sql_insert("projetos", $valores);
		
		location("escolhe_projeto.php","id=".$prox."&titulo=".$_POST["titulo"]); 
	}else{ 
		location("../projetos.php","msg_erro=ESCOLHA UM TÍTULO"); 
	}
	
?>