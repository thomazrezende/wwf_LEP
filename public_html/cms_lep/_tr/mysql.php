<?php 
/* TRCOM

mySQL V 1.0

*/ 

// query

function sql_update($tabela, $valores, $where){ 
	// $valores:Array = [["coluna","'valor'"],...];
	
	$sql=" 	UPDATE ".$tabela." SET ";
	
	for($i=0; $i<count($valores); $i++){		
		$sql .= $valores[$i][0] . " = '" . $valores[$i][1];
		if($i<count($valores) - 1) $sql .= "', ";
		else $sql .= "'";
	}
	
	if(!empty($where)) $sql .= " WHERE ".$where.";";
	else $sql .= ";";
	
	//print $sql; 
	$ok=mysql_query($sql) or die(mysql_error());
	
	if($ok){
		return true;
	}
}

function sql_update_case($tabela, $coluna, $ref, $valores){ 
	//$coluna:String = "dd_destaque"
	//$ref:String = "id" // referencia para as entradas de valor
 	//$valores:Array = [["1",$_POST["campo1"]],...];
	
	$sql=" 	UPDATE ".$tabela." SET " . $coluna. " = CASE ";
	
	for($i=0; $i<count($valores); $i++){		
		$sql .=" WHEN " .$ref. " = " .$valores[$i][0]." THEN '".$valores[$i][1]."'"; 
	}
	
	$sql .= " ELSE ".$coluna." END;"; // importante: evita que os demais registros virem NULL
	
	$ok=mysql_query($sql) or die(mysql_error());
	
	if($ok){
		return true;
	}
} 


function sql_delete($tabela, $ref, $valor, $limit){ 
	
	$sql="DELETE FROM ".$tabela." WHERE " .$ref. " = ".$valor." LIMIT ".$limit.";";								
		
	$ok=mysql_query($sql) or die(mysql_error()); 
	
	if($ok){
		return true;
	}
} 


function sql_insert($tabela, $valores){ 
	// $valores:Array = [["coluna","'valor'"],...];

	$sql=" 	INSERT INTO ".$tabela." ( ";
	
	for($i=0; $i<count($valores); $i++){		
		$sql .= $valores[$i][0];
		if($i<count($valores) - 1) $sql .= ", ";
	}
	
	$sql .= ") VALUES (";
					  
	for($i=0; $i<count($valores); $i++){		
		$sql .= "'".$valores[$i][1]."'";
		if($i<count($valores) - 1) $sql .= ", ";
	} 
	
	$sql .= ");"; 
	
	//print $sql;
	$ok=mysql_query($sql) or die(mysql_error()); 
	
	if($ok){
		return true;
	}
} 

function sql_select($tabela, $colunas, $order_by, $where, $all){ 
	//$colunas:String = "col1, col2, col3..."
	
	$sql="SELECT ".$colunas." FROM ".$tabela; 
	
	if(!empty($where)) $sql .= " WHERE ". $where;
	
	if(!empty($order_by)) $sql .= " ORDER BY ". $order_by.";"; 
	else  $sql .= ";"; 
	
	$consult=mysql_query($sql) or die(mysql_error());
	
	if($all){ 
		$saida = array(); 
		while($result = mysql_fetch_array($consult,MYSQL_BOTH)){
			array_push($saida,$result);	
		} 
		return $saida;
		
	}else{ 
		return mysql_fetch_assoc($consult); 
	} 
}   
 
function sql_select_lj( $tabela_a, $colunas, $tabela_b, $on, $order_by, $where, $all){ 
	//$colunas:String = "tabela_a.col1, tabela_a.col2, tabela_a.col3..."
	//$on:String = "clientes.id = projetos.id_cliente";
	
	$sql="SELECT ".$colunas." FROM ".$tabela_a. " LEFT JOIN " . $tabela_b. " ON ". $on;	
	
	if(!empty($where)) $sql .= " WHERE ". $where;
	
	if(!empty($order_by)) $sql .= " ORDER BY ". $order_by.";";
	else  $sql .= ";"; 
	
	$consult=mysql_query($sql) or die(mysql_error()); 
	
	if($all){ 
		$saida = array(); 
		while($result = mysql_fetch_array($consult,MYSQL_BOTH)){
			array_push($saida,$result);	
		} 
		return $saida;
		
	}else{ 
		return mysql_fetch_assoc($consult); 
	}
} 


/* SELECT - USO:
	$dados = sql_select("projetos","id, projeto_pt","","",true);   
	for($i=0; $i<count($dados); $i++){ 
		print $dados[$i]["id"]. " - ". $dados[$i]["projeto_pt"]."<br>"; 
	} 
	
	print "<br>===============<br>";
	
	$dados2 = sql_select("projetos","id, projeto_pt","","id='9'",false);  
	print $dados2["id"]." = ". $dados2["projeto_pt"]; 
*/ 
	
	
////////////// ferramentas

function ordem($id,$pos_fim,$tabela,$condicao){ 	
	// $condição = reordenar elementos especificos dentro da tabela. ex: imagens com id_projeto = X;
	if(empty($pos_fim)){
		//força como ulimo resultado
		$sql_null = "UPDATE ".$tabela." SET dd_ordem = '100' WHERE id=".$id.";";	
		$consult_null=mysql_query($sql_null) or die(mysql_error());	
	}else{	
	
		// pega valor antigo de ordem do item
		$sql_item="SELECT dd_ordem FROM ".$tabela." WHERE id=".$id.";";		
		$consult_item=mysql_query($sql_item) or die(mysql_error());	
		$result_item = mysql_fetch_assoc($consult_item);
		
		//compara com valor novo ->  gera valor temporario 
		if((float)$result_item["dd_ordem"]>(float)$pos_fim || (float)$result_item["dd_ordem"] <=0){
			$pos_temp=(float)$pos_fim-(float)0.5;
		}else{
			$pos_temp=(float)$pos_fim+(float)0.5;
		}
		
		// deixa tabela na ordem desejada
		$sql_pos = "UPDATE ".$tabela." SET dd_ordem = '".$pos_temp."' WHERE id=".$id.";";	
		$consult_pos=mysql_query($sql_pos) or die(mysql_error());
	}	
	
	//reescreve valores inteiros
	$sql="SELECT id FROM ".$tabela." ".$condicao." ORDER BY ordem;";			
	$consult=mysql_query($sql) or die(mysql_error());	
	//
	$pos=1;	
	while($result=mysql_fetch_array($consult,MYSQL_BOTH)){		
		$sql_fim=	"UPDATE ".$tabela."
					SET dd_ordem ='".$pos."'		
					WHERE id=".$result["id"].";";	
		
		mysql_query($sql_fim) or die(mysql_error());
		$pos++;		 	
	}
}

function next_id($tabela){
	$sql = "SHOW TABLE STATUS LIKE '".$tabela."'";
	$consult = mysql_query($sql) or die(mysql_error());

	$result = mysql_fetch_assoc($consult);
	$next_id = $result['Auto_increment'];
	return $next_id;
}

function nulo($valor){
	if($valor == "" || empty($valor) || !isset($valor)){
		return "NULL";
	}else{
		return "'".$valor."'";
	}
}

function zero($valor){
	if($valor == "" || empty($valor)){
		return 0;
	}else{
		return $valor;
	}
} 
 
 
function verifica_vinculo($tabela, $coluna, $proj_id, $itm_lb){

	// verifica preseça do item "img123" em projeto.layout = "img121,img122,img123" - remove o item do array string

	$projeto = sql_select($tabela,$coluna,"","id='".$proj_id."'",false);
	$itens = explode(",", $projeto[$coluna]);

	$key_itm = array_search($itm_lb,$itens);

	if( $key_itm !== false ){  
		unset($itens[$key_itm]); 
		sql_update($tabela,array(array($coluna,join(",",$itens))),"id='".$proj_id."'");
		xml_proj($proj_id); 
	}	
}  

function verifica_vinculo_renata($coluna,$itm_lb){

	// verifica preseça do item "item123" em renata.home ou renata.textos = "img121,img122,img123" - remove o item do array string

	$layout = sql_select('renata',$coluna,"","",false);
	$itens = explode(",", $layout[$coluna]);

	$key_itm = array_search($itm_lb,$itens);
	
	if( $key_itm !== false ){  
		unset($itens[$key_itm]); 
		sql_update('renata', array(array( $coluna, join(",",$itens))),"");
		xml_renata(); 
	}	
}  


function emb_100($src){ 
	$src_arr = explode( " ", $src );
	$retorno = "";
	
	for($i=0; $i<count($src_arr); $i++){  
		if( substr( $src_arr[$i], 0, 5) == "width" ){
			$retorno .= "width=\"100%\" ";
		}else if( substr( $src_arr[$i], 0, 6) == "height" ){
			$retorno .= "height=\"100%\" ";
		}else{
			$retorno .= $src_arr[$i]." ";
		} 
	}  
	
	return $retorno;
}

?>