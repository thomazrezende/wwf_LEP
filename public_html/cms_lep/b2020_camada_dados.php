<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_menus.php");

verif_log();
conectar();

head("CAMADA ".$_GET["id"]);
require_once("_tr/up_file_form.php");
?>

<body>

	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 7, true); ?>

    <div id="cont">
      	<div id="dados">

			<?php

			//dados
			$id = $_GET["id"];

			//SQL
			$dados = sql_select("b2020_camadas","*","","id=".$id,false);
			($dados["ativo"] == "1")?($public = true):($public = false);

			mensagem();
			navega(array(array("CAMADAS","b2020_camadas.php"), $dados["label"] ));

			if( $dados["fixa"] == 0 ){

				form1("altera", "", "php/b2020_camada_dados_altera.php?id=".$id, "post");

					titulo("","ETIQUETA", false);
					input("label", "input", "label", $dados["label"] , "text");

					titulo("","COR (#ff6600)", false);
					input("cor", "input", "cor", $dados["cor"] , "text");

					titulo("","", false);
					checkbox("ativo ", "ativo", 1, caps("INICIAR ATIVADA"), "", $public, false);

					submit("GRAVAR");

				form2();

				titulo("","MAPA + DADOS (kmz)", false);
				up_file_form("_dados", "arquivo", "php/b2020_camada_kmz_up.php?id=".$id, "arquivo", false, true, "kmz");

			}else{

				titulo("mt0","DADOS (csv)", false);
				up_file_form("_dados", "arquivo", "php/b2020_camada_csv_up.php?codigo=".$dados["codigo"], "arquivo", false, true, "csv");

			} 

			?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
