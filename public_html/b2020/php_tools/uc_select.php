<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
$uc_id = $_GET['uc_id'];

print '{';
// uc selecionada
if( $uc_id != 'null' ){

    $uc = sql_select( 'b2020_uc_coords', '*', '', 'uc_id=\''.$uc_id.'\'', false );
    $dados = sql_select( 'b2020_uc_dados', '*', '', 'uc_id=\''.$uc_id.'\'', false );
    $labels = sql_select( 'b2020_uc_dados', '*', '', 'id=\'1\'', false );
    $colunas = sql_select( 'b2020_uc_dados', '*', '', 'id=\'2\'', false );

    print '"uc":{';
    print '"dados":"'.$dados['dados'].'",';
    print '"labels":"'.$labels['dados'].'",';
    print '"colunas":"'.$colunas['dados'].'",';
    print '"coords":"'.$uc['coords'].'",';
    print '"uc_id":"'.$uc['uc_id'].'"';
    print '}';

}else{

    $ucs = sql_select( 'b2020_uc_coords', '*', '', '', true );
    print '"ucs":[';

    for($i=0; $i<count($ucs); $i++){
        print '{';
        print '"coords":"'.$ucs[$i]['coords'].'",';
        print '"uc_id":"'.$ucs[$i]['uc_id'].'"';
        print '}';
        if( $i < count($ucs)-1 ) print ',';
    }
    print ']';
}

print '}';

?>
