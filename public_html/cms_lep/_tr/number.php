<?php
/* TRCOM
 
NUMBER V 1.0

*/ 

function duas_casas($alvo){
	($alvo<10) ? ($retorno = "0".$alvo) : ($retorno = $alvo);
	return $retorno;
}

function tres_casas($alvo){
	if($alvo<10) {
		$retorno = "00".$alvo;
	}
	else if($alvo<100 && $alvo >=10){
		$retorno = "0".$alvo;
	}else{
		$retorno = $alvo;
	}	
	return $retorno;
}

?>


