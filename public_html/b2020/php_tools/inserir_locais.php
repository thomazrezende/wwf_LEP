<?php

require_once('../../../_control/acesso.php');
require_once('../../../_control/seguranca.php');
require_once('../../cms_lep/_tr/mysql.php');

conectar();

$cod = $_GET['cod'];
sql_truncate('b2020_'.$cod);

$xml = simplexml_load_file('xml/'.$cod.'.xml');
foreach( $xml->Document[0]->Folder[0] as $local ){

    if( $local->getName() == 'Placemark' ){
        $placemark = [];

        // id
        $description = $local->description;

        $doc = new DOMDocument();
        $doc->loadHTML($description);

        $tags = $doc->getElementsByTagName('td');

        $desc_arr = [];
        foreach ($tags as $tag) {
            array_push($desc_arr, $tag->nodeValue);
        }

        $placemark['id'] = null;
        for( $i=0; $i<count($desc_arr); $i++ ){
            // atualizar com o ID final!!!
            if ( $desc_arr[$i] == 'FID' ) $placemark['id'] = $desc_arr[$i+1];
        }

        // coords
        $placemark['coords'] = $local->Point->coordinates;

        // insert
        $valores = array(	array( "id", $placemark['id'] ),
                            array( "coords", $placemark['coords'] ));

        sql_insert( 'b2020_'.$cod, $valores);

    }
}

sql_clean('b2020_'.$cod, 'id', false);

print $cod.'s cadastradas com sucesso!';

?>
