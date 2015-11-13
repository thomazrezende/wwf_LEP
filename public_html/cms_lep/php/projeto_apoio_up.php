<?php  

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/arquivo.php");
	
	conectar();
	verif_log();

	$id = $_GET["id"];
	$id_projeto = $_SESSION["id"];

	unlink("../../projetos/projeto".$id_projeto."/apoio.jpg");
	up_img_var("imagem", -1, 'w', 450, "../../projetos/projeto".$id_projeto."/apoio", "jpeg");  
	
	

?>