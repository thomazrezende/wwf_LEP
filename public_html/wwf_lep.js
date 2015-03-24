window.onload = function (){  
	
	// VARS //
	
	var i,
		d,
		tag,
		rand,
		page_y,
		win_w,
		win_h,
		rand_banner;
	
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
	
	// FUNCS //
	
	for(i=0; i<pages.length; i++){
		tag = document.createElement('li');
		tag.ID = i;
		tag.innerHTML = pages[i][0];
		tag.page = pages[i][1];
		tag.className = 'menu_bt';
		
		if(path[path.length-1] == tag.page){
			tag.className += ' select';
		}else{
			tag.onclick = function(){
				document.location.href = root + this.page; 
			}
		} 
		
		menu_bts.appendChild(tag);
	}
	 
	// banners
	
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
					 "credito"]);
			
			rand_banner = Math.floor(Math.random() * banners_arr.length);  
			
			d =  banners_arr[rand_banner];
			
			if(d.credito != ''){
				$(banner_credito).html('foto: ' + d.credito);
			}else{
				$(banner_credito).hide();
			}
			banner.style.backgroundImage = 'url(banners/banner' + d.id + '.jpg)';
			
			
		}
	} 
	
	rand = Math.random() * 1000; 
	myRequest1.open("GET", "xml/banners.xml?rand="+rand, true);
	myRequest1.send(null);   
	
	
	// dados
	
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
			
			email.onclick = function(){ 
				document.location.href = 'mailto:' + dados_arr['dados'].email;
			}
			
			fbook.onclick = function(){ 
				window.open(dados_arr['dados'].fbook);
			} 
			
			twitter.onclick = function(){ 
				window.open(dados_arr['dados'].twitter);
			}
			
			f_email.href = 'mailto:' + dados_arr['dados'].email;
			f_fbook.href = dados_arr['dados'].fbook;
			f_twitter.href = dados_arr['dados'].twitter;
			
		}
	} 
	
	rand = Math.random() * 1000; 
	myRequest2.open("GET", "xml/dados.xml?rand="+rand, true);
	myRequest2.send(null);  
	
	
	
	
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
		var xml;
		
		xml = _xml.getElementsByTagName(obj_lb);  
		
		for(var i=0; i<xml.length; i++){
			obj = {}; 
			if( obj_lb != 'dados' ) id = ponteiro_lista(xml,i,"id"); 
			 for( var a=0; a<atts.length; a++ ){ 
				obj[atts[a]] = ponteiro_lista(xml,i,atts[a]);
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
	
	
	
	
}