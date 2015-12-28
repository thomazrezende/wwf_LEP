<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_tr/xml.php");
require_once("_menus.php");

verif_log();
conectar();

head("PROJETO ".$_SESSION["id"]);
require_once("_tr/up_file_form.php");

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

			submenu( $submenu_projeto, 6);

 			titulo("","&darr; INSERIR IMAGEM : (LARGURA: 450px | fundo branco | jpg, gif, png)",false);
			up_file_form("imagem", "arquivo", "php/projeto_apoio_up.php?id=".$id, "imagem", false, true, "jpg,jpeg,gif,png,bmp","ajax");
			//up_file_form($action, $name, $multiple, $drop_area, $formatos)

			if( file_exists("../projetos/projeto".$id."/apoio.jpg")) {

				$tb = "../projetos/projeto".$id."/apoio.jpg";
				$lb = "apoio.jpg";
				$lb_ext = "";
				$link = false;

				$bts = array( array( "del", "php/projeto_apoio_remove.php?id=".$id ));

				item('item', $tb, $lb, $lb_ext, $link, $bts, false);

				preview("../projetos/projeto".$id."/apoio.jpg","img");

			}

			?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
