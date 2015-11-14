<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
$id = $_GET['id'];

print '{';
// bacia selecionada
if( $id != 'null' ){

    $bacia = sql_select( 'b2020_bh', '*', '', 'id=\''.$id.'\'', false );
    $grupos = sql_select( 'b2020_grupos', '*', '', 'codigo=\'bh\'', false );
    $colunas = sql_select( 'b2020_colunas', '*', '', 'codigo=\'bh\'', false );

    if($bacia['tipo'] == 'principal') $condicao = 'principal=\''.$bacia['principal'].'\' and tipo=\'macro\'';
    if($bacia['tipo'] == 'macro') $condicao = 'principal=\''.$bacia['principal'].'\' and macro_id=\''.$id.'\' and tipo=\'meso\'';
    if($bacia['tipo'] == 'meso') $condicao = 'principal=\''.$bacia['principal'].'\' and macro_id=\''.$bacia['macro_id'].'\' and meso_id=\''.$id.'\' and tipo=\'micro\'';
    if($bacia['tipo'] == 'micro') $condicao = 'principal=\'null\' and tipo=\'null\'';

    print '"bacia":{';
    print '"dados":"'.$bacia['dados'].'",';
    print '"grupos":"'.$grupos['dados'].'",';
    print '"colunas":"'.$colunas['dados'].'",';
    print '"coords":"'.$bacia['coords'].'",';
    print '"tipo":"'.$bacia['tipo'].'",';
    print '"principal":"'.$bacia['principal'].'",';
    print '"principal_id":"'.$bacia['principal_id'].'",';
    print '"id":"'.$bacia['id'].'",';
    print '"macro_id":"'.$bacia['macro_id'].'",';
    print '"meso_id":"'.$bacia['meso_id'].'",';
    print '"micro_id":"'.$bacia['micro_id'].'"';
    print '},';

}else{
    $condicao = 'tipo=\'principal\'';
}

    $bacias = sql_select( 'b2020_bh', '*', '', $condicao, true );
    print '"bacias":[';

    for($i=0; $i<count($bacias); $i++){
        print '{';
        print '"coords":"'.$bacias[$i]['coords'].'",';
        print '"tipo":"'.$bacias[$i]['tipo'].'",';
        print '"principal":"'.$bacias[$i]['principal'].'",';
        print '"principal_id":"'.$bacias[$i]['principal_id'].'",';
        print '"id":"'.$bacias[$i]['id'].'",';
        print '"macro_id":"'.$bacias[$i]['macro_id'].'",';
        print '"meso_id":"'.$bacias[$i]['meso_id'].'",';
        print '"micro_id":"'.$bacias[$i]['micro_id'].'"';
        print '}';
        if( $i < count($bacias)-1 ) print ',';
    }

    print ']';
    print '}';

?>
