<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms/_tr/mysql.php');

conectar();
sql_truncate('b2020_bh');

$arquivos_bacias = [
    'amz.xml',
    'atl.xml',
    'cap.xml',
    'gui.xml',
    'jag.xml',
    'mar.xml',
    'mea.xml',
    'ori.xml',
    'pac.xml',
    'par.xml',
    'pnb.xml',
    'sfr.xml',
    'toc.xml',
    'uru.xml'
];

foreach ( $arquivos_bacias as $arquivo) {
    $bacias = simplexml_load_file('xml/'.$arquivo);
    foreach( $bacias->Document[0]->Folder[0] as $bacia ){

        if( $bacia->getName() == 'Placemark' ){
            $placemark = [];

            // id
            $description = $bacia->description;

            $doc = new DOMDocument();
            $doc->loadHTML($description);

            $tags = $doc->getElementsByTagName('td');

            $desc_arr = [];
            foreach ($tags as $tag) {
                array_push($desc_arr, $tag->nodeValue);
            }

            $placemark['macro_id'] = null;
            $placemark['meso_id'] = null;
            $placemark['micro_id'] = null;

            for($i=0; $i<count($desc_arr); $i++){
                if ($desc_arr[$i] == 'Macro') $placemark['macro_id'] = $desc_arr[$i+1];
                if ($desc_arr[$i] == 'Meso') $placemark['meso_id'] = $desc_arr[$i+1];
                if ($desc_arr[$i] == 'Micro') $placemark['micro_id'] = $desc_arr[$i+1];
                if ($desc_arr[$i] == 'Bacia') $placemark['id'] = $desc_arr[$i+1]; // id
                if ($desc_arr[$i] == 'Princ') $placemark['principal_id'] = $desc_arr[$i+1]; // id
                if ($desc_arr[$i] == 'Principal') $placemark['principal'] = $desc_arr[$i+1]; // label
            }

            // tipo
            $placemark['tipo'] = 'principal';
            if($placemark['macro_id'] != 0 ) $placemark['tipo'] = 'macro';
            if($placemark['meso_id'] != 0) $placemark['tipo'] = 'meso';
            if($placemark['micro_id'] != 0) $placemark['tipo'] = 'micro';

            // coords
            $placemark['coords'] = '';
            foreach( $bacia->MultiGeometry as $MultiGeometry ){
                foreach( $MultiGeometry->Polygon as $Polygon ){
                    foreach( $Polygon->outerBoundaryIs->LinearRing->coordinates as $key => $value ){
                        $placemark['coords'] .= trim ($value);
                    }
                    $placemark['coords'] .= "|";
                }
            }

            // insert
            $valores = array(	array("tipo", $placemark['tipo'] ),
                                array("principal", $placemark['principal'] ),
                                array("principal_id", $placemark['principal_id'] ),
                                array("id", $placemark['id'] ),
                                array("macro_id", $placemark['macro_id'] ),
    							array("meso_id", $placemark['meso_id'] ),
                                array("micro_id", $placemark['micro_id'] ),
                                array("coords", $placemark['coords'] )
    						);

            sql_insert( 'b2020_bh', $valores);

        }
    }
}

sql_clean('b2020_bh', 'id', 'tipo');

print 'bacias cadastradas com sucesso!';

?>
