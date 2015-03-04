<?php
require_once("../../_tr_1048672/acesso.php");
require_once("../../_tr_1048672/seguranca.php");
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
				input("titulo", "titulo", $dados["titulo"] , "text"); 

				titulo("","AUTOR",false); 
				input("autor", "autor", $dados["autor"] , "text"); 

				titulo("","ANO (aaaa)",false); 
				input("ano", "ano", $dados["ano"] , "text"); 

				titulo("","VE&Iacute;CULO",false); 
				input("veiculo", "veiculo", $dados["veiculo"] , "text"); 

				titulo("","LINK", false); 
				input("link", "link", $dados["link"] , "text");  

				titulo("","PALAVRAS-CHAVE",false);  
				text("palavras_chave", 'text', "palavras_chave", $dados["palavras_chave"], false);  

				submit("GRAVAR"); 
				
			form2();

			hr();
			
			titulo("","&darr; INSERIR ARQUIVO",false);
			up_file_form("php/documento_up.php", "arquivo", false, true, "all"); 
			
			if( !empty($dados["arquivo"])) { 
				$tb = '';
				$lb = $dados["arquivo"]; 
				$link = array("../documentos/".$dados["arquivo"], "_blank"); 

				$bts = array (	array( "del", "php/documento_arquivo_remove.php?id=".$id )); 

				item($id, $tb, $lb, $link, $bts, false);
			} 

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>