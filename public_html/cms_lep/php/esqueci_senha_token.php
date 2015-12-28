<?php

require_once("../../../_control/acesso.php");
require_once("../../../_control/seguranca.php");
require_once("../_tr/mysql.php");
require_once("../_tr/html.php");
require_once('../../_tools/PHPMailer/class.phpmailer.php');
require_once("../_domain.php");

conectar();

	$email = $_POST["email"];
	$dados = sql_select("usuarios", "*", "", "email='".$email."'", false);

	if( $dados["id"] == NULL ){

		location("../esqueci_senha.php","msg_erro=USUÁRIO NÃO ENCONTRADO");

	}else{

		$to_email = $dados["email"];
		$id = $dados['id'];
		$token_date = $_SERVER["REQUEST_TIME"];
		$token = md5( $token_date + rand(0,1000) );

		$valores = array(
			array("token",$token),
			array("token_date",$token_date)
		);

		$ok = sql_update("usuarios", $valores , "id='".$id."'");

		// email

		function gerar_link($d,$c,$t,$id){
			return "http://.".$d."/".$c."/php/redefinir_senha_action.php?id=".$id."&token=".$t;
		}

		$mensagem =  "<br><br>Clique no bot&atilde;o a seguir para redefinir a senha de acesso ao seu painel de administra&ccedil;&atilde;o<br>";
		$mensagem .= '<a href="'.gerar_link( $domain, $cms_folder, $token, $id ).'" target="_blank" style="margin-top:20px; padding:12px 50px; background:#333; color:#fff; font-size:14px; font-weight:bold; font-family:Arial, sans-serif; border-radius:10px; display:inline-block; text-decoration:none">REDEFINIR SENHA</a><br><br>';

		//PHPMailer
		$email = new PHPMailer();

		$email->IsHTML(true);
		$email->charSet = "UTF-8";
		$email->setFrom ( $generic_mail.'@'.$domain, $domain );
		$email->Subject = 'Redefinir senha';
		$email->Body = $mensagem;
		$email->AddAddress( $to_email );

		$send_mail = $email->Send();

		if(!$send_mail){
			die("ERRO: ".$email->ErrorInfo);
		}else{
			location("../login.php","msg_ok=INSTRUÇÕES DE REDEFINIÇÃO DE SENHA ENVIADAS POR E-MAIL");
		}

	}




?>
