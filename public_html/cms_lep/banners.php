<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("BANNERS"); 
require_once("_tr/up_file_form.php");       
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 5, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php

			//SQL
			$dados = sql_select("banners","*","id DESC","",true); 

			mensagem();	  
			navega(array("BANNERS")); 
			
			titulo("","&darr; INSERIR IMAGENS ( 900x300 jpg, gif, png )",false);
			up_file_form("_banners", "", "php/banners_up.php", "imagens[]", true, true, "jpg,jpeg,gif,png,bmp"); 
 
			hr();
				   
			form1("altera", "", "php/banners_altera.php", "post");  
			
				for($i=0; $i<count($dados); $i++){
					
					img("","mt20","../banners/banner".$dados[$i]['id'].".jpg",false);
					//img( $id, $cls, $src, $rtn )					
					
					input("label", "input", "label", $dados[$i]["credito"] , "text");
					
				} 
				 
				submit("GRAVAR CR&Eacute;DITOS"); 
				
			form2(); 	   

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
