<?php   

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
	
	if(isset($_POST["autor"]) && !empty($_POST["autor"])){
		
		$prox = next_id("critica"); 
		
		$valores = array(	array("autor",$_POST["autor"]), 
							array("publicado",0)
							); 
		 
		sql_insert("critica", $valores);
		
		location("escolhe_texto.php?id=".$prox."&autor=".$_POST["autor"],""); 
	}else{ 
		location("../textos.php","msg_erro=ESCOLHA UM NOME"); 
	}
	
?> 