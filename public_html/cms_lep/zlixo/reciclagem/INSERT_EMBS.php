<?php
require_once("../../../_tr_8362036/acesso.php");
require_once("../../../_tr_8362036/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");
 
verif_log(); 
conectar();

head("proj_arquivos");  
?>
<body>  
    
        
           <?php  
			 
			$arquivos = sql_select("arquivos","*","","tipo='emb'",true);	 
			
			//IMAGENS
			for($i=0; $i<count($arquivos); $i++){				
				sql_update("projetos",array(array("layout","emb".$arquivos[$i]["id"]."/w_emb"),array("dd_usar_display","1")),"id='".$arquivos[$i]["id_proj"]."'");				
			
				print "emb".$arquivos[$i]["id"]."/w_emb - proj".$arquivos[$i]["id_proj"];
				print "<br>";
			}
			
			print "ok";
			 
			
			?> 
        
</body>
</html>
