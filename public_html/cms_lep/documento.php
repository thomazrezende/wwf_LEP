<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("LEP - documento");  
require_once("_tr/up_file_form.php");  
?>

<body>  
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 3, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php

			$id = $_GET["id"];
			
			//SQL
			$dados = sql_select("documentos","*","","id=".$id,false);   
			($dados["publicado"] == "1")?($public = true):($public = false); 
			
			mensagem();	 
			navega(array(array("DOCUMENTOS","documentos.php"), $id." - ".$dados["titulo"] ));  

			form1("altera", "", "php/documento_altera.php?id=".$id, "post"); 
				
				titulo("", "", false);
				checkbox("publicado", "publicado", 1, caps("publicado"), "", $public, false); 
			
				titulo("","T&Iacute;TULO", false); 
				input("titulo", "input", "titulo", $dados["titulo"] , "text"); 

				titulo("","AUTOR",false); 
				input("autor", "input", "autor", $dados["autor"] , "text"); 

				titulo("","ANO (aaaa)",false); 
				input("ano", "input", "ano", $dados["ano"] , "text"); 

				titulo("","VE&Iacute;CULO",false); 
				input("veiculo", "input", "veiculo", $dados["veiculo"] , "text"); 

				titulo("","LINK", false); 
				input("link", "input", "link", $dados["link"] , "text");  

				titulo("","PALAVRAS-CHAVE",false);  
				text("palavras_chave", 'text', "palavras_chave", $dados["palavras_chave"], false);  

				submit("GRAVAR"); 
				
			form2();

			hr();
			
			titulo("","&darr; INSERIR ARQUIVO",false);
			up_file_form("php/documento_arquivo_up.php?id=".$id, "arquivo", false, true, "all"); 
			//up_file_form($action, $name, $multiple, $drop_area, $formatos)

			if( !empty($dados["arquivo"])) { 
				$tb = '';
				$lb = $dados["arquivo"]; 
				$link = array("../documentos/documento".$id."/".$dados["arquivo"], "_blank"); 

				$bts = array (	array( "del", "php/documento_arquivo_remove.php?id=".$id )); 

				item($id, $tb, $lb, $link, $bts, false);
			} 

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
