<?php

    require_once('../../../_control/acesso.php');
    require_once('../../../_control/seguranca.php');
    require_once('../../cms_lep/_tr/mysql.php');

    conectar();
    $cod = $_GET['cod'];

    $row = 1;
    if (($csv = fopen('csv/'.$cod.'.csv', "r")) === FALSE) return;
    while (($cols = fgetcsv($csv, 1000, ",")) !== FALSE) {

        $id = $cols[0];
        $dados = implode(',',$cols);
        $dados = trim($dados);

        $valores = array( array('dados', $dados) );

        if($row === 1) sql_update( 'b2020_grupos', $valores, 'codigo=\''.$cod.'\'');
        elseif($row === 2) sql_update( 'b2020_colunas', $valores, 'codigo=\''.$cod.'\'');
        else sql_update( 'b2020_'.$cod, $valores, 'id=\''.$id.'\'');

        $row++;

    }

    print 'dados '.$cod.' inseridos com sucesso!';

?>
