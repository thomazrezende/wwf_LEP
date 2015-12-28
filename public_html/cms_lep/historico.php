<?php

require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_menus.php");

verif_log();
conectar();

if($_SESSION["user_admin"] != 1){
	location("lep_dados.php","msg_erro=ACESSO NEGADO");
}

head("LEP - usuário");

?>
<body>

	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 1, true); ?>

    <div id="cont">
        <div id="dados">

            <?php

			mensagem();
            navega(array("HISTÓRICO"));
            submenu($submenu_lep, 3);

			$logs = sql_select( "logs","*","id DESC","",true );

			div1('historico', '', '', false);

			for($i=0; $i<count($logs); $i++){

				$conteudo = "";

				$ip = utf8_encode($logs[$i]["ip"]);
				$name = utf8_encode($logs[$i]["user_name"]);
				$id = utf8_encode($logs[$i]["user_id"]);
				$email = utf8_encode($logs[$i]["user_email"]);
				$data = utf8_encode($logs[$i]["data"]);
				$hora = utf8_encode($logs[$i]["hora"]);
				$browser = utf8_encode($logs[$i]["browser"]);

				$conteudo .= "<hr>\r\n";
				$conteudo .= "<b>id_usuario:</b> ".$id."<br>\r\n";
				$conteudo .= "<b>usuario:</b> ".$name."<br>\r\n";
				$conteudo .= "<b>login:</b> ".$email."<br>\r\n";
				$conteudo .= "<b>data:</b> ".$data."<br>\r\n";
				$conteudo .= "<b>hora:</b> ".$hora."<br>\r\n";
				$conteudo .= "<b>IP:</b> ".$ip."<br>\r\n";
				$conteudo .= "<b>browser:</b> ".$browser."\r\n";

				print $conteudo;

			}

			div2();

			?>

        </div> <!--dados-->

    </div> <!--cont-->

</body>
</html>
