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
require_once("_tr/sortable_lay.php");
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
			$dados = sql_select("projetos","layout","","id=".$id,false);  
			
			topo($id, $tb, $proj, "projetos.php");
			
			submenu( $submenu_projeto, 5); 
			
			$arquivos = sql_select("arquivos","*"," id DESC","id_proj=".$id,true);
			$banners = sql_select("banners","*"," dd_ordem","id_proj=".$id,true);
			 
			titulo("","ARQUVIOS",false); 
			ul1("arquivos","sortable_lay");
			
			for($i=0; $i<count($arquivos); $i++){
				$id_file = $arquivos[$i]["id"];
				$lb = $arquivos[$i]["label_".get_lg()];
				$tipo = $arquivos[$i]["tipo"];
				$tb = check_tb("../projetos/projeto".$id."/img".$id_file."p.jpg",$tipo,"item_tb");
				if($tipo == "img"){
					$file = "img".$id_file."p.jpg";
				}else{
					$file = "embed".$id_file;
				}  
				
				item_lay($id_file, opcoes($lb,$file), $tb, $tipo);  
			} 
			
			for($i=0; $i<count($banners); $i++){
				$tb = check_tb("../projetos/projeto".$id."/ban".$banners[$i]["id"]."pp.jpg","","item_tb");
				$id_file = $banners[$i]["id"];
				  
				item_lay($id_file, "BAN".$id_file, $tb,  "ban"); 
			} 
			
			ul2(); 
			
			form1("form_layout","","php/proj_layout_altera.php","post");
			input("layout", "input","layout",$dados["layout"],"hidden");
			submit("GRAVAR");
			form2(); 
			
			titulo("","LAYOUT",false); 
			div1("destinos","layout","",true);  
			div1("mais","btg mt0","<span>+ LINHA</span>",true); 
 
					
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
