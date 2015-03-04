<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("projeto - arquivos");  
require_once("_tr/up_file_form.php");
?>
<body>  

    <?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>

    <div id="cont">

        <div id="dados">  

        <?php

			//daods 
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];
			$dados = sql_select("projetos","*","","id=".$id,false); 

			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] )); 
  
			clear(); 

			submenu( $submenu_projeto, 2 );

			titulo( "","&darr; INSERIR IMAGEM DE CAPA ( jpg / gif / png )", false );
			up_file_form( "php/proj_capa_up.php", "imagem", false, true, "jpg,gif,png,jpeg" );  
			
			if( file_exists("../projetos/projeto".$id."/capa.jpg")){
				preview( "../projetos/projeto".$id."/capa.jpg", "img" ); 
				btg_del( "EXCLUIR", "IMAGEM DE CAPA", "php/proj_capa_remove.php", false);
			}
 
			
        ?> 

        </div> <!--dados-->  
    </div> <!--cont--> 
</body>
</html>
