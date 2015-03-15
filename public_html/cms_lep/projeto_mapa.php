<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO ".$_SESSION["id"]); 
?> 

<body>
    
	<style type="text/css">
		
		#mapa_painel{
			width:100%;
			padding-bottom: 20px;
			background:#f1f1f1;
			border:#eee 1px solid;
			margin-top:30px;
			position:relative;
		}
		
		#map_legenda{
			width:200px;
			position:absolute;
			top:10px;
			left:10px;
			background-color:rgba(51,51,51,.8);
			z-index:3;
			display:none;
			color:#fff;
			padding:10px;
		}
		
		.legenda_titulo{
			font-size:12px;
			font-weight:bold;
			margin-bottom:10px;
			line-height:16px;
		}
		
		.legenda_cor{ 
			width:20px;
			height:20px;
			display: inline-block;
			margin-right:10px;
		}
		
		.legenda_lb{
			font-size:12px;
			position:relative;
			bottom:3px;
			width:150px;
			text-overflow:clip;
			white-space:nowrap;
			display: inline-block;
			overflow:hidden;
		}
		
		.mapa_lb{
			width:10%;
			text-align:right;
			float:left;
			color:#999;
			margin-top:7px;
			text-align:center;
			overflow:hidden;
		}	
		
		.input3{ 
			width:20%;
			padding:5px;
			border:#ddd 1px solid;
			font-size:12px;
			float: left;
		}
		
		.mapa{
			background:#f1f1f1;
			width:100%;
			height:400px;
			margin-bottom: 20px;
		}
		
		.mr0{margin-right:0;}
	
	</style>
	
	<?php menu($menu_arr, $lg_arr, "_layout/logo_admin.png", 2, true); ?>
	 
    <div id="cont">
      	<div id="dados">
			
			<?php
 
			//dados 
			$id = $_SESSION["id"];
			$titulo = $_SESSION["titulo"];
			
			//SQL
			$dados = sql_select("projetos","*","","id=".$id,false);   
			$resultados = sql_select("resultados","*","id DESC","id_projeto=".$id,true);   
			
			$resultados_arr = array();
			$legendas = "";
			$kmzs = "";
			for($r=0; $r<count($resultados); $r++){
				array_push( $resultados_arr, array( 	$r,
														$resultados[$r]['titulo']));
				
				// guarda dados de legendas para repassar ao js
				$legendas .= $resultados[$r]['titulo_legenda'] . "|" . $resultados[$r]['legenda'] . "|";  
				$kmzs .= $resultados[$r]['label'] . ".kmz,";			
				
			} 

			$kmzs .= $id; // guarda id_projeto para js
		
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." _ ".$titulo )); 
			
			submenu( $submenu_projeto, 5 );
			
			titulo( "", "CARREGAR RESULTADO", false );
			select( "resultados", "resultados", "", false, $resultados_arr, 0 );
			
			// dados legendas para js
			input("legendas", "", "legendas", $legendas , "hidden");   
			input("kmzs", "", "kmzs", $kmzs , "hidden"); 
			
			
			form1("altera", "", "php/projeto_mapa_altera.php", "post");
				
				div1("mapa_painel","","", false);
					
					div1( "map_legenda", "", "" , true );

					div1( "map_canvas", "mapa", "" , true );

					div1( "lat_lb", "mapa_lb", "LAT:", true );
					input("lat", "input3", "lat", $dados["lat"] , "text"); 

					div1( "lat_lb", "mapa_lb", "LNG:", true );
					input("lng", "input3", "lng", $dados["lng"] , "text"); 

					div1( "lat_lb", "mapa_lb", "ZOOM:", true );
					input("zoom", "input3 mr0", "zoom", $dados["zoom"] , "text"); 	

					clear();

				div2();
					
				submit("GRAVAR COORDENADAS"); 
						
			form2();
			

			?>
        
        </div> <!--dados-->  
    </div> <!--cont-->   
	
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.3&sensor=false"></script>
	<script type="text/javascript">
	
	window.onload = function(){

		var map_canvas = document.getElementById("map_canvas"); 
		var map;
		var lat = document.getElementById("lat");
		var lng = document.getElementById("lng");
		var zoom = document.getElementById("zoom");
		
		var centro_at;
		var zoom_at;
		
		var bd_lat = Number(lat.value);
		var bd_lng = Number(lng.value);
		var bd_zoom = Number(zoom.value);

		var mapOptions = {
			center: new google.maps.LatLng(bd_lat, bd_lng), 
			zoom: bd_zoom,
			mapTypeId: google.maps.MapTypeId.SATELLITE,
			panControl: false,
			mapTypeControl: true,
			streetViewControl: false,
			scrollwheel: true,
			scaleControl: true, 
			overviewMapControl: false,
			rotateControl: false, 
			backgroundColor: '#f1f1f1',
			zoomControl: true,
			zoomControlOptions: {
				position: google.maps.ControlPosition.RIGHT_CENTER
			},
			scaleControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			}
			
		};

		map = new google.maps.Map(map_canvas, mapOptions); 
		
		google.maps.event.addListener(map, 'drag', function() {  
			centro_at = map.getCenter();
			lat.value = centro_at.k;
			lng.value = centro_at.B;
		});

		google.maps.event.addListener(map,'zoom_changed', function ()  { 
			zoom_at = map.getZoom();
			zoom.value = zoom_at;
		});
		
		// kmzs
		
		var kmzs = document.getElementById('kmzs').value.split(','); 
		var layer;
		var layers = [];
		var id_projeto = kmzs[kmzs.length-1];
		
		for(var k=0; k<kmzs.length-1; k++){ 
			
			layer = new google.maps.KmlLayer({ 
				suppressInfoWindows: true,
				preserveViewport: true, 
				url: "../projetos/projeto" + id_projeto + "/" + kmzs[k],
				zIndex:1,
				map: map
			});   
			
			layers.push(layer);
						
		}
		
		// select
		
		var resultados = document.getElementById('resultados');
		var map_legenda = document.getElementById('map_legenda');
				
		var legendas = document.getElementById('legendas').value.split('||');  
		
		for(var i in legendas){
			legendas[i] = legendas[i].split('|');
			for(var a in legendas[i]){
				legendas[i][a] = legendas[i][a].split(',');
			}
		}
		
		resultados.onchange = function(){ 
			if( this.selectedIndex-1 > -1 ){
				$(map_legenda).show();
				fazer_legenda(legendas[this.selectedIndex-1]); 
				
				for(var i in layers){
					if(i==this.selectedIndex-1){
						layers[i].setMap(map);
						console.log(layers[i]);
					}else{						
						layers[i].setMap(null);
					}
				}
				
			}else{
				$(map_legenda).hide();
			}			
		}
		
		var tag;
		
		function fazer_legenda(arr){
			
			map_legenda.innerHTML = '';
			
			for(var i in arr){
				tag = document.createElement('div');
				if(i==0){
					tag.className = 'legenda_titulo';
					tag.innerHTML = arr[i];	
				}else{
					tag.innerHTML = "<span class='legenda_cor' style='background:" + arr[i][1] + "'></span>";
					tag.innerHTML += "<span class='legenda_lb'>" + arr[i][0] + "</span>";
				}
				
				map_legenda.appendChild(tag);
			}
		}		
	}
		
	</script>

</body>
</html>
