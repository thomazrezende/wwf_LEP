<?php
require_once("../../../../_tr_8362036/seguranca.php"); 
require_once("../../../../_tr_8362036/acesso.php");
require_once("../_tr/mysql.php");
require_once("../_tr/xml.php"); 
require_once("../_tr/html.php"); 
 
verif_log(); 
conectar();

head(""); 
?>
<body>  

	   <?php  
		 
		$arquivos = sql_select("projetos","id, projeto_pt","","",true);	 
		
		//IMAGENS
		print_r($arquivos);
		
		for($i=0; $i<count($arquivos); $i++){				
			
			xml_proj($arquivos[$i]["id"]); 
		
			print  $arquivos[$i]["projeto_pt"]." ok";
			print "<br>"; 
			
		}
		
		print "COMPLETO!"; 
		
		?> 
        
</body>
</html>
