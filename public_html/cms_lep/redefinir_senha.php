<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_menus.php");

conectar();
verif_token();

head("LEP - redefinir senha");
?>
  
<body class="login"> 
     
    	
        <div id="dados_login">
			
    	<img src="_layout/logo_admin.png"/>
    
    	
		<?php  

		form1("senha", "", "php/redefinir_senha_altera.php", "post"); 

			titulo("","SENHA NOVA",false);
			input("senha_nova", "input", "senha_nova", "" , "password"); 

			titulo("","CONFIRME A SENHA NOVA",false);
			input("senha_confirma", "input", "senha_confirma", "" , "password"); 

			submit("GRAVAR"); 

		form2();

		?>
        
    	</div>
     
</body>
</html>