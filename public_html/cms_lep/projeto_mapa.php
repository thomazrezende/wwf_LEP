<?php
require_once("../../_control/acesso.php");
require_once("../../_control/seguranca.php");
require_once("_tr/mysql.php");
require_once("_tr/html.php"); 
require_once("_tr/string.php"); 
require_once("_menus.php");

verif_log(); 
conectar();

head("PROJETO - MAPA");
?> 

<body>
    
	<style type="text/css">
		
		#mapa_painel{
			width:100%;
			padding-top: 20px;
			background:#eee;
			border:#eee 1px solid;
			margin-top:30px;
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
			margin-top:20px;
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
			
			mensagem();	 
			navega(array(array("PROJETOS","projetos.php"), "PROJETO ".$id." - ".$dados["titulo"] )); 

			submenu( $submenu_projeto, 2 );
			
			form1("altera", "", "php/projeto_mapa_altera.php", "post");
				
				div1("mapa_painel","","", false);

					div1( "lat_lb", "mapa_lb", "LAT:", true );
					input("lat", "input3", "lat", $dados["lat"] , "text"); 

					div1( "lat_lb", "mapa_lb", "LNG:", true );
					input("lng", "input3", "lng", $dados["lng"] , "text"); 

					div1( "lat_lb", "mapa_lb", "ZOOM:", true );
					input("zoom", "input3 mr0", "zoom", $dados["zoom"] , "text"); 	

					clear();

					div1( "map_canvas", "mapa", "" , true );

				div2();
					
				submit("GRAVAR"); 
						
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
			zoomControl: true,
			scaleControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			}
		};

		map = new google.maps.Map(map_canvas, mapOptions); 
		
		google.maps.event.addListener(map, 'dragend', function() {  
			centro_at = map.getCenter();
			lat.value = centro_at.k;
			lng.value = centro_at.B;
		});

		google.maps.event.addListener(map,'zoom_changed', function ()  { 
			zoom_at = map.getZoom();
			zoom.value = zoom_at;
		});  
		
	}
		
	</script>

</body>
</html>
