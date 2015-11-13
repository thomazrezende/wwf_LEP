<?php

    require_once('../../../_control/acesso.php');
    require_once('../../../_control/seguranca.php');
    require_once('../../cms_lep/_tr/mysql.php');

    conectar();

    sql_truncate('b20_bacias_dados');

    if (($csv = fopen('dados_bacias.csv', "r")) === FALSE) return;
    while (($cols = fgetcsv($csv, 1000, "\t")) !== FALSE) {
        foreach( $cols as $key => $val ) {
            $cols[$key] = trim( $cols[$key] );
            // print $cols[$key];

            $bacia_id = explode(',', $cols[$key])[0];

            // insert
            $valores = array(	array("bacia_id", $bacia_id ),
                                array("dados", $cols[$key] ));

            sql_insert( 'b20_bacias_dados', $valores);

        }
    }

    print 'dados inseridos com sucesso!';

?>
