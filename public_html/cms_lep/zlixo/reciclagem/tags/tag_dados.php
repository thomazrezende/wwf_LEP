<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("tag_dados"); 
require_once("_tr/up_file_form.php");   
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(); ?> 
 	
        <div id="dados">
        
            <?php   
			
			$id = get_session("id","id_tag");
			
			$dados = sql_select("tags","*","","id=".$id,false);  
			
			voltar("TAGS","tags.php");
			
			form1("altera", "", "php/tag_dados_altera.php", "post");
					
				titulo("","NOME", true);
				input("label_".get_lg(), "label_".get_lg(), $dados["label_".get_lg()] , "text");  
				
				titulo("","GRAFICO 1 (OFF)", false);
				text("graf1","graf1",$dados["graf1"],false);
				
				titulo("","GRAFICO 2 (ON)", false);
				text("graf2","graf2",$dados["graf2"],false);  
				
				submit("GRAVAR"); 
				
				hr();
				
				print svg(120,120,"#333",3,$dados["graf2"]);
				print " "; 
				print svg(120,120,"#333",3,$dados["graf1"]);
				
			form2(); 
			
			/*
			
			BK: UPLAOD DE ICONE PNG
			
			hr();
			
			titulo("","&Iacute;CONE - PNG 41x41",false);
			
			up_file_form("php/tag_img1_up.php","tag_img", false, true,"png");	
			
			$tb = check_tb("../tags/tag".$id.".png","","");			
			
			//$hex = $dados["dd_hex"];
			$hex = "#333";
						
			item_tag($id, $dados["label_".get_lg()], $tb, "", "", $hex, false);  
		
			*/
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
