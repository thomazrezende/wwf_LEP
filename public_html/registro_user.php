<?php 

	require_once("../_control/seguranca.php"); 
	require_once("../_control/acesso.php");
	require_once("cms_lep/_tr/html.php"); 
	require_once("cms_lep/_tr/mysql.php");
	
	conectar();
	verif_log();  
	 
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$nome = test_input($_POST["nome"]);
	$email = test_input($_POST["email"]);
	$profissao = test_input($_POST["profissao"]); 
	$news = $_POST["news"]; 

	$valores = array(	array("nome", $nome),
						array("email", $email),
						array("profissao", $profissao),
						array("ativo", $news)
					); 

	sql_insert("visitantes", $valores);
	
?>