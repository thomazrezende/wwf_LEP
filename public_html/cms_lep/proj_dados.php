<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("projeto - dados");    
require_once("_editor/tiny_mce.php"); 
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php 
 
			//dados 
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];

			//SQL
			$dados = sql_select("projetos","*","","id=".$id,false);   
			($dados["publicado"] == "1")?($public = true):($public = false);

			function verifica_area($bd, $area){
				if($bd == $area) return true;
				else return false;
			}  

			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] )); 

			submenu( $submenu_projeto, 1);
			
			form1("altera", "", "php/proj_dados_altera.php?id=".$id, "post");
				
				submit("GRAVAR");
				
				titulo("","", false);
				checkbox("publicado", "publicado", 1, caps("publicado"), "", $public, false);

				titulo("","", false);
				radio("area1", "area", "16x9", "16 : 9 (640 x 360 px)", "", verifica_area($dados["area"], "16x9"), false);
				radio("area2", "area", "15x10", "15 : 10 (640 x 427 px)", "", verifica_area($dados["area"], "15x10"), false);
				radio("area2", "area", "4x3", "4 : 3 (640 x 480 px)", "", verifica_area($dados["area"], "4x3"), false);
				radio("area3", "area", "1x1", "1 : 1 (640 x 604 px)", "", verifica_area($dados["area"], "1x1"), false);
				 
				//radio($id, $name, $value, $lb, $img, $chk, $lg_ico){ 
				
				$categorias = array( 
					array(1,"FOTOGRAFIA"),
					array(2,"V&Iacute;DEO"),
					array(3,"OUTROS"));
			
				titulo("","CATEGORIA",false);
				select("categoria", "id_categ", "", false, $categorias, array($dados["id_categ"]) );

				titulo("","DATA (aaaa)", false);
				input("data", "data", $dados["data"] , "text"); 
				
				titulo("","T&Iacute;TULO", false);
				input("titulo", "titulo", $dados["titulo"] , "text");
				
				titulo("","SUBT&Iacute;TULO", false);
				input("subtitulo", "subtitulo", $dados["subtitulo"] , "text");
				
				titulo("","RESUMO", false);
				text("resumo", 'text', "resumo", $dados["resumo"], true);

				titulo("","DESCRI&Ccedil;&Atilde;O", false);
				text("texto", 'text', "texto", $dados["texto"], true);
				
				submit("GRAVAR"); 
						
			form2();  
			
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
