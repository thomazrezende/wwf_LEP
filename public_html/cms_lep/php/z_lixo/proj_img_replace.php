<?php   

require_once("../../../_control/seguranca.php"); 
require_once("../../../_control/acesso.php");
require_once("../_tr/html.php"); 
require_once("../_tr/xml.php"); 
require_once("../_tr/arquivo.php");
require_once("../_tr/mysql.php");

conectar();
verif_log();

if (!empty($_FILES['imagem']['name'])){ 
	
	$dados = array(	array("file",$_FILES['imagem']['name']) ); 
	sql_update("arquivos", $dados, "id='".$_SESSION["id_file"]."'" );
	
	up_img_var("imagem",-1,"w",640,"../../projetos/projeto".$_SESSION["id"]."/img".$_SESSION["id_file"]."m","jpeg"); 
	up_img_var("imagem",-1,"w",860,"../../projetos/projeto".$_SESSION["id"]."/img".$_SESSION["id_file"]."g","jpeg"); 
	up_img_fixo("imagem",-1,140,88,"../../projetos/projeto".$_SESSION["id"]."/tb".$_SESSION["id_file"],"jpeg");
	up_img_fixo("imagem",-1,36,36,"../../projetos/projeto".$_SESSION["id"]."/tb".$_SESSION["id_file"]."p","jpeg");	

} 

?> 