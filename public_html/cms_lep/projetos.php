<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("LEP - projetos"); 
require_once("_tr/sortable_auto.php");   
?>
<body>   
	
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
        <div id="dados">
        
            <?php

			mensagem();	
			navega(array("PROJETOS"));
			
			$projetos = sql_select("projetos","*","id DESC","",true);  
			
			form1("novo", "", "php/projeto_insere.php", "post"); 
					
				titulo("mt0","&darr; NOVO PROJETO (t&iacute;tulo)",false);
				input("titulo", "input", "titulo", "", "text");
				submit("INSERIR");
			 
			form2();
			titulo("","PUBLICADOS".obs_right("arraste para definir a ordem na p&aacute;gina inicial &darr;"),false); 
			
			ul1("itens",'sortable');
			
			for($i=0; $i<count($projetos); $i++){ 
			
				if($projetos[$i]["publicado"] == "1"){
			
					$id = $projetos[$i]["id"];
					$tb = '_layout/ico_projeto.png';
					$lb = $projetos[$i]["titulo"];
					$lb_ext = "";
					$link = array("php/escolhe_projeto.php?id=".$id."&titulo=".$lb, false);
					
					$bts = array (	array( "del", "php/projeto_remove.php?id=".$id )); 
				
					item('item'.$id, $tb, caps($id." _ ".$lb), $lb_ext, $link, $bts, true);
				}
			}  
			
			ul2();
			clear();
			titulo("","N&Atilde;O PUBLICADOS ",false); 
			
			ul1("lista_off",false);

			for($i=0; $i<count($projetos); $i++){ 
				
				if($projetos[$i]["publicado"] == "0"){
					
					$id = $projetos[$i]["id"];
					$tb = '_layout/ico_projeto.png';
					$lb = $projetos[$i]["titulo"]; 
					$link = array("php/escolhe_projeto.php?id=".$id."&titulo=".$lb, false);
					
					$bts = array (	array( "del", "php/projeto_remove.php?id=".$id )); 
				
					item($id, $tb, caps($id." _ ".$lb), $link, $bts, false);
				}
			}  
			
			ul2();

			$dados = sql_select("dados","layout_home","","",false); 
			form1("layout_altera", "layout_altera", "php/home_layout_altera.php","POST");  
			input("layout", "input", "layout", $dados["layout_home"], "hidden");  
			input("pagey_out", "input", "pagey_out", "", "hidden");  
			form2();  
			?>
        
			
			
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
