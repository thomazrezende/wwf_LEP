<?php  
	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/mysql.php"); 
	
	conectar();
	verif_log(); 
	
	// salva alterações
	$visitantes = sql_select( "visitantes","id","","",true );
	
	for($i=0; $i<count($visitantes); $i++){   
		$id = $visitantes[$i]['id'];  
		$dados = array(	array("ativo", $_POST["ativo".$id])); 
		sql_update("visitantes", $dados, "id='".$id."'" ); 
	} 

	$visitantes = sql_select( "visitantes","*","nome","",true );  
	
	//gera csv
	header("Content-type: text/csv; charset=UTF-8");
	header("Content-Disposition: attachment; filename=visitantes_lep.csv"); 
	header("Cache-Control: no-cache, no-store, must-revalidate"); 
	header("Pragma: no-cache");
	header("Expires: 0");

	$csv = fopen("php://output", "w");

	for($i=0; $i<count($visitantes); $i++){  
		if($visitantes[$i]['ativo'] == 1){  
			$row = array( $visitantes[$i]['email'], $visitantes[$i]['nome'], $visitantes[$i]['profissao'] );  
			fputcsv($csv, $row); 
		} 
	}

	fclose($csv);
	
?>