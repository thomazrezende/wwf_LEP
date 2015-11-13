<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();

$bacias = sql_select( 'b20_bacias', '*', '', 'tipo=\'principal\'', true);

print '{';
print '"bacias":[';

for($i=0; $i<count($bacias); $i++){
    print '{';
    print '"coords":"'.$bacias[$i]['coords'].'",';
    print '"tipo":"'.$bacias[$i]['tipo'].'",';
    print '"principal":"'.$bacias[$i]['principal'].'",';
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
