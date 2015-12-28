<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();

$cod = $_GET['cod'];
sql_truncate('b2020_'.$cod);

$xml = simplexml_load_file('xml/'.$cod.'.xml');
foreach( $xml->Document[0]->Folder[0] as $area ){

    if( $area->getName() == 'Placemark' ){
        $placemark = [];

        // id
        $description = $area->description;

        $doc = new DOMDocument();
        $doc->loadHTML($description);

        $tags = $doc->getElementsByTagName('td');

        $desc_arr = [];
        foreach ($tags as $tag) {
            array_push($desc_arr, $tag->nodeValue);
        }

        $placemark['id'] = null;
        for( $i=0; $i<count($desc_arr); $i++ ){
            if ( $desc_arr[$i] == 'cod' || $desc_arr[$i] == 'cod_cnuc' ) $placemark['id'] = $desc_arr[$i+1];
        } 

        // coords
        $placemark['coords'] = '';
        foreach( $area->MultiGeometry as $MultiGeometry ){
            foreach( $MultiGeometry->Polygon as $Polygon ){
                foreach( $Polygon->outerBoundaryIs->LinearRing->coordinates as $key => $value ){
                    $placemark['coords'] .= trim ($value);
                }
                $placemark['coords'] .= "|";
            }
        }

        // insert
        $valores = array(	array( "id", $placemark['id'] ),
                            array( "coords", $placemark['coords'] ));

        sql_insert( 'b2020_'.$cod, $valores);

        // print $placemark['id']."<br>";

    }
}

sql_clean('b2020_'.$cod, 'id', false);

print $cod.'s cadastradas com sucesso!';

?>
