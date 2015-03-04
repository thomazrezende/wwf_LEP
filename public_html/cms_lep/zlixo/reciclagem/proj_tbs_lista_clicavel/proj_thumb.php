<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_dados");    
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
			$id_tb = $_SESSION["id_tb"];
			$tb = check_tb("../projetos/projeto".$id."/ban".$id_tb."pp.jpg","","item_tb"); 
			
			//SQL  
			topo($id, $tb, $proj, "projetos.php");
			
			submenu( $submenu_projeto, 3); 
			
			titulo("","THUMBNAIL", false);
			$banners = sql_select("banners","id","dd_ordem","id_proj=".$_SESSION["id"], true);
			
			for($b=0; $b<count($banners); $b++){ 
				
				if($_SESSION["id_tb"] == $banners[$b]["id"]){
					$tb_class = "tb tb_select";
				}else{
					$tb_class = "tb";
				}
				
				print "<div class=\"tb_div\" >\r\n";
				print "<a href=\"php/proj_thumb_altera.php?id=".$banners[$b]["id"]."\" >";
				print "<img class=\"".$tb_class."\" src=\"../projetos/projeto".$id."/ban".$banners[$b]["id"]."p.jpg\"/>\r\n";
				print "</a>\r\n";
				print "</div>\r\n";
				
			}
				
					
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
