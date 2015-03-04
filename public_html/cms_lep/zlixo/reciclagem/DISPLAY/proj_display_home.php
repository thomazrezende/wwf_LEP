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
require_once("_tr/sortable_dsp.php");
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
			$tb = check_tb("../projetos/projeto".$_SESSION["id"]."/ban".$id_tb."pp.jpg","","item_tb"); 
			
			//SQL
			$dados = sql_select("projetos","display, id_suporte","","id=".$id,false);  
			$cls = "bg".$dados["id_suporte"];
			topo($id, $cls, $tb, $proj, "projetos.php");
			 
			submenu( $submenu_projeto, 4); 
			
			$banners = sql_select("banners","*","","id_proj=".$_SESSION["id"],true);  
						 
			titulo("","BANNERS","",false);
			
			ul1("banners","sortable_dsp");
			
			for($i=0; $i<count($banners); $i++){
				$tb = "../projetos/projeto".$_SESSION["id"]."/ban".$banners[$i]["id"]."pp.jpg";
				$id_file = $banners[$i]["id"]."/".$banners[$i]["dd_tipo"]; 
				item_lay($id_file, $tb, "ban"); 
			} 
			
			ul2(); 
			
			clear(); 
			 
			titulo("","DISPLAY NO PORTFOLIO","",false); 
			ul("modulo0","sortable_dsp destino");
			ul2();
			clear();
			ul("modulo1","sortable_dsp destino");
			ul2();
			clear();  
			
			form1("form_display","","php/proj_display_home_altera.php","post");
			input("layout", "input","layout",$dados["display"],"hidden"); 
			
			submit("GRAVAR");
			
			form2(); 
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
