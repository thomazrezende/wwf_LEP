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
			 
			titulo("","INSERIR BANNERS h=300px (jpg + png)",false);
			up_file_form("php/proj_banners_up.php", "banners[]", true, true,"jpg,jpeg,png");   
			
			titulo("","DISPLAY ",false);
			$arquivos = sql_select("banners","*","","id_proj=".$id,true); 
			
			ul1("display","sortable_ban");
			
			for($i=0; $i<count($arquivos); $i++){
				$tb = check_tb("../projetos/projeto".$id."/ban".$arquivos[$i]["id"].".jpg","img","item_tb");
				$lb = "ban".$arquivos[$i]["id"].".jpg";
				$id_file = $arquivos[$i]["id"];
				$link = "proj_banner_dados.php?id=".$arquivos[$i]["id"]; 
				  
				item_ban($id_file, $lb, $tb, $link);
			}    
			
			ul2();   
			
			clear(); 
			
			form1("display_altera", "display_altera", "php/proj_display_altera.php","POST"); 
			
			lixo("lixo","sortable_ban"); 
			
			clear();
			
			btg_del("TODOS OS ARQUIVOS","php/proj_display_remove_all.php",false);  
			
			input("display_layout", "display_layout", $dados["display"], "hidden");  
					
			form2();   
			
			$display_layout = explode(",",$dados["display"]);
			
			if( count($arquivos) > 0 ){
			
				titulo("","PREVIEW",false);
					
				div1("preview","banner_preview","",false); 
				
					div1("preview_cont1","","",false);
										
						for($i=0; $i<count($display_layout); $i++){
							
							img("../projetos/projeto".$id."/".$display_layout[$i].".jpg"); 
										
						}				
					
					div2(); 
					
					div1("preview_cont2",$cls,"",false);
										
						for($i=0; $i<count($display_layout); $i++){
							
							img("../projetos/projeto".$id."/".$display_layout[$i].".png"); 
										
						}				
					
					div2();   
				
				div2();
			}
			
			?>  
            
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
