window.onload = function (){ 
	
	var mobile = false; 
	
	var page_y;
	var win_w;
	var win_h;
	
	var root = location.origin;
	var path = location.pathname.split('/');
	
	for(i=0; i<path.length-1; i++){
		root +=  path[i] + '/';
	} 
	
	console.log("_root: " + root);
	
	// window funcs //
	
	window.onresize = resize;
	
	function resize(){
		
		win_w = $( window ).width();
		win_h = $( window ).height();
		
		trab_itens.style.height = win_h - 100 + 'px';
		contato_itens.style.height = win_h - 50 + 'px';
		
		if( win_w <= 900) {
			mobile = true;
			document.body.className = "mobile";
		}else{
			mobile = false;
			document.body.className = "";
		}
		
	}  
	
	function verifica_scroll(){
		
		page_y = $(window).scrollTop();
		
		if( page_y > 1 && !trava_menu ) {
			menu.style.background = '#fff';
			trava_menu = true;
		}
		
		if(page_y < 1 && trava_menu) {
			menu.style.background = '';
			trava_menu = false;
		}
		 
		t1_meio = verifica_altura(); 
		
		if( tela_at == 1 && 
		   	t1_meio_id != t1_projs[ t1_meio ].ID &&
		  	!mobile){
				stop_videos(); 
				t1_meio_id = t1_projs[ t1_meio ].ID; 

				if( t1_projs[ t1_meio ].video && 
				t1_projs[ t1_meio ].autoplay){ 

					iframe = $('#video' + t1_meio_id )[0];
					player = $f(iframe);
					player.api('play');
					player.api('setVolume', 0); 

			}
		}
	}  
	
	window.onscroll = verifica_scroll; 
	  
	
	
	// chama projetos.xml	
	
	resize();
	
	var rand = Math.random() * 1000; 
	myRequest1.open("GET", "xml/projetos.xml?rand="+rand, true);
	myRequest1.send(null);  
	
}