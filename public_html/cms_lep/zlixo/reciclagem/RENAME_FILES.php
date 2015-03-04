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
			 
			$arquivos = sql_select("arquivos","*","","tipo='img'",true);	 
			
			//IMAGENS
			for($i=0; $i<count($arquivos); $i++){
				
				$pasta = "../projetos/projeto".$arquivos[$i]["id_proj"]."/";
				$arquivo = $arquivos[$i]["arquivo"];				
				
				if(file_exists( $pasta.$arquivo )){
					//print "<img src=\"".$pasta.$arquivo."\" />";  
					
					$filename = $pasta.$arquivo; 
					
					// Content type
					header('Content-Type: image/jpeg');
					
					// Get new sizes
					list($width, $height) = getimagesize($filename);
					$newwidth = 216;
					$newheight = 122;
					
					// Load
					$thumb = imagecreatetruecolor($newwidth, $newheight);
					$source = imagecreatefromjpeg($filename);
					
					// Resize
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
					
					// Output 
					imagejpeg($thumb, $pasta."img".$arquivos[$i]["id"]."p.jpg", 95);  
					//unlink($thumb);
					//unlink($source);
					
					//resize
					rename($pasta.$arquivo , $pasta."img".$arquivos[$i]["id"]."g.jpg" ); 
					
					print "<img src=\"".$pasta."img".$arquivos[$i]["id"]."g.jpg\" />";
					print "<img src=\"".$pasta."img".$arquivos[$i]["id"]."p.jpg\" />";
					
				}
			}
			
			print "ok";
			 
			
			?> 
        
</body>
</html>
