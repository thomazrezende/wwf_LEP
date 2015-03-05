<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
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

			//dados 
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];
			$next_id = next_id("arquivos");
			 
			$dados = sql_select("projetos","*","","id=".$id,false); 

			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] ));  

			clear(); 

			submenu( $submenu_projeto, 3 );

			titulo("","&darr; INSERIR MINIATURAS ( jpg / gif / png )",false);
			up_file_form("php/proj_minis_up.php", "imagens[]", true, true,"jpg,gif,png,jpeg");  

			$miniaturas = sql_select("miniaturas","*","","id_projeto='".$id."'",true);
			clear();

			titulo("","LISTA DE MINIATURAS",false);
			ul1("arquivos","");

			//arquivos 
			for($i=0; $i<count($miniaturas); $i++){  
				
				$id_file = $miniaturas[$i]["id"]; 
				$tb = "../projetos/projeto".$id."/mini".$id_file.".jpg"; 
				$lb = "MINIATURA ".$id_file; 
				$link = ""; 
				$bts = array (	array( "del", "php/proj_mini_remove.php?id=".$id_file )); 
				
				item($id, $tb, $lb, $link, $bts, false);
			}   

			ul2();

			clear();
			
			if(count($miniaturas) > 0){
				titulo("","",false);
				btg_del("EXCLUIR TUDO", "TODOS OS ARQUIVOS?","php/proj_mini_remove_all.php",false);   
			}	

            ?> 

        </div> <!--dados-->  
    </div> <!--cont--> 
</body>
</html>
