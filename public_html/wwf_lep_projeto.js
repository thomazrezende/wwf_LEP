window.onload = function (){  
	
	// VARS //
	
	var i,
		r,
		a,
		b,
		d,
		dur=100,
		tag,
		tag2,
		tag3,
		tag4,
		tag5,
		tag6,
		lista,
		legenda,
		conteudo,
		bt_lista,
		bt_legenda,
		telas = [],
		preloader,
		map,
		resultados,
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
	var conteudo_telas;
	
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
	
	var conteudos = ['SOBRE','DOCUMENTOS','DADOS','RESULTADOS'];
	
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
		$('.bt_item').hover(function(){
			$( this ).css({backgroundColor:temas[tema]})
		},function(){
			$( this ).css({backgroundColor:''})
		});  
		$('.mapa_bt').hover(function(){
			if(this.className.indexOf('select') < 0){
				$( this ).css({backgroundColor:temas[tema]})
			}
		},function(){
			$( this ).css({backgroundColor:''})
		});  
		$('.conteudo_bt').hover(function(){
			if(this.className.indexOf('select') < 0){
				$( this ).css({backgroundColor:temas[tema]}) 
			}
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
					["documentos", "documento", ["id","publicado","titulo","autor","ano","veiculo","link","arquivo"]],
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
			 
			
			d = projeto_arr["dados"]; 
			d.path = root + "projetos/projeto" + d.id + "/";
			  
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
				fechar_lista();
				fechar_telas();
			}); 

			tag3 = document.createElement('div');
			tag3.id = 'zoom_in';
			tag3.className = 'mapa_bt zoom_in'; 
			tag3.onclick = function(){
				map.setZoom(map.getZoom() + 1);
			}
			tag2.appendChild(tag3);

			tag3 = document.createElement('div');
			tag3.id = 'zoom_out';
			tag3.className = 'mapa_bt zoom_out'; 
			tag3.onclick = function(){
				if(map.getZoom() > 3) map.setZoom(map.getZoom() - 1);
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
				bt_lista = document.createElement('div');
				bt_lista.id = 'resultado' + d.id;
				bt_lista.className = 'resultados mapa_bt';
				bt_lista.innerHTML = d.resultados[0].titulo.toUpperCase(); 
				tag2.appendChild(bt_lista); 

				bt_lista.onclick = function(){  
					if(lista.visible){ 
						fechar_lista();
					}else{ 
						abrir_lista();
					}
				}

				br = document.createElement('br');
				tag2.appendChild(br);

				lista = document.createElement('ul');
				lista.id = 'resultados' + d.id;
				lista.className = 'resultados_lista';  
				tag2.appendChild(lista);

				$(lista).hide(); 
				lista.visible = false;

				preloader = document.createElement('div');
				preloader.className = 'preloader';
				tag.appendChild(preloader);
				$(preloader).hide(); 

				map.resultados = []; 

				for(r=0; r<d.resultados.length; r++){ 
					tag5 = document.createElement('li');
					tag5.id = 'resultado' + d.resultados[r].id;
					tag5.ID = d.resultados[r].id; 
					tag5.titulo_legenda = d.resultados[r].titulo_legenda;
					tag5.legenda = d.resultados[r].legenda.split('|');  

					tag5.lb = d.resultados[r].titulo.toUpperCase();
					tag5.innerHTML = tag5.lb;
					tag5.className = 'mapa_bt'; 

					lista.appendChild(tag5);
					map.resultados.push(tag5);
					tag5.onclick = function(){
						chamar_kmz(this);
					}

					layer = new google.maps.KmlLayer({ 
						suppressInfoWindows: true,
						preserveViewport: true,
						url:root + "projetos/projeto" + d.id + "/" + d.resultados[r].label + ".kmz?session=" + session
					});

					google.maps.event.addListener(layer, 'status_changed', function () { 
						$(preloader).stop(true).fadeOut(dur); 
					}); 

					tag5.layer = layer;

					br = document.createElement('br');
					lista.appendChild(br);
				}  

				// legenda 

				bt_legenda = document.createElement('div');
				bt_legenda.className = 'legenda mapa_bt';
				bt_legenda.innerHTML = "LEGENDA";  
				tag2.appendChild(bt_legenda); 
				
				bt_legenda.onclick = function(){
					if(legenda.visible){
						fechar_legenda();
					}else{
						abrir_legenda();
					}
				}  
				
				legenda = document.createElement('ul');
				legenda.className = 'legenda_tx scroll2';   
				tag2.appendChild(legenda);  

				$(legenda).hide(); 
				legenda.visible = false;  
				
				// conteudo 
				
				conteudo = document.createElement('div');
				conteudo.id = 'conteudo';
				tag2.appendChild(conteudo);  
				
				conteudo_telas = document.createElement('div');
				conteudo_telas.id = 'conteudo_telas';
				conteudo_telas.tela_atual = 0;				
				conteudo_telas.visible = true;  
				$(conteudo_telas).css({maxHeight:win_h-200});
				tag2.appendChild(conteudo_telas); 
				
				for(a=0; a<4; a++){
					
					var tela = [],					
					conteudo_tela;
					
					tag4 = document.createElement('div');
					tag4.className = 'conteudo_bt';
					tag4.innerHTML = conteudos[a];
					tag4.ID = a;
					conteudo.appendChild(tag4);
					
					tela[0] = tag4; 
					
					tag4.onclick = function(){ 
						if(conteudo_telas.tela_atual == this.ID) fechar_telas();
						else abrir_tela(this.ID);
					}
					
					tag5 = new Image();
					tag5.src = '_layout/fechar.png';
					tag4.appendChild(tag5);
					
					if(a==0){
						tag4.className += ' select';
					}
					
					conteudo_tela = document.createElement('div');
					conteudo_tela.className = 'conteudo_tela';
					conteudo_telas.appendChild(conteudo_tela); 
										
					tela[1] = conteudo_tela;
					telas.push(tela);
						
					if(a>0) $(conteudo_tela).hide(); 
					
					//sobre
					if(a==0){
						tag2 = document.createElement('div');
						tag2.className = "conteudo_titulo wwf";
						tag2.innerHTML = "SOBRE";
						conteudo_tela.appendChild(tag2);	 
						conteudo_tela.innerHTML += d.sobre; 
					}
					
					//documentos
					if(a==1){ 

						tag2 = document.createElement('div');
						tag2.className = "conteudo_titulo wwf";
						tag2.innerHTML = "DOCUMENTOS";
						conteudo_tela.appendChild(tag2);	 
						
						var doc,
							item,
							bt_dw,
							bt_lk,
							item_lb,
							temp;
						
						for(i=0; i<d.documentos.length; i++){

							doc = d.documentos[i];  

							if(doc.publicado == 1){ 

								item = document.createElement('div');
								item.className = 'item_lista';
								item.id = 'item' + i;

								if(doc.arquivo != ''){
									bt_dw = document.createElement('div');
									bt_dw.className = 'bt_item item_downlaod';
									bt_dw.ID = doc.id;
									bt_dw.arquivo = doc.arquivo;
									bt_dw.onclick = function(){
										window.open(root + "documentos/documento" + this.ID + "/" + this.arquivo);
									}
									item.appendChild(bt_dw);
								}
								
								if(doc.link != ''){
									bt_lk = document.createElement('div');
									bt_lk.className = 'bt_item item_link';
									bt_lk.link = doc.link;
									bt_lk.onclick = function(){
										window.open( this.link );
									}
									item.appendChild(bt_lk);
								}

								item_lb = document.createElement('span');
								item_lb.className = 'item_lb'; 
								temp = doc.titulo;
								temp += " &ndash; " + doc.autor;
								temp += "<span class='sub_lb'> &bull; " + doc.veiculo;
								temp += ", " + doc.ano  + "</span>"; 
								item_lb.innerHTML = temp;
								item.appendChild(item_lb);

								conteudo_tela.appendChild(item); 
							} 
						}
					}
					
					//dados
					if(a==2){  
						
						var arq,
							sbt,
							bt,
							bt_lb,
							arquivo,
							arq_lista,
							arquivo_lb,
							arquivo_lista,
							grupo_titulo,
							bt_dw,
							grupos = [[],["ALVOS DE CONSERVA&Ccedil;&Atilde;O"],
									  	 ["CUSTOS DE CONSERVA&Ccedil;&Atilde;O"],
									  	 ["ARQUIVOS DE ENTRADA MARXAN"]];			
 
						for(i=0; i<d.arquivos.length; i++){  
							arq = d.arquivos[i];
							arquivo = document.createElement('div');
							arquivo.className = 'item_lista';
							arquivo.nbts = 0;
							
							arquivo_lb = document.createElement('span');
							arquivo_lb.className = 'item_lb';
							arquivo_lb.innerHTML = d.arquivos[i].titulo;
							arquivo.appendChild(arquivo_lb); 
							
							arq_lista = document.createElement('div');
							arq_lista.className = 'arq_lista';
							arq_lista.open = false;
							arquivo.lista = arq_lista;
							
							for(r=0; r<d.repositorios.length; r++){
								rep = d.repositorios[r];
								if(rep.nome ==  arq.label){
									arquivo.nbts++;
									
									sbt = document.createElement('div');
									sbt.className = 'item_lista sbt'; 
									arq_lista.appendChild(sbt);

									bt_lb = document.createElement('span');
									bt_lb.className = 'item_lb';
									bt_lb.innerHTML = label_arquivo(rep.ext, rep.arquivo, rep.bites);
									sbt.appendChild(bt_lb); 
									
									bt_dw = document.createElement('div');
									bt_dw.className = 'bt_item item_downlaod sbt';
									bt_dw.path = d.path;
									bt_dw.arquivo = rep.arquivo;
									sbt.appendChild(bt_dw);
									
									bt_dw.onclick = function(){
										window.open(this.path + this.arquivo, "_blank" );
									}									
								}
							}
							
							bt = document.createElement('div');
							bt.className = 'bt_item item_open';
							bt.arquivo = arquivo;
							bt.onclick = function(){
								if(this.arquivo.lista.open){
									this.arquivo.lista.open = false; 
									$(this.arquivo.lista).stop(true).animate({height:0},dur*2);
									this.className = "bt_item item_open";
								}else{
									this.arquivo.lista.open = true;
									$(this.arquivo.lista).stop(true).animate({height:bt.arquivo.nbts*43 + 5},dur*2);
									this.className = "bt_item item_close"; 
								}
							}
							
							arquivo.appendChild(bt);
							
							grupos[Number(arq.grupo)].push(arquivo);
						}
						
						for(i=1; i<grupos.length; i++){
							if(grupos[i].length>1){
									
								grupo_titulo = document.createElement('div'); 
								grupo_titulo.className = "conteudo_titulo wwf";
								grupo_titulo.innerHTML = grupos[i][0];

								conteudo_tela.appendChild(grupo_titulo);
								
								for(b=1; b<grupos[i].length; b++){
									arquivo = grupos[i][b]; 
									
									conteudo_tela.appendChild(arquivo);
									conteudo_tela.appendChild(arquivo.lista);  
									
								}
							}
						}
					}
					
					//resultados
					if(a==3){ 
						var resultado_cel,
							resultado_tb,
							resultado_titulo,
							rep,
							arquivo,
							arquivo_lb,
							bt_dw;
					
						tag2 = document.createElement('div');
						tag2.className = "conteudo_titulo wwf";
						tag2.innerHTML = "RESULTADOS";
						conteudo_tela.appendChild(tag2);
						for(i=0; i<d.resultados.length; i++){ 
							resultado_cel = document.createElement('div');
							resultado_cel.className = "resultado_cel";
							conteudo_tela.appendChild(resultado_cel);
							
							resultado_tb = document.createElement('div');
							resultado_tb.className = "resultado_tb";
							$(resultado_tb).css({backgroundImage:'url('+ d.path + 'tb' + d.resultados[i].id + '.jpg?session=' + session + ')'}) 
							resultado_cel.appendChild(resultado_tb);
							
							resultado_titulo = document.createElement('div');
							resultado_titulo.className = "resultado_titulo mapa_bt"; 
							resultado_titulo.innerHTML = d.resultados[i].titulo;
							resultado_titulo.bt_lista = map.resultados[i];
							map.resultados[i].bt_tela_resultados = resultado_titulo;
							resultado_titulo.onclick = function(){
								chamar_kmz(this.bt_lista);
							}
							
							resultado_cel.appendChild(resultado_titulo);
							
							for(r=0; r<d.repositorios.length; r++){
								rep = d.repositorios[r];
								if(rep.nome ==  d.resultados[i].label){
									arquivo = document.createElement('div');
									arquivo.className = 'item_lista'; 
									resultado_cel.appendChild(arquivo);
									
									arquivo_lb = document.createElement('span');
									arquivo_lb.className = 'item_lb';
									arquivo.appendChild(arquivo_lb);
									
									arquivo_lb.innerHTML = label_arquivo(rep.ext, rep.arquivo, rep.bites);
									
									bt_dw = document.createElement('div');
									bt_dw.className = 'bt_item item_downlaod';
									bt_dw.path = d.path;
									bt_dw.arquivo = rep.arquivo;
									arquivo.appendChild(bt_dw);
									
									bt_dw.onclick = function(){
										window.open(this.path + this.arquivo, "_blank" );
									}									
								}
							}							
						} 
					} 
				}   
				
				// iniciar
				
				projeto.appendChild(tag); 
				aplicar_tema();
				
				chamar_kmz(map.resultados[0]);
			}   
		}
	}
	
	function label_arquivo(lb, arq, bites){
		
		var tipo
		var peso
		
		if(bites <= 1000) peso = '1Kb';
		else if(bites > 1000 && bites < 1000000) peso = Math.round(bites/1000) + ' Kb';
		else if(bites >= 1000000 ) peso = Math.round(bites/1000000) + ' Gb';
		
		if(lb == "zip") tipo = 'SHAPEFILE';
		else if(lb == "txt") tipo = 'METADADOS';
		else tipo = lb.toUpperCase();
		
		return tipo + " : " + arq + " <span class='sub_lb'> ( " + peso + " )</span>";
	} 
	
	function chamar_kmz(alvo){ 
		for(r=0; r<map.resultados.length; r++){ 
			d = map.resultados[r];
			if(d == alvo){   
				bt_lista.innerHTML = d.lb;
				d.className = "select";
				$(preloader).fadeTo(dur,.75);	
				d.layer.setMap(map);
				d.bt_tela_resultados.className = 'resultado_titulo mapa_bt select';
				
				legenda.innerHTML = "";

				tag = document.createElement('div');
				tag.className  = 'legenda_titulo';
				tag.innerHTML = d.titulo_legenda;
				legenda.appendChild(tag);

				for(a=0; a<d.legenda.length; a++){
					leg = d.legenda[a].split(',');
					tag = document.createElement('li');
					tag.innerHTML = leg[0];
					tag2 = document.createElement('span');
					tag2.style.backgroundColor = leg[1];
					tag.appendChild(tag2); 
					legenda.appendChild(tag);
				}

			}else{
				d.layer.setMap(null);
				d.className = "mapa_bt";
				d.bt_tela_resultados.className = 'resultado_titulo mapa_bt';
			}
		} 

		fechar_lista();
	} 
	 
	function abrir_lista(){
		lista.visible = true; 
		$(lista).fadeIn(dur);
		$(bt_lista).css({backgroundImage:'url(_layout/icon_up2.png)'});
		fechar_legenda();
		fechar_telas();
	}

	function fechar_lista(){
		lista.visible = false; 
		$(lista).fadeOut(dur);
		$(bt_lista).css({backgroundImage:'url(_layout/icon_dw2.png)'});
	} 
	
	function abrir_tela(ID){ 
		for(i=0; i<4; i++){
			d = telas[i][0]; 
			if(i == ID){
				d.className = "conteudo_bt select"; 
				$(d.fechar).show();
				$( d ).css({backgroundColor:''});
				$(telas[i][1]).show(); 
				$(conteudo_telas).stop(true).fadeIn(dur); 
				conteudo_telas.tela_atual = ID;
			}else{
				d.className = "conteudo_bt"; 
				$(telas[i][1]).hide();
				$(d.fechar).hide();
			}
		}
		fechar_legenda();
		fechar_lista();
	} 

	function fechar_telas(){
		conteudo_telas.tela_atual = -1;
		$(conteudo_telas).fadeOut(dur);
		for(i=0; i<4; i++){
			d = telas[i][0]; 
			d.className = "conteudo_bt"; 
			$(d.fechar).hide();
		}
	}
	
	function abrir_legenda(){
		legenda.visible = true;
		$(legenda).fadeIn(dur);
		$(bt_legenda).css({backgroundImage:'url(_layout/icon_dw2.png)'}); 
		legenda.scrollTop = 0;
		fechar_lista();
		fechar_telas();
	}

	function fechar_legenda(){
		legenda.visible = false;
		$(legenda).fadeOut(dur);
		$(bt_legenda).css({backgroundImage:'url(_layout/icon_up2.png)', color:'#fff'}); 
	} 
	
	
	// window 
	
	window.onresize = resize;
	
	function resize(){ 
		win_w = $( window ).width();
		win_h = $( window ).height(); 
		
		$(conteudo_telas).css({maxHeight:win_h-200});
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
	
	
	// load data
	myRequest.open("GET", "projetos/projeto"+ projeto_id +"/dados.xml?session="+session, true);
	myRequest.send(null);
	
}