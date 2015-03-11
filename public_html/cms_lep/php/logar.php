<?php  
require_once("../../../_control/seguranca.php");
require_once("../../../_control/acesso.php");   
require_once("../_tr/html.php");  
require_once("../_tr/mysql.php"); 
	

	//logoff
	if(isset($_GET["sessao"]) && $_GET["sessao"] == "false"){
		logout();
		location("../login.php","");
	}else{
		conectar();
		
		$dados = sql_select("dados","email, senha","","",false);   
		//print $dados["email"]. " - ". $dados["senha"];  
		
		//if(1>2){
		if($_POST["login"] != $dados["email"] || comparePassword( $_POST["senha"], $dados["senha"])!=1){ 
			location("../login.php","msg_erro=DADOS INCORRETOS");
		}else{
			registra_log("../../../_control/logs"); 
			sessao_local( array(array("logado",md5("acesso_ok_90432498"))),true ); 
			
			sessao_lg("pt");
			location("../lep_dados.php","msg_ok=BEM VIND@!");
		} 
	}

?>


 