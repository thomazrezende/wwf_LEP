<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("LEP - senha");    
require_once("_editor/tiny_mce.php");

$dados = sql_select("dados", "*", "", "", false); 

?>
<body>  
    
		<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 1, true); ?>
	 
    <div id="cont"> 
 	
 	
        <div id="dados"> 
           
            <?php  
 
				mensagem();	 	
				navega(array("LEP"));

				submenu($submenu_lep, 2);  
			
				form1("senha", "", "php/senha_altera.php", "post");
             
					titulo("","SENHA ATUAL",false);
					input("senha_atual", "senha_atual", "", "password");
					
					titulo("","SENHA NOVA",false);
					input("senha_nova", "senha_nova", "" , "password"); 
					
					titulo("","CONFIRME A SENHA NOVA",false);
					input("senha_confirma", "senha_confirma", "" , "password"); 
					
					submit("GRAVAR"); 
				
				form2();
            ?>
        
        </div> <!--dados--> 
        
    </div> <!--cont-->

</body>
</html>
