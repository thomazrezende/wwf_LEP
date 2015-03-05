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
		
        
        form1("login_form", "login_form", "php/logar.php", "post");
        
            titulo("","LOGIN",false);
            input("login", "input", "login", "", "text");
            
            titulo("","SENHA",false);
            input("senha", "input", "senha", "", "password");  
            
            submit("ENTRAR &raquo;");
       
        form2();   
		
		a_link("","link_login","php/esqueci_senha.php", "esqueci a senha", "_self", false);	
		
		mensagem();
		
       
        ?> 
		</div>  
     
</body>
</html>
