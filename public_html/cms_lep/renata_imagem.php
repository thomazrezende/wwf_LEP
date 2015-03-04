<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php");
require_once("_menus.php");

verif_log(); 
conectar();

head("Renata - foto"); 
require_once("_tr/up_file_form.php");  
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 1, true); ?>
	 
    <div id="cont">
 	
        <div id="dados">
        
           	<?php  
 
			mensagem();	 
			navega(array("RENATA"));
		
			submenu($submenu_renata, 2);
			
			up_file_form("php/renata_imagem_up.php", "arquivo", false, true,"gif,jpg,jpeg,png");
	 		
			preview("../renata/renata_ursaia.jpg","img");  
			           
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
