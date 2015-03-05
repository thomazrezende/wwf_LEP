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
require_once("_tr/sortable.php");
?>
<body>     
	
    <?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>

    <div id="cont"> 
        <div id="dados">

        <?php 

		//daods 
		$id = $_SESSION["id"];
		$proj = $_SESSION["proj"];
		$next_id = next_id("arquivos");
		 
		$dados = sql_select("projetos","*","","id=".$id,false); 

		mensagem();	  
		navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] ));   

		clear(); 

		submenu( $submenu_projeto, 4 );

		titulo("","&darr; INSERIR IMAGENS ( jpg / gif / png )",false);
		up_file_form("php/proj_imgs_up.php", "imagens[]", true, true,"jpg,gif,png,jpeg"); 

		titulo("","&darr; INSERIR EMBED (c&oacute;digo) ",false);
		up_emb_form("php/proj_emb_up.php", "embed");  

		$arquivos = sql_select("arquivos","*","","id_projeto='".$id."'",true); 
		clear();

			if( count($arquivos) > 0 ){

				titulo("","LISTA DE ARQUIVOS ( arraste para definir a ordem )",false);
				ul1("itens","sortable");  

				//arquivos 
				for($i=0; $i<count($arquivos); $i++){ 

					$tipo = $arquivos[$i]["tipo"];
					$id_file = $arquivos[$i]["id"];
					$link = "proj_arquivo_dados.php?id=".$id_file; 

					if( $tipo == "emb" ){
						$lb = $arquivos[$i]["embed_lb"]; 
						$tb = "_layout/ico_emb.png";
					}else{
						$lb = $arquivos[$i]["file"]; 
						$tb = "../projetos/projeto".$id."/tb".$id_file."p.jpg";
					}

					$bts = array ( array( "del", "php/proj_arquivo_remove.php?tipo=".$tipo."&id=".$id_file ));  
					item($tipo.$id_file, $tb, $lb, $link, $bts, true);  

				}

				ul2();
				clear();  

				$layout = explode(",",$dados["layout"]); 

				btg_del("EXCLUIR TUDO", "TODOS OS ARQUIVOS?","php/proj_arquivo_remove_all.php",false);  

				form1("layout_altera", "layout_altera", "php/proj_layout_altera.php","POST");  
				input("layout", "input", "layout", $dados["layout"], "hidden");  
				input("pagey_out", "input","pagey_out","","hidden");			
				form2();  

				}
			?>  
		
			
        </div> <!--dados-->  
    </div> <!--cont--> 
</body>
</html>
