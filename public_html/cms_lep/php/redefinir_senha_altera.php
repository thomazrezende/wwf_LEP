<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	
	conectar(); 
	
	if( empty($_POST["senha_nova"]) || empty($_POST["senha_confirma"]) ) {  
		
		$msg="PREENCHA OS 2 CAMPOS";
		location("../redefinir_senha.php","msg_erro=".$msg);
		
	} 
	
	elseif( $_POST["senha_nova"] != $_POST["senha_confirma"]) {
		
		$msg="CONFIRMAÇÃO INVÁLIDA";
		location("../redefinir_senha.php","msg_erro=".$msg); 
	
	}else{  
		
		$senha_nova = getPasswordHash(getPasswordSalt(), $_POST["senha_nova"] ); 

		$ok = sql_update("dados", array(array("senha",$senha_nova)),""); 

		if($ok){
			$msg="SENHA ALTERADA COM SUCESSO";
			location("../login.php","msg_ok=".$msg); 
		}else{ 
			$msg="HOUVE UM ERRO. POR FAVOR TENTE NOVAMENTE";
			location("../login.php","msg_erro=");
		}
		 
				
	}


?>