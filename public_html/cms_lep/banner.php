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
			
			$temas = array(
				'#cc6666',
				'#ff6666',
				'#ff9966',
				'#ffcc66',
				'#cc9966',
				'#cccc66',
				'#66cc66',
				'#99cc66',
				'#66cc99',
				'#66cccc',
				'#6699cc',
				'#66ccff',
				'#99ccff',
				'#6666cc',
				'#9999ff',
				'#9966cc',
				'#cc66cc',
				'#cc99ff',
				'#cc6699',
				'#ff6699');
				
				 
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
