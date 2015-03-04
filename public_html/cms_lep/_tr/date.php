<?php 
/* TRCOM

DATE ELEMENTS V 1.0

*/ 

function mes($num,$tipo_mes, $lg){
	//$tipo = "numero" "nome" 

	$mes_lbs = array( 	array("00","",""),
	array("01","JAN","JAN"),
	array("02","FEV","FEB"),
	array("03","MAR","MAR"),
	array("04","ABR","APR"),
	array("05","MAIO","MAY"),
	array("06","JUN","JUN"),
	array("07","JUL","JUL"),
	array("08","AGO","AUG"),
	array("09","SET","SEP"),
	array("10","OUT","OCT"),
	array("11","NOV","NOV"),
	array("12","DEZ","DEC"));
	
	if($tipo_mes == "numero"){
		return $mes_lbs[(int)$num][0];
	}else{		
		($lg == "pt")?($nlg = 1):($nlg = 2);
		return $mes_lbs[(int)$num][$nlg];
	}
}

//2003-10-09 para 09.10.2003 ou 09 out 2003 ## precisa da mes()! 
function dma($data, $formato, $separador, $tipo_mes, $lg){ 
	
	switch($formato){
		case "ddmm":
			return substr($data,8,2).$separador.mes(substr($data,5,2),$tipo_mes,$lg);
		break;
			
		case "ddmmaaaa":
			return substr($data,8,2).$separador.mes(substr($data,5,2),$tipo_mes,$lg).$separador.substr($data,0,4);
		break;
		
		case "ddmmaa":
			return substr($data,8,2).$separador.mes(substr($data,5,2),$tipo_mes,$lg).$separador.substr($data,2,2);
		break;
		
		case "mmaaaa":
			return mes(substr($data,5,2),$tipo_mes,$lg).$separador.substr($data,0,4);
		break;
		
		case "mmaa":
			return mes(substr($data,5,2),$tipo_mes,$lg).$separador.substr($data,2,2);
		break;
		
	}
} 


?>