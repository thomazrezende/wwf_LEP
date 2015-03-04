<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("tags");  
require_once("_tr/sortable_tag.php");  
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(); ?>  
 	
        <div id="dados" >
        
            <?php  
			
			$tags = sql_select("tags","*","dd_ordem","",true);  
			
			form1("", "", "php/tag_insere.php", "post"); 
					
				titulo("","NOVA TAG",false);
				input("nome", "nome", "" , "text");
				submit("INSERIR"); 
						
			form2();

			titulo("","LISTA DE TAGS",false);			
			ul1("tags","sortable_tag");
			
			for($i=0; $i<count($tags); $i++){ 
			
				$id = $tags[$i]["id"];
				$lb = $tags[$i]["label_pt"];
				$tb = svg(26,30,"#fff",1,$tags[$i]["graf2"]);
				$del = 	"php/tag_remove.php?id=".$id;	
				$link = "tag_dados.php?id=".$id;	
				$hex = "#333";
			
				item_tag($id, caps($lb), $tb, $link, $del, $hex, true); 
			} 
			
			ul2();
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
