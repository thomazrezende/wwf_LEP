<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO - RESULTADOS");  
require_once("_tr/up_file_form2.php");  
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
 
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$titulo )); 

			submenu( $submenu_projeto, 3); 
			
			for($i=1; $i<=10; $i++){  
				up_file_form("form".$i,"php/projeto_arquivo_up.php?pos=".$i, "arquivo".$i, false, false, "all"); 
				//up_file_form($action, $name, $multiple, $drop_area, $formatos) 
			}
			
			
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
