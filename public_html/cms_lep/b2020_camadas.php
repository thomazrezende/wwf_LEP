<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_menus.php");

verif_log();
conectar();

head("B2020 : CAMADAS");
require_once("_tr/up_file_form.php");
?>

<body>

	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 7, true); ?>

    <div id="cont">
      	<div id="dados">

            <?php

			mensagem();
			navega( array("B2020 : CAMADAS") );

            titulo("mt0","CAMADAS FIXAS",false);

            $camadas_fixas = sql_select("b2020_camadas","*","id "," fixa='1'",true);

            ul1("itens",'');

            for($i=0; $i<count($camadas_fixas); $i++){

                $id = $camadas_fixas[$i]["id"];
                $tb = '_layout/ico_camada.png';
                $lb = $camadas_fixas[$i]["label"];
                $lb_ext = "";
                $link = array("b2020_camada_dados.php?id=".$id, false);

                $bts = array ();

                item('item'.$id, $tb, caps($lb), $lb_ext, $link, $bts, false);

            }

            ul2();

            $camadas_extra = sql_select("b2020_camadas","*","id DESC"," fixa='0'",true);

			form1("novo", "", "php/b2020_camada_insere.php", "post");

				titulo("","&darr; NOVA CAMADA (etiqueta)",false);
				input("label", "input", "label", "", "text");
				submit("INSERIR");

			form2();

            titulo("mt0","CAMADAS EXTRA",false);
			ul1("itens",'');

			for($i=0; $i<count($camadas_extra); $i++){

				$id = $camadas_extra[$i]["id"];
				$tb = '_layout/ico_camada.png';
				$lb = $camadas_extra[$i]["label"];
				$lb_ext = "";
				$link = array("b2020_camada_dados.php?id=".$id, false);

				$bts = array (	array( "del", "php/b2020_camada_remove.php?id=".$id ));

				item('item'.$id, $tb, caps($lb), $lb_ext, $link, $bts, false);

			}

			ul2();




			?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
