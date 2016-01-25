<?php

/* TRCOM
 
STRING V 1.0

*/

function caps($alvo){
	return mb_strtoupper( $alvo, "utf-8");
}

function cr($empresa,$direitos){
	print "&copy; ".date("Y")." ".$empresa." - ".$direitos;
}

// converter dados que vem de um xml codificado como utf-8
function u2h($alvo){ 
	return htmlentities($alvo, ENT_QUOTES, "UTF-8" );
} 

// converter dados que vem direto do BD (UTF8 nao rola)
function bd2h($alvo){
	return htmlentities($alvo, ENT_QUOTES );
}



?>