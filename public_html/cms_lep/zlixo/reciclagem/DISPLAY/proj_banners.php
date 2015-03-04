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
			$id_tb = $_SESSION["id_tb"];
			$tb = check_tb("../projetos/projeto".$id."/ban".$id_tb."pp.jpg","","item_tb");
			 
			$dados = sql_select("projetos","*","","id=".$id,false);   
			$cls = "bg".$dados["id_suporte"];
			topo($id, $cls, $tb, $proj, "projetos.php");
			
			submenu( $submenu_projeto, 2);
			 
			titulo("","INSERIR BANNERS ( R 448 x 252 | H 448 x 125 | V 223 x 252)",false);
			up_file_form("php/proj_banner_up.php", "banners[]", true, true,"gif,jpg,jpeg,png");  
			
			titulo("","BANNERS ",false);  
			$arquivos = sql_select("banners","*","","id_proj=".$id,true); 
			
			ul1("banners","sortable_ban");
			
			for($i=0; $i<count($arquivos); $i++){
				$tb = check_tb("../projetos/projeto".$id."/ban".$arquivos[$i]["id"]."pp.jpg","img","item_tb");
				$lb = "ban".$arquivos[$i]["id"]."m.jpg";
				$id_file = $arquivos[$i]["id"];
				$del = "php/proj_banner_remove.php?id=".$arquivos[$i]["id"]; 
				
				$thumb = "";
				if($id_file != $id_tb) $thumb = "php/proj_thumb_altera.php?id=".$id_file; 
				  
				item_banner($id_file, $lb, $tb, $del,$thumb);
			}  
			
			ul2(); 
			
			btg_del("TODAS AS IMAGENS?","php/proj_banner_remove_all.php",false); 
			
			if(!empty($id_tb) && count($arquivos) > 0){
				titulo("","THUMBNAIL",false); 
				img("../projetos/projeto".$id."/ban".$id_tb."p.jpg");
			}
			
			
			
			?>  
            
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
