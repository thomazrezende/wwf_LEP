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
			voltar("PROJETOS","projetos.php"),
			voltar("ARQUIVOS","proj_arquivos.php")
		)); ?>
 	  
      	<div id="dados">
        
           <?php  
			
			//daods
			$id = $_GET["id"];
			$proj = $_SESSION["proj"];
			$id_tb = $_SESSION["id_tb"];
			$tb = check_tb("../projetos/projeto".$_SESSION["id"]."/ban".$id_tb."pp.jpg","","item_tb"); 
			
			//SQL
			$dados = sql_select("displays","*","","id=".$_GET["id"],false);  
			
			topo($id, $tb, $proj, "projetos.php");
			
			$banners = sql_select("banners","*","","id_proj=".$_SESSION["id"],true);  
						 
			titulo("","BANNERS",false);
			
			ul1("banners","sortable_dsp");
			
			for($i=0; $i<count($banners); $i++){
				$tb = "../projetos/projeto".$_SESSION["id"]."/ban".$banners[$i]["id"]."pp.jpg";
				$id_file = $banners[$i]["id"]."/".$banners[$i]["dd_tipo"]; 
				item_lay($id_file, $tb, "ban"); 
			} 
			
			ul2(); 
			
			clear(); 
			 
			titulo("",opcoes(caps($dados["label"]),"DISPLAY ".$id),false); 
			ul("modulo0","sortable_dsp destino");
			ul2();
			clear();
			ul("modulo1","sortable_dsp destino");
			ul2();
			clear();  
			
			form1("form_display","","php/proj_display_altera.php?id=".$_GET["id"],"post");
			input("layout","layout",$dados["layout"],"hidden"); 
			
			titulo("","LABEL",false); 
			input("label", "input","label",$dados["label"],"text");
			
			titulo("","",false);
			checkbox("home", "input","home",1,"COPIAR PARA DISPLAY PRINCIPAL","","",false);
			
			submit("GRAVAR");
			
			form2(); 
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
