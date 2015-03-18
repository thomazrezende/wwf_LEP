<?php

	//INISET
 	ini_set('error_reporting', E_ALL);
    ini_set('show_errors', true);
    ini_set('display_errors', true);
	ini_set("upload_max_filesize", "200M");
	ini_set("post_max_size", "200M");
 
function sessao(){
	if(!isset($_SESSION)){
		session_start(); // verificar se a SESSION ja foi criada e (se nao) cria
		session_regenerate_id(); // renova a id de sessao para evitar invasoes
	} 	
}

function sessao_local($itens,$criar){
	//itens = array( array(label,valor) , array(label,valor) );
	sessao();
	// limpa sessao
	for($u=0;$u<count($itens);$u++){
		unset($_SESSION[$itens[$u][0]]);
	}
	
	//recria sessao
	if($criar){
		for($s=0;$s<count($itens);$s++){
			$_SESSION[$itens[$s][0]] = $itens[$s][1];
		}
	}
} 

function get_session($get_lb, $session_lb){
	if(isset($_GET[$get_lb])){
		 sessao_local(array( array($session_lb,$_GET[$get_lb])),true);
	}
	return $_SESSION[ $session_lb ];		
} 

function sessao_lg($lg){ 
	sessao();
	$_SESSION["lg"] = $lg;	 
} 

function get_lg(){ 
	sessao();
	return $_SESSION["lg"]; 
}

// log
function verif_log(){
	sessao();
	if(!isset($_SESSION["logado"]) || $_SESSION["logado"]!= md5("acesso_ok_90432498")){
		header("Location:login.php");
		exit;
	}
}

function verif_token(){
	sessao();
	if(!isset($_SESSION["token_ok"]) || $_SESSION["token_ok"]!= md5("token_ok_02894621")){
		header("Location:login.php?msg_erro=TEMPO DE REDEFINIÇÃO DE SENHA ESGOTADO");  
		exit;
	}
}

function logout(){
	sessao();
	$_SESSION["logado"] = md5("acesso_negado");
	session_unset();
	session_destroy();
} 

function cria_senha($n){
	$senha="";	
	
	for($i=0;$i<$n;$i++){		
		($i<3)?( $char=chr(65+mt_rand(0,25)) ):( $char=mt_rand(0,9) );					
		$senha.=$char;
	}	
	return strtolower($senha);	
}

// password hash by Richard Lord - http://www.bigroom.co.uk/blog/php-password-security 
function getPasswordSalt(){
    return substr( str_pad( dechex( mt_rand() ), 8, '0', STR_PAD_LEFT ), -8 );
}

// calculate the hash from a salt and a password
function getPasswordHash( $salt, $password ){
    return $salt . ( hash( 'whirlpool', $salt . $password ) );
}

// compare a password to a hash
function comparePassword( $password, $hash ){ // retorna 1 se true
    $salt = substr( $hash, 0, 8 ); 
    return $hash == getPasswordHash( $salt, mysql_real_escape_string($password) );
}
 
function ver_senha($password){
	// get a new hash for a password
	$hash = getPasswordHash( getPasswordSalt(), $password );
	print $hash;
}  


?>