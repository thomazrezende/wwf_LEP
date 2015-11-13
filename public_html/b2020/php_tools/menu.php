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

    $bacias = sql_select( 'b2020_bh_coords', '*', '', 'tipo=\'principal\'', true );
    print '"bacias":[';

    for( $i=0; $i<count($bacias); $i++ ){

        $bacia_id = $bacias[$i]['bacia_id'];
        $dados = sql_select( 'b2020_bh_dados', '*', '', 'bacia_id=\''.$bacia_id.'\'', false );
        $dados_arr = explode( ',', $dados['dados']);

        $dados_arr[1] = 'Nome da Bacia';

        print '{';
        print '"bacia_id":"'.$bacia_id.'",';
        print '"nome":"'.$bacia_id.'-'.$dados_arr[1].'"';
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
