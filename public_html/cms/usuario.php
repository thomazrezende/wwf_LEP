<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");
require_once("_tr/string.php");
require_once("_menus.php");
require_once("_tr/xml.php");

verif_log();
conectar();

if($_SESSION["user_admin"] != 1){
	location("usuarios.php","msg_erro=ACESSO NEGADO");
}

head("LEP - usuário");
require_once("_tr/up_file_form.php");
?>

<body>

	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 8, true); ?>

    <div id="cont">
      	<div id="dados">

			<?php

			$id = $_GET["id"];

			//SQL
			$dados = sql_select("usuarios","*","","id=".$id,false);
			($dados["admin"] == "1")?($admin = true):($admin = false);

			mensagem();
			navega(array(array("USUÁRIOS","usuarios.php"), $dados["nome"] ));

			form1("altera", "", "php/usuario_altera.php?id=".$id, "post");

				titulo("", "", false);
				checkbox("admin", "admin", 1, caps("administrador"), "", $admin, false);

				titulo("","NOME", false);
				input("nome", "input", "nome", $dados["nome"] , "text");

				titulo("","E-MAIL", false);
				input("email", "input", "email", $dados["email"] , "text");

				submit("GRAVAR");

			form2();

			?>

        </div> <!--dados-->
    </div> <!--cont-->

</body>
</html>
