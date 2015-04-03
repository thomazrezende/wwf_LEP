window.onload = function (){  
	
	// VARS //
	
	var i,
		d,
		tag,
		tag2,
		tag3,
		tag4,
		tag5,
		tag6,
		tag7,
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
	
	$(document.body).hide().fadeIn(300);
	
	// temas
	var temas = [
		'#cc6666',
		'#ff6666',
		'#ff9966',
		'#ffcc66',
		'#cc9966',
		'#cccc66',
		'#66cc66',
		'#99cc66',
		'#66cc99',
		'#66cccc',
		'#6699cc',
		'#66ccff',
		'#99ccff',
		'#6666cc',
		'#9999ff',
		'#9966cc',
		'#cc66cc',
		'#cc99ff',
		'#cc6699',
		'#ff6699'];

	
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
				sessionStorage.setItem("session", session);
				
				banner_id = Math.floor( Math.random() * banners_arr.length ); 
				
				d = banners_arr[banner_id];
				
				sessionStorage.setItem("tema", d.tema);
				sessionStorage.setItem("banner_id", d.id);
			}  
			
			d = banners_arr[banner_id]; 
			
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
			
			console.log(">>>"+d);
			
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
					//["resultados", ["label","titulo","id"]],
					"zoom",
					"resumo"]);
			
				// lista 
			
			// projetos
			
			var projeto_id;
			var resultados;
			
			console.log(projetos_arr);
			
			if(page == 0){ 
				
				layout_home = dados_arr['dados'].layout_home.split(',');
				
				for(i in layout_home){
					
					projeto_id = layout_home[i].split("item")[1];
					d = projetos_arr["projeto" + projeto_id];
					
					tag = document.createElement('li');
					tag.ID = projeto_id;
					tag.id = 'projeto' + projeto_id;
					tag.className = 'projeto';
					
					tag2 = document.createElement('div');
					tag2.className = 'projeto_bts';
					tag.appendChild(tag2);
					
					tag3 = document.createElement('div');
					tag3.className = 'titulo wwf mapa_bt';
					tag3.id = 'titulo' + projeto_id;
					tag3.innerHTML = d.titulo;
					tag2.appendChild(tag3);
										
					tag4 = document.createElement('div');
					tag4.id = 'resultado' + projeto_id;
					tag4.className = 'resultados mapa_bt';
					tag2.appendChild(tag4); 
					
					tag5 = document.createElement('ul');
					tag5.id = 'resultados' + projeto_id;
					tag5.className = 'resultados_lista';
					tag2.appendChild(tag5); 
					
					resultados = 
					
					tag6 = document.createElement('div');
					tag6.id = 'zoom_in'+ projeto_id;
					tag6.className = 'mapa_bt zoom_in';
					tag2.appendChild(tag6); 
					
					tag7 = document.createElement('div');
					tag7.id = 'zoom_out'+ projeto_id;
					tag7.className = 'mapa_bt zoom_out';
					tag2.appendChild(tag7);
					
					projetos.appendChild(tag);
					
				} 
			}
			
			/*
			<li id="projeto1" class="projeto">
				<div class="projeto_bts">
					<div class="titulo wwf mapa_bt">Áreas Prioritárias para conservação no cerrado e Pantanal</div> 
					<div class="resultados mapa_bt">ÁREAS PRIORITÁRIAS PARA CONSERVAÇÃO</div> 

					<ul class="resultados_lista">
						<li class="select">ÁREAS PRIORITÁRIAS PARA CONSERVAÇÃO</li>
						<li class="mapa_bt" >ÁREAS PRIORI CONSERVAÇÃO</li>
						<li class="mapa_bt" >ÁREAS  CONSERVAÇÃO PARA CONSERVAÇÃO DE ÁREAS</li>
					</ul>

					<div class="mapa_bt zoom_in"></div>
					<div class="mapa_bt zoom_out"></div>

					 <div class="mapa_bt resumo">Lorem ipsum dolor sit amet leo. Maecenas sapien ultrices ante aliquam ipsum. Faucibus lorem leo odio vitae nam. Tellus mauris vivamus viverra convallis donec. Mi odio sodales orci at elit. Sodales consequat ante. Congue magna massa at enim ut turpis in quos neque laoreet placerat. In ea congue condimentum accumsan a duis commodo donec accumsan urna integer. Non elit et. Turpis suspendisse felis orci cillum nulla integer dolor congue. Mollis mollit augue. Massa massa ut. Dui hac maecenas. Tincidunt a nec. Suscipit convallis quam. Donec a penatibus cursus wisi risus enim molestie phasellus massa sit non malesuada commodo platea mattis quis facilisis. A faucibus sodales enim quam non. Lectus ultricies sem vestibulum molestie ut ut ac ultricies lectus metus nibh accumsan dignissim nam volutpat hendrerit purus. Sed orci tincidunt. Lacinia suspendisse suscipit. Et id pharetra. Nibh nec suspendisse. Imperdiet quis eu elementum at facilisis nec vitae pharetra. Non diam amet. Ante dolor mattis parturient auctor duis. Luctus sit tempus. Id dictum mi et platea odio. Tempor ac eu iaculis est interdum arcu dictumst nulla. Orci est massa. Tellus posuere at.</div> 
				</div>
			</li> 
			*/
			
			// 4.documentos 
			myRequest4.open("GET", "xml/documentos.xml?session="+session, true);
			myRequest4.send(null);
			
		}
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
						temp += "<span class='cinza'> &bull; " + d.veiculo;
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
						$(busca_x).fadeOut(100);
					}
				}

				busca_tx.onkeyup = function(){
					if(this.value == ''){
						$(busca_x).fadeOut(100);
					}else{
						$(busca_x).fadeIn(100);
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
					$(busca_opts).fadeIn(100).css({top: -43 * filtro});
					tag = document.getElementById('opt' + filtro);
					$(tag).css({backgroundColor:temas[tema]})
				}

				$(busca_opts).mouseleave(function(){
					$(this).fadeOut(100);
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
						$(busca_opts).fadeOut(100);
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
		var obj;
		var join;
		var xml;
		
		xml = _xml.getElementsByTagName(obj_lb);   
		
		console.log(obj_lb);
		
		for(var i=0; i<xml.length; i++){
			obj = {}; 
			if( obj_lb != 'dados' ) id = ponteiro_lista(xml,i,"id"); 
			for( var a=0; a<atts.length; a++ ){  
				
				/*if(isArray(atts[a])){
					
					obj[atts[a][0]]	= [];
					
					for(n_registros){ 
						
						join = {};  
						
						for( var b=0; b<atts[a][1].length; b++ ){ 
							join[atts[a][1][b]] = ponteiroXYZ;						
						}	
					
					}
					
					obj[atts[a][0]].push(join);
					
				}else{ */
					
					obj[atts[a]] = ponteiro_lista(xml,i,atts[a]); 
					
				//}
				
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
	function ponteiro_lista(xml,i,lb){ //  ponteiro que retorna conteúdo da tag com index = i
		if(xml[i].getElementsByTagName(lb)[0].firstChild){ // se a tag estiver vazia, o firstChild = null da bug no retorno da proxima linha
			return xml[i].getElementsByTagName(lb)[0].firstChild.nodeValue;  
		}
	}
	
	function isArray( obj ) {
		return toString.call(obj) === "[object Array]";
	};
	
	
	
	
}