<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_tb");    
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
			submenu( $submenu_projeto, 2); 
			 
			titulo("","THUMBNAIL 210x118",false); // CHECAr ESSE TAMANHO!!!!
			up_files("php/proj_tb_up.php", "tb", 1,false);  
			
			preview("../projetos/projeto".$id."/tbg.jpg"); 
			
			
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
