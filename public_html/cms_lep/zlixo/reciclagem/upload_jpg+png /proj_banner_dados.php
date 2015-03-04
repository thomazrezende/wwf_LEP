<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_arquivos");  
require_once("_tr/up_file_form.php");  
?>
<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(array(
			voltar("PROJETOS","projetos.php"),
			voltar("DISPLAY","proj_display.php")
		)); ?> 
 	  
      	<div id="dados">
        
           <?php
			
			//dados
			$id = $_SESSION["id"]; 
			$proj = $_SESSION["proj"];
			$dados = sql_select("projetos","*","","id=".$id,false);   
			$tb = check_tb("../projetos/projeto".$id."/tbp.jpg","","item_tb");  
			$cls = "bg".$dados["id_suporte"];   
			
			topo($id, $cls, $tb, $proj, "projetos.php");    
				
			titulo("","SUBSTITUIR BANNER".$_GET["id"]." (jpg e/ou png)",false);
			up_file_form("php/proj_banner_img_altera.php?id=".$_GET["id"], "banners[]", true, true,"jpg,jpeg,png");   
			
			$ban_jpg = "../projetos/projeto".$id."/ban".$_GET["id"].".jpg";
			$ban_png = "../projetos/projeto".$id."/ban".$_GET["id"].".png";
			
			if(file_exists($ban_jpg) || file_exists($ban_png) ){
				
				titulo("","PREVIEW",false);
				
				div1("","banner_preview","",false); 
					
					if( file_exists($ban_jpg) ) { 
						img( $ban_jpg );
					}
					
					clear();
					
					if( file_exists($ban_png) ) { 
						img_cls( $ban_png, $cls );  
					}
				
				div2();  
			
			}
			
			?> 
        
        </div> <!--dados-->  
    </div> <!--cont--> 
</body>
</html>
