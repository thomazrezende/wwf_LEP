<?php   

	require_once("../../../_control/seguranca.php"); 
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php"); 
	require_once("../_tr/xml.php"); 
	require_once("../_tr/arquivo.php");
	require_once("../_tr/mysql.php");
	
	conectar();
	verif_log();
     
	if (!empty($_FILES['imagens']['name'][0])){    
	
	$n_arq = count($_FILES['imagens']['name']);
		
		$n = next_id("miniaturas");
		
		for($i = 0; $i < $n_arq; $i++) { 
		
			$id_img = $n+$i;
			
			up_img_fixo("imagens",$i,110,95,"../../projetos/projeto".$_SESSION["id"]."/mini".$id_img,"jpeg");
			
			$valores = array( 	array("id_projeto",$_SESSION["id"]),
								array("file",$_FILES['imagens']['name'][$i]) 
								);
			
			sql_insert("miniaturas", $valores);  
		} 
		
		//sql_select($tabela, $colunas, $order_by, $where, $all)
		$miniaturas_bd = sql_select("miniaturas","id","","id_projeto='".$_SESSION["id"]."'", true ); 
		$miniaturas_out = array();
		
		for($i=0; $i<count($miniaturas_bd); $i++){
			array_push($miniaturas_out, $miniaturas_bd[$i]["id"]);
		}		
		
		$dados = array(	array("miniaturas", implode(",", $miniaturas_out) )); 
		
		sql_update("projetos", $dados, "id='".$_SESSION["id"]."'" ); 
		
		xml_proj($_SESSION["id"]);
			  
	} 
	
?> 