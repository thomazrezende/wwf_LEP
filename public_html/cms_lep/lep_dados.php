<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("LEP - dados");  
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
				submenu($submenu_lep, 1); 

				form1("altera", "", "php/lep_dados_altera.php", "post");  

					titulo("","E-MAIL (login)",false);
					input("email", "input", "email", $dados["email"] , "text");  
					
					titulo("","FACEBOOK",false);
					input("fbook", "input", "fbook", $dados["fbook"] , "text");  

					titulo("","TWITTER",false);
					input("twitter", "input", "twitter", $dados["twitter"] , "text");  

					titulo("","SOBRE O LEP", false);
					text("sobre_lep", 'text', "sobre_lep", $dados["sobre_lep"], true);  

					titulo("","SOBRE O PSC", false);
					text("sobre_psc", 'text', "sobre_psc", $dados["sobre_psc"], true);  

					
					submit("GRAVAR"); 
				
				form2();
				
            ?> 
        
        </div> <!--dados--> 
       
    </div> <!--cont-->

</body>
</html>
