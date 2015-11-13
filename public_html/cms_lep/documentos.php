<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("LEP - documentos"); 
?>
<body>   
	
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont">
        <div id="dados">
        
            <?php

			mensagem();
			navega(array("DOCUMENTOS"));
			
			$documentos = sql_select( "documentos","*","id DESC","",true );  
			
			form1("novo", "", "php/documento_insere.php", "post"); 
				
				titulo("mt0","&darr; NOVO DOCUMENTO (t&iacute;tulo)",false);
				input("titulo", "input", "titulo", "", "text");
				submit("INSERIR");
			
			form2();
			
			titulo("","PUBLICADOS",false); 
			
			ul1("itens",false);
			
			for($i=0; $i<count($documentos); $i++){
			
				if($documentos[$i]["publicado"] == "1"){
					
					$doc = "";
					if(!empty($documentos[$i]["arquivo"])) $doc = " :: download";
					
					$lnk = "";
					if(!empty($documentos[$i]["link"])) $lnk = " :: link";
					
					$autor = "";
					if(!empty($documentos[$i]["autor"])) $autor = " - " . $documentos[$i]["autor"];
					
					$id = $documentos[$i]["id"];
					$tb = '_layout/ico_documento.png';
					$lb = 'DOC '.$id;
					$lb_ext = " _ ".$documentos[$i]["titulo"].$autor.$doc.$lnk;;
					$link = array("documento.php?id=".$id, false);
					
					$bts = array( array( "del", "php/documento_remove.php?id=".$id )); 
				
					item('item'.$id, $tb, $lb, $lb_ext, $link, $bts, false);
				}
			}
			
			ul2();
			
			clear();

			titulo("","N&Atilde;O PUBLICADOS ",false); 
			
			ul1("lista_off",false);
			for($i=0; $i<count($documentos); $i++){ 
				
				if($documentos[$i]["publicado"] == "0"){
					
					$doc = "";
					if(!empty($documentos[$i]["arquivo"])) $doc = " :: download";
					
					$lnk = "";
					if(!empty($documentos[$i]["link"])) $lnk = " :: link"; 
					
					$autor = "";
					if(!empty($documentos[$i]["autor"])) $autor = " - " . $documentos[$i]["autor"];
					
					$id = $documentos[$i]["id"];
					$tb = '_layout/ico_documento.png';
					$lb = 'DOC '.$id;
					$lb_ext = " _ ".$documentos[$i]["titulo"].$autor.$doc.$lnk;
					$link = array("documento.php?id=".$id, false);
					
					$bts = array (	array( "del", "php/documento_remove.php?id=".$id )); 
				
					item('item'.$id, $tb, $lb, $lb_ext, $link, $bts, false);
				}
			}  
			
			ul2();
 
			
			?> 
			
			
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
