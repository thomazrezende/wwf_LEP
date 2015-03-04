<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	
	conectar();
	verif_log();   
	
	$dados_arr = sql_select("dados", "senha", "", "", false); 	
	$senha_banco = $dados_arr["senha"];  
	
	if( empty($_POST["senha_nova"]) || empty($_POST["senha_confirma"]) || empty($_POST["senha_atual"]) ) {  
		
		$msg="PREENCHA OS 3 CAMPOS";
		location("../lep_senha.php","msg_erro=".$msg);
		
	} 
	
	elseif( $_POST["senha_nova"] != $_POST["senha_confirma"]) {
		
		$msg="CONFIRMAÇÃO INVÁLIDA";
		location("../lep_senha.php","msg_erro=".$msg); 
	
	}else{
		
		$compara = comparePassword( $_POST["senha_atual"], $senha_banco);
		 
		if(	$compara == 1) {
			$senha_nova = getPasswordHash(getPasswordSalt(), $_POST["senha_nova"] ); 
			 
			$ok = sql_update("dados", array(array("senha",$senha_nova)),""); 
			 
			if($ok){
				$msg="SENHA ALTERADA COM SUCESSO";
				location("../lep_senha.php","msg_ok=".$msg); 
			}else{ 
				location("../lep_senha.php","msg_erro=ERRO");
			}
		
		}else{		
			$msg="SENHA ATUAL INCORRETA";			
			location("../lep_senha.php","msg_erro=".$msg); 
			
		}			
	}


?>