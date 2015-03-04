<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("LEP - projetos"); 
require_once("_tr/sortable.php");   
?>
<body>   
	
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
        <div id="dados">
        
            <?php

			mensagem();	
			navega(array("PROJETOS"));
			
			$projetos = sql_select("projetos","*","id DESC","",true);  
			
			form1("novo", "", "php/proj_insere.php", "post"); 
					
				titulo("mt0","&darr; NOVO PROJETO (t&iacute;tulo)",false);
				input("titulo", "titulo", "", "text");
				submit("INSERIR");
			 
			form2();
			
			titulo("","PUBLICADOS ( arraste para definir a ordem na p&aacute;gina inicial )",false); 
			
			ul1("itens",'sortable');
			
			for($i=0; $i<count($projetos); $i++){ 
			
				if($projetos[$i]["publicado"] == "1"){
			
					$id = $projetos[$i]["id"];
					$tb = '';
					$lb = caps($projetos[$i]["titulo"]); 
					$link = "php/escolhe_proj.php?id=".$id."&proj=".$lb;
					
					$bts = array (	array( "del", "php/proj_remove.php?id=".$id )); 
				
					item('item'.$id, $tb, $id." _ ".$lb, $link, $bts, true);
				}
			}  
			
			ul2();
			
			clear();

			titulo("","N&Atilde;O PUBLICADOS ",false); 
			
			ul1("lista_off",false);
			for($i=0; $i<count($projetos); $i++){ 
				
				if($projetos[$i]["publicado"] == "0"){
					
					$id = $projetos[$i]["id"];
					$tb = '';
					$lb = caps($projetos[$i]["titulo"]); 
					$link = "php/escolhe_proj.php?id=".$id."&proj=".$lb;
					
					$bts = array (	array( "del", "php/proj_remove.php?id=".$id )); 
				
					item($id, $tb, $id." _ ".$lb, $link, $bts, false);
				}
			}  
			
			ul2();

			$dados = sql_select("lep","layout_home","","",false); 
			form1("layout_altera", "layout_altera", "php/home_layout_altera.php","POST");  
			input("layout", "layout", $dados["layout_home"], "hidden");  
			input("pagey_out","pagey_out","","hidden");			
			form2();  
			
			?>
        
			
			
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
