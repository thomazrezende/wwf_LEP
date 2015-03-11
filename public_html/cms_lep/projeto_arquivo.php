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
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php

			$id = $_GET["id"];
			$id_projeto = $_SESSION["id"];
			
			$grupos = array(	array(1,"ALVOS DE CONSERVA&Ccedil;&Atilde;O"),
								array(2,"CUSTO DE CONSERVA&Ccedil;&Atilde;O"),
								array(3,"ARQUIVOS DE ENTRADA MARXAN"));

			//SQL
			$dados = sql_select("arquivos","*","","id=".$id,false);
			
			mensagem();	
			navega(array(	array("PROJETOS","projetos.php"),
				   			array("PROJETO ".$id_projeto." - ARQUIVOS","projeto_arquivos.php"),
				  			"ARQUIVO ".$id. " - " . $dados["label"] )); 

			form1("altera", "", "php/projeto_arquivo_altera.php?id=".$id, "post");  
			
				titulo("","NOME_DOS_ARQUIVOS (sem espa&ccedil;o &sol; extens&atilde;o)", false); 
				input("label", "input", "label", $dados["label"] , "text");
				
				titulo("","T&Iacute;TULO", false); 
				input("titulo", "input", "titulo", $dados["titulo"] , "text"); 

				titulo("","GRUPO", false); 
				select("grupo", "grupo", "", false, $grupos, array($dados["grupo"]));

				submit("GRAVAR"); 
				
			form2(); 

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
