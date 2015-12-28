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
		$usuarios = sql_select("usuarios","*","","",true);

		$pass = false;

		for( $i=0; $i<count($usuarios); $i++ ){
			 // if(1<2){
			if( $_POST["login"] == $usuarios[$i]["email"] && comparePassword( $_POST["senha"], $usuarios[$i]["senha"]) == 1 ){
				$pass = true;
				$pass_id = $usuarios[$i]["id"];
				$pass_admin = $usuarios[$i]["admin"];
				$pass_name = $usuarios[$i]["nome"];
				$pass_email = $usuarios[$i]["email"];
			 }
		}

		if( $pass == false ){
			location("../login.php","msg_erro=DADOS INCORRETOS");
		}else{
			registra_log("../../../_control/logs", $pass_id, $pass_name, $pass_email );
			sessao_local( array(
							array("logado", md5("acesso_ok_90432498")),
							array("user_id",$pass_id),
							array("user_admin",$pass_admin),
							array("user_email",$pass_email),
							array("user_name",$pass_name)
						),true );

			sessao_lg("pt");
			location("../lep_dados.php","msg_ok=OLÁ ".strtoupper($pass_name));
		}
	}

?>
