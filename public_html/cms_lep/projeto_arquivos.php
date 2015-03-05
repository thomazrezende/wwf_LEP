<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO - ARQUIVOS");    
?>

<body>
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php
 
			//dados 
			$id = $_SESSION["id"];
			$titulo = $_SESSION["titulo"];

			//SQL
			$dados = sql_select("projetos","*","","id=".$id,false);   
			($dados["publicado"] == "1")?($public = true):($public = false);
 
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] )); 

			submenu( $submenu_projeto, 3);
			
			
			
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
