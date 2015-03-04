<?php  

	require_once("../../../_tr_1048672/seguranca.php"); 
	require_once("../../../_tr_1048672/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log(); 
		
	$valores = array(
		array("autor",$_POST["autor"]),
		array("publicado",$_POST["publicado"]),
		array("titulo",$_POST["titulo"]),
		array("data",$_POST["data"]),
		array("texto",$_POST["texto"])
	);
	
	sessao();
	$_SESSION["autor"] = $_POST["autor"];
 
	$ok = sql_update("critica", $valores, "id=".$_SESSION["id_critica"]);
	xml_textos();

	// att layout textos
	if($_POST["publicado"] == 1 ){
		
		$item = "item".$_SESSION["id_critica"];
		
		//incluir no final do layout home
		$layout_bd = sql_select('renata','textos',"","",false);
		$layout_arr = explode(',', $layout_bd['textos']);
		
		$key_itm = array_search($item, $layout_arr); 
		
		if( $key_itm === false ){ 
			array_push($layout_arr, $item); 
			sql_update('renata', array(array( 'textos', join(',',$layout_arr) )),"");
			xml_renata();
		} 
		
	}else{
		//remove
		verifica_vinculo_renata('textos',"item".$_SESSION["id_critica"]); 
	}
	
	location("../texto_dados.php?msg_ok=DADOS ALTERADOS COM SUCESSO",""); 
	

?>