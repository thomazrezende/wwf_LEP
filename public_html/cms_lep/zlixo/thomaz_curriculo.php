<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("thomaz_cv");    
require_once("_tr/up_file_form.php");
?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 1, true); ?>
	 
    <div id="cont">
    
   		<?php mensagem(false); ?> 
		<?php submenu($submenu_thomaz, 3); ?> 
 	
        <div id="dados">
        
            <?php  
			$rnd = rand();
			
			titulo("","ARQUIVO - FORMATO: PDF",true);
			
			up_file_form("php/thomaz_cv_up.php", "pdf_".get_lg(), false, true,"pdf");	 
			arquivo("../thomaz/cv_thomazrezende_".get_lg().".pdf?rand=".$rnd, "pdf", "", "", true, "php/thomaz_cv_remove.php");
			
			?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
