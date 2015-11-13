<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();
sql_truncate('b2020_uc_coords');

$ucs = simplexml_load_file('xml/uc.xml');
foreach( $ucs->Document[0]->Folder[0] as $uc ){

    if( $uc->getName() == 'Placemark' ){
        $placemark = [];

        // id
        $description = $uc->description;

        $doc = new DOMDocument();
        $doc->loadHTML($description);

        $tags = $doc->getElementsByTagName('td');

        $desc_arr = [];
        foreach ($tags as $tag) {
            array_push($desc_arr, $tag->nodeValue);
        }

        $placemark['uc_id'] = null;

        for($i=0; $i<count($desc_arr); $i++){
            if ($desc_arr[$i] == 'FID') $placemark['uc_id'] = $desc_arr[$i+1];
        }


        // coords
        $placemark['coords'] = '';
        foreach( $uc->MultiGeometry as $MultiGeometry ){
            foreach( $MultiGeometry->Polygon as $Polygon ){
                foreach( $Polygon->outerBoundaryIs->LinearRing->coordinates as $key => $value ){
                    $placemark['coords'] .= trim ($value);
                }
                $placemark['coords'] .= "|";
            }
        }

        // insert
        $valores = array(	array("uc_id", $placemark['uc_id'] ),
                            array("coords", $placemark['coords'] )
						);

        sql_insert( 'b2020_uc_coords', $valores);

    }
}

sql_clean('b2020_uc_coords', 'uc_id', false);

print 'UCs cadastradas com sucesso!';

?>
