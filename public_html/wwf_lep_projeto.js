window.onload = function (){  
	
	// VARS //
	
	var i,
		r,
		a,
		d,
		dur=100,
		tag,
		tag2,
		tag3,
		tag4,
		tag5,
		tag6,
		preloader,
		map,
		layer,
		leg,
		mapOptions,
		br,
		win_w,
		win_h,
		tema,
		session,
		projeto_id,
		get; 
	
	var projeto = document.getElementById('projeto');
	
	var root = location.origin;
	var path = location.pathname.split('/');
	
	for(i=0; i<path.length-1; i++){
		root += path[i] + '/';
	}
	
	console.log("_root: " + root);  
	
	get = location.href.split("?id=");
	
	if(get.length > 1){
		projeto_id = get[1];
	}else{
		document.location.href = "projetos.html";
	}
	
	 
				
	var conteudos = [
		'SOBRE O PROJETO',
		'DOCUMENTOS',
		'DADOS',
		'RESULTADOS'					
	]
	
	var temas = [
		'#cc6666','#ff6666','#ff9966','#ffcc66',
		'#cc9966','#cccc66','#66cc66','#99cc66',
		'#66cc99','#66cccc','#6699cc','#66ccff',
		'#99ccff','#6666cc','#9999ff','#9966cc',
		'#cc66cc','#cc99ff','#cc6699','#ff6699']; 

	// CORES // 
	
	function aplicar_tema(){
		$('.resultados_lista li').hover(function(){
			$( this ).css({backgroundColor:temas[tema]})
		},function(){
			$( this ).css({backgroundColor:''})
		}); 
		$('.mapa_bt').hover(function(){
			$( this ).css({backgroundColor:temas[tema]})
		},function(){
			$( this ).css({backgroundColor:''})
		});  
		$('.conteudo_bt').hover(function(){
			$( this ).css({backgroundColor:temas[tema]})
		},function(){
			$( this ).css({backgroundColor:''})
		});  
	}
	   
	
	// DADOS PROJETO //
	
	var myRequest;	
	var xml_projeto;	
	var projeto_arr = [];
	
	if(window.XMLHttpRequest){
		myRequest = new XMLHttpRequest();
	}else if(window.ActiveXObject){ 
		myRequest = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	myRequest.onreadystatechange = function(){  
		if(this.readyState === 4){ 
			xml_projeto = this.responseXML;  
			projeto_arr = xml2arr ( 
				xml_projeto, "dados",
					["id",
					"publicado",
					"titulo",
					"lat",
					"lng",
					 "zoom",
					 "sobre",
					["resultados", "resultado", ["label","titulo","id","titulo_legenda","legenda"]],
					["arquivos", "arquivo", ["id","titulo","grupo","label"]],
					["repositorios", "repositorio", ["id","arquivo","nome","ext","tipo","bites"]]
					]);
			 
			// dados
			
			session = sessionStorage.getItem("session"); 
			tema = sessionStorage.getItem("tema");
			
			if( !tema || !session ){ 
				
				session = Math.random() * 1000;
				tema = 0;
				
				sessionStorage.setItem("tema", tema ); 
				sessionStorage.setItem("session", session);
			}   
			
			var resultados; 
			var map;

			d = projeto_arr["dados"]; 
			  
			tag = document.createElement('div');
			tag.id = 'projeto' + d.id;
			tag.className = 'tela_projeto';
			
			// map

			mapOptions = {
				center: new google.maps.LatLng(d.lat,d.lng), 
				zoom: Number(d.zoom),
				mapTypeId: google.maps.MapTypeId.SATELLITE,
				panControl: false,
				mapTypeControl: false,
				streetViewControl: false,
				scrollwheel: true,
				scaleControl: true, 
				overviewMapControl: false,
				rotateControl: false, 
				backgroundColor: '#fff',
				scrollwheel: true,
				zoomControl: false
			};

			map = new google.maps.Map(tag, mapOptions);   

			tag2 = document.createElement('div');
			tag2.className = 'projeto_bts';
			tag.appendChild(tag2); 

			google.maps.event.addListener(map, 'dragstart', function() { 
				fechar_lista(this);
				fechar_legenda(this);
				fechar_telas(this);
			}); 

			tag3 = document.createElement('div');
			tag3.id = 'zoom_in';
			tag3.className = 'mapa_bt zoom_in';
			tag3.map = map;
			tag3.onclick = function(){
				this.map.setZoom(this.map.getZoom() + 1);
			}
			tag2.appendChild(tag3);

			tag3 = document.createElement('div');
			tag3.id = 'zoom_out';
			tag3.className = 'mapa_bt zoom_out';
			tag3.map = map;
			tag3.onclick = function(){
				if(this.map.getZoom() > 3) this.map.setZoom(this.map.getZoom() - 1);
			}
			tag2.appendChild(tag3);

			//titulo

			tag3 = document.createElement('div');
			tag3.className = 'titulo voltar wwf mapa_bt';  
			tag3.id = 'titulo';
			tag3.innerHTML = d.titulo;
			tag2.appendChild(tag3);

			tag3.onclick = function(){
				document.location.href = "projetos.html" ;
			}

			br = document.createElement('br');
			tag2.appendChild(br);

			//resultados

			if(d.resultados.length > 0){ 
				tag3 = document.createElement('div');
				tag3.id = 'resultado' + d.id;
				tag3.className = 'resultados mapa_bt';
				tag3.innerHTML = d.resultados[0].titulo.toUpperCase();
				tag3.map = map;
				map.bt_lista = tag3;
				tag2.appendChild(tag3); 

				tag3.onclick = function(){  
					if(this.map.lista.visible){ 
						fechar_lista(this.map);
					}else{ 
						abrir_lista(this.map);
					}
				}

				br = document.createElement('br');
				tag2.appendChild(br);

				tag4 = document.createElement('ul');
				tag4.id = 'resultados' + d.id;
				tag4.className = 'resultados_lista'; 
				map.lista = tag4;
				tag2.appendChild(tag4);

				$(tag4).hide();
				tag4.visible = false; 

				preloader = document.createElement('div');
				preloader.className = 'preloader';
				tag.appendChild(preloader);
				$(preloader).hide(); 

				map.resultados = []; 

				for(r=0; r<d.resultados.length; r++){ 
					tag5 = document.createElement('li');
					tag5.id = 'resultado' + d.resultados[r].id;
					tag5.ID = d.resultados[r].id;
					tag5.map = map; 
					tag5.titulo_legenda = d.resultados[r].titulo_legenda;
					tag5.legenda = d.resultados[r].legenda.split('|');  

					tag5.lb = d.resultados[r].titulo.toUpperCase();
					tag5.innerHTML = tag5.lb;
					tag5.className = 'mapa_bt'; 

					tag4.appendChild(tag5);
					map.resultados.push(tag5);
					tag5.onclick = function(){
						chamar_kmz(this);
					}

					layer = new google.maps.KmlLayer({ 
						suppressInfoWindows: true,
						preserveViewport: true,
						url:root + "projetos/projeto" + d.id + "/" + d.resultados[r].label + ".kmz?session=" + session
					});

					layer.preloader = preloader;  
					google.maps.event.addListener(layer, 'status_changed', function () { 
						$(this.preloader).stop(true).fadeOut(dur); 
					}); 

					tag5.layer = layer;

					br = document.createElement('br');
					tag4.appendChild(br);
				}  

				// legenda 

				tag3 = document.createElement('div');
				tag3.className = 'legenda mapa_bt';
				tag3.innerHTML = "LEGENDA"; 
				tag3.map = map;
				map.bt_legenda = tag3;
				tag2.appendChild(tag3); 

				tag4 = document.createElement('ul');
				tag4.className = 'legenda_tx scroll2';  
				map.legenda = tag4;
				tag2.appendChild(tag4);  

				$(tag4).hide(); 
				tag4.visible = false;

				tag3.onclick = function(){
					if(this.map.legenda.visible){
						fechar_legenda(this.map);
					}else{
						abrir_legenda(this.map);
					}
				}  
				
				// conteudo
				
				tag3 = document.createElement('div');
				tag3.id = 'conteudo';
				tag2.appendChild(tag3);  
				
				tag5 = document.createElement('div');
				tag5.id = 'conteudo_telas';
				tag5.visible = true;
				map.telas = tag5;
				tag2.appendChild(tag5);
				
				for(a=0; a<4; a++){
					tag4 = document.createElement('div');
					tag4.className = 'conteudo_bt';
					tag4.innerHTML = conteudos[a];
					tag3.appendChild(tag4);   
					
					if(a==0) tag4.className += ' select';
					
					tag4 = document.createElement('div');
					tag4.className = 'conteudo_tela';
					tag4.innerHTML = '<p>Lorem ipsum dolor sit amet risus vitae mattis sed felis potenti augue. Dui integer nulla. Libero et phasellus. Amet libero pede. Lectus donec ad ac duis sapien. Etiam erat ut et inceptos suscipit eros scelerisque suscipit. Aliquam habitasse at. Tristique euismod purus mollis vitae ipsum. Penatibus non ligula tortor nonummy et ut pede in. Aliquam ipsum lacus at arcu cubilia. Litora eget id. Voluptatem enim eu. Integer sodales vitae. Phasellus aenean odio et ullamcorper ligula sed sit potenti orci tellus fermentum recusandae nunc et eget curabitur cursus blandit nec quis suspendisse morbi leo wisi urna nonummy. Nunc convallis malesuada. Ante neque orci. Aliquam faucibus suscipit. Lobortis aptent platea. Pretium sem cursus ultricies et ut. Eros at mattis ante posuere sed. Id tellus cursus viverra vestibulum elementum lacus fermentum dolor ultrices a id. Duis scelerisque molestie. Vestibulum at pellentesque. Aliquam et purus auctor eget eros. Nisl integer turpis habitant habitant amet eget facilisis eros. Nunc sunt tortor. Aenean ipsum erat tristique in vitae. Arcu ac suspendisse. Mauris mauris turpis faucibus et magna hymenaeos eget eget. Eu vehicula semper quam nunc amet.</p><p>Nullam ligula pellentesque. Semper enim maecenas orci vel molestie porta felis consectetuer id lobortis class. Eget integer faucibus rerum aliquam quisque. Nulla nisl mattis ipsum et vestibulum. Donec et nunc dolore nibh tellus. Arcu sodales luctus. Tincidunt tristique id aliquam dapibus pede. Dolor lacinia accumsan placerat urna et. Lorem suspendisse in tortor est egestas. Reprehenderit pellentesque mauris commodo eget ut. Cras ullamcorper quis. Libero felis tempor velit et rhoncus. Con aliquam suspendisse in adipisicing duis vestibulum aenean morbi turpis ante justo. Nec praesentium dolor condimentum aliquam justo. Porttitor ullamcorper odio.</p><p>Pretium consectetuer a. Tincidunt ultrices diam. Etiam maecenas neque in vehicula non. Dictumst blandit pharetra metus sed donec neque dictum felis imperdiet ligula aliquam pellentesque libero nisl. Nullam convallis sit.</p><p>Lorem ipsum dolor sit amet risus vitae mattis sed felis potenti augue. Dui integer nulla. Libero et phasellus. Amet libero pede. Lectus donec ad ac duis sapien. Etiam erat ut et inceptos suscipit eros scelerisque suscipit. Aliquam habitasse at. Tristique euismod purus mollis vitae ipsum. Penatibus non ligula tortor nonummy et ut pede in. Aliquam ipsum lacus at arcu cubilia. Litora eget id. Voluptatem enim eu. Integer sodales vitae. Phasellus aenean odio et ullamcorper ligula sed sit potenti orci tellus fermentum recusandae nunc et eget curabitur cursus blandit nec quis suspendisse morbi leo wisi urna nonummy. Nunc convallis malesuada. Ante neque orci. Aliquam faucibus suscipit. Lobortis aptent platea. Pretium sem cursus ultricies et ut. Eros at mattis ante posuere sed. Id tellus cursus viverra vestibulum elementum lacus fermentum dolor ultrices a id. Duis scelerisque molestie. Vestibulum at pellentesque. Aliquam et purus auctor eget eros. Nisl integer turpis habitant habitant amet eget facilisis eros. Nunc sunt tortor. Aenean ipsum erat tristique in vitae. Arcu ac suspendisse. Mauris mauris turpis faucibus et magna hymenaeos eget eget. Eu vehicula semper quam nunc amet.</p><p>Nullam ligula pellentesque. Semper enim maecenas orci vel molestie porta felis consectetuer id lobortis class. Eget integer faucibus rerum aliquam quisque. Nulla nisl mattis ipsum et vestibulum. Donec et nunc dolore nibh tellus. Arcu sodales luctus. Tincidunt tristique id aliquam dapibus pede. Dolor lacinia accumsan placerat urna et. Lorem suspendisse in tortor est egestas. Reprehenderit pellentesque mauris commodo eget ut. Cras ullamcorper quis. Libero felis tempor velit et rhoncus. Con aliquam suspendisse in adipisicing duis vestibulum aenean morbi turpis ante justo. Nec praesentium dolor condimentum aliquam justo. Porttitor ullamcorper odio.</p><p>Pretium consectetuer a. Tincidunt ultrices diam. Etiam maecenas neque in vehicula non. Dictumst blandit pharetra metus sed donec neque dictum felis imperdiet ligula aliquam pellentesque libero nisl. Nullam convallis sit.</p>';
					tag5.appendChild(tag4); 
					
					if(a>0) tag4.style.display = 'none'; 
				}  
				
				// iniciar
				
				projeto.appendChild(tag); 
				aplicar_tema();
				
				chamar_kmz(map.resultados[0]);
			}   
		}
	}
	
	function chamar_kmz(alvo){ 
		for(r=0; r<alvo.map.resultados.length; r++){ 
			d = alvo.map.resultados[r];
			if(d == alvo){   
				d.map.bt_lista.innerHTML = d.lb;
				d.className = "select";
				$(d.layer.preloader).fadeTo(dur,.75);	
				d.layer.setMap(d.map);
				
				d.map.legenda.innerHTML = "";

				tag = document.createElement('div');
				tag.className  = 'legenda_titulo';
				tag.innerHTML = d.titulo_legenda;
				d.map.legenda.appendChild(tag);

				for(a=0; a<d.legenda.length; a++){
					leg = d.legenda[a].split(',');
					tag = document.createElement('li');
					tag.innerHTML = leg[0];
					tag2 = document.createElement('span');
					tag2.style.backgroundColor = leg[1];
					tag.appendChild(tag2); 
					d.map.legenda.appendChild(tag);
				}

			}else{
				d.layer.setMap(null);
				d.className = "mapa_bt";
			}
		} 

		fechar_lista(alvo.map);
	} 
	 
	function abrir_lista(alvo){
		alvo.lista.visible = true; 
		$(alvo.lista).fadeIn(dur);
		$(alvo.bt_lista).css({backgroundImage:'url(_layout/icon_up2.png)'});
		if(alvo.legenda) fechar_legenda(alvo);
		if(alvo.telas) fechar_telas(alvo);
	}

	function fechar_lista(alvo){
		alvo.lista.visible = false; 
		$(alvo.lista).fadeOut(dur);
		$(alvo.bt_lista).css({backgroundImage:'url(_layout/icon_dw2.png)'});
	}
 	
	function abrir_telas(alvo){
		alvo.telas.visible = true; 
		$(alvo.telas).fadeIn(dur);
		if(alvo.legenda) fechar_legenda(alvo);
		if(alvo.lista) fechar_lista(alvo);
	}

	function fechar_telas(alvo){
		alvo.telas.visible = false;
		$(alvo.telas).fadeOut(dur);
	}
	
	function abrir_legenda(alvo){
		alvo.legenda.visible = true;
		$(alvo.legenda).fadeIn(dur);
		$(alvo.bt_legenda).css({backgroundImage:'url(_layout/icon_dw2.png)', color:'rgba(255,255,255,.3)'}); 
		alvo.legenda.scrollTop = 0;
		if(alvo.lista) fechar_lista(alvo);
		if(alvo.telas) fechar_telas(alvo);
	}

	function fechar_legenda(alvo){
		alvo.legenda.visible = false;
		$(alvo.legenda).fadeOut(dur);
		$(alvo.bt_legenda).css({backgroundImage:'url(_layout/icon_up2.png)', color:'#fff'}); 
	} 
	
	
	// window 
	
	window.onresize = resize;
	
	function resize(){ 
		win_w = $( window ).width();
		win_h = $( window ).height();  
	}  
	  
	resize();
	
	
	// XML //
	
	function xml2arr(_xml, obj_lb, atts){  
		var arr = [];
		var id = '';
		var _id = '';
		var obj;
		var join;
		var xml;
		var sub;
		
		xml = _xml.getElementsByTagName(obj_lb); 
		 
		for(var i=0; i<xml.length; i++){ 
			obj = {}; 
			if( obj_lb != 'dados' ) id = ponteiro_lista(xml,i,"id"); 
			for( var a=0; a<atts.length; a++ ){  
				
				if(isArray(atts[a])){ 
					sub = xml[i].getElementsByTagName(atts[a][1]); 
					obj[atts[a][0]]	= [];
					
					for(_i=0; _i<sub.length; _i++){ 
						join = {};	 
						for( var b=0; b<atts[a][2].length; b++ ){  // atts
							join[atts[a][2][b]] = ponteiro_lista(sub,_i,atts[a][2][b]);						
						}
						
						if( atts[a][1] != 'dados' ) _id = ponteiro_lista(sub,_i,"id");
						
						obj[atts[a][0]].push(join);
						obj[atts[a][0]][ atts[a][1] + _id ] = join;
					}
						
				}else{ 
					obj[atts[a]] = ponteiro_lista(xml,i,atts[a]); 
				} 
			}
			
			arr.push(obj);
			arr[obj_lb + id] = obj;
		}

		return arr;
		
	}

	// att
	function ponteiro_att(xml, ID, att){  
		if( xml[ID] ){
			return xml[ID].getAttribute(att); 
		}
	}

	// nodes
	function ponteiro_lista(xml,a,lb){ //  ponteiro que retorna conteúdo da tag com index [a] e tags internas do index [a][b]
		if(xml[a].getElementsByTagName(lb)[0]){ // se a tag estiver vazia, o firstChild = null da bug no retorno da proxima linha
			return xml[a].getElementsByTagName(lb)[0].firstChild.nodeValue;   
		}  
	}
	
	function isArray( obj ) {
		return toString.call(obj) === "[object Array]";
	}; 
	
	
	// load data
	myRequest.open("GET", "projetos/projeto"+ projeto_id +"/dados.xml?session="+session, true);
	myRequest.send(null);
	
}