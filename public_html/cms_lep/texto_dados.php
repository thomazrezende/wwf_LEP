<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("textos - dados");    
require_once("_editor/tiny_mce.php");
?>
<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont"> 
      	<div id="dados">
        
            <?php  
			
			//daods 
			$id = $_SESSION["id_critica"];
			$autor = $_SESSION["autor"];
			
			//SQL
			$dados = sql_select("critica","*","","id=".$id,false);   
			($dados["publicado"] == "1")?($public = true):($public = false);
			
			mensagem();	 
			navega(array(array("TEXTOS","textos.php"), "TEXTO ".$id." - ".$autor ));  
			
			form1("altera", "", "php/texto_dados_altera.php?id=".$id, "post");  
				
				submit("GRAVAR"); 

				titulo("","", false);
				checkbox("publicado", "publicado", 1, caps("publicado"), "", $public, false);	 
				 
				titulo("","DATA (aaaa ou 0)", false);
				input("data", "input", "data", $dados["data"] , "text"); 
				
				titulo("","T&Iacute;TULO", false);
				input("titulo", "input", "titulo", $dados["titulo"] , "text");
				
				titulo("","AUTOR", false);
				input("autor", "input", "autor", $dados["autor"] , "text");
				
				titulo("","texto", false);
				text("texto", "input", "text", "texto", $dados["texto"], true);  
				
				submit("GRAVAR"); 
						
			form2();  
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->  

</body>
</html>
