<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_sb");    
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 4, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(); ?> 
 	  
      	<div id="dados">
        
            <?php  
			
			//daods
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];
			$dados = sql_select("projetos","*","","id=".$id,false);   
			$tb = check_file("../projetos/projeto".$id."/tb.jpg","_layout/tb_generica.jpg"); 
			
			topo($id, $tb, $proj, "projetos.php");
			
			submenu( $submenu_projeto, 4);   
			 
			titulo("","STORY BOARD",false);
			up_files("php/proj_sb_up.php", "sb", 9, true);
			
			titulo("","PROPOR&Ccedil;&Atilde;O",false);
			//radio($id, $name, $value, $lb, $img, $chk, $lg_ico) 
			radio("prop16", "prop", "16x9", "16x9", "", true, false);
			radio("prop3", "prop", "3x4", "3x4", "", false, false);
				
			submit("ENVIAR");	
				
			form2(); // fecha o up_files
			
			//arquivo($src, $tipo, $tb, $lb, $link, $del){ 
			arquivo("../projetos/projeto".$id."/sb1.jpg", "jpg", "../projetos/projeto".$id."/sb1.jpg", "STORY BOARD", "", "php/proj_banner_remove.php"); 
			titulo("","PREVIEW",false);	
			
			sb_preview();			
			
			?>
        
        	
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
