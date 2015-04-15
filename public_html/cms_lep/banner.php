<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("LEP - documento");  
require_once("_tr/up_file_form.php");  
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 5, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php

			$id = $_GET["id"]; 

			// temas
			$temas = array(
			'#cc6666','#e26565','#ee9569','#e7b34c','#be995e',
			'#c0c05a','#90bd63','#7cba7c','#68be93','#66cccc',
			'#6699cc','#79a7d4','#75b8d9','#8585d6','#7e7ebb',
			'#7c5f99','#9473b5','#ad6bad','#b6628c','#c4567b'); 
				 
			//SQL
			$dados = sql_select("banners","*","","id=".$id,false);
			
			mensagem();	 
			navega(array(array("BANNERS","banners.php"), "BANNER ".$id ));  

			form1("altera", "", "php/banner_altera.php?id=".$id, "post");  
				
				titulo("","CR&Eacute;DITO FOTO (opcional)", false); 
				input("credito", "input", "credito", $dados["credito"] , "text"); 

				titulo("","LINK (opcional)",false); 
				input("link", "input", "link", $dados["link"] , "text");   
				
				titulo("","COR PREDOMINANTE",false); 
				for($i=0; $i<count($temas); $i++){ 
					
					$tema = $temas[$i];
					$chk = false;
					if($dados["tema"] == $i) $chk = true;
					
					print "<div style='width:20%;color:#fff;float:left;padding:5px;border:#fff 1px solid;background-color:".$tema."'>";
					radio('tema'.$i, 'tema', $i, $tema, false, $chk, false );
					print "</div>";
				}
				
				clear();

				submit("GRAVAR"); 
				
			form2();

			hr();
			
			titulo("","&darr; SUBSTITUIR ARQUIVO",false);
			up_file_form("_banner", "arquivo", "php/banner_arquivo_up.php?id=".$id, "arquivo", false, true, "jpg,gif,png,bmp"); 
			
			preview("../banners/banner".$id.".jpg","img"); 

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
