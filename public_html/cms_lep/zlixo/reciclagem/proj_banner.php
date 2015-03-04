<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_banner");   
require_once("_tr/up_file_form.php");
require_once("_tr/sortable_ban.php");
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(array(
			voltar("PROJETOS","projetos.php")
		)); ?>
 	  
      	<div id="dados">
        
           <?php  
			
			//daods
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];
			$tb = check_tb("../projetos/projeto".$id."/tbp.jpg","","item_tb");
			 
			$dados = sql_select("projetos","*","","id=".$id,false);   
			$cls = "bg".$dados["id_suporte"];
			topo($id, $cls, $tb, $proj, "projetos.php");
			
			submenu( $submenu_projeto, 3);
			 
			titulo("","INSERIR BANNER COR ( 300x1200 jpg )",false);
			up_file_form("php/proj_banner_cor_up.php", "banner_cor", false, true,"jpg");  
			
			titulo("","INSERIR BANNER P&B ( 300x1200 png )",false);
			up_file_form("php/proj_banner_pb_up.php", "banner_pb", false, true,"png");    
			
			if(file_exists("../projetos/projeto".$id."/banner_pb.png") || file_exists("../projetos/projeto".$id."/banner_cor.jpg") ){
				
				titulo("","PREVIEW",false);
				
				div1("","banner_preview","",false); 
					
					if(file_exists("../projetos/projeto".$id."/banner_pb.png")) {
						div1("","banner_bg ".$cls ,"",false);
							img("../projetos/projeto".$id."/banner_pb.png");
						div2();
					}
				
					if(file_exists("../projetos/projeto".$id."/banner_cor.jpg")) {
						img("../projetos/projeto".$id."/banner_cor.jpg");
					}
				
				div2();  
			
			}
			  
			  
			?>  
            
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
