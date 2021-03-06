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
require_once("_tr/up_repositorio_form.php");
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

			submenu( $submenu_projeto, 2);

			div1("campos","","", false);
			up_file_form( 1, 1, "php/projeto_repositorio_up.php", "arquivo", false, false, "all","ajax");
			div2();

			btg("bt_add", "bt_add", "+", "");
			btg("enviar", "", "ENVIAR ARQUIVOS", "");

			titulo('','REPOSIT&Oacute;RIO', false);
			ul1("itens",false);
			$repositorios = sql_select( "repositorios", "*", "arquivo", "id_projeto=".$id, true );

			$lista = "";

			for($i=0; $i<count($repositorios); $i++){

				$id_repositorio = $repositorios[$i]["id"];
				$tb = '_layout/ico_'.$repositorios[$i]["ext"].".png";
				$lb = $repositorios[$i]["arquivo"] . " :: " . round($repositorios[$i]["bites"]/1000, 2) . " Kb";
				$lb_ext = "";
				$link = array("../projetos/projeto".$id."/".$repositorios[$i]["arquivo"],"_blank");

				$bts = array (	array( "del", "php/projeto_repositorio_remove.php?id=".$id_repositorio ));

				item('item'.$id_repositorio, $tb, $id_repositorio." _ ".$lb, $lb_ext, $link, $bts, false);

				$lista .= $repositorios[$i]["arquivo"];
				if( $i<count($repositorios)-1 ) $lista .= ",";
			}

			ul2();

			input("lista", "text", "lista", $lista, "hidden");

			?>



        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
