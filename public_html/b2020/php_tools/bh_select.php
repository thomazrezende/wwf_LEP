<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
$bacia_id = $_GET['bacia_id'];

print '{';
// bacia selecionada
if( $bacia_id != 'null' ){

    $bacia = sql_select( 'b2020_bh_coords', '*', '', 'bacia_id=\''.$bacia_id.'\'', false );
    $dados = sql_select( 'b2020_bh_dados', '*', '', 'bacia_id=\''.$bacia_id.'\'', false );
    $labels = sql_select( 'b2020_bh_dados', '*', '', 'id=\'1\'', false );
    $colunas = sql_select( 'b2020_bh_dados', '*', '', 'id=\'2\'', false );

    if($bacia['tipo'] == 'principal') $condicao = 'principal=\''.$bacia['principal'].'\' and tipo=\'macro\'';
    if($bacia['tipo'] == 'macro') $condicao = 'principal=\''.$bacia['principal'].'\' and macro_id=\''.$bacia_id.'\' and tipo=\'meso\'';
    if($bacia['tipo'] == 'meso') $condicao = 'principal=\''.$bacia['principal'].'\' and macro_id=\''.$bacia['macro_id'].'\' and meso_id=\''.$bacia_id.'\' and tipo=\'micro\'';
    if($bacia['tipo'] == 'micro') $condicao = 'principal=\'null\' and tipo=\'null\'';

    print '"bacia":{';
    print '"dados":"'.$dados['dados'].'",';
    print '"labels":"'.$labels['dados'].'",';
    print '"colunas":"'.$colunas['dados'].'",';
    print '"coords":"'.$bacia['coords'].'",';
    print '"tipo":"'.$bacia['tipo'].'",';
    print '"principal":"'.$bacia['principal'].'",';
    print '"principal_id":"'.$bacia['principal_id'].'",';
    print '"bacia_id":"'.$bacia['bacia_id'].'",';
    print '"macro_id":"'.$bacia['macro_id'].'",';
    print '"meso_id":"'.$bacia['meso_id'].'",';
    print '"micro_id":"'.$bacia['micro_id'].'"';
    print '},';
}else{
    $condicao = 'tipo=\'principal\'';
}

$bacias = sql_select( 'b2020_bh_coords', '*', '', $condicao, true );
print '"bacias":[';

for($i=0; $i<count($bacias); $i++){
    print '{';
    print '"coords":"'.$bacias[$i]['coords'].'",';
    print '"tipo":"'.$bacias[$i]['tipo'].'",';
    print '"principal":"'.$bacias[$i]['principal'].'",';
    print '"principal_id":"'.$bacias[$i]['principal_id'].'",';
    print '"bacia_id":"'.$bacias[$i]['bacia_id'].'",';
    print '"macro_id":"'.$bacias[$i]['macro_id'].'",';
    print '"meso_id":"'.$bacias[$i]['meso_id'].'",';
    print '"micro_id":"'.$bacias[$i]['micro_id'].'"';
    print '}';
    if( $i < count($bacias)-1 ) print ',';
}
print ']';
print '}';

?>
