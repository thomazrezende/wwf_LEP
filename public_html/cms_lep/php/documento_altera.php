<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log(); 

	$id = $_GET["id"];
	
	$dados = array(
					array("publicado", $_POST["publicado"]),
					array("titulo", $_POST["titulo"]),
					array("autor", $_POST["autor"]),
					array("ano", $_POST["ano"]),
					array("veiculo",$_POST["veiculo"]),
					array("link", $_POST["link"]),
					array("palavras_chave", $_POST["palavras_chave"])
					);
 
 
	sql_update("documentos", $dados, "id='".$id."'" ); 
	
  	xml_documentos(); 

	location("../documento.php","id=".$id."&msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 