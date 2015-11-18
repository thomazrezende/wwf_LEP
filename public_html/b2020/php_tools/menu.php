<?php
ini_set('memory_limit', '-1');

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

function bool($n){
    if($n=='0') return 'false';
    else return 'true';
}

function built_json($data, $obj){
    print '"'.$obj.'":[';

    for( $i=0; $i<count($data); $i++ ){

        $id = $data[$i]['id'];
        $dados_arr = explode( ',', $data[$i]['dados']);

        $dados_arr[1] = 'Nome do item';

        print '{';
        print '"id":"'.$id.'",';
        print '"nome":"'.$dados_arr[1].'"';
        print '}';

        if( $i < count($data)-1 ) print ',';
    }
    print '],';
}

conectar();

    print '{';

    // bacias
    $bhs = sql_select( 'b2020_bh', '*', '', 'tipo=\'principal\'', true );
    built_json($bhs, 'bh', true);

    // aps
    $aps = sql_select( 'b2020_ap', '*', '', '', true );
    built_json($aps, 'ap');

    // tis
    $tis = sql_select( 'b2020_ti', '*', '', '', true );
    built_json($tis, 'ti');

    // ucs
    $ucs = sql_select( 'b2020_uc', '*', '', '', true );
    built_json($ucs, 'uc');

    // camadas
    $camadas = sql_select( 'b2020_camadas', '*', '', '', true );
    print '"camadas":[';

    for( $i=0; $i<count($camadas); $i++ ){

        print '{';
        print '"label":"'.$camadas[$i]['label'].'",';
        print '"codigo":"'.$camadas[$i]['codigo'].'",';
        print '"cor":"'.$camadas[$i]['cor'].'",';
        print '"ativo":'.bool($camadas[$i]['ativo']);
        print '}';

        if( $i < count($camadas)-1 ) print ',';
    }
    print ']';
    print '}';


?>
