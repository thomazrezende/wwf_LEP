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
require_once("_tr/up_file_form.php");       
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php

			$id = $_GET["id"];
			$id_projeto = $_SESSION["id"];
			
			$grupos = array(	array(1,"ALVOS DE CONSERVA&Ccedil;&Atilde;O"),
								array(2,"CUSTO DE CONSERVA&Ccedil;&Atilde;O"),
								array(3,"ARQUIVOS DE ENTRADA MARXAN"));

			//SQL
			$dados = sql_select("resultados","*","","id=".$id,false);
			
			mensagem();	
			navega(array(	array("PROJETOS","projetos.php"),
				   			array("PROJETO ".$id_projeto." - RESULTADOS","projeto_resultados.php"),
				  			"RESULTADO ".$id. " - " . $dados["label"] )); 

			form1("altera", "", "php/projeto_resultado_altera.php?id=".$id, "post");  
			
				titulo("","NOME_DOS_ARQUIVOS ( sem extens&atilde;o )", false); 
				input("label", "input", "label", $dados["label"] , "text");
				
				titulo("","T&Iacute;TULO", false); 
				input("titulo", "input", "titulo", $dados["titulo"] , "text"); 

				titulo("","T&Iacute;TULO LEGENDA", false); 
				input("titulo_legenda", "input", "titulo_legenda", $dados["titulo_legenda"] , "text");

				// LEGENDA 
				
				$legendas = explode("|",$dados["legenda"]);
				
				$cols = array(	array("legenda_col2","ou #HEX"),
								array("legenda_col1","R G B"));
				

				titulo("","LEGENDAS".obs_right("R,G,B ou #HEX"), false); 
				
				for( $i=0; $i<10; $i++){
					if(!empty($legendas[$i])){
						$legenda = explode(',', $legendas[$i]);						
						input_legenda("legenda".$i, $legenda[0], $legenda[1] );
					}else{
						input_legenda("legenda".$i, "", "");
					}						
				} 

				submit("GRAVAR"); 
				
			form2(); 

			hr();
			
			titulo("","&darr; INSERIR IMAGEM (jpg, gif, png)",false);
			up_file_form("_resultado", "", "php/projeto_resultado_img_up.php?id=".$id, "imagem", false, true, "jpg,jpeg,gif,png,bmp"); 

			if( file_exists("../projetos/projeto".$id_projeto."/tb".$id.".jpg")) {  
				preview("../projetos/projeto".$id_projeto."/tb".$id.".jpg","img");
			} 


			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
