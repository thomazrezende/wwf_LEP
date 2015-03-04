<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("LEP - links"); ;  
require_once("_editor/tiny_mce.php");

$dados = sql_select("dados", "links", "", "", false);  

?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 4, true); ?>
	 
    <div id="cont">  
        <div id="dados">
           
           <?php
				
				mensagem();	 
				navega(array("LINKS")); 

				form1("altera", "", "php/links_altera.php", "post");  
					
					titulo("","", false);
					text("links", 'text', "links", $dados["links"], true);   
					
					submit("GRAVAR"); 
				
				form2();
				
            ?> 
        
        </div> <!--dados-->  
    </div> <!--cont-->

</body>
</html>
