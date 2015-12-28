<?php

	require_once("../../../_control/seguranca.php");
	require_once("../../../_control/acesso.php");
	require_once("../_tr/mysql.php");
	require_once("../_tr/html.php");

	conectar();
	verif_log();

	$cod = $_GET['cod'];
	$id = $_GET['id'];
	$up_file = $_FILES['arquivo']['tmp_name'];

    $row = 1;
    if (($csv = fopen($up_file, "r")) === FALSE) return;
    while (($cols = fgetcsv($csv, 1000, ",")) !== FALSE) {

        $id_bacia = $cols[0];
        $dados = implode(',',$cols);
        $dados = trim($dados);

        $valores = array( array('dados', $dados) );

        if($row === 1) sql_update( 'b2020_grupos', $valores, 'codigo=\''.$cod.'\'');
        elseif($row === 2) sql_update( 'b2020_colunas', $valores, 'codigo=\''.$cod.'\'');
        else sql_update( 'b2020_'.$cod, $valores, 'id=\''.$id_bacia.'\'');

        $row++;

    }

	location("../b2020_camada_dados.php","id=".$id.'&msg_ok=DADOS ATUALIZADOS COM SUCESSO' );

?>
