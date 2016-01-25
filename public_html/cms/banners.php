<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_menus.php");

verif_log();
conectar();

head("BANNERS");
require_once("_tr/up_file_form.php");
?>

<body>

	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 5, true); ?>

    <div id="cont">
      	<div id="dados">

			<?php

			//SQL
			$dados = sql_select("banners","*","id DESC","",true);

			mensagem();
			navega(array("BANNERS"));

			titulo("mt0","&darr; INSERIR IMAGENS ( 900x300 jpg, gif, png )",false);
			up_file_form("_banners", "", "php/banners_up.php", "imagens[]", true, true, "jpg,jpeg,gif,png,bmp","ajax"); 

			for($i=0; $i<count($dados); $i++){

				$id = $dados[$i]['id'];

				div1( "b".$id, "banner","",false);
					a_link('', '', 'banner.php?id='.$id, img("","","../banners/banner".$dados[$i]['id'].".jpg",true,false), '', false );
					bt_del("banner".$id,"php/banner_remove.php?id=".$id, false);

				div2();

			}

			form2();

			?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
