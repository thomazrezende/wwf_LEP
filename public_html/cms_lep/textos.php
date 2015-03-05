<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("textos");   
require_once("_tr/sortable.php");   
?>
<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont"> 
        <div id="dados">
        
            <?php 

			mensagem();	 	
			navega(array("TEXTOS"));
			
			$criticas = sql_select("critica","*","id DESC","",true);  
			
			form1("novo", "", "php/texto_insere.php", "post"); 
					
				titulo("","&darr; NOVO TEXTO (autor)",false);
				input("autor", "input", "autor", "", "text");
				submit("INSERIR");
			 
			form2();
			
			titulo("","PUBLICADOS ( arraste para definir a ordem )",false); 
			
			ul1("itens",'sortable');
			
			for( $i=0; $i<count($criticas); $i++ ){ 
			
				if($criticas[$i]["publicado"] == "1"){
			
					$id = $criticas[$i]["id"];
					$tb = "_layout/ico_texto.png";
					$lb = caps($criticas[$i]["autor"]);
					$bts = 	array (	array("del","php/texto_remove.php?id=".$id));	
					$link = "php/escolhe_texto.php?id=".$id."&autor=".$lb;
				
					item('item'.$id, $tb, $id." _ ".$lb, $link, $bts, true);
				}
			}  
			
			ul2();
			
			clear();

			titulo("","N&Atilde;O PUBLICADOS",false); 
			
			ul1("lista_off",false);
			for( $i=0; $i<count($criticas); $i++ ){ 
				
				if($criticas[$i]["publicado"] == "0"){ 
					
					$id = $criticas[$i]["id"];
					$tb = "_layout/ico_texto.png";
					$lb = caps($criticas[$i]["autor"]);
					$bts = 	array (	array("del","php/texto_remove.php?id=".$id));		
					$link = "php/escolhe_texto.php?id=".$id."&autor=".$lb;
					
					item($id, $tb, $id." _ ".$lb, $link, $bts, false);
				}
			}  
			
			ul2();  

			$renata = sql_select("renata","textos","","",false);  
			form1("layout_altera", "layout_altera", "php/textos_layout_altera.php","POST");  
			input("layout", "input", "layout", $renata["textos"], "hidden");  
			input("pagey_out", "input","pagey_out","","hidden");			
			form2();  
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
