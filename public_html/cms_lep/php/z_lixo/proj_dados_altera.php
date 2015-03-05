<?php    

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();     
	
	sessao();
	$_SESSION["proj"] = $_POST["titulo"];
	
	$dados = array(
					array("titulo",$_POST["titulo"]),
					array("subtitulo", mysql_real_escape_string ($_POST["subtitulo"])),
					array("id_categ",$_POST["id_categ"]),
					array("publicado",$_POST["publicado"]),
					array("data",$_POST["data"]),
					array("area",$_POST["area"]),
					array("resumo",$_POST["resumo"]),
					array("texto",$_POST["texto"])
					);
 
 
	sql_update("projetos", $dados, "id='".$_SESSION["id"]."'" ); 
	
  	xml_proj($_SESSION["id"]); 

	// att layout textos
	if($_POST["publicado"] == 1 ){
		
		$item = "item".$_SESSION["id"];
		
		//incluir no final do layout home
		$layout_bd = sql_select('renata','home',"","",false);
		$layout_arr = explode(',', $layout_bd['home']);
		
		$key_itm = array_search($item, $layout_arr); 
		
		if( $key_itm === false ){ 
			array_push($layout_arr, $item); 
			sql_update('renata', array(array( 'home', join(',',$layout_arr) )),"");
			xml_renata();
		} 
		
	}else{
		//remove
		verifica_vinculo_renata('home',"item".$_SESSION["id"]);
	} 

	location("../proj_dados.php","msg_ok=DADOS ALTERADOS COM SUCESSO"); 
	
?> 