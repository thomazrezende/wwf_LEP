<?php  
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/xml.php");
	
	conectar();
	verif_log();
	
	$id = $_GET['id'];

	remove_pasta('../../projetos/projeto'.$id, 'projetos', $id, array('arquivos','resultados'), array('id_projeto','id_projeto'));
	remove_pasta('../../repositorio/projeto'.$id, false, false, false, false);
	//remove_pasta($path, $tabela, $id, $tabelas_vinc, $lbs_vinc){ 
	
	$dados = sql_select("dados","layout_home","","",false);  
	$layout_home = explode(",",$dados["layout_home"]); 
	$key = array_search("item".$id, $layout_home);

	if( $key !== false ){  
		unset( $layout_home[$key] );  
		$layout_novo = implode(",",$layout_home); 
		sql_update("dados", array(array("layout_home",$layout_novo)), "" ); 
		xml_dados();
		xml_projetos();
	}

	location("../projetos.php","msg_ok=PROJETO REMOVIDO COM SUCESSO");
	
?>