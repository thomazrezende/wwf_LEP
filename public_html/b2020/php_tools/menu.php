<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

function bool($n){
    if($n===0) return 'false';
    else return 'true';
}

conectar();

    print '{';

    // bacias

    $bacias = sql_select( 'b2020_bh', '*', '', 'tipo=\'principal\'', true );
    print '"bacias":[';

    for( $i=0; $i<count($bacias); $i++ ){

        $id = $bacias[$i]['id'];
        $dados_arr = explode( ',', $bacias[$i]['dados']);

        $dados_arr[1] = 'Nome da Bacia';

        print '{';
        print '"id":"'.$id.'",';
        print '"nome":"'.$id.'-'.$dados_arr[1].'"';
        print '}';

        if( $i < count($bacias)-1 ) print ',';
    }
    print '],';

    // camadas

    $camadas = sql_select( 'b2020_camadas', '*', '', '', true );
    print '"camadas":[';

    for( $i=0; $i<count($camadas); $i++ ){

        print '{';
        print '"id":"'.$camadas[$i]['id'].'",';
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
