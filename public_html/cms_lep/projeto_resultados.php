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

			submenu( $submenu_projeto, 5);
			
			$itens = sql_select( "resultados","*","","",true ); 

			form1("novo", "", "php/projeto_resultado_insere.php", "post"); 
				
				titulo("mt0","&darr; NOVO RESULTADO (nome_dos_arquivos)",false);
				input("label", "input", "label", "", "text");
				
				submit("INSERIR");
			
			form2();
			
			titulo("","RESULTADOS",false);
			ul1("itens2",false);
			
			for($i=0; $i<count($itens); $i++){ 
					
				$id = $itens[$i]["id"];
				$tb = '';
				$lb = $itens[$i]["label"];
				$link = array("projeto_resultado.php?id=".$id, false);

				$bts = array (	array( "del", "php/projeto_resultado_remove.php?id=".$id )); 

				item('item'.$id, $tb, $id." _ ".$lb, $link, $bts, false);
				
			} 
			ul2();

			

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->  

</body>
</html>
