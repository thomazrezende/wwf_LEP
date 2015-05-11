<?php 
/* TRCOM */ 

function chama_colunas($colunas){
	 
	$nitens=count($colunas); // colunas  um array com os itens a serem listados
	$itens="";
 
	for($i=0;$i<$nitens;$i++){
		$itens.=$colunas[$i];
		if($i<($nitens - 1)) { $itens.=", "; }
		}
	return $itens;
}

function cdata($lb){
	if (substr($lb, 0, 2) == "dd" || 
		substr($lb, 0, 2) == "id" || 
		substr($lb, 0, 4) == "data" ||
		$lb == "grupo" ||
		$lb == "lat" ||
		$lb =="lng" ||
		$lb == "zoom" || 
		$lb == "bites" || 
		$lb == "publicado") return false;
	else return true;
}
 
function xml( $arquivo, $pai, $filho, $tabela, $colunas, $condicao, $numerar_itens, $join ){
	 
	//$numerar_itens: boolean - insere o id do item na tag 
	 
	$itens=chama_colunas($colunas);//array com itens a serem selecionados
	 
	$sql="SELECT ".$itens." FROM ".$tabela." ".$condicao.";";
	$consulta=mysql_query($sql) or die(mysql_error());
	$nreg=mysql_num_rows($consulta);
	  
	// Abre / cria o arquivo xml com permisso para escrever 
	$xml = fopen($arquivo, "w+");
	chmod($arquivo,0644);
 
	//Escreve o cabealho e o primeiro n do xml 
	fwrite($xml, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n"); 
	fwrite($xml, "<".$pai.">\r\n");	 		
 
 	//cria conteudo
	$nrolls=count($colunas);
	$conteudo="";
	for($i=0; $i<$nreg; $i++) { 
		 
		if(isset($filho) && !empty($filho)){
			$id_filho = mysql_result($consulta,$i,"id"); 
				if($numerar_itens) $conteudo .= "\t<".$filho.$id_filho.">\r\n";
				else $conteudo .= "\t<".$filho.">\r\n";  
			}  
			
			for($c=0;$c<$nrolls;$c++){
				$lb=$colunas[$c]; 
				if( cdata($lb) ){
					$conteudo .= "\t\t<".$lb."><![CDATA[".mysql_result($consulta,$i,$lb)."]]></".$lb.">\r\n"; 
				}else{
					$conteudo .= "\t\t<".$lb.">".mysql_result($consulta,$i,$lb)."</".$lb.">\r\n"; 
				} 
			}
		
			////////// join
		
			if($join){ 
				
				$id = mysql_result($consulta,$i,'id'); 
				$n_join = count($join);
				
				for($t=0; $t<$n_join; $t++){
					
					$itens_join = chama_colunas( $join[$t][3] );
					
					$sql_join="SELECT ".$itens_join." FROM ".$join[$t][0]." WHERE ".$join[$t][2]."='".$id."';";
					$consulta_join=mysql_query($sql_join) or die(mysql_error());
					$nreg_join=mysql_num_rows($consulta_join);
					
					$conteudo .= "\t\t<".$join[$t][0].">\r\n"; 
					
					for($j=0; $j<$nreg_join; $j++){ // para cada resultado
						
						if( !empty($join[$t][1])){
							$conteudo .= "\t\t\t<".$join[$t][1].">\r\n";
						}
						
						for($cj=0; $cj<count($join[$t][3]); $cj++){ // para cada coluna no resultado 
							
							$lb_join = $join[$t][3][$cj]; 
							
							if( cdata($lb_join) ){
								$conteudo .= "\t\t\t\t<".$lb_join."><![CDATA[".mysql_result($consulta_join,$j,$lb_join)."]]></".$lb_join.">\r\n";  
							}else{
								$conteudo .= "\t\t\t\t<".$lb_join.">".mysql_result($consulta_join,$j,$lb_join)."</".$lb_join.">\r\n"; 
							} 
						}  
					   
						if( !empty($join[$t][1])){					
							$conteudo .= "\t\t\t</".$join[$t][1].">\r\n"; 
						} 
					}
					
					$conteudo .= "\t\t</".$join[$t][0].">\r\n"; 
				}
				
			}
		
			////////// /join
		 
	 		if(isset($filho) && !empty($filho)){ 
				if($numerar_itens) $conteudo .= "\t</".$filho.$id_filho.">\r\n";
				else $conteudo .= "\t</".$filho.">\r\n";
			}
	    }		
		
	  //Escrevendo no xml
	  fwrite($xml, $conteudo);
 
	//Finalizando com a ltima tag 
	fwrite($xml, "</".$pai.">");
	
	//Fechando o arquivo 
	fclose($xml); 		
} 	

function xml_dados(){
	$arquivo="../../xml/dados.xml";
	$colunas=array("email","links","sobre_lep","sobre_psc",'fbook','twitter','layout_home');
	xml($arquivo, "dados", "", "dados", $colunas, "",false,false);
} 

function xml_banners(){
	$arquivo="../../xml/banners.xml";
	$colunas=array("id","credito","link","tema");
	xml($arquivo, "banners", "banner", "banners", $colunas, "",false,false);
}

function xml_projetos(){
	$arquivo="../../xml/projetos.xml";
	$colunas=array("id","publicado","titulo","lat","lng","zoom","resumo");
	$join = array(
		array(	"resultados", // table to join / pai
			  	"resultado",  // filho
 				"id_projeto", // label id ex:id_projeto
			    array("id", "titulo", "label", "titulo_legenda", "legenda")),// colunas join
		array(	"arquivos", // table to join / pai
			  	"arquivo",  // filho
 				"id_projeto", // label id ex:id_projeto
			    array("id","grupo","titulo", "label")) // colunas join
	); 
	xml($arquivo, "projetos", "projeto", "projetos", $colunas, "ORDER BY id DESC",false, $join);
}							
						
function xml_documentos(){
	$arquivo="../../xml/documentos.xml";
	$colunas=array("id","id_projeto","publicado","titulo","autor","ano","veiculo","link", "palavras_chave","arquivo");
	xml($arquivo, "documentos", "documento", "documentos", $colunas, "ORDER BY titulo",false,false);
}

function xml_projeto($id){
	$arquivo="../../projetos/projeto".$id."/dados.xml";
	$colunas = array("id","publicado","titulo","lat","lng","zoom","sobre");
	$join = array(
		array(	"resultados", // table to join / pai
			  	"resultado",  // filho
 				"id_projeto", // label id ex:id_projeto
			    array("id", "titulo", "label", "titulo_legenda", "legenda")),// colunas join
		array(	"documentos", // table to join / pai
			  	"documento",  // filho
 				"id_projeto", // label id ex:id_projeto
			    array("id", "publicado", "titulo", "autor", "ano", "veiculo", "link", "arquivo")),// colunas join
		array(	"arquivos", // table to join / pai
			  	"arquivo",  // filho
 				"id_projeto", // label id ex:id_projeto
			    array("id","grupo","titulo", "label"))
	); 
	xml($arquivo, "dados", "", "projetos", $colunas, "WHERE id='".$id."'", false, $join);
	xml_projetos();
}		

 ////////////// xml especÌfico

 function xml_projeto_ANTIGO($id){ 
	
	$colunas = array("id","publicado","titulo","lat","lng","zoom","sobre");
	$itens = chama_colunas($colunas);
			
	$arq_xml="../../projetos/projeto".$id."/dados.xml";
	
	$sql="SELECT ".$itens." FROM projetos WHERE id=".$id.";";
	$consulta=mysql_query($sql) or die(mysql_error());
	$ok=mysql_query($sql) or die(mysql_error());
	 
	// Abre / cria o arquivo xml com permisso para escrever 
	$xml = fopen($arq_xml, "w+");
	chmod($arq_xml,0644);
 
	//Escreve o cabealho e o primeiro n do xml 
	fwrite($xml, "<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n"); 
	fwrite($xml, "<projeto>\r\n");
	fwrite($xml, "\t<dados>\r\n");
 
 	//cria conteudo
	$nrolls=count($colunas);
	$conteudo="";
		
		for($c=0;$c<$nrolls;$c++){
			$lb=$colunas[$c];
			$conteudo .= "\t\t<".$lb."><![CDATA[".mysql_result($consulta,0,$lb)."]]></".$lb.">\r\n";
		}
				
	  //Escrevendo no xml
	  fwrite($xml, $conteudo);
 
	//Finalizando com a ltima tag 
	fwrite($xml, "\t</dados>\r\n");
	
	 /*
	// arquivos 
	fwrite($xml, "\t<arquivos>\r\n");
	$colunas_arq = array("id","id_projeto","file","embed","autoplay");
	$nrolls_arq=count($colunas_arq);
	
	$sql_arq="SELECT * FROM arquivos WHERE id_projeto='".$id."'";
	$consult_arq=mysql_query($sql_arq) or die(mysql_error());
	while($result=mysql_fetch_assoc($consult_arq)){
		
		//cria conteudo
		$conteudo_arq="";
		$conteudo_arq.="\t\t<arquivo>\r\n";
			
			for($a=0;$a<$nrolls_arq;$a++){
				$lb_arq=$colunas_arq[$a];
				$conteudo_arq.= "\t\t\t<".$lb_arq."><![CDATA[".$result[$lb_arq]."]]></".$lb_arq.">\r\n"; 
			}
			
		$conteudo_arq.="\t\t</arquivo>\r\n";
		 //Escrevendo no xml
	  	fwrite($xml, $conteudo_arq);
	}	
	fwrite($xml, "\t</arquivos>\r\n");  
	*/
	 
	fwrite($xml, "</projeto>\r\n");
	//Fechando o arquivo 
	fclose($xml); 
	
	xml_projetos();
}
 


?>