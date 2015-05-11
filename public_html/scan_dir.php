<?php

$dir = "repositorio/projeto".$_GET["id"];

$files = scandir($dir);
$list = [];

foreach( $files as $file){
	if($file[0] != '.')	{
			
		$nome = explode(".",$file)[0];
		$ext = explode(".",$file)[1];
		$size = filesize($dir."/".$file); 
		
		$rep = $file." | ".$nome." | ".$ext." | ".$size;
		
		array_push($list, $rep); 
	}
}

print join(',',$list);

?>