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

			submenu( $submenu_projeto, 2);

			div1('','nota',"<div class='nota_dados mb10'>AVISO</div>ESTA LISTA PERMITE APENAS TESTES DE DOWNLOAD. PARA INSERIR OU REMOVER ARQUIVOS POR FAVOR ACESSE A PASTA <i>PROJETO".$id."</i> ATRAVÉS DE UM CLIENTE FTP (EX: <a href='https://filezilla-project.org/' target='_blank'>FILEZILLA</a>) COM OS SEGUINTES DADOS:<div class='nota_dados mt10'>HOST: 23.229.196.231 | USER: repositorio@paisagem.wwf.org.br | PASSWORD: DHXi@FE6xsm </div>",true);

			$repositorio = scandir("../repositorio/projeto".$id);

			$grupo_lb = '';

			foreach($repositorio as $arquivo) {

				if($arquivo[0] != "."){

					$arquivo_arr = explode('.',$arquivo);

					$peso;

					//peso
					if($size <= 1000) $peso = '1KB';
					else if($size > 1000 && $size < 1000000) $peso = round($size/1000,1) . ' KB';
					else if($size > 1000000 && $size < 1000000000) $peso = round($size/1000000,1) . ' MB';
					else if($size >= 1000000000 ) $peso = round($size/1000000000,1) . ' GB';

					if($grupo_lb != $arquivo_arr[0] ){
						$grupo_lb = $arquivo_arr[0];
						titulo('',caps($grupo_lb), false);
					}

					$size = filesize("../repositorio/projeto".$id."/".$arquivo);

					$tb = '_layout/ico_'.$arquivo_arr[1].".png";
					$lb = $arquivo . " :: " . $peso;
					$lb_ext = "";
					$link = array("../repositorio/projeto".$id."/".$arquivo,"_blank");

					$bts = false;

					item('item', $tb, $lb, $lb_ext, $link, $bts, false);

				}

			}

		?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
