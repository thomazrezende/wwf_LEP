<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");

	conectar();
	verif_log();

	$id = $_GET["id"];
	$up_file = $_FILES['arquivo']['tmp_name'];
	$path_file = "../../b2020/camadas/camada".$id."/camada.kmz";

	if( file_exists($path_file)){ unlink($path_file); }
	copy( $up_file, $path_file );

?>
