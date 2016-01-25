<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php");

conectar();
sessao();

head("LEP - login");

?>

<body class="login">

        <div id="dados_login">
		<img src="_layout/logo_admin.png"/>

		<?php

        form1("login_form", "login_form", "php/esqueci_senha_token.php", "post");

            titulo("","EMAIL (LOGIN)",false);
            input("email", "input", "email", "","text");

            submit("REDEFINIR SENHA &raquo;");

        form2();

		a_link("","link_login","login.php", "VOLTAR", "_self", false);

		mensagem();

        ?>
		</div>

</body>
</html>
