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
    
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php
 
			//dados 
			$id = $_SESSION["id"];
			$titulo = $_SESSION["titulo"];

			//SQL 
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." _ ".$titulo )); 

			submenu( $submenu_projeto, 3);
			
			$itens = sql_select( "arquivos","*","","",true ); 

			form1("novo", "", "php/projeto_arquivo_insere.php", "post"); 
				
				titulo("mt0","&darr; NOVO ARQUIVO (nome_dos_arquivos : sem espa&ccedil;o &sol; extens&atilde;o)",false);
				input("label", "input", "label", "", "text");
				
				submit("INSERIR");
			
			form2();
			
			for($a=0; $a<count($grupos); $a++){ 
				
				titulo("", $grupos[$a][1], false); 
				ul1("itens".$a,false);

				for($i=0; $i<count($itens); $i++){

					if($itens[$i]["grupo"] == $a){
							
						$id = $itens[$i]["id"];
						$tb = '';
						$lb = $itens[$i]["label"];
						$link = array("projeto_arquivo.php?id=".$id, false);

						$bts = array (	array( "del", "php/projeto_arquivo_remove.php?id=".$id )); 

						item('item'.$id, $tb, $id." _ ".$lb, $link, $bts, false);
					}
				} 
				
				ul2();
				
			}	
 
			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
