<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php");  
require_once("_menus.php");
require_once("_tr/xml.php"); 

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
			navega(array(array("DOCUMENTOS","documentos.php"), "DOCUMENTO ".$id." _ ".$dados["titulo"] ));  

			form1("altera", "", "php/documento_altera.php?id=".$id, "post"); 
				
				titulo("", "", false);
				checkbox("publicado", "publicado", 1, caps("publicado"), "", $public, false); 

				titulo("","PROJETO", false);
				$projetos = sql_select("projetos","*","","", true);

				$projetos_lista = array();
				for($i=0; $i<count($projetos); $i++){ 
					$projeto_opt = array( $projetos[$i]["id"], $projetos[$i]["id"]." - ".$projetos[$i]["titulo"] );
					array_push($projetos_lista, $projeto_opt);
				} 
				select("id_projeto", "id_projeto", "", false, $projetos_lista, array($dados["id_projeto"]),false); 
			
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

				titulo("","ARQUIVO", false); 
				input("arquivo", "input", "arquivo", $dados["arquivo"] , "text");  

				titulo("","PALAVRAS-CHAVE",false);  
				text("palavras_chave", 'text', "palavras_chave", $dados["palavras_chave"], false);  

				submit("GRAVAR"); 
				
			form2();

			hr();
			
			div1('','nota',"<div class='nota_dados mb10'>AVISO</div>ARQUIVOS COM MAIS QUE 8MB PODEM FICAR CORROMPIDOS SE INSERIDOS USANDO O FORMULÁRIO ABAIXO. NESSES CASOS ACESSE A PASTA <i>DOCUMENTOS</i> ATRAVÉS DE UM CLIENTE FTP (EX: <a href='https://filezilla-project.org/' target='_blank'>FILEZILLA</a>) E INSIRA O ARQUIVO MANUALMENTE. LEMBRE-SE DE INCLUIR O NOME DO ARQUIVO COM EXTENSÃO NO CAMPO <i>ARQUIVO</i> ACIMA, CASO CONTRÁRIO O LINK CONTINUARÁ NÃO EXISTINDO.<br><div class='nota_dados mt10'>HOST: 23.229.196.231 | USER: documentos@paisagem.wwf.org.br | PASSWORD: DHXi@FE6xsm </div>",true);
 
 			titulo("","&darr; INSERIR ARQUIVO :: peso m&aacute;ximo: 8MB",false);
			up_file_form("_documento", "arquivo", "php/documento_arquivo_up.php?id=".$id, "arquivo", false, true, "all"); 
			//up_file_form($action, $name, $multiple, $drop_area, $formatos)

			if( !empty($dados["arquivo"])) { 
				$tb = '';
				$lb = $dados["arquivo"];  
				$lb_ext = '';  
				$link = array("../documentos/".$dados["arquivo"], "_blank"); 

				$bts = array (	array( "del", "php/documento_arquivo_remove.php?id=".$id )); 

				item($id, $tb, $lb, $lb_ext, $link, $bts, false); 
			}  
	
			
			xml_documentos2();
			
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
