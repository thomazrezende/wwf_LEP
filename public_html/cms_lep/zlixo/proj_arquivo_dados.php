<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("projeto - dados do arquivo");  
require_once("_tr/up_file_form.php");  
?>
<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
        
           <?php 
			
			if(isset($_GET["id"])) sessao_local(array( array("id_file",$_GET["id"])),true);
			$arquivo_dados = sql_select("arquivos","*","","id=".$_SESSION["id_file"],false); 
			 
			$tipo = $arquivo_dados["tipo"];
			$embed = $arquivo_dados["embed"];   
			
			//dados 
			$id = $_SESSION["id"];
			$proj = $_SESSION["proj"];
			$file =  "../projetos/projeto".$id."/img".$_SESSION["id_file"]."g.jpg"; 
			$dados = sql_select("projetos","*","","id=".$id,false);  

			($arquivo_dados["autoplay"] == "1")?($auto = true):($auto = false);
			
			mensagem();	 
			
			navega(array(array("PROJETOS","projetos.php"), array("PROJETO ".$id." - ".caps($dados["titulo"])." [ARQUIVOS]","proj_arquivos.php"), "ARQUIVO ".$_SESSION["id_file"] ));
			 
			if($tipo == "emb"){
		
				form1("", "dados", "php/proj_embed_altera.php","post");
					
					titulo("","", false);
					checkbox("autoplay", "autoplay", 1, caps("autoplay"), "", $auto, false); 
				
					titulo("","NOME (lista de arquivos)",false); 
					input("embed_lb", "input", "embed_lb", $arquivo_dados["embed_lb"], "text");
					
					titulo("","ATUALIZAR C&Oacute;DIGO EMBED",false);
					text("embed", "embed_in", "embed", $arquivo_dados["embed"], false );   
					 
					submit("GRAVAR");
					
				form2();
			
			}
			
			if($tipo == "img"){ 
				
				titulo("", "SUBSTITUIR IMAGEM ( jpg / gif / png )",false);
				up_file_form("php/proj_img_replace.php", "imagem", false, true,"jpg,gif,png,jpeg");  
				
			}
			
			if( $tipo == "emb" ) preview( $embed, "emb" );
			else preview( $file, "img" ); 
			
			?> 
        
        </div> <!--dados-->  
    </div> <!--cont--> 
</body>
</html>
