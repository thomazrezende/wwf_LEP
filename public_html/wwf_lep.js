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
		temp,
		page, 
		page_y,
		win_w,
		win_h,
		tema,
		session,
		banner_id,
		layout_home;
	
	var pages = [
		["PROJETOS","projetos.html"],
		["SOBRE","sobre.html"],
		["DOCUMENTOS","documentos.html"],
		["LINKS","links.html"]
	];
	
	var root = location.origin;
	var path = location.pathname.split('/');
	
	for(i=0; i<path.length-1; i++){
		root += path[i] + '/';
	} 
	
	console.log("_root: " + root); 
	
	
	// OBJETOS //
	
	var menu = document.getElementById('menu');
	var menu_bts = document.getElementById('menu_bts');
	 
	var banner = document.getElementById('banner');
	var banner_credito = document.getElementById('banner_credito');
	
	var email = document.getElementById('email'); 
	var fbook = document.getElementById('fbook'); 
	var twitter = document.getElementById('twitter'); 
	
	var f_email = document.getElementById('f_email'); 
	var f_fbook = document.getElementById('f_fbook'); 	
	var f_twitter = document.getElementById('f_twitter'); 
	
	var sobre_psc = document.getElementById('sobre_psc'); 
	var sobre_lep = document.getElementById('sobre_lep');  
	
	var busca_tx = document.getElementById('busca_tx');  
	var busca_x = document.getElementById('busca_x');  
	var buscar_em = document.getElementById('buscar_em');
	var busca_opts = document.getElementById('busca_opts');
	var lista = document.getElementById('lista');
	
	var links = document.getElementById('links');
	var banner = document.getElementById('banner');
	
	var projetos = document.getElementById('projetos'); 
	
	// temas
	var temas = [
		'#cc6666','#ff6666','#ff9966','#ffcc66',
		'#cc9966','#cccc66','#66cc66','#99cc66',
		'#66cc99','#66cccc','#6699cc','#66ccff',
		'#99ccff','#6666cc','#9999ff','#9966cc',
		'#cc66cc','#cc99ff','#cc6699','#ff6699'];
	
	// FUNCS //
	
	for(i=0; i<pages.length; i++){
		tag = document.createElement('li');
		tag.innerHTML = pages[i][0];
		tag.page = pages[i][1];
		tag.className = 'menu_bt';
		
		if(path[path.length-1] == tag.page){
			tag.className += ' select';
			page = i;
		}else{
			tag.onclick = function(){
				document.location.href = root + this.page; 
			}
		} 
		
		menu_bts.appendChild(tag);
	}
	
	// CORES // 
	
	function aplicar_tema(){
		
		// topo		
		$('#logo_lep_lb').css({color:temas[tema]}); 
		$('#banner_cor').css({background:temas[tema]}); 
		
		$('.contato_bt').hover(function(){
			$( this ).css({backgroundColor:temas[tema]})
		},function(){
			$( this ).css({backgroundColor:''})
		});   
		
		//menu
		$('.menu_bt').hover(function(){
			$( this ).css({color:temas[tema]})
		},function(){
			$( this ).css({color:''})
		}); 
		$('.menu_bt.select').css({color:temas[tema]}); 
  
		// projetos  
		if(page == 0){ 
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
		} 

		//sobre
		if(page == 1){ 
			$('#sobre a').css({color:temas[tema], textDecoration:"none"});
			$('#sobre a').hover(function(){
				$( this ).css({color:temas[tema], textDecoration:"underline"})
			},function(){
				$( this ).css({color:temas[tema], textDecoration:"none"})
			}); 
		} 
		
		// documentos
		if(page == 2){  
			$('#buscar_em').hover(function(){
				$( this ).css({backgroundColor:temas[tema]})
			},function(){
				$( this ).css({backgroundColor:''})
			});
			$('.bt_item').hover(function(){
				$( this ).css({backgroundColor:temas[tema]})
			},function(){
				$( this ).css({backgroundColor:''})
			});
			$('#busca_x').hover(function(){
				$( this ).css({backgroundColor:temas[tema]})
			},function(){
				$( this ).css({backgroundColor:''})
			});
			$('.busca_opt').hover(function(){
				$( this ).css({backgroundColor:temas[tema], color:'#fff'})
			},function(){
				$( this ).css({backgroundColor:'', color:''})
			});
		} 

		// links 
		if(page == 3){  
			$('#links a').hover(function(){
				$( this ).css({color:temas[tema]})
			},function(){
				$( this ).css({color:''})
			});
		}
		
		// footer  
		$('footer a').hover(function(){
			$( this ).css({color:temas[tema]})
		},function(){
			$( this ).css({color:''})
		});
		
	}
	 
	// BANNERS //
	
	var myRequest1;	
	var xml_banners;	
	var banners_arr = [];

	if(window.XMLHttpRequest){ 
		myRequest1 = new XMLHttpRequest();
	}else if(window.ActiveXObject){ 
		myRequest1 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	myRequest1.onreadystatechange = function(){  
		if(this.readyState === 4){ 
			xml_banners = this.responseXML;    
			banners_arr = xml2arr ( 
				xml_banners, "banner", 
					["id",
					 "tema",
					 "credito"]); 
			
			tema = sessionStorage.getItem("tema");
			banner_id = sessionStorage.getItem("banner_id");
			session = sessionStorage.getItem("session"); 
			
			if( !tema || !session || !banner_id ){ 
				
				session = Math.random() * 1000;  
				banner_id = Math.floor( Math.random() * banners_arr.length ); 
				
				d = banners_arr[banner_id];
				
				sessionStorage.setItem("tema", d.tema);
				sessionStorage.setItem("banner_id", banner_id);
				sessionStorage.setItem("session", session);
			}  
			
			d = banners_arr[banner_id]; 
			
			console.log(banners_arr[banner_id]);
			
			if(d.credito != ''){
				$(banner_credito).html('foto: ' + d.credito);
			}else{
				$(banner_credito).hide();
			}
			
			banner.style.backgroundImage = 'url(banners/banner' + d.id + '.jpg)';
			
			console.log("tema:" + tema);
			
			// 2.dados

			myRequest2.open("GET", "xml/dados.xml?session="+session, true);
			myRequest2.send(null);  
			 
		}
	} 
	
	// 1.banners
	 
	myRequest1.open("GET", "xml/banners.xml?session="+session, true);
	myRequest1.send(null); 
	
	// DADOS //
	
	var myRequest2;	
	var xml_dados;	
	var dados_arr = [];

	if(window.XMLHttpRequest){ 
		myRequest2 = new XMLHttpRequest();
	}else if(window.ActiveXObject){ 
		myRequest2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	myRequest2.onreadystatechange = function(){  
		if(this.readyState === 4){ 
			xml_dados = this.responseXML; 
			dados_arr = xml2arr ( 
				xml_dados, "dados",
					["email",
					 "links",
					 "sobre_lep",
					 "sobre_psc",
					 "fbook",
					 "twitter",
					 "layout_home"
					]);
			
			// contato
			
			d = dados_arr['dados']; 
			
			email.onclick = function(){ 
				document.location.href = 'mailto:' + d.email;
			}
			
			fbook.onclick = function(){ 
				window.open(d.fbook);
			} 
			
			twitter.onclick = function(){ 
				window.open(d.twitter);
			}
			
			f_email.href = 'mailto:' + d.email;
			f_fbook.href = d.fbook;
			f_twitter.href = d.twitter; 
			 
			// sobre  
			if(page == 1){ 
				$(sobre_lep).html(d.sobre_lep);
				$(sobre_psc).html(d.sobre_psc);  
			}
			
			// links 
			if(page == 3){  
				$(links).html(d.links);  
			}	
			
			// 3.PROJETOS 
			myRequest3.open("GET", "xml/projetos.xml?session="+session, true);
			myRequest3.send(null);
			
		}
	}  
	
	// PROJETOS //
	
	var myRequest3;	
	var xml_projetos;	
	var projetos_arr = [];
	
	if(window.XMLHttpRequest){
		myRequest3 = new XMLHttpRequest();
	}else if(window.ActiveXObject){ 
		myRequest3 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	myRequest3.onreadystatechange = function(){  
		if(this.readyState === 4){ 
			xml_projetos = this.responseXML;    
			projetos_arr = xml2arr ( 
				xml_projetos, "projeto", 
					["id",
					"publicado",
					"titulo",
					"lat",
					"lng",
					["resultados", "resultado", ["label","titulo","id","titulo_legenda","legenda"]],
					"zoom",
					"resumo"]);
			
			// projetos
			
			var projeto_id;
			var resultados; 
			
			if(page == 0){ 
				
				layout_home = dados_arr['dados'].layout_home.split(',');   
				
				var map;
				
				for(i=0; i<layout_home.length; i++){
					
					projeto_id = layout_home[i].split("item")[1];
					d = projetos_arr["projeto" + projeto_id];
										
					tag = document.createElement('li');
					tag.id = 'projeto' + projeto_id;
					tag.className = 'cel_projeto';  
					
					//map
					
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
						scrollwheel: false,
						zoomControl: false
					};
					
					map = new google.maps.Map(tag, mapOptions);   
					
					tag2 = document.createElement('div');
					tag2.className = 'projeto_bts';
					tag.appendChild(tag2); 
					
					google.maps.event.addListener(map, 'dragstart', function() { 
						fechar_lista(this);
						fechar_texto(this);
					}); 
					
					tag3 = document.createElement('div');
					tag3.id = 'zoom_in'+ projeto_id;
					tag3.className = 'mapa_bt zoom_in';
					tag3.map = map;
					tag3.onclick = function(){
						this.map.setZoom(this.map.getZoom() + 1);
					}
					tag2.appendChild(tag3);
					
					tag3 = document.createElement('div');
					tag3.id = 'zoom_out'+ projeto_id;
					tag3.className = 'mapa_bt zoom_out';
					tag3.map = map;
					tag3.onclick = function(){
						if(this.map.getZoom() > 3) this.map.setZoom(this.map.getZoom() - 1);
					}
					tag2.appendChild(tag3);
					
					//titulo
					
					tag3 = document.createElement('div');
					tag3.className = 'titulo wwf mapa_bt'; 
					tag3.ID = projeto_id;
					tag3.id = 'titulo' + projeto_id;
					tag3.innerHTML = d.titulo;
					tag2.appendChild(tag3);
					
					tag3.onclick = function(){
						document.location.href = "projeto.html?id=" + this.ID ;
					}
					
					br = document.createElement('br');
					tag2.appendChild(br);
					 
					//resultados
					
					if(d.resultados.length > 0){ 
						tag3 = document.createElement('div');
						tag3.id = 'resultado' + projeto_id;
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
						tag4.id = 'resultados' + projeto_id;
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
					}  
					
					//resumo
						
					tag3 = document.createElement('div');
					tag3.className = 'resumo mapa_bt'; 
					tag3.innerHTML = d.resumo; 
					tag3.map = map;
					map.bt_resumo = tag3;
					tag2.appendChild(tag3); 
					
					tag4 = document.createElement('div');
					tag4.className = 'resumo_tx scroll2'; 
					tag4.innerHTML = d.resumo;
					map.texto = tag4;
					tag2.appendChild(tag4); 
					
					$(tag4).hide(); 
					tag4.visible = false;
					
					tag3.onclick = function(){
						if(this.map.texto.visible){
							fechar_texto(this.map);
						}else{
							abrir_texto(this.map);
						}
					}
					
					projetos.appendChild(tag); 
					chamar_kmz(map.resultados[0]);
				} 
			}
			
			// 4.documentos 
			myRequest4.open("GET", "xml/documentos.xml?session="+session, true);
			myRequest4.send(null);
			
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
		if(alvo.texto) fechar_texto(alvo);
		if(alvo.legenda) fechar_legenda(alvo);
	}

	function fechar_lista(alvo){
		alvo.lista.visible = false; 
		$(alvo.lista).fadeOut(dur);
		$(alvo.bt_lista).css({backgroundImage:'url(_layout/icon_dw2.png)'});
	}

	function abrir_texto(alvo){
		alvo.texto.visible = true;
		$(alvo.texto).fadeIn(dur);
		$(alvo.bt_resumo).css({backgroundImage:'url(_layout/icon_dw2.png)', color:'rgba(255,255,255,.3)'}); 
		alvo.texto.scrollTop = 0;
		if(alvo.lista) fechar_lista(alvo);
		if(alvo.legenda) fechar_legenda(alvo);
	}

	function fechar_texto(alvo){
		alvo.texto.visible = false;
		$(alvo.texto).fadeOut(dur);
		$(alvo.bt_resumo).css({backgroundImage:'url(_layout/icon_up2.png)', color:'#fff'}); 
	} 
	
	function abrir_legenda(alvo){
		alvo.legenda.visible = true;
		$(alvo.legenda).fadeIn(dur);
		$(alvo.bt_legenda).css({backgroundImage:'url(_layout/icon_dw2.png)'}); 
		alvo.legenda.scrollTop = 0;
		if(alvo.lista) fechar_lista(alvo);
		if(alvo.texto) fechar_texto(alvo);
	}

	function fechar_legenda(alvo){
		alvo.legenda.visible = false;
		$(alvo.legenda).fadeOut(dur);
		$(alvo.bt_legenda).css({backgroundImage:'url(_layout/icon_up2.png)', color:'#fff'}); 
	} 
	
	// DOCUMENTOS // 
		
	var myRequest4;	
	var xml_documentos;	
	var documentos_arr = [];

	var lista_arr = [];

	if(window.XMLHttpRequest){ 
		myRequest4 = new XMLHttpRequest();
	}else if(window.ActiveXObject){ 
		myRequest4 = new ActiveXObject("Microsoft.XMLHTTP");
	}

	myRequest4.onreadystatechange = function(){  
		if(this.readyState === 4){ 
			xml_documentos = this.responseXML;    
			documentos_arr = xml2arr ( 
				xml_documentos, "documento", 
					["id",
					"publicado",
					"titulo",
					"autor",
					"ano",
					"veiculo",
					"link",
					"palavras_chave",
					 "arquivo"]);

			// lista 
			
			if(page == 2){

				for(i=0; i<documentos_arr.length; i++){

					d = documentos_arr[i];

					if(d.publicado == 1){ 

						tag = document.createElement('div');
						tag.className = 'item_lista';
						tag.id = 'item' + i;

						if(d.arquivo != ''){
							tag2 = document.createElement('div');
							tag2.className = 'bt_item item_downlaod';
							tag2.ID = d.id;
							tag2.arquivo = d.arquivo;
							tag2.onclick = function(){
								window.open(root + "documentos/documento" + this.ID + "/" + this.arquivo);
							}
							tag.appendChild(tag2);
						}

						if(d.link != ''){
							tag3 = document.createElement('div');
							tag3.className = 'bt_item item_link';
							tag3.link = d.link;
							tag3.onclick = function(){
								window.open( this.link );
							}
							tag.appendChild(tag3);
						}

						tag4 = document.createElement('span');
						tag4.className = 'item_lb'; 
						temp = d.titulo;
						temp += " &ndash; " + d.autor;
						temp += "<span class='sub_lb'> &bull; " + d.veiculo;
						temp += ", " + d.ano  + "</span>"; 
						tag4.innerHTML = temp;
						tag.appendChild(tag4);

						tag.titulo = d.titulo.toUpperCase();
						tag.autor = d.autor.toUpperCase();
						tag.veiculo = d.veiculo.toUpperCase();
						tag.palavras_chave = d.palavras_chave.toUpperCase();

						lista.appendChild(tag);
						d.item = tag;	
					} 
				} 
				
				// busca

				busca_tx.onfocus = function(){
					if(this.value == ''){
						this.placeholder = '';
					}
				}

				busca_tx.onblur = function(){
					if(this.value == ''){
						this.placeholder = 'PESQUISAR';
						$(busca_x).fadeOut(dur);
					}
				}

				busca_tx.onkeyup = function(){
					if(this.value == ''){
						$(busca_x).fadeOut(dur);
					}else{
						$(busca_x).fadeIn(dur);
					}
					filtrar();
				}

				busca_x.onclick = function(){
					busca_tx.value = '';
					busca_tx.placeholder = 'PESQUISAR';
					$(this).hide();
					filtrar();
				}

				function filtrar(){

					var t = busca_tx.value.toUpperCase();

					for(i in documentos_arr){

						d = documentos_arr[i].item; 
						if (t==''){
							$(d).show();
						}else{
							$(d).hide();
							if(( filtro == 0 || filtro == 1) && d.titulo.indexOf(t) >= 0 ){ 
								$(d).show();
							}
							if(( filtro == 0 || filtro == 2) && d.autor.indexOf(t) >= 0 ){ 
								$(d).show();
							} 
							if(( filtro == 0 || filtro == 3) && d.veiculo.indexOf(t) >= 0 ){ 
								$(d).show();
							} 
							if(( filtro == 0 || filtro == 4) && d.palavras_chave.indexOf(t) >= 0 ){ 
								$(d).show();
							} 
						}
					}
				}

				var filtro = 0; 

				buscar_em.onclick = function(){
					$(busca_opts).fadeIn(dur).css({top: -43 * filtro});
					tag = document.getElementById('opt' + filtro);
					$(tag).css({backgroundColor:temas[tema]})
				}

				$(busca_opts).mouseleave(function(){
					$(this).fadeOut(dur);
				})

				// opts

				var opts = [['TUDO','tudo'],
							['T&Iacute;TULO','titulo'],
							['AUTOR','autor'],
							['VE&Iacute;CULO','titulo'],
							['PALAVRAS-CHAVE','palavras_chave']
						   ];

				for(i=0; i<opts.length; i++){

					tag = document.createElement('li');
					tag.ID = i;
					tag.id = 'opt'+i;
					tag.lb = opts[i][1];
					tag.className = 'busca_opt';
					if(i==0) {
						tag.className += ' select';
					}
					tag.innerHTML = opts[i][0];

					tag.onclick = function(){
						filtro = this.ID;

						for(i=0; i<opts.length; i++){
							tag = document.getElementById('opt' + i);
							if(i == filtro){
								tag.className = 'busca_opt select';
							}else{
								tag.className = 'busca_opt';
							} 
						} 
						
						buscar_em.innerHTML = opts[this.ID][0];
						filtrar();
						$(busca_opts).fadeOut(dur);
					}

					busca_opts.appendChild(tag);

				} 
			} // if page == 2
			
			// .5 cores
			
			aplicar_tema();
			
		}
	}
	
	// window 
	
	window.onresize = resize;
	
	function resize(){ 
		win_w = $( window ).width();
		win_h = $( window ).height();  
	}  
	
	function verifica_scroll(){ 
		page_y = $(window).scrollTop(); 
	}  
	
	window.onscroll = verifica_scroll;
	resize();
	
	
	// XML //
	
	function xml2arr(_xml, obj_lb, atts){  
		var arr = [];
		var id = '';
		var _id = '';
		var obj;
		var join;
		var xml;
		var _xml;
		
		xml = _xml.getElementsByTagName(obj_lb); 
		
		for(var i=0; i<xml.length; i++){
			obj = {}; 
			if( obj_lb != 'dados' ) id = ponteiro_lista(xml,i,"id"); 
			for( var a=0; a<atts.length; a++ ){  
				
				if(isArray(atts[a])){
					//_xml = sub lista de itens. ex: projetos > projeto > arquivos > arquivo
					// estrutura abaixo evita que tag 'arquivo' fora da lista 'arquivos' entre no array
					_xml = xml[i].getElementsByTagName(atts[a][0])[0].getElementsByTagName(atts[a][1]); 
					obj[atts[a][0]]	= [];
					
					for(_i=0; _i<_xml.length; _i++){ 
						
						join = {};	 
						for( var b=0; b<atts[a][2].length; b++ ){  // atts
							join[atts[a][2][b]] = ponteiro_lista(_xml,_i,atts[a][2][b]);						
						}
						
						if( atts[a][1] != 'dados' ) _id = ponteiro_lista(_xml,_i,"id");
						
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
	
	
}