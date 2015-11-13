<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
$id = $_GET['id'];
$cod = $_GET['cod'];

print '{';

if( $id != 'null' ){ // item selecionado

    $selecao = sql_select( 'b2020_'.$cod.'_coords', '*', '', $cod.'_id=\''.$id.'\'', false );
    $dados = sql_select( 'b2020_'.$cod.'_dados', '*', '', $cod.'_id=\''.$id.'\'', false );
    $labels = sql_select( 'b2020_'.$cod.'_dados', '*', '', 'id=\'1\'', false );
    $colunas = sql_select( 'b2020_'.$cod.'_dados', '*', '', 'id=\'2\'', false );

    print '"selecao":{';
    print '"dados":"'.$dados['dados'].'",';
    print '"labels":"'.$labels['dados'].'",';
    print '"colunas":"'.$colunas['dados'].'",';
    print '"coords":"'.$selecao['coords'].'",';
    print '"id":"'.$selecao[$cod.'_id'].'"';
    print '}';

}else{ // itens mapa

    $mapa = sql_select( 'b2020_'.$cod.'_coords', '*', '', '', true );
    print '"mapa":[';

    for($i=0; $i<count($mapa); $i++){
        print '{';
        print '"coords":"'.$mapa[$i]['coords'].'",';
        print '"id":"'.$mapa[$i][$cod.'_id'].'"';
        print '}';
        if( $i < count($mapa)-1 ) print ',';
    }
    print ']';
}

print '}';

?>
