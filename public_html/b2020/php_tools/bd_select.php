<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
$id = $_GET['id'];
$cod = $_GET['cod'];

print '{';

if( $id != 'null' ){ // item selecionado

    $selecao = sql_select( 'b2020_'.$cod, '*', '', 'id=\''.$id.'\'', false );
    $grupos = sql_select( 'b2020_grupos', '*', '', 'codigo=\''.$cod.'\'', false );
    $colunas = sql_select( 'b2020_colunas', '*', '', 'codigo=\''.$cod.'\'', false );

    print '"selecao":{';
    print '"dados":"'.$selecao['dados'].'",';
    print '"grupos":"'.$grupos['dados'].'",';
    print '"colunas":"'.$colunas['dados'].'",';
    print '"tipo":"'.$selecao['tipo'].'",';
    print '"coords":"'.$selecao['coords'].'",';
    print '"id":"'.$selecao['id'].'"';
    print '}';

}else{ // itens mapa

    $mapa = sql_select( 'b2020_'.$cod, '*', '', '', true );
    print '"mapa":[';

    for($i=0; $i<count($mapa); $i++){
        print '{';
        print '"id":"'.$mapa[$i]['id'].'",';
        print '"tipo":"'.$mapa[$i]['tipo'].'",';
        print '"coords":"'.$mapa[$i]['coords'].'",';
        print '"id":"'.$mapa[$i]['id'].'"';
        print '}';
        if( $i < count($mapa)-1 ) print ',';
    }
    print ']';
}

print '}';

?>
