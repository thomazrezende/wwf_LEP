<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/html.php");
	require_once("../_tr/mysql.php");

	conectar();
	verif_log();

	if(isset($_POST["label"]) && !empty($_POST["label"])){

		$prox = next_id("b2020_camadas");
		mkdir("../../b2020/camadas/camada".$prox,0755);

		$valores = array( array("label",$_POST["label"]));

		sql_insert("b2020_camadas", $valores);
		location("../b2020_camada_dados.php","id=".$prox);
	}else{
		location("../b2020_camadas.php","msg_erro=ESCOLHA UMA ETIQUETA");
	}


?>
