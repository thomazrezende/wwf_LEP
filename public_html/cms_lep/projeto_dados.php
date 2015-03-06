<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO ".$_SESSION["id"]);    
require_once("_editor/tiny_mce.php"); 
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
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." _ ".$titulo )); 

			submenu( $submenu_projeto, 1);
			
			form1("altera", "", "php/projeto_dados_altera.php", "post");
				
				titulo("","", false);
				checkbox("publicado", "publicado", 1, caps("publicado"), "", $public, false);
 				
				titulo("","T&Iacute;TULO", false);
				input("titulo", "input", "titulo", $dados["titulo"] , "text"); 

				titulo("","RESUMO", false);
				text("resumo", 'text', "resumo", $dados["resumo"], false);
				
				titulo("","DESCRI&Ccedil;&Atilde;O", false);
				text("sobre", 'text', "sobre", $dados["sobre"], true);
				
				submit("GRAVAR"); 
						
			form2();  
			
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
