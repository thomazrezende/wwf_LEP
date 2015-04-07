<?php
/* TRCOM

HTML ELEMENTS V 1.0

*/

// $rtn = retorno:boolean 

///////////// GERAL  

header('Content-Type: text/html; charset=UTF-8',true);
ini_set('default_charset','UTF-8');
mb_internal_encoding('UTF-8'); 
ini_set('max_upload_filesize', 2000000); 

function head($title){ 
	
	print "<!DOCTYPE html>\r\n";
	print "<html lang=\"pt-br\">\r\n";
	print "<head>\r\n";
	print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
	print "<meta http-equiv=\"Content-Language\" content=\"pt-br\" />\r\n";
	
	print "<title>".$title."</title>\r\n";
	print "<meta name=\"robots\" content=\"noindex, nofollow\">\r\n";
	print "<link rel=\"shortcut icon\" href=\"../_layout/fav_icon.png\"/>\r\n";
	
	print "<link rel=\"stylesheet\" type=\"text/css\" href=\"_admin.css\"/>\r\n";
	
	print "<script type=\"text/javascript\" language=\"javascript\" src=\"../_tools/jquery-2.0.2.min.js\" charset=\"utf-8\"></script>\r\n"; 
	print "<script type=\"text/javascript\" language=\"javascript\" src=\"../_tools/jquery.form.js\" charset=\"utf-8\"></script>\r\n"; 
	print "<script type=\"text/javascript\" language=\"javascript\" src=\"func_js.js\" charset=\"utf-8\"></script> \r\n"; 
	
	print "</head>\r\n";
	 
} 


function div1( $id, $cls, $html, $close ){
	print "<div id=\"".$id."\" class=\"".$cls."\">\r\n";
	print $html."\r\n";
	if($close) div2(); 	
}  

function div2(){
	print "</div>\r\n";
}

function a_link( $id, $cls, $url, $lb, $trgt, $rtn ){
	$a = "<a id=\"".$id."\" href=\"".$url."\" class=\"".$cls."\" target=\"".$trgt."\">".$lb."</a>";
	if($rtn) return $a;
	else print $a;
}

function img( $id, $cls, $src, $rtn ){
	if(file_exists($src)){
		$rand = mt_rand();
		$img = "<img id=\"".$id."\" class=\"".$cls."\" src=\"".$src."?".$rand."\" />\r\n";
		if($rtn) return $img;
		else print $img;
	}
}

function embed( $id, $cls, $src, $rtn ){
	if(!empty($src)){
		$embed =  "<div class='".$id."' class='".$cls."' >".$src."</div>";
		if($rtn) return $embed;
		else print $embed; 
	}	
}

function preview( $src, $tipo ){
	if($tipo=="img"){
		if(file_exists($src)){
			titulo("","PREVIEW",false);
				div1('','img_preview','',false);
				img("","",$src, false); 	
			div2();
		}
	}
	
	if($tipo == "emb"){
		if(!empty($src)){
			titulo("","PREVIEW",false);
			div1('','emb_preview','',false);
				embed("","",$src, false); 
			div2();
		} 
	}
} 	  

function check_tb($tb, $tipo, $class){
	
	$cls = "";
	if(!empty($class)) $cls = "class=\"".$class."\""; 
	
	if( !file_exists($tb) ) { 
		if(!empty($tipo)){
			$_tb = "<img src=\"_layout/ico_".$tipo.".png\"/>"; 
		}else{
			$_tb = "<img src=\"_layout/tb_generica.jpg\"/>"; 
		}
		
	}else{ 
		$_tb = "<img ".$cls." src=\"".reload($tb)."\"/>";
	}
	
	return $_tb; 

}


function check_tb_url($tb, $tipo){
	
	if( !file_exists($tb) ) { 
		if(!empty($tipo)){
			$_tb = "_layout/ico_".$tipo.".png"; 
		}else{
			$_tb = "_layout/tb_generica.jpg"; 
		}
		
	}else{ 
		$_tb = reload($tb);
	}
	
	return $_tb; 

}

function arquivo($src_abs, $tipo, $tb, $lb, $link, $del){
	
	$src = explode("?",$src_abs);
	
	if(file_exists($src[0])){
	
		if(empty($tb)){
			$_tb = "<img src=\"_layout/ico_".$tipo.".png\"/>";  
		}else{
			$_tb = "<img class=\"item_tb\" src=\"".$tb."\"/>";
		}
		
		$a = "";
		$a2 = "";
		$hover = "";
		if($link) {  
			$a = "<a href=\"".$src_abs."\" class=\"item_link\" target=\"_blank\">\r\n";
			$a2 = "</a>\r\n";
			$hover = "hover";
		}
	
		$file_path = explode("/", $src[0]);
		$file_name = $file_path[count($file_path) - 1];
		
		if(empty($lb)) { 
			$_lb = $file_name;
		}else{ 
			$_lb = $lb;
		}
		
		$bt_del = "";
		if(!empty($del)){
			$bt_del = bt_del($_lb, $del,true);	
		}
		
		print "<div class=\"item_file ".$hover."\">".$a.$_tb."<span>".$_lb."</span>".$a2.$bt_del."</div>\r\n";
	}
} 

function ul1( $id, $cls ){  
	$ul = "<ul id=".$id." class=\"".$cls."\" >"; 
	print $ul;
}

function ul2(){
	print "</ul>";
} 

function item( $id, $tb, $lb, $link, $bts, $hand ){
	// link = array(url, target);
	
	$cls = "item";
	if(!empty($link)) $cls = "item hover";

					$li = 	"<li id=\"".$id."\" class=\"".$cls."\" >";
	 				$li .=	item_tb( $tb, true );  
					$li .=	"<div class=\"item_lb\">".$lb."</div>";
	if($link[0])	$li .=	"<a href=\"".$link[0]."\" class=\"item_link\" ";
	if($link[1])	$li .=	"target='".$link[1]."'";
	if($link[0])	$li .=  "></a>";
	if($hand)		$li .= 	"<div class=\"handle\"><img src=\"_layout/handle.png\"/></div>";	
	
	if($bts)	for( $i=0; $i<count($bts); $i++ ){
					if( $bts[$i][0] == "del" ) $li .= bt_del( $lb, $bts[$i][1], true ); 
					//if( $bts[$i][0] == "mais" ) $li .= bt_mais( $lb, $del, true );  // criar novos modulos
				} 
				
				$li .=	"</li>";
	
	print $li;
	
}

function item_tb( $src, $rtn ){ 
	
	$rand = mt_rand();
	
	$tb = "<img class=\"item_tb\" src=\"_layout/tb_generica.png\"/>";
	if($src) $tb = "<img class=\"item_tb\" src=\"".$src."?".$rand."\" />";
	
	if($rtn) return $tb;
	else print $tb;
	
}
 

function bt_del( $aviso, $del_path, $rtn ){
	$bt = "<a id=\"deletar\" onclick=\"javascript:excluir('".$aviso."','".$del_path."');\" class=\"btp bt_del\"></a>\r\n";
	if($rtn){
		return $bt;
	}else{
		print $bt;
	}
} 


function clear(){
	print "<div class=\"clear\"></div>\r\n";	
} 


function bt_fechar( $id, $rtn ){
	$bt = "<a onclick=\"javascript:fechar('".$id."');\" class=\"btp\">&lt;</a>\r\n";
	if($rtn){
		return $bt;
	}else{
		print $bt;
	}
}
 

function btg_del( $lb, $aviso, $del_path, $rtn ){
	$bt = "<a id=\"excluir_tudo\" onclick=\"javascript:excluir('".$aviso."','".$del_path."');\" class=\"excluir_tudo \">".$lb."</a>\r\n";
	if($rtn){
		return $bt;
	}else{
		print $bt;
	}
}


function voltar($lb, $link){
	return "<a href=\"".$link."\" class=\"bt_voltar\"><span>&laquo; ".$lb."</span></a>";
}

function btg($id, $cls, $lb, $link){
	$href = "";
	if($link) $href = "href=\"".$link."\"";
	print "<a id=\"".$id."\" ".$href." class=\"btg ".$cls."\"><span> ".$lb."</span></a>"; 
} 


function hr(){
	print "<hr>";
}


function vrf_http($url){
	if(substr($url,0,4) != "http" && !empty($url)){
		return "http://".$url;
	}else{
		return $url;
	}
}

function reload($src){
	$rand = mt_rand();
	return $src."?".$rand;	
}

function titulo_pg($lb){   
	print "<div class=\"titulo_pg \">".$lb." </div>\r\n";
}

function obs_right($lb){
	return "<span class=\"fr mr20\">".$lb." </span>\r\n";
}

function titulo($class, $lb, $lg_ico){   
	print "<div class=\"titulo ".$class."\">".$lb." ".band($lg_ico)."</div>\r\n";
}


function band( $lg_ico ){
	//$lg_ico:Boolean - mostrar bandeira 
	if($lg_ico) return "<img width=\"11\" src=\"_layout/bandeira_".get_lg().".jpg\"/>";
}

function mensagem(){ 
	
	$msg_div = "";
	
	if(isset($_GET["msg_ok"])) $msg_div = "<div id=\"mensagem\" class=\"msg_ok\"><span>".$_GET["msg_ok"]."</span></div>";
	if(isset($_GET["msg_erro"])) $msg_div =  "<div id=\"mensagem\" class=\"msg_erro\"><span>".$_GET["msg_erro"]."</span></div>";
							
	print "<div id=\"mensagem_wrap\">".$msg_div."</div>\r\n";
}
  
function navega($bts){   
	for($i=0; $i<count($bts); $i++){
		if($i<count($bts)-1){
			print "<a href=\"".$bts[$i][1]."\" class=\"btg_voltar\"><span><img src='_layout/larr.png'/> ".$bts[$i][0]."</span></a>";
		 }else{
			print "<div id=\"topo\">".caps($bts[$i])."</div>"; 
		} 
	}
}   
	
function location($url,$get){
	$extra = "";
	if(!empty($get)) $extra = "?".$get;  
	
	header("Location: ".$url.$extra);
	ob_end_flush();
} 
 
function back(){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
	ob_end_flush();
}

///////////// MENU  

function menu($menu_arr, $lg_arr, $logo_src, $menu_ativo, $mostrar){

	print "<div id=\"menu\">\r\n";
	print "<div id=\"logo\">\r\n";
	print "<a href=\"http://paisagem.wwf.org.br/cms_lep/lep_dados.php\"><img class=\"menu_logo\" src=\"".$logo_src."\"/></a>\r\n";	
	print "</div>\r\n";
	
	if($mostrar){
	
		print "<ul class=\"menu_ul\">";
		
			for($i=0; $i<count($menu_arr); $i++){
				($menu_ativo==$i+1) ? (menu_li($menu_arr[$i][0],"",true,false) ) : (menu_li($menu_arr[$i][0],$menu_arr[$i][1],false,false));
			} 
				
		print "</ul>\r\n";
	
	}
	
	//idioma
	if(count($lg_arr)>0){ 
		print "<div class=\"titulo_lg\">IDIOMAS</div>\r\n";
		print "<ul class=\"menu_ul\">";
		
			for($i=0; $i<count($lg_arr); $i++){
				(get_lg() == $lg_arr[$i][0]) ? (lg_li($lg_arr[$i][0], $lg_arr[$i][1], true)) : (lg_li($lg_arr[$i][0], $lg_arr[$i][1], false));
			} 
			
		print "</ul>\r\n"; 
	}
	
	//opcoes
	print "<div class=\"titulo_lg\">OP&Ccedil;&Otilde;ES</div>\r\n";
	print "<ul class=\"menu_ul\">";
	
		menu_li("&laquo; SAIR","php/logar.php?sessao=false",false,false);
		menu_li("VIZUALIZAR &rarr;","http://paisagem.wwf.org.br/",false,true);
		
	print "</ul>\r\n"; 
	
	print "</div>\r\n";
} 

function menu_li( $lb, $url, $sel, $target ){
	
	$trg = "_self";
	if($target) $trg = "_blank";
	
	if($sel){
		print "<li class=\"menu_select\">".$lb."</li>";
	}else{
		print "<li><a target=".$trg." href=\"".$url."\">".$lb."</a></li>";
	}
} 
	
/////////////// IDIOMAS   

function lg_li($lg, $lb, $sel){ 
	if($sel){
		print "<li class=\"menu_select\"><img src=\"_layout/bandeira_".$lg.".jpg\" /><span>".$lb."</span></li>";
	}else{
		print "<li><a href=\"php/muda_idioma.php?lg=".$lg."\"><img src=\"_layout/bandeira_".$lg.".jpg\" /><span>".$lb."</span></a></li>";
	}
} 


/////////////// SUBMENU  

function submenu($submenu_arr, $submenu_ativo){ 
	//$submenu_arr:Array = [["label","pagina.php"],...];  
	
	if(!empty($submenu_arr)){
		
		print "<div class=\"submenu_ul\">";
		
		for($i=0; $i<count($submenu_arr); $i++){
			($submenu_ativo==$i+1) ? (submenu_li($submenu_arr[$i][0],"",true) ) : (submenu_li($submenu_arr[$i][0],$submenu_arr[$i][1],false));
		} 
			
		print "</div>\r\n"; 
	
	}else{
		print "<div class=\"submenu_fake\"></div>\r\n";  
	}
}  

function submenu_li($lb, $url, $sel){ 
	if($sel){
		print "<li class=\"submenu_select\">".$lb."</li>";
	}else{
		print "<li><a href=\"".$url."\">".$lb."</a></li>";
	}
} 

/////////////// FORM

function form1($id, $name, $action, $method){  
	print "<form id=\"".$id."\" name=\"".$name."\" action=\"".$action."\" method=\"".$method."\" >\r\n";
}

function form2(){
	print  "</form>\r\n";
}

function checkbox($id, $name, $value, $lb, $img, $chk, $lg_ico){ 
	//img = <img src.../> ou <div
	
	$imagem = "";
	if(!empty($img)) $imagem = $img;
	
	print "<div class=\"checkbox\">\r\n";
		print "<input name=\"".$name."\" value=\"0\" type=\"hidden\" />\r\n"; 
		if($chk){
			print $imagem."<input id=\"".$id."\" name=\"".$name."\" value=\"".$value."\" type=\"checkbox\" checked /> <label for=\"".$id."\"> ".$lb." ".band($lg_ico)."</label>\r\n";
		}else{
			print $imagem."<input id=\"".$id."\" name=\"".$name."\" value=\"".$value."\" type=\"checkbox\" /> <label for=\"".$id."\"> ".$lb." ".band($lg_ico)."</label>\r\n"; 
		}	 
	print "</div>\r\n";
} 

function verifica_chk($val){
	if($val == 1) return true;
	else return false;
}

function radio($id, $name, $value, $lb, $img, $chk, $lg_ico){ 
	$imagem = "";
	if(!empty($img)) $imagem = "<img src=\"".$img."\"/>";  
	
	print "<div>\r\n";  
		if($chk){
			print $imagem."<input id=\"".$id."\" name=\"".$name."\" value=\"".$value."\" type=\"radio\" checked=\"checked\" /><label for=\"".$id."\"> ".$lb." ".band($lg_ico)."</label>\r\n";
		}else{
			print $imagem."<input id=\"".$id."\" name=\"".$name."\" value=\"".$value."\" type=\"radio\" /><label for=\"".$id."\"> ".$lb." ".band($lg_ico)."</label>\r\n";
		}	
	print "</div>\r\n";
	
} 

function select($id, $name, $onchange, $multiple, $opt, $sel, $opt0){ 
	//$opt = [[value,lb],...]
	//$sel = [value escolhido1,...]
	$mltp = "";
	if($multiple) $mltp = "multiple"; 
	$onchg = "";
	if(!empty($onchange)) $onchg = " onchange=\"".$onchg."\" ";
	
	print "<select name=\"".$name."\" id=\"".$id."\" class=\"select\" ".$onchg." ".$mltp." >\r\n";	
	
	if($opt0 != false){
		print "<option class=\"select_opt\" value=\"".$opt0[0]."\">".$opt0[1]."</option>\r\n";
	}else{	
		print "<option class=\"select_opt\" value=\"0\"> + </option>\r\n";
	}
	
	for($i=0; $i<count($opt); $i++){ 
		if(in_array($opt[$i][0],$sel)){
			print "<option class=\"select_opt\" value=\"".$opt[$i][0]."\" selected=\"selected\">".$opt[$i][1]."</option>\r\n";
		}else{
			print "<option class=\"select_opt\" value=\"".$opt[$i][0]."\">".$opt[$i][1]."</option>\r\n";
		} 
	}
	
	print "</select>\r\n";
}

function opcoes($opt_a, $opt_b){
	if(empty($opt_a)) return $opt_b;
	else return $opt_a;
}

function input($id, $cls, $name, $value, $type){ 
	$_id = "";
	if($id) $_id = "id=\"".$id."\""; 
	print "<input ".$_id." name=\"".$name."\" value=\"".$value."\"  type=\"".$type."\" class=\"".$cls."\"/> \r\n";  
} 

function colunas($cols){
	$colunas = "";
	for($i=0; $i<count($cols); $i++){
		$colunas .= "<div class='".$cols[$i][0]."'>".$cols[$i][1]."</div>\r\n";
	}
	 
	return $colunas;
}

function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   
   return $rgb;
}

function rgb2hex($rgb) {
   $hex = "#";
   $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
   $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

   return $hex; 
}

function input_legenda($name, $label, $hex){
	
	$legenda = "<div class='legenda'>\r\n";
	$legenda .= "<div class='legenda_cor' style='background:".$hex."'></div>\r\n";
	$legenda .= "<input name='".$name."_label' value='".$label."' type='text' class='legenda_label'/> \r\n"; 
	$legenda .= "<input name='".$name."_hex' value='".$hex."' maxlength='11' type='text' class='legenda_hex'/> \r\n";
	$legenda .= "</div>\r\n";
	
	print $legenda; 
} 

 
function text( $id, $cls, $name, $cont, $edit ){ 
	$editor = "";
	if($edit) $editor = "editor";
	
	//$edit:Boolean
	print "<textarea id=\"".$id."\" class=\"".$cls." ".$editor."\" name=\"".$name."\" >".$cont."</textarea>\r\n";  
}

function submit($lb){ 
	print "<div>\r\n";
	print "<input type=\"submit\" value=\"".$lb."\" class=\"btg mt30 gravar\"/>\r\n";
	print "</div>\r\n";
} 


function up_file($name, $multiple){
	$mult = "";
	if($multiple) $mult = "multiple";
	print "<div><input type=\"file\" name=\"".$name."\" class=\"file\" ".$mult."></div>\r\n";
} 

function up_file_form($form_id, $input_id, $action, $input_name, $multiple, $drop_area, $formatos){
	
	$class = ""; 
	if($drop_area) $class = "drop_area";
	
	print "<form id=\"form".$form_id."\" class=\"up_file_form\" enctype=\"multipart/form-data\" action=\"".$action."\" method=\"post\">\r\n";   
	 
	if($multiple) print  "<input lista=\"".$formatos."\" id=\"input".$input_id."\" type=\"file\" name=\"".$input_name."\" class=\"".$class." multiple\" multiple>\r\n";
	else print  "<input lista=\"".$formatos."\" id=\"input".$input_id."\" type=\"file\" name=\"".$input_name."\" class=\"".$class." single\" >\r\n"; 
	
	print "<div id=\"progress".$form_id."\" class=\"progress\">\r\n";
    print	"<div id=\"bar".$form_id."\" class=\"bar\"></div >\r\n";
    print   "<div id=\"percent".$form_id."\" class=\"percent\">0%</div >\r\n";
    print   "</div>\r\n";        
	
	print "</form>\r\n";
	
} 

function up_emb_form($action, $name){   
	print "<form class=\"up_emb_form\" action=\"".$action."\" method=\"post\">\r\n"; 
	print "<textarea class=\"embed_in\" name=\"".$name."\"></textarea>\r\n"; 
	print "<input type=\"submit\" value=\"INSERIR\" class=\"btg  mt10\"/>\r\n";
	print "</form>\r\n"; 
} 

function svg($w,$h,$hex,$scl,$pth){
		
		$retorno = "";
		$scale ="";
		if($scl){
			$scale = "transform=\"scale(".$scl.")\"";
		}
		
		$retorno .= "<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" width=\"". $w ."px\" height=\"". $h ."px\" viewBox=\"0 0 ". $w . " " . $h ."\" enable-background=\"new 0 0 ". $w . " " . $h ."\" xml:space=\"preserve\" >";
		$retorno .= "<g fill=\"".$hex."\" ".$scale.">";
		$retorno .= $pth;		
		$retorno .= "</g></svg>";
		 
		return $retorno; 	
}
 
function rodape(){ 
	print "<div id=\"rodape\"></div>\r\n"; 
}
 


?>