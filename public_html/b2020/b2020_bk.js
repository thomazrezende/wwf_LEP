// JavaScript Document
window.onload = function(){

	///////////////////////////////////////////////////////////////////////////////////////// VARS

	var i;
	var d;
	var a;
	var val;

	var branco = "#fff";
	var preto = "#333";
	var vermelho = "#c12b2b";
	var cinza = "#ccc";

 	var selecao = 'bacias';

	var min_zoom = 4;
	var max_zoom = 11;
	var zoom_at = 4;

	var lista_itens_h;
	var camadas;

	var itm;
	var olho;

	var dur = 300, // default duration for animations
		in_out = "easeInOutQuart",
		_out = "easeOutQuart",
		in_ = "easeInQuart";

	var map;

	var bacias;
	var bacia = {};
	var bacia_polygon;
	var macro_bacias;
	var meso_bacias;
	var micro_bacias;

	var map_types;
	var tipos;
	var map_ok = false;

	var xml;

	var dados_lbs = {
		bacia: 'Bacia',
		nome: 'nome',
		desm_2000: 'desmatamento 2000',
		desm_2005: 'desmatamento 2005',
		desm_2010: 'desmatamento 2010',
		desm_2012: 'desmatamento 2012',
		uhe_instaladas: 'usinas hidrelétircas: instaladas',
		uhe_planejadas: 'usinas hidrelétircas: planajedas',
		uhe_potenciais: 'usinas hidrelétircas: potencial',
		pch_instaladas: 'pch: instaladas',
		pch_planejadas: 'pch: planejadas',
		pch_potenciais: 'pch: potencial',
		min_potencial: 'mineiração: potencial',
		min_exploracao: 'mineiração: exploração',
		ucpi: 'unidades de conservação 1',
		ucus: 'unidades de conservação 2',
		ti: 'terras indígenas',
		ap: 'áreas prioritárias'
	}

	///////////////////////////////////////////////////////////////////////////////////////// OBJETOS

	function get(id){ return document.getElementById(id)}
	function reg(id){ window[id] = get(id) }

	reg('topo');
	reg('logout');
	reg('user_lb');

	reg('lista');
	reg('lista_cont');
	lista.aberto = false;
	reg('bt_lista');
	reg('painel_select');

	reg('lista_itens');
	lista_itens.aberto = false;

	reg('lista_camadas');
	reg('lista_bacias');
	reg('lista_areas');
	reg('lista_projetos');

	reg('dash');
	dash.aberto = false;
	reg('dash_topo');
	reg('dash_titulo');
	reg('dash_voltar');
	reg('dash_cont');

	reg('tipo');
	reg('zoom_in');
	reg('zoom_nivel');
	reg('zoom_out');

	reg('preloader');
	$(preloader).hide();

	reg('mapa');
	reg('bt_bacias');
	reg('bt_areas');
	reg('bt_nivel');
	reg('nivel_slider');

	/////////////////////////////////////////////////////////////////////////////////////////  FUNCOES

	// LISTA //

	$(bt_lista).on('click', function(){
		if(lista.aberto){
			fechar_lista();
		}else{
			abrir_lista();
		}
	})

	function abrir_lista(){
		lista.aberto = true;
		$(bt_lista).css({backgroundImage:'url(layout/fechar_lista.png)'})
		$(lista).animate({left:0}, dur, in_out);
	}

	function fechar_lista(){
		lista.aberto = false;
		$(bt_lista).css({backgroundImage:'url(layout/lista.png)'})
		$(lista).animate({left:-400}, dur, in_out);
		if(lista_itens.aberto) fechar_lista_itens();
	}

	$(painel_select).on('click', function(){
		if(lista_itens.aberto){
			fechar_lista_itens();
		}else{
			abrir_lista_itens();
		}
	});

	lista_itens_h = 140;

	function abrir_lista_itens(){
		lista_itens.aberto = true;
		painel_select.className = 'painel_topo aberto';
		$(lista_itens).show().animate({height:lista_itens_h}, dur, in_out);
		$(lista_cont).animate({bottom:-1*lista_itens_h}, dur, in_out);
	}

	function fechar_lista_itens(){
		lista_itens.aberto = false;
		$(lista_itens).animate({height:0}, dur, in_out, function(){
			painel_select.className = 'painel_topo';
			$(lista_itens).hide();
		});
		$(lista_cont).animate({bottom:0}, dur, in_out);
	}

	$(lista_cont).on('mouseenter',function(){
		if(lista_itens.aberto) fechar_lista_itens();
	});

	for( i=0; i<=3; i++ ){
		itm = get('lista_item' + i);
		itm.ID = i;
		itm.cont = get('painel_cont' + i);

		itm.onclick = function(){
			for( a=0; a<=3; a++ ){
				itm = get('lista_item' + a);
				if(itm == this){
					itm.className = 'lista_item selected';
					painel_select.innerHTML = itm.innerHTML;
					$(itm.cont).show();
				}else{
					itm.className = 'lista_item';
					$(itm.cont).hide();
				}
			}

			fechar_lista_itens();
		}
	}

	// BASE //

	$(bt_nivel).on('click',function(){
		if(selecao == 'bacias'){
			selecao = 'areas';
			$(bt_areas).animate({ opacity: 1}, dur, in_out);
			$(bt_bacias).animate({ opacity: .3}, dur, in_out);
			$(nivel_slider).animate({ left: 30}, dur, in_out);
		}else{
			selecao = 'bacias';
			$(bt_bacias).animate({ opacity: 1}, dur, in_out);
			$(bt_areas).animate({ opacity: .3}, dur, in_out);
			$(nivel_slider).animate({ left: 5}, dur, in_out);
		}
	})


	// DASBOARD //

	var bacia_polygon = new google.maps.Polyline;

	function abrir_dash( alvo, id ){

		dash.aberto = true;
		if(lista.aberto) fechar_lista();
		$(dash).animate({right:0}, dur, in_out);

		// dados

		if(alvo == 'bacia'){
			$.post(
				"php_tools/bacia.php?bacia_id=" + id,
					null,
					function( data ) {

						dash_titulo.innerHTML =  alvo + " " + id;

						if (data.tipo != "principal") {
							$(dash_voltar).show();
							$(dash_topo).css({ width:327 });
						}else{
							$(dash_voltar).hide();
							$(dash_topo).css({ width:'' });
						}

						// contorno
						bacia_polygon.setMap(null);

						bacia_polygon = new google.maps.Polygon({
							path: data.coords,
							fillColor: '#e69900',
    						strokeWeight: 0,
    						fillOpacity: 0.15,
							zIndex:1,
							clickable: false
						});
						bacia_polygon.setMap(map);

					},
				"json"
			);
		}
	}

	function fechar_dash(d){
		dash.aberto = false;
		$(dash).animate({right:-400}, dur, in_out);
		macro_bacias.setMap(null);
		meso_bacias.setMap(null);
		micro_bacias.setMap(null);
		bacia_polygon.setMap(null);
	}

	dash_topo.onclick = fechar_dash;

	// mobile //

	var mobile;

	var isMobile = {
		Android: function() {
			return navigator.userAgent.match(/Android/i);
		},
		BlackBerry: function() {
			return navigator.userAgent.match(/BlackBerry/i);
		},
		iOS: function() {
			return navigator.userAgent.match(/iPhone|iPad|iPod/i);
		},
		Opera: function() {
			return navigator.userAgent.match(/Opera Mini/i);
		},
		Windows: function() {
			return navigator.userAgent.match(/IEMobile/i);
		},
		any: function() {
			return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
		}
	};

	if( isMobile.any() ){
		mobile = true;
		bt_event = 'touchstart';
	}else{
		mobile = false;
		bt_event = 'click';
	}

	console.log( "MOBILE: " + mobile );

	// window funcs

	function map_size(){
		google.maps.event.trigger( map, 'resize' );
		map.setZoom( map.getZoom() - 1 );
		map.setZoom( map.getZoom() + 1 );
	}

	function resize(){
		win_w = $( window ).width();
		win_h = $( window ).height();
		if(map_ok) map_size();
	}

	resize();
	window.onresize = resize;


	// bts funcs


	function decimal(num,casas,sep){ // sep define o tipo de separação . ou ,
		var nCasas = 1;
		for(var n=1;n<=casas;n++) {
			nCasas *= 10;
		}
		var valor = Math.round(num*nCasas)/nCasas;
		return decimalSep(valor,sep);
	}

	function decimalSep(num,sep){
		var numSt = num.toString();
		var indice = numSt.indexOf(".");
		if(indice != -1){
			var nDecimal = numSt.slice(indice+1,numSt.length);
			if(nDecimal == 0){
				numSt.slice(0, indice);
			}else{
				return numSt.slice(0, indice)+sep+numSt.slice(indice+1,numSt.length);
			}
		}else{
			return num;
		}
	}

	function duas_casas(n){
		if(n<10) return '0' + n;
		else return n;
	}

	function ordenar(alvo,criterio1,criterio2){
		alvo.sort(function (a, b) {
			if (a[criterio1] < b[criterio1])
			  return 1;
			if (a[criterio1] > b[criterio1])
			  return -1;
			if(a[criterio1] == b[criterio1]){
				if(criterio2 != null){
					if (a[criterio2] > b[criterio2])
					  return 1;
					if (a[criterio2] < b[criterio2])
				  return -1;
				}
				return 0;
			}
		});
	}


	///////////////////////////////////////////////////////////////////////////////////////// LOADDATA

	var xml_bacias;
	var xml_areas;
	var xml_projetos;

	function loadData(){

		xml_bacias = $(xml).find('bacias').children();
		xml_areas = $(xml).find('areas').children();;
		xml_projetos = $(xml).find('projetos').children();

		// bacias
		$(xml_bacias).each(function(i,d){

			itm = document.createElement('li');
			itm.ID = i;
			itm.className = 'cont_item';
			itm.innerHTML = $(d).attr('nome');

			itm.nome = $(d).attr('nome');
			itm.id = $(d).attr('id');

			// mais dados

			itm.onclick = function(){
				 abrir_dash( 'bacia', this.id);
			}

			lista_bacias.appendChild(itm);

		});

		// areas
		$(xml_areas).each(function(i,d){

			itm = document.createElement('li');
			itm.ID = i;
			itm.className = 'cont_item';
			itm.innerHTML = $(d).attr('nome');

			itm.nome = $(d).attr('nome');
			itm.id = $(d).attr('id');
			// mais dados

			itm.onclick = function(){
				abrir_dash('area', this.id);
			}

			lista_areas.appendChild(itm);

		});

		// projetos

		$(xml_projetos).each(function(i,d){

			itm = document.createElement('li');
			itm.ID = i;
			itm.className = 'cont_item';
			itm.innerHTML = $(d).attr('nome');

			itm.nome = $(d).attr('nome');
			itm.id = $(d).attr('id');

			// mais dados
			itm.onclick = function(){
				abrir_dash('projeto', this.id);
			}

			lista_projetos.appendChild(itm);

		});

		// map
		loadMap();

	}	// fim loadData

	///////////////////////////////////////////////////////////////////////////////////////// LOADMAP

	function loadMap(){

		centro_ini = new google.maps.LatLng( -15.15, -51.98 );
		centro_at = new google.maps.LatLng( -15.15, -51.98 );

		var mapOptions = {
			center: centro_at,
			zoom: 4,
			mapTypeId: google.maps.MapTypeId.SATELLITE,
			panControl:false,
			mapTypeControl:false,
			streetViewControl:false,
			scaleControl: true,
			overviewMapControl:false,
			rotateControl:false,
			zoomControl:false,
			scaleControlOptions: {
				position: google.maps.ControlPosition.BOTTOM_LEFT
			}
		};

		// camdas //

		camadas = [
			{ lb:'BACIAS HIDROGR&Aacute;FICAS', camada:null, ativo:false },
			{ lb:'&Aacute;REAS PRIORIT&Aacute;RIAS DE CONSERVA&Ccedil;&Atilde;O', camada:null, ativo:true },
			{ lb:'RIOS', camada:null, ativo:true },
			{ lb:'ESTRADAS', camada:null, ativo:true },
			{ lb:'UNIDADES DE CONSERVA&Ccedil;&Atilde;O', camada:null, ativo:true },
			{ lb:'TERRAS IND&Iacute;GENAS', camada:null, ativo:true },
			{ lb:'CIDADES', camada:null, ativo:true },
			{ lb:'HIDREL&Eacute;TRICAS', camada:null, ativo:true }
		];

		for( i in camadas ) {
			d = camadas[i];

			itm = document.createElement('li');
			itm.ID = i;
			itm.d = d;
			itm.className = 'cont_item camada cor'+i;
			if(!d.ativo) itm.className += ' off';
			itm.innerHTML = d.lb;

			itm.onclick = function(){
				if(this.d.ativo){
					this.d.ativo = false;
					this.className = 'cont_item camada off';
				}else{
					this.d.ativo = true;
					this.className = 'cont_item camada cor' + this.ID;
				}
			}

			olho = document.createElement('div');
			olho.className = 'olho';

			itm.appendChild(olho);
			lista_camadas.appendChild(itm);
		}

		map = new google.maps.Map( mapa, mapOptions );

		google.maps.event.addListener( map, 'dragstart', function() {
			// function onDrag
		});

		google.maps.event.addListener( map, 'dragend', function() {
			centro_at = map.getCenter();
		});

		google.maps.event.addListener(map,'zoom_changed', function (){
			zoom_at = map.getZoom();
			$(zoom_nivel).html( duas_casas(zoom_at-3));
		});

		map_ok = true;


		// KMZ //

		function get_info(inf){
			var arr_info = inf.split( /<tr>|<td>|<\/tr>|<\/td>/ );
			var ret = {};
			for( var i=0; i<arr_info.length; i++ ){
				if( arr_info[i].toUpperCase() === 'BACIA' ) ret.bacia_id = Number(arr_info[i+2]);
				if( arr_info[i].toUpperCase() === 'PRINCIPAL' ) ret.principal = arr_info[i+2];
				if( arr_info[i].toUpperCase() === 'MACRO' ) ret.macro_id = Number(arr_info[i+2]);
				if( arr_info[i].toUpperCase() === 'MESO' ) ret.meso_id = Number(arr_info[i+2]);
				if( arr_info[i].toUpperCase() === 'MICRO' ) ret.micro_id = Number(arr_info[i+2]);
			}

			return ret;
		}

		//BACIA

		bacias = new google.maps.KmlLayer({
			// suppressInfoWindows: true,
			preserveViewport: true,
			zIndex:3,
			url: 'http://www.thomazrezende.com/arquivo/b2020/bacias4/principais.kmz',
			map: map
		});

		$(preloader).fadeTo(dur,.75);
			google.maps.event.addListener(bacias, 'status_changed', function () {
			$(preloader).stop(true).fadeOut(dur);
		});

		google.maps.event.addListener(bacias, 'click', function(kmlEvent) {
			$(preloader).fadeTo(dur,.75);
			var info = get_info(kmlEvent.featureData.infoWindowHtml);
			macro_bacias.setUrl('http://www.thomazrezende.com/arquivo/b2020/bacias4/' + info.principal + '.kmz')
			macro_bacias.setMap(map);
			meso_bacias.setMap(null);
			micro_bacias.setMap(null);

			// dash
			console.log('----');
			console.log('PRINCIPAL');
			console.log(kmlEvent.featureData.infoWindowHtml);
			console.log(info);
			console.log('----');

			abrir_dash('bacia', info.bacia_id);
		});


		//MACRO
		macro_bacias = new google.maps.KmlLayer({
			// suppressInfoWindows: true,
			preserveViewport: true,
			zIndex:4
		});

		google.maps.event.addListener(macro_bacias, 'status_changed', function () {
			$(preloader).stop(true).fadeOut(dur);
		});

		google.maps.event.addListener(macro_bacias, 'click', function(kmlEvent) {
			$(preloader).fadeTo(dur,.75);
			var info = get_info(kmlEvent.featureData.infoWindowHtml);
			meso_bacias.setUrl('http://www.thomazrezende.com/arquivo/b2020/bacias4/' + info.principal + '_' + info.macro_id + '.kmz');
			meso_bacias.setMap(map);
			micro_bacias.setMap(null);

			// dash
			console.log('----');
			console.log('MACRO');
			console.log(kmlEvent.featureData.infoWindowHtml);
			console.log(info);
			console.log('----');
			abrir_dash('bacia', info.macro_id);
		});


		//MESO
		meso_bacias = new google.maps.KmlLayer({
			// suppressInfoWindows: true,
			preserveViewport: true,
			zIndex:5
		});

		google.maps.event.addListener(meso_bacias, 'status_changed', function () {
			$(preloader).stop(true).fadeOut(dur);
		});

		google.maps.event.addListener(meso_bacias, 'click', function(kmlEvent) {
			$(preloader).fadeTo(dur,.75);
			var info = get_info(kmlEvent.featureData.infoWindowHtml);
			micro_bacias.setUrl('http://www.thomazrezende.com/arquivo/b2020/bacias4/' + info.principal + '_' + info.meso_id + '.kmz')
			micro_bacias.setMap(map);

			// dash
			console.log('----');
			console.log('MESO');
			console.log(kmlEvent.featureData.infoWindowHtml);
			console.log(info);
			console.log('----');
			abrir_dash('bacia', info.meso_id);
		});

		//MICRO

		micro_bacias = new google.maps.KmlLayer({
			// suppressInfoWindows: true,
			preserveViewport: true,
			zIndex:6
		});

		google.maps.event.addListener(micro_bacias, 'status_changed', function () {
			$(preloader).stop(true).fadeOut(dur);
		});

		google.maps.event.addListener(micro_bacias, 'click', function(kmlEvent) {
			var info = get_info(kmlEvent.featureData.infoWindowHtml);

			// dash
			console.log('----');
			console.log('MICRO');
			console.log(kmlEvent.featureData.infoWindowHtml);
			console.log(info);
			console.log('----');
			abrir_dash('bacia', info.micro_id);
		});


		/*
		//BACIA 2

		var bacias = new google.maps.KmlLayer({
			// suppressInfoWindows: true,
			preserveViewport: true,
			zIndex:1,
			url: 'http://www.thomazrezende.com/arquivo/b2020/bacias3/bacias.kmz',
			map: map
		});

		$(preloader).fadeTo(dur,.75);
			google.maps.event.addListener(bacias, 'status_changed', function () {
			$(preloader).stop(true).fadeOut(dur);
		});

		var ref;
		var bacia_id;

		google.maps.event.addListener(bacias, 'click', function(kmlEvent) {
			var info = get_info(kmlEvent.featureData.infoWindowHtml);
			if( info.micro_id ){
				bacia_id = ref + '_' + info.micro_id;
			}else{
				if( info.meso_id  ){
					bacia_id = ref + '_' + info.meso_id;
				}else{
					if( info.macro_id ){
						bacia_id = ref + '_' + info.macro_id;
					}else{
						if( info.id >= 0 ) {
							ref = bacias_kmz[Number(info.id)];
							bacia_id = ref;
						}
					}
				}

				$(preloader).fadeTo(dur,.75);
				bacias.setUrl('http://www.thomazrezende.com/arquivo/b2020/bacias3/' + bacia_id + '.kmz');
			}

			// dash
			abrir_dash("BACIA ", bacia_id);
		});

		*/


		///////////////// tipo de mapa

		tipos = tipo.getElementsByTagName('li');
		map_types = [
			google.maps.MapTypeId.SATELLITE,
			google.maps.MapTypeId.HYBRID,
			google.maps.MapTypeId.TERRAIN,
			google.maps.MapTypeId.ROADMAP
		];

		for( i=0; i<tipos.length; i++) {
			tipos[i].tipo = i;
			tipos[i].onclick =  function(){
				map.setMapTypeId( map_types[this.tipo] );
				for(i in tipos ) {
					if(tipos[i] == this){
						tipos[i].className = 'bt_tipo selected';
					}else{
						tipos[i].className = 'bt_tipo ';
					}
				}
			}
		}

		///////////////// zoom

		zoom_at = map.getZoom();

		zoom_in.onclick = function(){
			if(zoom_at < max_zoom){
				map.setZoom(zoom_at+1);
			}
		}

		zoom_out.onclick = function(){
			if(zoom_at > min_zoom){
				map.setZoom(zoom_at-1);
			}
		}

		//////////////////// styles

		//map.setOptions({styles: styles});

		resize();

	} // fim loadMap


	// map styles

	var styles = [
	  {
		"featureType": "water",
		"stylers": [
		  { "color": "#31414b" }
		]
	  },{
		"featureType": "landscape",
		"stylers": [
		  { "color": "#333333" }
		]
	  },{
		"featureType": "poi",
		"stylers": [
		  { "color": "#333333" }
		]
	  },{
		"featureType": "road",
		"elementType": "geometry",
		"stylers": [
		  { "visibility": "simplified" },
		  { "color": "#444444" }
		]
	  },{
		"elementType": "labels",
		"stylers": [
		  { "visibility": "simplified" },
		  { "color": "#999999" }
		]
	  },{
		"elementType": "labels.icon",
		"stylers": [
		  { "visibility": "off" }
		]
	  },{
		"featureType": "transit",
		"stylers": [
		  { "visibility": "off" }
		]
	  }
	]

	//iniciar
	$.ajax({
		url: 'dados.xml',
		dataType: 'xml',
		success: function(data){
			xml = $(data);
			loadData()
		},
		error: function(data){
			console.log('Error loading XML data');
		}
	});

} // fim window.onload
