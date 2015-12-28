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
            navega(array("USUÁRIOS"));
            submenu($submenu_lep, 2);

			$usuarios = sql_select( "usuarios","*","id DESC","",true );

			form1("novo", "", "php/usuario_insere.php", "post");

				titulo("mt0","&darr; NOVO USUÁRIO (e-mail)",false);
				input("email", "input", "email", "", "text");
				submit("INSERIR");

			form2();

			titulo("","PUBLICADOS",false);
			ul1("itens",false);

			for($i=0; $i<count($usuarios); $i++){

				$admin = "";
				if($usuarios[$i]["admin"] == 1) $admin = " (admin)";

				$id = $usuarios[$i]["id"];
				if($admin != "" ) $tb = '_layout/ico_admin.png';
				else $tb = '_layout/ico_visitante.png';
				$lb = $usuarios[$i]["nome"];
				$lb_ext = " :: ".$usuarios[$i]["email"].$admin;
				$link = array("usuario.php?id=".$id, false);

				if( $usuarios[$i]["id"] == '0'){
					$bts = array();
				}else{
					$bts = array( array( "del", "php/usuario_remove.php?id=".$id ));
				}


				item('item'.$id, $tb, $lb, $lb_ext, $link, $bts, false);

			}

			ul2();

			?>

        </div> <!--dados-->

    </div> <!--cont-->

</body>
</html>
