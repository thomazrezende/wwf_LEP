<?php   

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();  
	
	if(isset($_POST["titulo"]) && !empty($_POST["titulo"])){
		
		$prox = next_id("projetos");
		mkdir("../../projetos/projeto".$prox,0755);
		
		$valores = array(	array("titulo",$_POST["titulo"]),
							array("data",date("Y")),
							array("publicado",0)
							); 
		 
		sql_insert("projetos", $valores);
		
		location("escolhe_proj.php?id=".$prox."&proj=".$_POST["titulo"],""); 
	}else{ 
		location("../projetos.php","msg_erro=ESCOLHA UM NOME"); 
	}
	
?> 