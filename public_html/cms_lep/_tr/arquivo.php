<?php 
/* TRCOM
 
ARQUIVOS V 1.0

*/ 

function replace_arq($label,$path_file,$tabela,$campo,$condicao){
	// path deve conter o nome do arquivo final
	
	$nome_arquivo = $_FILES[$label]["name"]; // nome do arquivo pra reescrever o ar (origem)
	$nome_temp = $_FILES[$label]["tmp_name"];
	$nome_tipo = $_FILES[$label]["type"];
	
	if (!empty($nome_arquivo)){
	
		if(file_exists($path_file)){ unlink($path_file); }
		
		$ok = copy($nome_temp, $path_file); 
	
		if($ok){
			if(!empty($tabela)){
				unlink($nome_temp);
				$sql=	"UPDATE ".$tabela." SET 
						".$campo." = '".$nome_arquivo."'";
				
				if(!empty($condicao)) $sql.= " WHERE ".$condicao.";"; 
				mysql_query($sql) or die(mysql_error());
			}
			return true;	
		}
	}else{
		return false;
	}
} 

function marca_dagua_fixo($marca,$label,$wmax,$hmax,$arqfim,$tipo){
	$nome_arquivo = $_FILES[$label]["name"]; // nome do arquivo pra reescrever o ar (origem)
	$nome_temp = $_FILES[$label]["tmp_name"];
	$nome_tipo = $_FILES[$label]["type"];
	
	if (!empty($nome_arquivo)){
	
		$watermark = imagecreatefromjpeg($marca);
		$watermark_width = imagesx($watermark);  
		$watermark_height = imagesy($watermark);
		
		$dest_x = 10;  
		$dest_y = 10;
	 
		//create imagem from uploaded file
		switch($nome_tipo){
			case "image/jpeg": $src = imagecreatefromjpeg($nome_temp); break;
			case "image/gif": $src = imagecreatefromgif($nome_temp); break;
			case "image/png": $src = imagecreatefrompng($nome_temp); break;
		}
				
		//capture original image sizes
		list($width,$height) = getimagesize($nome_temp);
		
		//create new truecolor placeholder
		$tmp = imagecreatetruecolor($wmax,$hmax);
		
		settype($prop,"float"); 
		$prop = $width/$height;		
		$maxprop = $wmax/$hmax;
		
		if($prop>$maxprop){ // se a proporao for maior que 300/200 > fixa a altura em 200 > recalcula a proporao da largura com altura de 200 > calcula bordas > crop no centro
			$hfim = $hmax;
			$wfim = ($width/$height)*$hmax;
		}else{
			$wfim = $wmax;
			$hfim = ($height/$width)*$wmax;
		}
		
		$wborda=($wfim-$wmax)/2; // calcula a sobra e divide por dois
		$hborda=($hfim-$hmax)/2;		
		
		imagecopyresampled($tmp,$src,-$wborda,-$hborda,0,0,$wfim,$hfim,$width,$height); // centraliza a amostra e gera ima nova
		imagecopymerge($tmp, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 100);
		
		// now write the resized image to disk.
		switch($tipo){
			case "gif": $ok = imagegif($tmp,$arqfim.".gif"); break;
			case "jpeg": $ok = imagejpeg($tmp,$arqfim.".jpg",95); break;
			case "png": $ok = imagepng($tmp,$arqfim.".png"); break;
			}
		
		if($ok){
			// limpa memoria	
			imagedestroy($src);
			imagedestroy($tmp);			
			//
			return true;
		}
		
	}else{
		return false;
	}
}

function negativo($src,$saida){ 
	$_src = imagecreatefromjpeg($src);
	imagefilter($_src, IMG_FILTER_NEGATE); 
	imagejpeg($_src,$saida);  
	imagedestroy($src);   
}

// tamanho fixo e cropando a imagem na medida maior
function up_img_fixo($label,$id,$wmax,$hmax,$arqfim,$tipo){ 
	//$id = -1 para arquivo unico
	
	if( $id >= 0 ){ // se vierem valores multiplos - $_files = multiple
		$nome_arquivo = $_FILES[$label]["name"][$id]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"][$id];
		$nome_tipo = $_FILES[$label]["type"][$id];
	}else{ // senao, usar o label 
		$nome_arquivo = $_FILES[$label]["name"]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"];
		$nome_tipo = $_FILES[$label]["type"];
	} 
		
	if (!empty($nome_arquivo)){ 
			//create imagem from uploaded file
			switch($nome_tipo){
				case "image/jpeg": $src = imagecreatefromjpeg($nome_temp); break;
				case "image/gif": $src = imagecreatefromgif($nome_temp); break;
				case "image/png": $src = imagecreatefrompng($nome_temp); break;
			}	
			
			//capture original image sizes
			list($width,$height) = getimagesize($nome_temp);
			
			//create new truecolor placeholder
			$tmp = imagecreatetruecolor($wmax,$hmax);
			
			settype($prop,"float"); //fraao
			$prop = $width/$height;		
			$maxprop = $wmax/$hmax;
			
			if($prop>$maxprop){ // se a proporao for maior que 300/200 > fixa a altura em 200 > recalcula a proporao da largura com altura de 200 > calcula bordas > crop no centro
				$hfim = $hmax;
				$wfim = ($width/$height)*$hmax;
			}else{
				$wfim = $wmax;
				$hfim = ($height/$width)*$wmax;
			}
			
			$wborda=($wfim-$wmax)/2; // calcula a sobra e divide por dois
			$hborda=($hfim-$hmax)/2;		
			
			imagecopyresampled($tmp,$src,-$wborda,-$hborda,0,0,$wfim,$hfim,$width,$height); // centraliza a amostra e gera ima nova
		
			// now write the resized image to disk.
			switch($tipo){
				case "gif": $ok = imagegif($tmp,$arqfim.".gif"); break;
				case "jpeg": $ok = imagejpeg($tmp,$arqfim.".jpg",95); break;
				case "png": $ok = imagepng($tmp,$arqfim.".png"); break;
				}
			
			if($ok){
				// limpa memoria	
				imagedestroy($src);
				imagedestroy($tmp);			
				//
				return true;
			}
			
		}else{
			return false;
		}
	}
	
	
//tam final fixo mostrando a img toda
function up_img_fixo_all($label,$id,$wmax,$hmax,$arqfim,$tipo,$rgbfundo){ //$TIPO: "gif","jpeg" ou "png" 
	
	if( $id >= 0 ){ // se vierem valores multiplos - $_files = multiple
		$nome_arquivo = $_FILES[$label]["name"][$id]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"][$id];
		$nome_tipo = $_FILES[$label]["type"][$id];
	}else{ // senao, usar o label 
		$nome_arquivo = $_FILES[$label]["name"]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"];
		$nome_tipo = $_FILES[$label]["type"];
	} 
	
	if (!empty($nome_arquivo)){
	
			//create imagem from uploaded file
			switch($nome_tipo){
				case "image/jpeg": $src = imagecreatefromjpeg($nome_temp); break;
				case "image/gif": $src = imagecreatefromgif($nome_temp); break;
				case "image/png": $src = imagecreatefrompng($nome_temp); break;
			}			
			
			//capture original image sizes
			list($width,$height) = getimagesize($nome_temp);
			
			//create new truecolor placeholder
			$tmp = imagecreatetruecolor($wmax,$hmax);
			
			//  background
			$fundo = imagecolorallocate($tmp, hexrgb($rgbfundo, r), hexrgb($rgbfundo, g), hexrgb($rgbfundo, b));
			imagefill($tmp, 0, 0, $fundo);	
			
			settype($prop,"float"); //fraÁao
			$prop = $width/$height;		
			$maxprop = $wmax/$hmax;
			
			if($prop<$maxprop){ // se a imagem for muito alta> fixa a altura em hmax > recalcula a proporÁao da largura com altura de hmax > calcula bordas > centraliza
				$hfim = $hmax;
				$wfim = ($width/$height)*$hmax;
			}else{
				$wfim = $wmax;
				$hfim = ($height/$width)*$wmax;
			}
			
			$wborda=($wmax-$wfim)/2; // calcula a sobra e divide por dois
			$hborda=($hmax-$hfim)/2;		
			
			imagecopyresampled($tmp,$src,$wborda,$hborda,0,0,$wfim,$hfim,$width,$height); // centraliza a amostra e gera ima nova
			
			// now write the resized image to disk.
			header('Content-type: image/'.$tipo);
			switch($tipo){
				case "gif": $ok = imagegif($tmp,$arqfim.".gif"); break;
				case "jpeg": $ok = imagejpeg($tmp,$arqfim.".jpg",95); break;
				case "png": $ok = imagepng($tmp,$arqfim.".png"); break;
				}
			
			if($ok){
				// limpa memoria	
				imagedestroy($src);
				imagedestroy($tmp);				
				return true;
			}
			
		}else{
			return false;
		}
	} 
	
	
// img var com uma medida fixa
function up_img_var($label, $id, $limite, $max, $arqfim, $tipo){ 	
	
	/*	
	$limite=medida que ser fixa("w" ou "h");
	$arqfim = path/nome do arquivo final;
	$id = -1: 1 imagem
	*/
		
	if( $id >= 0 ){ // se vierem valores multiplos - $_files = multiple
		$nome_arquivo = $_FILES[$label]["name"][$id]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"][$id];
		$nome_tipo = $_FILES[$label]["type"][$id];
	}else{ // senao, usar o label 
		$nome_arquivo = $_FILES[$label]["name"]; // nome do arquivo pra reescrever o ar (origem)
		$nome_temp = $_FILES[$label]["tmp_name"];
		$nome_tipo = $_FILES[$label]["type"];
	} 
	
	if (!empty($nome_arquivo)){		
			
			//create imagem from uploaded file
			switch($nome_tipo){
				case "image/jpeg": $src = imagecreatefromjpeg($nome_temp); break;
				case "image/gif": $src = imagecreatefromgif($nome_temp); break;
				case "image/png": $src = imagecreatefrompng($nome_temp); break;
			}	
			
			//capture original image sizes
			list($width,$height) = getimagesize($nome_temp);
		
		/////// IMG
			if($limite == "w"){
				if($width >= $max){
					$wfim_img = $max; // fixa largura e define altura proporcinal
					$hfim_img = ($height/$width)*$max;				
				}else{
					$wfim_img = $width; // mantem as medidas originais;
					$hfim_img = $height;				
				}

			}else{ // se for "h"
				if($height >= $max){
					$hfim_img = $max; // fixa altura e define largura proporcinal
					$wfim_img = ($width/$height)*$max;
				}else{
					$wfim_img = $width; // mantem as medidas originais;
					$hfim_img = $height;				
				}				
			}
		
			//create new truecolor placeholder
			$tmp_img = imagecreatetruecolor($wfim_img,$hfim_img);				
			imagecopyresampled($tmp_img,$src,0,0,0,0,$wfim_img,$hfim_img,$width,$height);
		
		
		/////// ARQUIVOS
		
			// escreve img 
			switch($tipo){
				case "gif": $ok_img = imagegif($tmp_img,$arqfim.".gif"); break;
				case "jpeg": $ok_img = imagejpeg($tmp_img,$arqfim.".jpg",95); break;
				case "png": $ok_img = imagepng($tmp_img,$arqfim.".png"); break;
				}
			
			if($ok_img){			
				
				// limpa memoria		
				imagedestroy($tmp_img);		
				imagedestroy($src);							
					 
				return true;
								
			}else{
				return false;
			}
		}
	}	 

function hexrgb($hexstr, $rgb) {
 $int = hexdec($hexstr);
 switch($rgb) {
        case "r":
        return 0xFF & $int >> 0x10;
            break;
        case "g":
        return 0xFF & ($int >> 0x8);
            break;
        case "b":
        return 0xFF & $int;
            break;
        default:
        return array(
            "r" => 0xFF & $int >> 0x10,
            "g" => 0xFF & ($int >> 0x8),
            "b" => 0xFF & $int
            );
            break;
    }   
}

//remove arquivo e mantem regsitro
function remove_arq($path, $arquivo, $tabela, $id, $label){

	if(isset($id)){ // isset pq vir via GET
		$sql="UPDATE ".$tabela." SET ".$label." = NULL WHERE id = ".$id." LIMIT 1;";								
		$ok=mysql_query($sql) or die(mysql_error());
		//
		if($ok){
			if(file_exists($path."/".$arquivo)){ unlink($path."/".$arquivo); }
			return true;	
		}
	}
}

//remove arquivo e regsitro
function remove_item($path, $item, $tabela, $id){

	if(isset($id)){ // isset pq vir via GET
		$sql="DELETE FROM ".$tabela." WHERE id = ".$id." LIMIT 1;";								
		$ok=mysql_query($sql) or die(mysql_error());
		//
		if($ok){
			if(!empty($item) && file_exists($path."/".$item)){ unlink($path."/".$item); }
			return true;	
		}
	}
}

//remove arquivo, regsitro e arquivos vinculados
function remove_itens($path, $itens, $tabela, $id){

	/* $path=caminho sem "/" no final
	$itens=array com nomes de arquivo.ext
	$tabela=tabela com registros dos itens
	$id=id dos itens
	
	uso: deletar vairos itens sob o mesmo registro. ex: imagem, tb e tbG na mesma pasta*/
 
	if(isset($id)){ // isset pq vir via GET
		$sql="DELETE FROM ".$tabela." WHERE id = ".$id." LIMIT 1;";								
		$ok=mysql_query($sql) or die(mysql_error());
		//
		if($ok){
			for($i=0;$i<count($itens);$i++){
				if(file_exists($path."/".$itens[$i])){ 
					unlink($path."/".$itens[$i]); 
				}
			}
			return true;			
		}
	}
}

// remove pasta com arquivos e regsitro
function remove_pasta($path, $tabela, $id, $tabelas_vinc, $lbs_vinc){ 
	/* //
	$tabelas_vinc = array com tabelas vinculadas;
	$lbs_vinc = array respectivos label de vinculo de id (tipo id_proj)
	// */
	if(isset($id)){ // isset pq vir via GET
		$sql="DELETE FROM ".$tabela." WHERE id = ".$id." LIMIT 1;";								
		$ok=mysql_query($sql) or die(mysql_error());
		//
		if($ok){				
			foreach(glob($path."/*") as $arquivo) {
				unlink($arquivo);
			}
			//
			if(isset($tabelas_vinc) && !empty($tabelas_vinc)){
				for($i=0; $i<count($tabelas_vinc); $i++){
					// se houver alguma tabela vinculada (ex: imagens na exclusao de proj)
					$sql_vinc="DELETE FROM ".$tabelas_vinc[$i]." WHERE ".$lbs_vinc[$i]." = ".$id.";";
					mysql_query($sql_vinc) or die(mysql_error());
				}
			}
			rmdir($path);
			return true;								
		}	
	}
} 

?>